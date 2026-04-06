<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'items',
        'subtotal',
        'delivery_cost',
        'certificate_discount',
        'bonuses_used',
        'total',
        'bonuses_earned',
        'certificate_used',
        'delivery_details',
        'status',
        'status_text',
    ];

    protected $casts = [
        'items' => 'array',
        'certificate_used' => 'array',
        'delivery_details' => 'array',
        'subtotal' => 'decimal:2',
        'delivery_cost' => 'decimal:2',
        'certificate_discount' => 'decimal:2',
        'bonuses_used' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}