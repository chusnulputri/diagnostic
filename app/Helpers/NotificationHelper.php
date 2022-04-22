<?php

namespace App\Helpers;

use App\Jobs\ProcessPushNotifications;
use App\Models\m_user_company;
use App\Models\permision_position;
use App\Models\permissions;
use App\Notifications\GeneralNotifications;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;

class NotificationHelper
{
    public function databaseWithPushNotif($company_id, $slug, $title = 'Notification', $body = null, $url = null, $dataAdditional = [])
    {
        $position_id = [];
        $permisson = permissions::where('slug', $slug)->first();
        
        if ($permisson) {
            $position_id =  permision_position::where('permissions_id', $permisson->id)->pluck('m_position_p_id');
        }

        $user = m_user_company::whereIn('uc_company_id', $company_id);
        if (!empty($position_id)) {
            $user->whereIn('uc_position_id', $position_id);
        }
        $user = $user->get();
        


        $data_value_array = [];
        foreach ($user as $key => $value) {
            $userCompany = m_user_company::where('uc_id', $value->uc_id)->first();
            $details = [
                'message' => $body,
                "url" => $url,
                "title" => $title,
                "data" => $dataAdditional
            ];
            Notification::send($userCompany, new GeneralNotifications($details));
            array_push($data_value_array, $value->uc_notification_token);
        }

        ProcessPushNotifications::dispatch([
            'title' => $title,
            'body' => $body,
            'type' => $dataAdditional[0] ?? null,
            'token' => array_values(array_filter($data_value_array))
        ]);
    }
}
