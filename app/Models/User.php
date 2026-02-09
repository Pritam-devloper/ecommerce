<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'phone', 'avatar', 'is_active',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function isAdmin(): bool { return $this->role === 'admin'; }
    public function isSeller(): bool { return $this->role === 'seller'; }
    public function isBuyer(): bool { return $this->role === 'buyer'; }

    public function seller() { return $this->hasOne(Seller::class); }
    public function orders() { return $this->hasMany(Order::class); }
    public function wishlist() { return $this->hasMany(Wishlist::class); }
    public function addresses() { return $this->hasMany(Address::class); }
    public function reviews() { return $this->hasMany(Review::class); }
    public function cart() { return $this->hasMany(Cart::class); }
}
