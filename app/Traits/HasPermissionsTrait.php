<?php

namespace App\Traits;

use App\Models\permissions;
use Illuminate\Support\Arr;

/**
 * 
 */
trait HasPermissionsTrait
{
    public function permissions()
    {
        return $this->belongsToMany(permissions::class, 'permision_position');
    }
    
    /**
     * check if has permission or not
     * @param string $permission
     */
    protected function hasPermission($permission)
    {
        return (bool) $this->permissions->where('slug', $permission)->count() || $this->hasPermissionThroughSpecial($permission);
    }

    /**
     * check if user has permission through special-permission
     * @param string $permission
     */
    protected function hasPermissionThroughSpecial($permission)
    {
        return (bool) $this->permissions()->whereJsonContains('special_permissions', $permission)->count();
    }

    /**
     * attach selected permissions to a user
     * @param string $permissions single or multiple string with comma separated
     */
    public function givePermissionsTo(...$permissions)
    {
        $permissions = $this->getAllPermissions($permissions);
        if (is_null($permissions)) {
            return $this;
        }
        $this->permissions()->attach($permissions);
        return $this;
    }

    /**
     * revoke selected permissions from an user
     * @param string $permissions single or multiple string with comma separated
     */
    public function revokePermissions(...$permissions)
    {
        $permissions = $this->getAllPermissions($permissions);
        if (is_null($permissions)) {
            return $this;
        }
        $this->permissions()->detach($permissions);
        return $this;
    }

    /**
     * revoke all permissions then attach selected permissions to a user
     * @param string $permissions single or multiple string with comma separated
     */
    public function refreshPermissions(...$permissions)
    {
        $this->permissions()->detach();
        $this->givePermissionsTo($permissions);
        return $this;
    }

    /**
     * check user if has permission or not
     * @param string $permission
     */
    public function hasPermissionTo($permission)
    {
        return $this->hasPermission($permission);
    }

    /**
     * get selected permission model by 'slug'
     */
    public function getAllPermissions(array $permissions)
    {
        $permissions = Arr::flatten($permissions);
        return permissions::whereIn('slug', $permissions)->get();
    }
}
