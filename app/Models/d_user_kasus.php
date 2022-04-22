<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class d_user_kasus extends Model
{
    protected $table      = 'd_user_kasus';
    protected $primaryKey = 'uk_id';

    public function penyakit(){
        return $this->hasMany(d_user_kasus_penyakit::class, 'ukp_user_kasus_id', 'uk_id');
    }
}