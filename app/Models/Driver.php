<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Driver extends Model
{
    use HasApiTokens;

    protected $table = 'drivers'; 

    protected $fillable = [
        'name',
        'nrp',
        'contact',
        'regency_id',
        'licence_number',
        'licence_active',
        'licence_type',
        'is_active',
    ];
}
