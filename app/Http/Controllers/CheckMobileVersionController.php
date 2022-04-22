<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckMobileVersionController extends Controller
{
    // get lates playstore app version through env manually
    public function getEnvLatestPlaystoreAppVersion(Request $request)
    {
        $usedVersionCode = $request->version_code;
        $isUpdate = false;
        $isCritical = false;

        $latestVersionCode = env('LATEST_PLAYSTORE_APP_VERSION_CODE');
        $latestVersionNote = env('LATEST_PLAYSTORE_APP_VERSION_NOTE', 'Tidak ada catatan');

        if ($usedVersionCode < $latestVersionCode) {
            $isUpdate = true;
            $isCritical = true;
        }

        $data = [
            'is_critical' => $isCritical,
            'is_update' => $isUpdate,
            'latest_version' => $latestVersionCode,
            'latest_note' => $latestVersionNote
        ];
        return response()->json([
            'status' => 'success',
            'data' => $data,
            'latest_note' => $latestVersionNote
        ]);
    }
}
