<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    protected $fillable = ['user_id', 'shop_name', 'slug', 'description', 'logo', 'banner', 'phone', 'address', 'status', 'commission_rate', 'balance'];

    public function user() { return $this->belongsTo(User::class); }
    public function products() { return $this->hasMany(Product::class); }
    public function orders() { return $this->hasManyThrough(OrderItem::class, Product::class, 'seller_id', 'product_id'); }
    public function orderItems() { return $this->hasMany(OrderItem::class); }
    public function coupons() { return $this->hasMany(Coupon::class); }
    public function withdrawRequests() { return $this->hasMany(WithdrawRequest::class); }

    public function isApproved(): bool { return $this->status === 'approved'; }
    public function getRouteKeyName() { return 'slug'; }
}
