<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [

            // Electronics
            ['name' => 'Wireless Mouse',           'price' => 799.00,  'stock_quantity' => 120],
            ['name' => 'Bluetooth Headphones',     'price' => 1499.00, 'stock_quantity' => 80],
            ['name' => 'USB-C Charger 25W',        'price' => 699.00,  'stock_quantity' => 150],
            ['name' => '32GB Pen Drive',           'price' => 449.00,  'stock_quantity' => 200],
            ['name' => 'Laptop Cooling Pad',       'price' => 999.00,  'stock_quantity' => 60],

            // Office Supplies
            ['name' => 'A4 Paper Pack (500 sheets)',  'price' => 350.00, 'stock_quantity' => 300],
            ['name' => 'Stapler Set',                  'price' => 120.00, 'stock_quantity' => 180],
            ['name' => 'Whiteboard Marker Pack',       'price' => 180.00, 'stock_quantity' => 250],

            // Household & General store items
            ['name' => 'LED Desk Lamp',               'price' => 1299.00, 'stock_quantity' => 70],
            ['name' => 'Water Bottle (1L)',           'price' => 199.00,  'stock_quantity' => 220],
            ['name' => 'Portable Storage Box',        'price' => 499.00,  'stock_quantity' => 95],

            // Accessories
            ['name' => 'Mobile Back Cover',           'price' => 249.00,  'stock_quantity' => 300],
            ['name' => 'Tempered Glass Screen Guard', 'price' => 149.00,  'stock_quantity' => 350],
            ['name' => 'Laptop Sleeve 15-inch',       'price' => 999.00,  'stock_quantity' => 50],

            // Miscellaneous
            ['name' => 'Digital Alarm Clock',         'price' => 699.00,  'stock_quantity' => 85],
            ['name' => 'Rechargeable Torch',          'price' => 499.00,  'stock_quantity' => 110],
            ['name' => 'Bluetooth Speaker Mini',      'price' => 899.00,  'stock_quantity' => 75],

        ];

        foreach ($products as $p) {
            Product::create($p);
        }
    }
}
