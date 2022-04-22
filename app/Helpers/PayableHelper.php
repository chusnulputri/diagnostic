<?php

namespace App\Helpers;

use App\Models\dk_payable_balances;
use App\Models\dk_payable_detail_payments;
use App\Models\dk_payable_details;
use App\Models\dk_payables;
use App\Models\m_company;
use App\Models\m_customer;
use App\Models\m_supplier;
use ArsoftModules\NotaGenerator\Facades\NotaGenerator;
use Carbon\Carbon;

class PayableHelper
{
    public function firstOrCreatePayable($debtor, $creditor,$type)
    {
        $payable = dk_payables::where('debtorable_id', $debtor)
            ->where('creditorable_id', $creditor)
            ->first();
        if (!$payable) {
            $payable = new dk_payables;
            $payable->debtorable_id = $debtor;
            $payable->creditorable_id = $creditor;
            $payable->save();
            
        }
        
        if($type == 'supplier'){
            $cred = m_supplier::where('s_id',$creditor)->first();
            if($cred){
                $cred->payablesCredit()->save($payable);
            }

            $deb = m_company::where('c_id',$debtor)->first();
            if($deb){
                $deb->payablesDebit()->save($payable);
            }
            
        }else if($type == 'customer'){
            
            $deb = m_customer::where('cs_id',$debtor)->first();
            if($deb){
                $deb->payablesDebit()->save($payable);
            }
            
            $cred = m_company::where('c_id',$creditor)->first();
            if($cred){
                $cred->payablesCredit()->save($payable);
            }
        }else{
            $deb = m_company::where('c_id',$debtor)->first();
            if($deb){
                $deb->payablesDebit()->save($payable);
            }

            $cred = m_company::where('c_id',$creditor)->first();
            if($cred){
                $cred->payablesCredit()->save($payable);
            }
        }

        

        return $payable;
    }

    public function insertPayableDetail($debtor, $creditor, $name, $date, $reff, $amount, $dueDate, $note, $type,$invoiceNumber = null)
    {
        $payable = $this->firstOrCreatePayable($debtor, $creditor,$type);
        
        $payableDetail = new dk_payable_details();
        $payableDetail->payable_id = $payable->id;
        $payableDetail->name = $name;
        $payableDetail->date = $date;
        $payableDetail->amount = $amount;
        $payableDetail->total_paid = 0;
        $payableDetail->due_date = $dueDate;
        $payableDetail->number = $invoiceNumber ?? NotaGenerator::generate('dk_payable_details', 'number', 4, Carbon::now()->format('Y-m-d'))->addPrefix('INV')->getResult();
        $payableDetail->note = $note;
        $payableDetail->save();
        
        self::throttleSaldo(
            $payableDetail->payable_id,
            $payableDetail->amount,
            $payableDetail->date,
            'out'
        );

        if ($payableDetail) {
            return [
                'status' => 'success',
                'data' => $payableDetail
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat proses data payable, transaksi tidak dapat diproses'
            ];
        }
    }

    public static function deletePayableDetail($payableDetailId)
    {
        $payableDetail = dk_payable_details::find($payableDetailId);
        if (!$payableDetail) {
            return [
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat proses data payable, transaksi tidak dapat diproses'
            ];
        }
        self::throttleSaldoMinus(
            $payableDetail->payable_id, 
            $payableDetail->amount, 
            $payableDetail->date,
            'out'
        );
        $payableDetail->delete();

        if ($payableDetail) {
            return [
                'status' => 'success',
                'data' => $payableDetail
            ];
        }
    }

    /**
     * used for insert payable payment
     */
    public static function throttleSaldo(String $payableId, Float $amount, String $date, String $flag)
    {

        $periode = date('Y-m', strtotime($date)) . '-01';

        $payableBalance = dk_payable_balances::where('payable_id', $payableId)
            ->where('periods', $periode)
            ->first();

        $mutasiMasuk = 0;
        $mutasiKeluar = 0;
        $saldoAkhir = 0;

        if ($flag == 'in') {
            $mutasiMasuk = $amount;
            $saldoAkhir  = $amount;
        } else {
            $mutasiKeluar = $amount;
            $saldoAkhir   = $amount * -1;
        }

        if ($payableBalance) {
            $payableBalance->total_balance_in = ($payableBalance->total_balance_in + $mutasiMasuk);
            $payableBalance->total_balance_out = ($payableBalance->total_balance_out + $mutasiKeluar);
            $payableBalance->closing_balance = ($payableBalance->closing_balance + $saldoAkhir);
            $payableBalance->update();
        } else {

            $lastResidue = dk_payable_balances::where('payable_id', $payableId)
                ->where('periods', "<", $periode)
                ->latest()
                ->first();

            $openingBalance = ($lastResidue) ? $lastResidue->closing_balance : 0;

            $newPayableBalance = new dk_payable_balances();
            $newPayableBalance->payable_id = $payableId;
            $newPayableBalance->periods = $periode;
            $newPayableBalance->opening_balance = $openingBalance;
            $newPayableBalance->total_balance_in = $mutasiMasuk;
            $newPayableBalance->total_balance_out = $mutasiKeluar;
            $newPayableBalance->closing_balance = $openingBalance + $saldoAkhir;
            $newPayableBalance->save();
        }

        // DB::table('dk_payable_saldo')
        //             ->where('ps_debitur', $debitur)
        //             ->where('ps_perusahaan', $perusahaan)
        //             ->where('ps_periode', ">", $periode)
        //             ->where('ps_jenis', $type)->update([
        //                 'ps_saldo_awal'     => DB::raw('ps_saldo_awal + '.$saldoAkhir),
        //                 'ps_saldo_akhir'    => DB::raw('ps_saldo_akhir + '.$saldoAkhir),
        //             ]);

        return [
            'status'    => 'success',
            'flag'      => 'throttle saldo'
        ];
    }

