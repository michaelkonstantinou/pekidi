<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Declaration extends Model
{
    protected $fillable = ['name', 'full_name', 'born_at', 'home_address', 'national_id', 'user_id'];
}
