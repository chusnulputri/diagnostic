<?php

namespace App\Models;

use App\Modules\Region\Domestic\Models\ro_cities;
use App\Modules\Region\Domestic\Models\ro_provinces;
use App\Modules\Region\Domestic\Models\ro_subdistricts;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

class User extends Authenticatable
{
    use Notifiable,
        CanResetPassword,
        SoftDeletes,
        HasFactory;

    protected $table      = 'users';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'name',
        'bod',
        'address',
        'gender',
        'email',
    ];
    
    protected $hidden    = [
        'password',
        'remember_token',
    ];

    protected $appends = ['age'];

    public function getAgeAttribute() {
        return Carbon::now()->diffInYears($this->bod);
    }
}
