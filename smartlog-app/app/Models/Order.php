<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'order_id',
        'Booking_number',
        'customer_name',
        'transport_type',
        'order_type',
        'services',
        'amount',
        'number_of_tons',
        'number_of_m3',
        'receive_order_address',
        'delivery_address',
        'pakage_group',
        'pakage_type',
        'cut_off_time',
        'order_status',
        'order_date',
    ];
}
