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
            ['name' => 'Wireless Mouse', 'price_cents' => 7900, 'stock_quantity' => 20],
            ['name' => 'Mechanical Keyboard', 'price_cents' => 24900, 'stock_quantity' => 10],
            ['name' => 'USB-C Hub', 'price_cents' => 11900, 'stock_quantity' => 7],
            ['name' => 'Laptop Stand', 'price_cents' => 8900, 'stock_quantity' => 4], 
        ];

        foreach ($products as $data) {
            Product::updateOrCreate(['name' => $data['name']], $data);
        }
    }
}
