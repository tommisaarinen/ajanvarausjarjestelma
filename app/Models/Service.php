<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'services';
    protected $fillable = ['name', 'available', 't_est', 'cancellable', 'cancel_within'];
}
