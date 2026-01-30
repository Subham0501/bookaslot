<?php

namespace Database\Seeders;

use App\Models\Gift;
use App\Models\GiftAddon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create actual gifts (not boxes)
        $gifts = [
            [
                'name' => 'Photo Frame with LED Lights',
                'description' => 'Beautiful photo frame with LED lights to display your memories beautifully.',
                'price' => 1200.00,
                'sort_order' => 1,
            ],
            [
                'name' => 'LED Photo Frame (Small)',
                'description' => 'Small LED photo frame - perfect for desk or table.',
                'price' => 900.00,
                'sort_order' => 2,
            ],
            [
                'name' => 'LED Photo Frame (Large)',
                'description' => 'Large LED photo frame - makes a statement piece.',
                'price' => 1500.00,
                'sort_order' => 3,
            ],
            [
                'name' => 'Premium Chocolates Box',
                'description' => 'Delicious premium chocolates in an elegant gift box.',
                'price' => 800.00,
                'sort_order' => 4,
            ],
            [
                'name' => 'Chocolate Gift Set',
                'description' => 'Premium chocolate gift set with assorted flavors.',
                'price' => 1000.00,
                'sort_order' => 5,
            ],
            [
                'name' => 'Fresh Flower Bouquet',
                'description' => 'Beautiful fresh flower bouquet to make your gift extra special.',
                'price' => 1500.00,
                'sort_order' => 6,
            ],
            [
                'name' => 'Rose Bouquet',
                'description' => 'Elegant red rose bouquet - perfect for expressing love.',
                'price' => 1800.00,
                'sort_order' => 7,
            ],
            [
                'name' => 'Mixed Flower Arrangement',
                'description' => 'Colorful mixed flower arrangement for any occasion.',
                'price' => 1200.00,
                'sort_order' => 8,
            ],
        ];

        // Common Addons that can be added to any gift
        $commonAddons = [
            [
                'name' => 'Photo Frame with LED Lights',
                'description' => 'Beautiful photo frame with LED lights to display your memories beautifully.',
                'price' => 1200.00,
                'sort_order' => 1,
            ],
            [
                'name' => 'Premium Chocolates Box',
                'description' => 'Delicious premium chocolates in an elegant gift box.',
                'price' => 800.00,
                'sort_order' => 2,
            ],
            [
                'name' => 'Fresh Flower Bouquet',
                'description' => 'Beautiful fresh flower bouquet to make your gift extra special.',
                'price' => 1500.00,
                'sort_order' => 3,
            ],
            [
                'name' => 'Rose Bouquet',
                'description' => 'Elegant red rose bouquet - perfect for expressing love.',
                'price' => 1800.00,
                'sort_order' => 4,
            ],
            [
                'name' => 'Mixed Flower Arrangement',
                'description' => 'Colorful mixed flower arrangement for any occasion.',
                'price' => 1200.00,
                'sort_order' => 5,
            ],
            [
                'name' => 'LED Photo Frame (Small)',
                'description' => 'Small LED photo frame - perfect for desk or table.',
                'price' => 900.00,
                'sort_order' => 6,
            ],
            [
                'name' => 'LED Photo Frame (Large)',
                'description' => 'Large LED photo frame - makes a statement piece.',
                'price' => 1500.00,
                'sort_order' => 7,
            ],
            [
                'name' => 'Chocolate Gift Set',
                'description' => 'Premium chocolate gift set with assorted flavors.',
                'price' => 1000.00,
                'sort_order' => 8,
            ],
            [
                'name' => 'Personalized Message Card',
                'description' => 'Add a custom message card with your personal touch.',
                'price' => 200.00,
                'sort_order' => 9,
            ],
            [
                'name' => 'Gift Wrapping',
                'description' => 'Premium gift wrapping with ribbon and bow.',
                'price' => 150.00,
                'sort_order' => 10,
            ],
            [
                'name' => 'Express Delivery',
                'description' => 'Get your gift delivered within 24 hours.',
                'price' => 300.00,
                'sort_order' => 11,
            ],
        ];

        // Create gifts
        foreach ($gifts as $giftData) {
            $gift = Gift::create([
                'name' => $giftData['name'],
                'description' => $giftData['description'],
                'price' => $giftData['price'],
                'is_active' => true,
                'sort_order' => $giftData['sort_order'],
            ]);

            // Add common addons to each gift
            foreach ($commonAddons as $addonData) {
                // Don't add the same item as an addon to itself
                if ($addonData['name'] !== $giftData['name']) {
                    GiftAddon::create([
                        'gift_id' => $gift->id,
                        'name' => $addonData['name'],
                        'description' => $addonData['description'],
                        'price' => $addonData['price'],
                        'is_active' => true,
                        'sort_order' => $addonData['sort_order'],
                    ]);
                }
            }
        }
    }
}
