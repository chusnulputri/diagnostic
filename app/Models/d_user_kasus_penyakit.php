<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class d_user_kasus_penyakit extends Model
{
    protected $table      = 'd_user_kasus_penyakit';
    protected $primaryKey = 'ukp_id';

    public function d_user_kasus() {
        return $this->belongTo(d_user_kasus::class, 'uk_id', 'ukp_user_kasus_id');
    }
    
    public function detail(){
        return $this->hasMany(d_user_kasus_penyakit_detail::class, 'ukpd_kasus_penyakit_id', 'ukp_id');
    }
}