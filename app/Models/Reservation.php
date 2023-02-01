<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;

class Reservation extends Model
{
    use HasFactory;
    protected $table = 'reservations';
    protected $fillable = ['location_id', 'service_id', 'customer_id', 't_start', 't_end'];
    public $timestamps = true;

    public function prunable() {
        return static::whereDate('t_end', '<=', date("Y-m-d H:i:s"));
    }
}