    /**
     * used for delete payable payment
     */
    public static function throttleSaldoMinus(String $payableId, Float $amount, String $date, String $flag)
    {

        $periode = date('Y-m', strtotime($date)) . '-01';

        $payableBalance = dk_payable_balances::where('payable_id', $payableId)
            ->where('periods', $periode)
            ->first();

        $mutasiMasuk = 0;
        $mutasiKeluar = 0;
        $saldoAkhir = 0;

        if ($flag == 'in') {
            $mutasiMasuk = $amount;
            $saldoAkhir  = $amount;
        } else {
            $mutasiKeluar = $amount;
            $saldoAkhir   = $amount * -1;
        }

        if ($payableBalance) {
            $payableBalance->total_balance_in = ($payableBalance->total_balance_in - $mutasiMasuk);
            $payableBalance->total_balance_out = ($payableBalance->total_balance_out - $mutasiKeluar);
            $payableBalance->closing_balance = ($payableBalance->closing_balance - $saldoAkhir);
            $payableBalance->update();
        }

        // DB::table('dk_payable_saldo')
        //             ->where('ps_debitur', $debitur)
        //             ->where('ps_perusahaan', $perusahaan)
        //             ->where('ps_periode', ">", $periode)
        //             ->where('ps_jenis', $type)->update([
        //                 'ps_saldo_awal'     => DB::raw('ps_saldo_awal + '.$saldoAkhir),
        //                 'ps_saldo_akhir'    => DB::raw('ps_saldo_akhir + '.$saldoAkhir),
        //             ]);

        return [
            'status'    => 'success',
            'flag'      => 'throttle saldo'
        ];
    }

    /**
     * @param string $payableDetailId
     * @param string $date date format : Y-m-d
     * @param float $amount
     */
    public function insertPayableDetailPayments($payableDetailId, $date, $amount)
    {
        $detailPayment = new dk_payable_detail_payments();
        $detailPayment->payable_detail_id = $payableDetailId;
        $detailPayment->date = $date;
        $detailPayment->amount = $amount;
        $detailPayment->save();
        if ($detailPayment) {
            $updateTotalPaid = $this->updateTotalPaidPayableDetail($payableDetailId, $amount);
            if ($updateTotalPaid['status'] != 'success') {
                return [
                    'status' => 'error',
                    'message' => 'Terjadi kesalahan saat proses data payable, transaksi dibatalkan'
                ];
            }
            return [
                'status' => 'success',
                'data' => $detailPayment
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat proses data payable, transaksi dibatalkan'
            ];
        }
    }

    /**
     * @param string $payableDetailPaymentId payable-detail-payment-id
     */
    public function deletePayableDetailPayments($payableDetailPaymentId)
    {
        $detailPayment = dk_payable_detail_payments::find($payableDetailPaymentId);
        if (!$detailPayment) {
            return [
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat proses data payable, transaksi dibatalkan'
            ];
        }
        $amount = $detailPayment->amount * -1;
        $payableDetailId = $detailPayment->payable_detail_id;
        $updateTotalPaid = $this->updateTotalPaidPayableDetail($payableDetailId, $amount);
        if ($updateTotalPaid['status'] != 'success') {
            return [
                'status' => 'error',
                'message' => $updateTotalPaid['message']
            ];
        }
        $detailPayment->delete();
        return [
            'status' => 'success',
            'data' => $detailPayment
        ];
    }

    /**
     * @param int $payableDetailId
     */
    public function getPayableDetailPayment($payableDetailId)
    {
        return dk_payable_detail_payments::where('payable_detail_id', $payableDetailId)->first();
    }

    /**
     * update total paid payable detail ( total_paid + amount )
     * 
     * @param int $payableDetailId payable-detail-id
     * @param decimal|int $amount amount, minus value allowed
     */
    public function updateTotalPaidPayableDetail($payableDetailId, $amount)
    {
        $payableDetail = dk_payable_details::find($payableDetailId);
        if ($payableDetail) {
            if (($payableDetail->total_paid + $amount) > $payableDetail->amount) {
                return [
                    'status' => 'error',
                    'message' => 'Nominal pembayaran tidak boleh melebihi sisa tagihan ( ' . ($payableDetail->amount - $payableDetail->total_paid) . ' )'
                ];
            }
            $payableDetail->total_paid += $amount;
            $payableDetail->save();
            return [
                'status' => 'success',
                'data' => $payableDetail
            ];
        }
        return [
            'status' => 'error',
            'message' => 'Terjadi kesalahan saat proses data payable, transaksi tidak dapat diproses'
        ];
    }
    
}
