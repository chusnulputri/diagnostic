<?php

namespace Database\Seeders;

use App\Models\m_user_company;
use App\Modules\Setting\Notifications\Models\Notifications;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $listUserCompanyIds = m_user_company::get()->pluck('uc_id')->toArray();
        $listNotifType = ['purchase-order', 'cashbon', 'leave', 'resign', 'outlet-stock-transfer'];
        $counter = 100;
        while ($counter > 0) {
            $tempRand = [
                'title' => 'title notif random: ' . Str::random(10),
                'message' => 'Notif random: ' . Str::random(20),
                'url' => url('/aktivitas-sdm/manajemen-staf/cuti-pegawai'),
                'type' => $listNotifType[array_rand($listNotifType)],
            ];
            DB::table('notifications')->insert([
                'id' => Str::uuid()->toString(),
                'type' => 'App\Notifications\GeneralNotifications',
                'notifiable_type' => 'App\Models\m_user_company',
                'notifiable_id' => $listUserCompanyIds[array_rand($listUserCompanyIds)],
                'data' => json_encode($tempRand),
                'read_at' => null,
                'created_at' => now()->parse(mt_rand(100000, time())),
                'updated_at' => null
            ]);
            $counter--;
        }
    }
}
