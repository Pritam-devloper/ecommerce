<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'seller_id', 'category_id', 'name', 'slug', 'description', 'price', 'discount_price',
        'stock', 'sku', 'brand', 'images', 'thumbnail', 'is_active', 'is_featured',
        'is_flash_sale', 'status', 'views',
    ];

    protected $casts = ['images' => 'array', 'is_active' => 'boolean', 'is_featured' => 'boolean', 'is_flash_sale' => 'boolean'];

    public function seller() { return $this->belongsTo(Seller::class); }
    public function category() { return $this->belongsTo(Category::class); }
    public function reviews() { return $this->hasMany(Review::class); }
    public function wishlists() { return $this->hasMany(Wishlist::class); }
    public function cartItems() { return $this->hasMany(Cart::class); }
    public function orderItems() { return $this->hasMany(OrderItem::class); }

    public function getRouteKeyName() { return 'slug'; }

    public function getFinalPriceAttribute()
    {
        return $this->discount_price ?? $this->price;
    }

    public function getDiscountPercentAttribute()
    {
        if ($this->discount_price && $this->price > 0) {
            return round((($this->price - $this->discount_price) / $this->price) * 100);
        }
        return 0;
    }

    public function averageRating()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function scopeApproved($query) { return $query->where('status', 'approved'); }
    public function scopeActive($query) { return $query->where('is_active', true); }
    public function scopeFeatured($query) { return $query->where('is_featured', true); }
    public function scopeFlashSale($query) { return $query->where('is_flash_sale', true); }
}
