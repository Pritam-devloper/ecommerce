<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductImageSeeder extends Seeder
{
    public function run(): void
    {
        // Jewelry image URLs from Unsplash
        $jewelryImages = [
            'rings' => [
                'https://images.unsplash.com/photo-1605100804763-247f67b3557e?w=800',
                'https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?w=800',
                'https://images.unsplash.com/photo-1611591437281-460bfbe1220a?w=800',
                'https://images.unsplash.com/photo-1603561591411-07134e71a2a9?w=800',
                'https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?w=800',
            ],
            'necklaces' => [
                'https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?w=800',
                'https://images.unsplash.com/photo-1506630448388-4e683c67ddb0?w=800',
                'https://images.unsplash.com/photo-1617038260897-41a1f14a8ca0?w=800',
                'https://images.unsplash.com/photo-1602173574767-37ac01994b2a?w=800',
            ],
            'bracelets' => [
                'https://images.unsplash.com/photo-1611591437281-460bfbe1220a?w=800',
                'https://images.unsplash.com/photo-1573408301185-9146fe634ad0?w=800',
                'https://images.unsplash.com/photo-1635767798638-3e25273a8236?w=800',
            ],
            'earrings' => [
                'https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?w=800',
                'https://images.unsplash.com/photo-1596944924616-7b38e7cfac36?w=800',
                'https://images.unsplash.com/photo-1535556116002-6281ff3e9f36?w=800',
            ],
            'bridal' => [
                'https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?w=800',
                'https://images.unsplash.com/photo-1605100804763-247f67b3557e?w=800',
                'https://images.unsplash.com/photo-1603561591411-07134e71a2a9?w=800',
            ],
        ];

        $products = Product::with('category')->get();

        foreach ($products as $product) {
            $categoryName = strtolower($product->category->name);
            
            // Determine which image set to use
            $imageSet = match(true) {
                str_contains($categoryName, 'ring') => $jewelryImages['rings'],
                str_contains($categoryName, 'necklace') => $jewelryImages['necklaces'],
                str_contains($categoryName, 'bracelet') => $jewelryImages['bracelets'],
                str_contains($categoryName, 'earring') => $jewelryImages['earrings'],
                str_contains($categoryName, 'bridal') => $jewelryImages['bridal'],
                default => $jewelryImages['rings'],
            };

            // Assign random images from the set
            $selectedImages = array_rand(array_flip($imageSet), min(3, count($imageSet)));
            if (!is_array($selectedImages)) {
                $selectedImages = [$selectedImages];
            }

            // Set thumbnail (first image)
            $thumbnail = $selectedImages[0];
            
            // Set additional images
            $images = array_slice($selectedImages, 1);

            $product->update([
                'thumbnail' => $thumbnail,
                'images' => $images,
            ]);
        }

        $this->command->info('Product images updated successfully!');
    }
}
