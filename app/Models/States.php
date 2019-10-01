<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class States extends Model
{
    protected $fillable = ['code', 'name'];

    protected $hidden = ['created_at', 'updated_at'];
}
