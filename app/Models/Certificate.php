<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'value',
        'status',
        'owner_email',
        'buyer_name',
        'used_at',
        'used_by',
        'order_id',
        'expires_at',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'expires_at' => 'datetime',
        'used_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'used_by');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}