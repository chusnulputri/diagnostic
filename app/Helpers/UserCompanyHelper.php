<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

if (!function_exists('getUserDetail')) {
    /**
     * @param Illuminate\Http\Request $request
     */
    function getUserDetail(Request $request = null)
    {
        if ($request) {
            $userCompany = $request->user();
        } else {
            $userCompany = Auth::user();
        }
        if (!$userCompany) {
            return null;
        }
        $user = User::find($userCompany->id);
        return $user;
    }
}