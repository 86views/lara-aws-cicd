<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RuleConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $conditions = [
            // Rule 1 - Premium Electronics: type == electronics AND price > 100
            ['rule_id' => 1, 'product_selector' => 'type',  'operator' => '==', 'value' => 'electronics', 'created_at' => now(), 'updated_at' => now()],
            ['rule_id' => 1, 'product_selector' => 'price', 'operator' => '>',  'value' => '100',         'created_at' => now(), 'updated_at' => now()],

            // Rule 2 - Budget Accessories: type == accessories AND price < 50
            ['rule_id' => 2, 'product_selector' => 'type',  'operator' => '==', 'value' => 'accessories', 'created_at' => now(), 'updated_at' => now()],
            ['rule_id' => 2, 'product_selector' => 'price', 'operator' => '<',  'value' => '50',          'created_at' => now(), 'updated_at' => now()],

            // Rule 3 - Low Stock Alert: qty < 10
            ['rule_id' => 3, 'product_selector' => 'qty',   'operator' => '<',  'value' => '10',          'created_at' => now(), 'updated_at' => now()],

            // Rule 4 - Logitech Products: vendor == Logitech
            ['rule_id' => 4, 'product_selector' => 'vendor','operator' => '==', 'value' => 'Logitech',    'created_at' => now(), 'updated_at' => now()],

            // Rule 5 - Furniture Items: type == furniture
            ['rule_id' => 5, 'product_selector' => 'type',  'operator' => '==', 'value' => 'furniture',   'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('rule_conditions')->insert($conditions);
    }
}
