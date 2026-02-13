<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Support\Str;

class JewelryProductSeeder extends Seeder
{
    public function run(): void
    {
        // Create jewelry categories
        $categories = [
            'Rings' => 'Elegant rings for every occasion',
            'Necklaces' => 'Beautiful necklaces and pendants',
            'Bracelets' => 'Stunning bracelets and bangles',
            'Earrings' => 'Exquisite earrings collection',
            'Bridal' => 'Special bridal jewelry sets',
        ];

        $categoryModels = [];
        foreach ($categories as $name => $description) {
            $categoryModels[$name] = Category::firstOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'description' => $description,
                    'is_active' => true,
                ]
            );
        }

        // Create or get a seller
        $adminUser = User::where('role', 'admin')->first();
        if (!$adminUser) {
            $adminUser = User::create([
                'name' => 'Admin',
                'email' => 'admin@aether.com',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]);
        }

        $seller = Seller::firstOrCreate(
            ['user_id' => $adminUser->id],
            [
                'shop_name' => 'AETHER Collection',
                'slug' => 'aether-collection',
                'description' => 'Premium handcrafted jewelry',
                'status' => 'approved',
                'commission_rate' => 10,
            ]
        );

        // Jewelry products data
        $products = [
            // Rings
            [
                'name' => 'Sixteen Stone by Tiffany',
                'category' => 'Rings',
                'description' => 'Tiffany\'s 16 expression of love\'s everlasting beauty, showcased in a singular design. Inspired by the icon, this band is crafted with 16 round brilliant diamonds set in platinum. Shown with Tiffany Soleste® band in platinum with diamonds.',
                'price' => 75000,
                'discount_price' => 67500,
                'stock' => 15,
                'brand' => 'Tiffany & Co',
                'is_featured' => true,
            ],
            [
                'name' => 'Aria Command',
                'category' => 'Rings',
                'description' => 'A stunning eternity band featuring brilliant-cut diamonds set in 18k yellow gold. Perfect for everyday elegance.',
                'price' => 42000,
                'discount_price' => null,
                'stock' => 20,
                'brand' => 'AETHER',
                'is_featured' => true,
            ],
            [
                'name' => 'Love Aria Command',
                'category' => 'Rings',
                'description' => 'Delicate half-eternity ring with pavé diamonds in 18k yellow gold. A timeless piece for any collection.',
                'price' => 39000,
                'discount_price' => 35100,
                'stock' => 18,
                'brand' => 'AETHER',
                'is_flash_sale' => true,
            ],
            [
                'name' => 'Rotary Infinity',
                'category' => 'Rings',
                'description' => 'Classic platinum band with alternating round diamonds. Sophisticated and versatile design.',
                'price' => 72000,
                'discount_price' => null,
                'stock' => 12,
                'brand' => 'Cartier',
                'is_featured' => false,
            ],
            [
                'name' => 'Elliot Half',
                'category' => 'Rings',
                'description' => 'Elegant half-eternity band in white gold with brilliant diamonds. Perfect for stacking or wearing alone.',
                'price' => 48000,
                'discount_price' => 43200,
                'stock' => 25,
                'brand' => 'AETHER',
                'is_flash_sale' => true,
            ],

            // Necklaces
            [
                'name' => 'Vintage Pearl Pendant',
                'category' => 'Necklaces',
                'description' => 'Exquisite freshwater pearl pendant on a delicate 18k gold chain. A timeless classic.',
                'price' => 35000,
                'discount_price' => 31500,
                'stock' => 30,
                'brand' => 'AETHER',
                'is_featured' => true,
            ],
            [
                'name' => 'Diamond Solitaire Necklace',
                'category' => 'Necklaces',
                'description' => 'Single brilliant-cut diamond suspended on a platinum chain. Simple elegance at its finest.',
                'price' => 85000,
                'discount_price' => null,
                'stock' => 10,
                'brand' => 'Tiffany & Co',
                'is_featured' => true,
            ],
            [
                'name' => 'Amber Stone Choker',
                'category' => 'Necklaces',
                'description' => 'Vintage-inspired choker with amber stones set in antique gold. Statement piece for special occasions.',
                'price' => 52000,
                'discount_price' => 46800,
                'stock' => 8,
                'brand' => 'AETHER',
                'is_flash_sale' => true,
            ],

            // Bracelets
            [
                'name' => 'Tennis Bracelet Classic',
                'category' => 'Bracelets',
                'description' => 'Classic tennis bracelet with round brilliant diamonds in platinum. Timeless sophistication.',
                'price' => 125000,
                'discount_price' => null,
                'stock' => 6,
                'brand' => 'Cartier',
                'is_featured' => true,
            ],
            [
                'name' => 'Gold Chain Bracelet',
                'category' => 'Bracelets',
                'description' => 'Delicate 18k gold chain bracelet with adjustable clasp. Perfect for layering.',
                'price' => 28000,
                'discount_price' => 25200,
                'stock' => 35,
                'brand' => 'AETHER',
                'is_flash_sale' => true,
            ],
            [
                'name' => 'Vintage Bangle Set',
                'category' => 'Bracelets',
                'description' => 'Set of three vintage-inspired bangles in mixed metals. Stackable and versatile.',
                'price' => 45000,
                'discount_price' => null,
                'stock' => 15,
                'brand' => 'AETHER',
                'is_featured' => false,
            ],

            // Earrings
            [
                'name' => 'Diamond Stud Earrings',
                'category' => 'Earrings',
                'description' => 'Classic diamond stud earrings in platinum settings. Essential for every jewelry collection.',
                'price' => 95000,
                'discount_price' => null,
                'stock' => 20,
                'brand' => 'Tiffany & Co',
                'is_featured' => true,
            ],
            [
                'name' => 'Pearl Drop Earrings',
                'category' => 'Earrings',
                'description' => 'Elegant freshwater pearl drops with gold accents. Perfect for formal occasions.',
                'price' => 32000,
                'discount_price' => 28800,
                'stock' => 25,
                'brand' => 'AETHER',
                'is_flash_sale' => true,
            ],
            [
                'name' => 'Hoop Earrings Gold',
                'category' => 'Earrings',
                'description' => 'Classic 18k gold hoop earrings. Versatile and timeless design.',
                'price' => 24000,
                'discount_price' => null,
                'stock' => 40,
                'brand' => 'AETHER',
                'is_featured' => false,
            ],

            // Bridal
            [
                'name' => 'Bridal Set Deluxe',
                'category' => 'Bridal',
                'description' => 'Complete bridal jewelry set including necklace, earrings, and bracelet. Exquisite craftsmanship with diamonds and pearls.',
                'price' => 250000,
                'discount_price' => 225000,
                'stock' => 5,
                'brand' => 'AETHER',
                'is_featured' => true,
            ],
            [
                'name' => 'Engagement Ring Solitaire',
                'category' => 'Bridal',
                'description' => 'Stunning solitaire engagement ring with 2-carat diamond in platinum setting. Certified diamond included.',
                'price' => 350000,
                'discount_price' => null,
                'stock' => 3,
                'brand' => 'Tiffany & Co',
                'is_featured' => true,
            ],
        ];

        foreach ($products as $productData) {
            $category = $categoryModels[$productData['category']];
            
            Product::create([
                'seller_id' => $seller->id,
                'category_id' => $category->id,
                'name' => $productData['name'],
                'slug' => Str::slug($productData['name']),
                'description' => $productData['description'],
                'price' => $productData['price'],
                'discount_price' => $productData['discount_price'],
                'stock' => $productData['stock'],
                'sku' => 'JWL-' . strtoupper(Str::random(8)),
                'brand' => $productData['brand'],
                'is_active' => true,
                'is_featured' => $productData['is_featured'] ?? false,
                'is_flash_sale' => $productData['is_flash_sale'] ?? false,
                'status' => 'approved',
                'views' => rand(50, 500),
            ]);
        }

        $this->command->info('Jewelry products seeded successfully!');
    }
}
