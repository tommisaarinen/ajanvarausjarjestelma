<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $table = 'locations';
    protected $casts = [
        'open' => 'array',
        'available_services' => 'array',
        'open_exceptions' => 'array'
    ];
    protected $fillable = [
        'city',
        'address',
        'zip',
        'name',
        'open',
        'available_services',
        'open_exceptions'
    ];
    public $timestamps = false;
}
