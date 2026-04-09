<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
    {
        $rules = [
            ['name' => 'Premium Electronics',  'apply_tags' => 'premium,electronics',   'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Budget Accessories',   'apply_tags' => 'budget,accessories',    'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Low Stock Alert',      'apply_tags' => 'low-stock',             'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Logitech Products',    'apply_tags' => 'logitech,peripherals',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Furniture Items',      'apply_tags' => 'furniture,office',      'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('rules')->insert($rules);
    }
}
