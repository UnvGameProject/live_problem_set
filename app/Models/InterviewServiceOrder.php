<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterviewServiceOrder extends Model
{
    protected $fillable = [
        'order_id',
        'customer_name',
        'vehicle_id',
        'technician',
        'status',
        'priority',
        'labor_hours',
        'parts_cost',
    ];

    protected $casts = [
        'labor_hours' => 'decimal:2',
        'parts_cost' => 'decimal:2',
    ];
}
