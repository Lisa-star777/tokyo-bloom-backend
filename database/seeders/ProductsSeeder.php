<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {
       

        foreach ($products as $product) {
            Product::create($product);
        }
        
        echo "✅ Добавлено " . count($products) . " товаров\n";
    }
}
