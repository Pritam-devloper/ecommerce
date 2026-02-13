<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Product;
use App\Models\User;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        // Create some buyer users if they don't exist
        $buyers = [];
        $buyerData = [
            ['name' => 'Sarah Johnson', 'email' => 'sarah@example.com'],
            ['name' => 'Emily Chen', 'email' => 'emily@example.com'],
            ['name' => 'Michael Brown', 'email' => 'michael@example.com'],
            ['name' => 'Jessica Williams', 'email' => 'jessica@example.com'],
            ['name' => 'David Miller', 'email' => 'david@example.com'],
        ];

        foreach ($buyerData as $data) {
            $buyers[] = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => bcrypt('password'),
                    'role' => 'buyer',
                ]
            );
        }

        // Sample reviews
        $reviews = [
            ['rating' => 5, 'comment' => 'Absolutely stunning! The craftsmanship is exceptional and it looks even better in person.'],
            ['rating' => 5, 'comment' => 'Beautiful piece, exactly as described. Fast shipping and excellent packaging.'],
            ['rating' => 4, 'comment' => 'Lovely jewelry, very elegant. Slightly smaller than expected but still gorgeous.'],
            ['rating' => 5, 'comment' => 'Perfect gift for my wife. She absolutely loves it! Highly recommend.'],
            ['rating' => 5, 'comment' => 'Exquisite quality and timeless design. Worth every penny.'],
            ['rating' => 4, 'comment' => 'Great product, beautiful finish. Delivery was quick.'],
            ['rating' => 5, 'comment' => 'This is my third purchase from AETHER. Never disappointed!'],
            ['rating' => 5, 'comment' => 'Elegant and sophisticated. Compliments everywhere I go.'],
            ['rating' => 4, 'comment' => 'Very nice piece. Good quality for the price.'],
            ['rating' => 5, 'comment' => 'Absolutely love it! The attention to detail is remarkable.'],
        ];

        // Add reviews to random products
        $products = Product::all();
        
        foreach ($products as $product) {
            // Add 2-5 reviews per product
            $reviewCount = rand(2, 5);
            $usedBuyers = [];
            
            for ($i = 0; $i < $reviewCount; $i++) {
                // Get a buyer that hasn't reviewed this product yet
                $availableBuyers = array_filter($buyers, function($buyer) use ($usedBuyers) {
                    return !in_array($buyer->id, $usedBuyers);
                });
                
                if (empty($availableBuyers)) break;
                
                $buyer = $availableBuyers[array_rand($availableBuyers)];
                $usedBuyers[] = $buyer->id;
                
                $reviewData = $reviews[array_rand($reviews)];
                
                Review::updateOrCreate(
                    [
                        'product_id' => $product->id,
                        'user_id' => $buyer->id,
                    ],
                    [
                        'rating' => $reviewData['rating'],
                        'comment' => $reviewData['comment'],
                        'created_at' => now()->subDays(rand(1, 60)),
                    ]
                );
            }
        }

        $this->command->info('Reviews seeded successfully!');
    }
}
