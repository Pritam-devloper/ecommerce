<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = ['seller_id', 'code', 'type', 'value', 'min_order', 'max_uses', 'used', 'expires_at', 'is_active'];
    protected $casts = ['expires_at' => 'date', 'is_active' => 'boolean'];

    public function seller() { return $this->belongsTo(Seller::class); }

    public function isValid(): bool
    {
        return $this->is_active && $this->used < $this->max_uses && (!$this->expires_at || $this->expires_at->isFuture());
    }

    public function calculateDiscount(float $subtotal): float
    {
        if ($subtotal < $this->min_order) return 0;
        return $this->type === 'percent'
            ? round($subtotal * ($this->value / 100), 2)
            : min($this->value, $subtotal);
    }
}
