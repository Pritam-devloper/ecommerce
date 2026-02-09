<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number', 'user_id', 'address_id', 'subtotal', 'discount', 'shipping',
        'total', 'status', 'payment_method', 'payment_status', 'coupon_code', 'notes',
        'shipped_at', 'delivered_at',
    ];
    protected $casts = ['shipped_at' => 'datetime', 'delivered_at' => 'datetime'];

    public function user() { return $this->belongsTo(User::class); }
    public function address() { return $this->belongsTo(Address::class); }
    public function items() { return $this->hasMany(OrderItem::class); }

    public static function generateOrderNumber(): string
    {
        return 'ORD-' . strtoupper(uniqid());
    }
}
