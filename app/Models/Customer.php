<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'subscription', 'gender', 'dob', 'additional_info', 'preferences',
        'user_id',
    ];
}
