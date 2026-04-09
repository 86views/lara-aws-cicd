<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
      public function run(): void
    {
        $products = [
            [
                'name'        => 'Wireless Mouse',
                'description' => 'Ergonomic wireless mouse with long battery life.',
                'price'       => 29.99,
                'sku'         => 'WM-001',
                'qty'         => 150,
                'type'        => 'electronics',
                'vendor'      => 'Logitech',
                'image'       => null,
                'tags'        => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'Mechanical Keyboard',
                'description' => 'Tactile mechanical keyboard with RGB lighting.',
                'price'       => 89.99,
                'sku'         => 'MK-002',
                'qty'         => 75,
                'type'        => 'electronics',
                'vendor'      => 'Corsair',
                'image'       => null,
                'tags'        => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'USB-C Hub',
                'description' => 'Multi-port USB-C hub with HDMI and ethernet.',
                'price'       => 49.99,
                'sku'         => 'UC-003',
                'qty'         => 200,
                'type'        => 'electronics',
                'vendor'      => 'Anker',
                'image'       => null,
                'tags'        => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'Office Chair',
                'description' => 'Ergonomic office chair with lumbar support.',
                'price'       => 299.99,
                'sku'         => 'OC-004',
                'qty'         => 30,
                'type'        => 'furniture',
                'vendor'      => 'Herman Miller',
                'image'       => null,
                'tags'        => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'Standing Desk',
                'description' => 'Height-adjustable standing desk.',
                'price'       => 499.99,
                'sku'         => 'SD-005',
                'qty'         => 15,
                'type'        => 'furniture',
                'vendor'      => 'Flexispot',
                'image'       => null,
                'tags'        => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'Laptop Stand',
                'description' => 'Aluminium adjustable laptop stand.',
                'price'       => 39.99,
                'sku'         => 'LS-006',
                'qty'         => 5,
                'type'        => 'accessories',
                'vendor'      => 'Nexstand',
                'image'       => null,
                'tags'        => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'Monitor 27"',
                'description' => '4K IPS monitor with 144Hz refresh rate.',
                'price'       => 649.99,
                'sku'         => 'MN-007',
                'qty'         => 40,
                'type'        => 'electronics',
                'vendor'      => 'LG',
                'image'       => null,
                'tags'        => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'Webcam HD',
                'description' => '1080p webcam with built-in microphone.',
                'price'       => 59.99,
                'sku'         => 'WC-008',
                'qty'         => 3,
                'type'        => 'electronics',
                'vendor'      => 'Logitech',
                'image'       => null,
                'tags'        => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'Desk Lamp',
                'description' => 'LED desk lamp with adjustable brightness.',
                'price'       => 24.99,
                'sku'         => 'DL-009',
                'qty'         => 0,
                'type'        => 'accessories',
                'vendor'      => 'BenQ',
                'image'       => null,
                'tags'        => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'Noise Cancelling Headphones',
                'description' => 'Over-ear headphones with active noise cancellation.',
                'price'       => 199.99,
                'sku'         => 'NC-010',
                'qty'         => 60,
                'type'        => 'electronics',
                'vendor'      => 'Sony',
                'image'       => null,
                'tags'        => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ];

        DB::table('products')->insert($products);
    }
}
