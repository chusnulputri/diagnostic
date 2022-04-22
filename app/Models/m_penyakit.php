<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class m_penyakit extends Model
{
    protected $table      = 'm_penyakit';
    protected $primaryKey = 'p_id';

    protected $guarded = ['id'];

    public function rules(){
        return $this->hasMany(d_rule::class, 'r_penyakit_id', 'p_id');
    }
}