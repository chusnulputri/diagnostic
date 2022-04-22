<?php

namespace App\Providers;

use App\Models\permissions;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class PermissionsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        try {
            $requestAgent = $_SERVER['HTTP_USER_AGENT'] ?? null;
            permissions::get()->map(function ($permission) use ($requestAgent) {
                Gate::define($permission->slug, function ($userAuth) use ($permission, $requestAgent) {
                    // start: temporary, delete later
                    // return true;
                    // end
                    if ($userAuth->uc_user_id == 0) {
                        return true;
                    }
                    /* disabled for dev purpose, enable it in live production */
                    $position = $userAuth->position;
                    if (preg_match('/\bDart\b/',$requestAgent)) {
                        $hasMobilePermission = true;
                        // if ($position) {
                        //     $hasMobilePermission = $position->hasPermissionTo('mobile-permissions');
                        // }
                        return $hasMobilePermission;
                    }
                    return $position->hasPermissionTo($permission->slug);
                });
            });
        } catch (\Throwable $th) {
            Log::debug('permissions', [
                'data' => [
                    'message' => $th->getMessage()
                ]
            ]);
            return false;
        }
    }
}
