<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class d_kasus extends Model
{
    protected $table      = 'd_kasus';
    protected $primaryKey = 'k_id';

    protected $guarded = ['id'];
}