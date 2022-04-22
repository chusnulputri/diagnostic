<?php

namespace Database\Seeders;

use App\Models\permissions;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            // activity for courier
            'delivery-activity-confirm-sent',

            // couriers for delivery
            ['delivery-courier-menu', ['delivery-courier-read']],
            'delivery-courier-read',
            'delivery-courier-update',

            // inventory extra stock
            ['delivery-extra-stock-menu', ['delivery-extra-stock-read']],
            'delivery-extra-stock-read',
            'delivery-extra-stock-create',
            'delivery-extra-stock-update',
            'delivery-extra-stock-confirm',
            'delivery-extra-f-cancel',
            'delivery-extra-stock-delete',

            // delivery schedule managements
            ['delivery-schedule-menu', 'delivery-schedule-read'],
            'delivery-schedule-read',

            // director
            ['director-menu', [
                'purchase-order-confirm-approval-2',
                'production-report-read',
                'purchase-report-read',
                'sales-report-read',
                'stock-monitoring-read',
            ]],

            // extra stock transfer ( stock transfer with delivery : packaging delivery )
            ['extra-stock-transfer-menu', ['extra-stock-transfer-read']],
            'extra-stock-transfer-read',
            'extra-stock-transfer-create',
            'extra-stock-transfer-update',
            'extra-stock-transfer-delete',

            // finance approval purchase order
            ['finance-menu', [
                'purchase-order-confirm-approval-1',
            ]],

            // incoming goods
            ['incoming-goods-menu', ['incoming-goods-read']],
            'incoming-goods-read',
            'incoming-goods-create',
            'incoming-goods-update',
            'incoming-goods-delete',
            'incoming-goods-confirm-approval-1',
            'incoming-goods-confirm-approval-2',
            'incoming-goods-confirm-approval-3',
            'incoming-goods-cancel-approval-1',
            'incoming-goods-cancel-approval-2',
            'incoming-goods-cancel-approval-3',

            // inventory receipt ( for mobile outlet and etc)
            ['inventory-receipt-menu', ['inventory-receipt-read']],
            'inventory-receipt-read',
            'inventory-receipt-confirm-received',
            'inventory-receipt-cancel-received',
            'inventory-receipt-update',

            // master customer
            ['master-customer-menu', ['master-customer-read']],
            'master-customer-read',
            'master-customer-create',
            'master-customer-update',
            'master-customer-delete',

            // master coa
            ['master-coa-menu', ['master-coa-read', 'master-coa-group-read']],
            ['master-coa-read', ['master-coa-group-read']],
            ['master-coa-create', ['master-coa-group-create']],
            ['master-coa-update', ['master-coa-group-update']],
            ['master-coa-delete', ['master-coa-group-delete']],

            // master coa group
            ['master-coa-group-menu', ['master-coa-group-read']],
            'master-coa-group-read',
            'master-coa-group-create',
            'master-coa-group-update',
            'master-coa-group-delete',

            // master division
            ['master-division-menu', ['master-division-read']],
            'master-division-read',
            'master-division-create',
            'master-division-update',
            'master-division-delete',

            // master employee
            ['master-employee-menu', ['master-employee-read']],
            'master-employee-read',
            'master-employee-create',
            'master-employee-update',
            'master-employee-delete',

            // master entity
            ['master-entity-menu', ['master-entity-read']],
            'master-entity-read',
            'master-entity-create',
            'master-entity-update',
            'master-entity-delete',

            // master item
            ['master-item-menu', ['master-item-read']],
            'master-item-read',
            'master-item-create',
            'master-item-update',
            'master-item-delete',

            // master item-recipe
            ['master-item-recipe-menu', ['master-item-recipe-read']],
            'master-item-recipe-read',
            'master-item-recipe-create',
            'master-item-recipe-update',
            'master-item-recipe-delete',

            // master leave
            ['master-leave-menu', ['master-leave-read']],
            'master-leave-read',
            'master-leave-create',
            'master-leave-update',
            'master-leave-delete',

            // master outlet
            ['master-outlet-menu', ['master-outlet-read']],
            'master-outlet-read',
            'master-outlet-create',
            'master-outlet-update',
            'master-outlet-delete',

            // master payment-method
            ['master-payment-method-menu', ['master-payment-method-read']],
            'master-payment-method-read',
            'master-payment-method-create',
            'master-payment-method-update',
            'master-payment-method-delete',

            // master position
            ['master-position-menu', ['master-position-read', 'master-division-read']],
            ['master-position-read', ['master-division-read']],
            'master-position-create',
            'master-position-update',
            'master-position-delete',

            // master presence location
            ['master-presence-location-menu', ['master-presence-location-read']],
            'master-presence-location-read',
            'master-presence-location-create',
            'master-presence-location-update',
            'master-presence-location-delete',

            // master subscription plan
            ['master-subscription-plan-menu', ['master-subscription-plan-read']],
            'master-subscription-plan-read',
            'master-subscription-plan-create',
            'master-subscription-plan-update',
            'master-subscription-plan-delete',

            // master supplier
            ['master-supplier-menu', ['master-supplier-read']],
            'master-supplier-read',
            'master-supplier-create',
            'master-supplier-update',
            'master-supplier-delete',

            // master transaction
            ['master-transaction-menu', ['master-transaction-read']],
            'master-transaction-read',
            'master-transaction-create',
            'master-transaction-update',
            'master-transaction-delete',

            // opname
            ['opname-menu', ['opname-read', 'master-item-read']],
            ['opname-read', ['master-item-read']],
            'opname-create',
            'opname-update',
            'opname-delete',
            // adjustment
            'opname-adjustment',

            // outgoing goods
            ['outgoing-goods-menu', ['outgoing-goods-read']],
            'outgoing-goods-read',
            'outgoing-goods-create',
            'outgoing-goods-update',
            'outgoing-goods-delete',
            'outgoing-goods-confirm-approval-1',
            'outgoing-goods-confirm-approval-2',
            'outgoing-goods-confirm-approval-3',
            'outgoing-goods-cancel-approval-1',
            'outgoing-goods-cancel-approval-2',
            'outgoing-goods-cancel-approval-3',

            // purchase-delivery
            ['purchase-delivery-menu', ['purchase-delivery-read', 'purchase-order-read']],
            ['purchase-delivery-read', ['purchase-order-read']],
            'purchase-delivery-create',
            'purchase-delivery-update',
            'purchase-delivery-delete',
            'purchase-delivery-confirm-received',
            'purchase-delivery-cancel-received',

            // purchase order
            ['purchase-order-menu', ['purchase-order-read']],
            'purchase-order-read',
            'purchase-order-create',
            'purchase-order-update',
            'purchase-order-process',
            'purchase-order-cancel',
            'purchase-order-confirm-ordered',
            'purchase-order-cancel-ordered',
            'purchase-order-confirm-approval-1',
            'purchase-order-confirm-approval-2',
            'purchase-order-delete',

            // purchase report
            ['purchase-report-menu', ['purchase-report-read']],
            'purchase-report-read',

            // purchase return
            ['purchase-return-menu', ['purchase-return-read', 'purchase-order-read']],
            ['purchase-return-read', ['purchase-order-read']],
            'purchase-return-create',
            'purchase-return-update',
            'purchase-return-delete',

            // production finished goods
            ['production-finished-menu', ['production-finished-read', 'production-plan-read']],
            ['production-finished-read', ['production-plan-read']],
            'production-finished-create',
            'production-finished-update',
            'production-finished-confirm',
            'production-finished-cancel',
            'production-finished-delete',

            // production plan
            ['production-plan-menu', ['production-plan-read']],
            'production-plan-read',
            'production-plan-create',
            'production-plan-confirm',
            'production-plan-cancel',
            'production-plan-delete',

            // raw material production
            ['production-raw-menu', ['production-raw-read', 'production-plan-read']],
            ['production-raw-read', ['production-plan-read']],
            'production-raw-create',
            'production-raw-update',
            'production-raw-confirm-submit',
            'production-raw-cancel-submit',
            'production-raw-confirm-approval-1',
            'production-raw-confirm-approval-2',
            'production-raw-delete',

            // production report
            'production-report-read',

            // production waste
            ['production-waste-menu', ['production-waste-read']],
            'production-waste-read',
            'production-waste-create',
            'production-waste-update',
            'production-waste-confirm',
            'production-waste-delete',

            // change money
            ['sales-change-money-menu', ['sales-change-money-read']],
            'sales-change-money-read',
            'sales-change-money-create',
            'sales-change-money-update',
            // confirm handed
            'sales-change-money-confirm-handed',
            // confirm received
            'sales-change-money-confirm-received',
            'sales-change-money-delete',

            // sales delivery
            ['sales-delivery-menu', ['sales-delivery-read', 'sales-order-read']],
            ['sales-delivery-read', ['sales-order-read']],
            'sales-delivery-confirm-sent',
            'sales-delivery-cancel-sent',

            // sales deposit
            ['sales-deposit-menu', ['sales-deposit-read']],
            'sales-deposit-read',
            'sales-deposit-create',
            'sales-deposit-update',
            // confirm received
            'sales-deposit-confirm-received',
            'sales-deposit-delete',

            // salesn order
            ['sales-order-menu', ['sales-order-read', 'master-customer-create']],
            ['sales-order-read', ['master-customer-create']],
            'sales-order-create',
            'sales-order-update',
            'sales-order-delete',
            'sales-order-confirm',
            'sales-order-cancel',

            // sales pos
            'sales-pos-menu',
            'sales-pos-history',
            'sales-pos-create',

            // sales report
            ['sales-report-menu', ['sales-report-read']],
            'sales-report-read',

            // sales return management
            ['sales-return-menu', ['sales-return-read']],
            'sales-return-read',
            'sales-return-create',
            'sales-return-update',
            'sales-return-delete',

            // SDM
            // sdm attendance
            ['sdm-attendance-menu', ['sdm-attendance-read']],
            'sdm-attendance-read',
            'sdm-attendance-create-absent',

            // sdm workdays and holidays
            'sdm-workdays-holidays-read',
            ['sdm-workdays-menu', ['sdm-workdays-holidays-read', 'sdm-workdays-management-read']],
            'sdm-workdays-holidays-create',
            'sdm-workdays-holidays-update',
            'sdm-workdays-holidays-delete',
            'sdm-workdays-management-read',
            'sdm-workdays-management-menu',
            'sdm-workdays-management-update',

            ['sdm-overtime-menu', ['sdm-overtime-read']],
            'sdm-overtime-read',
            'sdm-overtime-create',
            'sdm-overtime-update',
            'sdm-overtime-delete',

            // leave management
            'sdm-leave-management-read',
            ['sdm-leave-management-menu', ['sdm-leave-management-read']],
            'sdm-leave-management-create',
            'sdm-leave-management-update',
            'sdm-leave-management-approval-1',
            'sdm-leave-management-approval-2',
            'sdm-leave-management-delete',

            // cashbon management
            'sdm-cashbon-management-read',
            ['sdm-cashbon-management-menu', ['sdm-cashbon-management-read']],
            'sdm-cashbon-management-create',
            'sdm-cashbon-management-update',
            'sdm-cashbon-management-approval-1',
            'sdm-cashbon-management-approval-2',
            'sdm-cashbon-management-delete',

            // cashbon schedule
            'sdm-cashbon-schedule-read',
            ['sdm-cashbon-schedule-menu', ['sdm-cashbon-schedule-read']],
            'sdm-cashbon-schedule-create',
            'sdm-cashbon-schedule-update',
            'sdm-cashbon-schedule-delete',

            // sdm employee loan management
            ['sdm-employee-loan-menu', ['sdm-employee-loan-read']],
            'sdm-employee-loan-read',
            'sdm-employee-loan-create',
            'sdm-employee-loan-update',
            'sdm-employee-loan-delete',
            'sdm-employee-loan-confirm-release',

            // sdm salary management
            ['sdm-sallary-management-menu', ['sdm-sallary-management-read']],
            'sdm-sallary-management-read',
            'sdm-sallary-management-create',
            'sdm-sallary-management-update',
            'sdm-sallary-management-delete',
            'sdm-sallary-management-confirm-release',

            // sdm salary management bonus
            ['sdm-sallary-bonus-menu', ['sdm-sallary-bonus-read']],
            'sdm-sallary-bonus-read',
            'sdm-sallary-bonus-create',
            'sdm-sallary-bonus-update',
            'sdm-sallary-bonus-delete',
            'sdm-sallary-bonus-confirm-received',
            'sdm-sallary-bonus-cancel-received',

            // sdm salary management cuts
            ['sdm-sallary-cuts-menu', ['sdm-sallary-cuts-read']],
            'sdm-sallary-cuts-read',
            'sdm-sallary-cuts-create',
            'sdm-sallary-cuts-update',
            'sdm-sallary-cuts-delete',
            'sdm-sallary-cuts-confirm-received',
            'sdm-sallary-cuts-cancel-received',

            // sdm salary management allowance
            ['sdm-sallary-allowance-menu', ['sdm-sallary-allowance-read']],
            'sdm-sallary-allowance-read',
            'sdm-sallary-allowance-create',
            'sdm-sallary-allowance-update',
            'sdm-sallary-allowance-delete',
            'sdm-sallary-allowance-confirm-received',
            'sdm-sallary-allowance-cancel-received',

            // sdm resign management
            ['sdm-resign-management-menu', ['sdm-resign-management-read']],
            'sdm-resign-management-read',
            'sdm-resign-management-create',
            'sdm-resign-management-update',
            'sdm-resign-management-delete',
            'sdm-resign-management-confirm',
            'sdm-resign-management-cancel',
            'sdm-resign-management-approval-1',
            'sdm-resign-management-approval-2',

            // sdm job vacancy management
            ['sdm-job-vacancy-menu', ['sdm-job-vacancy-read']],
            'sdm-job-vacancy-read',
            'sdm-job-vacancy-create',
            'sdm-job-vacancy-update',
            'sdm-job-vacancy-delete',
            'sdm-job-vacancy-publish',
            'sdm-job-vacancy-cancel-publish',

            // sdm job applicant
            ['sdm-job-applicants-menu', ['sdm-job-applicants-read']],
            'sdm-job-applicants-read',
            'sdm-job-applicants-approve',

            // sdm quiz management
            ['sdm-quiz-management-menu', ['sdm-quiz-management-read']],
            'sdm-quiz-management-read',
            'sdm-quiz-management-create',
            'sdm-quiz-management-update',
            'sdm-quiz-management-delete',
            'sdm-quiz-management-update-status',

            // sdm job test schedule
            ['sdm-job-test-schedule-menu', ['sdm-job-test-schedule-read']],
            'sdm-job-test-schedule-read',
            'sdm-job-test-schedule-create',
            'sdm-job-test-schedule-update',
            'sdm-job-test-schedule-delete',
            'sdm-job-test-schedule-assign-quiz',
            'sdm-job-test-schedule-send-notif',

            // sdm applicant test result
            ['sdm-job-applicant-test-result-menu', ['sdm-job-applicant-test-result-read']],
            'sdm-job-applicant-test-result-read',
            'sdm-job-applicant-test-result-confirm-1',
            'sdm-job-applicant-test-result-confirm-2',

            // sdm applicant test result interview
            ['sdm-job-applicant-interview-menu', ['sdm-job-applicant-interview-read']],
            'sdm-job-applicant-interview-read',
            'sdm-job-applicant-interview-confirm',

            // sdm employee mutation
            ['sdm-employee-mutation-menu', ['sdm-employee-mutation-read']],
            'sdm-employee-mutation-read',
            'sdm-employee-mutation-create',
            'sdm-employee-mutation-delete',
            'sdm-employee-mutation-confirm',

            // stock monitoring
            ['stock-monitoring-menu', ['stock-monitoring-read']],
            'stock-monitoring-read',

            // stock transfer ( stock transfer without delivery data : outlet transfer, return packaging )
            ['stock-transfer-menu', ['stock-transfer-read']],
            'stock-transfer-read',
            'stock-transfer-create',
            'stock-transfer-update',
            'stock-transfer-delete',
            'stock-transfer-confirm-approval',
            'stock-transfer-confirm-sent',
            'stock-transfer-confirm-received',

            // mobile permissions
            'mobile-permissions',
        ];

        Schema::disableForeignKeyConstraints();
        permissions::query()->truncate();
        Schema::enableForeignKeyConstraints();
        foreach ($data as $i => $value) {
            permissions::create([
                'slug' => is_array($value) ? $value[0] : $value,
                'special_permissions' => is_array($value) ? (is_array($value[1]) ? json_encode($value[1]) : null) : null
            ]);
        }
    }
}
