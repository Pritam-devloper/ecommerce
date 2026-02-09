<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Seller;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin User ──
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@shopzone.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // ── Buyer Users ──
        $buyer1 = User::create([
            'name' => 'Rahul Sharma',
            'email' => 'buyer@shopzone.com',
            'password' => Hash::make('password'),
            'role' => 'buyer',
            'phone' => '9876543210',
            'is_active' => true,
        ]);

        $buyer2 = User::create([
            'name' => 'Priya Patel',
            'email' => 'priya@shopzone.com',
            'password' => Hash::make('password'),
            'role' => 'buyer',
            'phone' => '9876543211',
            'is_active' => true,
        ]);

        // ── Seller Users ──
        $sellerUser1 = User::create([
            'name' => 'Amit Electronics',
            'email' => 'seller@shopzone.com',
            'password' => Hash::make('password'),
            'role' => 'seller',
            'phone' => '9876543212',
            'is_active' => true,
        ]);

        $sellerUser2 = User::create([
            'name' => 'Fashion Hub',
            'email' => 'fashion@shopzone.com',
            'password' => Hash::make('password'),
            'role' => 'seller',
            'phone' => '9876543213',
            'is_active' => true,
        ]);

        $sellerUser3 = User::create([
            'name' => 'Book World',
            'email' => 'books@shopzone.com',
            'password' => Hash::make('password'),
            'role' => 'seller',
            'phone' => '9876543214',
            'is_active' => true,
        ]);

        // ── Sellers ──
        $seller1 = Seller::create([
            'user_id' => $sellerUser1->id,
            'shop_name' => 'Amit Electronics Store',
            'slug' => 'amit-electronics-store',
            'description' => 'Best quality electronics and gadgets at amazing prices.',
            'phone' => '9876543212',
            'address' => 'MG Road, Bangalore',
            'status' => 'approved',
            'commission_rate' => 10,
            'balance' => 5000,
        ]);

        $seller2 = Seller::create([
            'user_id' => $sellerUser2->id,
            'shop_name' => 'Fashion Hub Store',
            'slug' => 'fashion-hub-store',
            'description' => 'Trendy clothing and accessories for everyone.',
            'phone' => '9876543213',
            'address' => 'Linking Road, Mumbai',
            'status' => 'approved',
            'commission_rate' => 12,
            'balance' => 3500,
        ]);

        $seller3 = Seller::create([
            'user_id' => $sellerUser3->id,
            'shop_name' => 'Book World Store',
            'slug' => 'book-world-store',
            'description' => 'Wide collection of books across all genres.',
            'phone' => '9876543214',
            'address' => 'College Street, Kolkata',
            'status' => 'pending',
            'commission_rate' => 8,
            'balance' => 0,
        ]);

        // ── Categories ──
        $electronics = Category::create(['name' => 'Electronics', 'slug' => 'electronics', 'description' => 'Electronic gadgets and devices', 'is_active' => true, 'sort_order' => 1]);
        $fashion = Category::create(['name' => 'Fashion', 'slug' => 'fashion', 'description' => 'Clothing and accessories', 'is_active' => true, 'sort_order' => 2]);
        $books = Category::create(['name' => 'Books', 'slug' => 'books', 'description' => 'Books and educational material', 'is_active' => true, 'sort_order' => 3]);
        $home = Category::create(['name' => 'Home & Living', 'slug' => 'home-living', 'description' => 'Home decor and furnishing', 'is_active' => true, 'sort_order' => 4]);
        $sports = Category::create(['name' => 'Sports & Fitness', 'slug' => 'sports-fitness', 'description' => 'Sports equipment and fitness gear', 'is_active' => true, 'sort_order' => 5]);
        $beauty = Category::create(['name' => 'Beauty & Health', 'slug' => 'beauty-health', 'description' => 'Beauty products and health essentials', 'is_active' => true, 'sort_order' => 6]);

        // Sub-categories
        Category::create(['name' => 'Smartphones', 'slug' => 'smartphones', 'parent_id' => $electronics->id, 'is_active' => true, 'sort_order' => 1]);
        Category::create(['name' => 'Laptops', 'slug' => 'laptops', 'parent_id' => $electronics->id, 'is_active' => true, 'sort_order' => 2]);
        Category::create(['name' => "Men's Wear", 'slug' => 'mens-wear', 'parent_id' => $fashion->id, 'is_active' => true, 'sort_order' => 1]);
        Category::create(['name' => "Women's Wear", 'slug' => 'womens-wear', 'parent_id' => $fashion->id, 'is_active' => true, 'sort_order' => 2]);

        // ── Products ──
        $products = [
            ['name' => 'Wireless Bluetooth Headphones', 'slug' => 'wireless-bluetooth-headphones', 'seller_id' => $seller1->id, 'category_id' => $electronics->id, 'description' => 'Premium wireless headphones with noise cancellation, 30-hour battery life, and deep bass.', 'price' => 2999, 'discount_price' => 1999, 'stock' => 50, 'sku' => 'ELC-001', 'brand' => 'SoundMax', 'status' => 'approved', 'is_active' => true, 'is_featured' => true],
            ['name' => 'Smart Watch Pro X', 'slug' => 'smart-watch-pro-x', 'seller_id' => $seller1->id, 'category_id' => $electronics->id, 'description' => 'Advanced smartwatch with heart rate monitor, GPS tracking, and water resistance up to 50m.', 'price' => 5999, 'discount_price' => 4499, 'stock' => 30, 'sku' => 'ELC-002', 'brand' => 'TechFit', 'status' => 'approved', 'is_active' => true, 'is_featured' => true],
            ['name' => 'USB-C Fast Charger 65W', 'slug' => 'usb-c-fast-charger-65w', 'seller_id' => $seller1->id, 'category_id' => $electronics->id, 'description' => '65W GaN fast charger compatible with laptops, tablets, and smartphones.', 'price' => 1499, 'discount_price' => 999, 'stock' => 100, 'sku' => 'ELC-003', 'brand' => 'PowerUp', 'status' => 'approved', 'is_active' => true, 'is_flash_sale' => true],
            ['name' => 'Mechanical Gaming Keyboard', 'slug' => 'mechanical-gaming-keyboard', 'seller_id' => $seller1->id, 'category_id' => $electronics->id, 'description' => 'RGB mechanical keyboard with Cherry MX switches and programmable macros.', 'price' => 3499, 'discount_price' => null, 'stock' => 25, 'sku' => 'ELC-004', 'brand' => 'KeyMaster', 'status' => 'approved', 'is_active' => true],
            ['name' => 'Portable Bluetooth Speaker', 'slug' => 'portable-bluetooth-speaker', 'seller_id' => $seller1->id, 'category_id' => $electronics->id, 'description' => 'Waterproof portable speaker with 360 sound and 20-hour battery.', 'price' => 1999, 'discount_price' => 1499, 'stock' => 40, 'sku' => 'ELC-005', 'brand' => 'SoundMax', 'status' => 'approved', 'is_active' => true, 'is_flash_sale' => true],
            ['name' => 'Premium Cotton T-Shirt', 'slug' => 'premium-cotton-t-shirt', 'seller_id' => $seller2->id, 'category_id' => $fashion->id, 'description' => '100% organic cotton t-shirt, comfortable fit, available in multiple colors.', 'price' => 799, 'discount_price' => 499, 'stock' => 200, 'sku' => 'FSH-001', 'brand' => 'ComfortWear', 'status' => 'approved', 'is_active' => true, 'is_featured' => true],
            ['name' => 'Slim Fit Denim Jeans', 'slug' => 'slim-fit-denim-jeans', 'seller_id' => $seller2->id, 'category_id' => $fashion->id, 'description' => 'Classic slim fit jeans with stretch denim for maximum comfort.', 'price' => 1599, 'discount_price' => 1199, 'stock' => 80, 'sku' => 'FSH-002', 'brand' => 'DenimCo', 'status' => 'approved', 'is_active' => true],
            ['name' => 'Leather Wallet for Men', 'slug' => 'leather-wallet-for-men', 'seller_id' => $seller2->id, 'category_id' => $fashion->id, 'description' => 'Genuine leather bi-fold wallet with RFID protection.', 'price' => 999, 'discount_price' => 699, 'stock' => 60, 'sku' => 'FSH-003', 'brand' => 'LeatherCraft', 'status' => 'approved', 'is_active' => true, 'is_flash_sale' => true],
            ['name' => 'Running Shoes AirFlex', 'slug' => 'running-shoes-airflex', 'seller_id' => $seller2->id, 'category_id' => $sports->id, 'description' => 'Lightweight running shoes with air cushion technology.', 'price' => 3499, 'discount_price' => 2799, 'stock' => 45, 'sku' => 'SPT-001', 'brand' => 'AirFlex', 'status' => 'approved', 'is_active' => true, 'is_featured' => true],
            ['name' => 'Yoga Mat Premium', 'slug' => 'yoga-mat-premium', 'seller_id' => $seller2->id, 'category_id' => $sports->id, 'description' => 'Anti-slip yoga mat with alignment lines. 6mm thick.', 'price' => 1299, 'discount_price' => 899, 'stock' => 70, 'sku' => 'SPT-002', 'brand' => 'ZenFit', 'status' => 'approved', 'is_active' => true],
            ['name' => 'The Psychology of Money', 'slug' => 'psychology-of-money', 'seller_id' => $seller3->id, 'category_id' => $books->id, 'description' => 'Timeless lessons on wealth, greed, and happiness by Morgan Housel.', 'price' => 399, 'discount_price' => 299, 'stock' => 150, 'sku' => 'BK-001', 'brand' => 'Jaico Publishing', 'status' => 'pending', 'is_active' => true],
            ['name' => 'Atomic Habits', 'slug' => 'atomic-habits', 'seller_id' => $seller3->id, 'category_id' => $books->id, 'description' => 'An Easy & Proven Way to Build Good Habits & Break Bad Ones by James Clear.', 'price' => 499, 'discount_price' => 349, 'stock' => 120, 'sku' => 'BK-002', 'brand' => 'Penguin', 'status' => 'pending', 'is_active' => true],
        ];

        foreach ($products as $p) {
            Product::create($p);
        }

        // ── Settings ──
        $settings = [
            'site_name' => 'ShopZone',
            'site_description' => 'Your one-stop multi-vendor e-commerce marketplace',
            'contact_email' => 'support@shopzone.com',
            'contact_phone' => '+91 1800 123 4567',
            'default_commission' => '10',
            'shipping_charge' => '50',
            'free_shipping_above' => '500',
            'min_withdrawal' => '100',
        ];

        foreach ($settings as $key => $value) {
            Setting::set($key, $value);
        }

        // ── Addresses ──
        $buyer1->addresses()->create([
            'name' => 'Rahul Sharma',
            'phone' => '9876543210',
            'address_line' => '123, MG Road, Indiranagar',
            'city' => 'Bangalore',
            'state' => 'Karnataka',
            'zip_code' => '560038',
            'country' => 'India',
            'is_default' => true,
        ]);

        $buyer2->addresses()->create([
            'name' => 'Priya Patel',
            'phone' => '9876543211',
            'address_line' => '45, Juhu Beach Road',
            'city' => 'Mumbai',
            'state' => 'Maharashtra',
            'zip_code' => '400049',
            'country' => 'India',
            'is_default' => true,
        ]);

        echo "Database seeded successfully!\n";
        echo "Admin:  admin@shopzone.com / password\n";
        echo "Buyer:  buyer@shopzone.com / password\n";
        echo "Seller: seller@shopzone.com / password\n";
    }
}
