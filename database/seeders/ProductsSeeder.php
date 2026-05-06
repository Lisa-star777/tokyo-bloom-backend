<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Букеты
            [
                'title' => 'Нежность',
                'price' => 3500,
                'category' => 'bouquets',
                'description' => 'Нежный букет из пионов и эустомы',
                'materials' => 'Пионы, эустома, зелень',
                'image_url' => 'https://images.unsplash.com/photo-1591886960571-74d43a9d4166?w=600',
            ],
            [
                'title' => 'Счастье',
                'price' => 4500,
                'category' => 'bouquets',
                'description' => 'Яркий букет из роз и гербер',
                'materials' => 'Розы, герберы, альстромерия',
                'image_url' => 'https://images.unsplash.com/photo-1561181286-d3fee7d55364?w=600',
            ],
            [
                'title' => 'Любовь',
                'price' => 5500,
                'category' => 'bouquets',
                'description' => 'Роскошный букет из 101 розы',
                'materials' => 'Розы красные',
                'image_url' => 'https://images.unsplash.com/photo-1546842931-886c185b4c8c?w=600',
            ],
            [
                'title' => 'Весеннее настроение',
                'price' => 3800,
                'category' => 'bouquets',
                'description' => 'Яркий весенний букет',
                'materials' => 'Тюльпаны, ирисы, гипсофила',
                'image_url' => 'https://images.unsplash.com/photo-1589123053646-4e8c49d46b0a?w=600',
            ],
            
            // Подарки
            [
                'title' => 'Медвежонок',
                'price' => 1500,
                'category' => 'gifts',
                'description' => 'Плюшевый мишка',
                'materials' => 'Плюш, текстиль',
                'image_url' => 'https://images.unsplash.com/photo-1559715541-5daf8a5a4a3a?w=600',
            ],
            [
                'title' => 'Шоколад премиум',
                'price' => 1200,
                'category' => 'gifts',
                'description' => 'Коробка бельгийского шоколада',
                'materials' => 'Шоколад, упаковка',
                'image_url' => 'https://images.unsplash.com/photo-1549007994-cb92caebd54b?w=600',
            ],
            [
                'title' => 'Воздушные шары',
                'price' => 800,
                'category' => 'gifts',
                'description' => 'Набор гелиевых шаров',
                'materials' => 'Латекс, гелий, лента',
                'image_url' => 'https://images.unsplash.com/photo-1530103862676-de8c9debad1d?w=600',
            ],
            
            // Цветы в коробках
            [
                'title' => 'Розы в шляпной коробке',
                'price' => 4000,
                'category' => 'box-flowers',
                'description' => 'Элегантная композиция из роз в коробке',
                'materials' => 'Розы, коробка, флористическая губка',
                'image_url' => 'https://images.unsplash.com/photo-1561181286-d4243e45d33e?w=600',
            ],
            [
                'title' => 'Пионы в коробке',
                'price' => 4500,
                'category' => 'box-flowers',
                'description' => 'Нежные пионы в стильной коробке',
                'materials' => 'Пионы, коробка, флористическая губка',
                'image_url' => 'https://images.unsplash.com/photo-1563241527-3004b7be0ffd?w=600',
            ],
            [
                'title' => 'Микс цветов в коробке',
                'price' => 4200,
                'category' => 'box-flowers',
                'description' => 'Ассорти из роз, хризантем и гипсофилы',
                'materials' => 'Розы, хризантемы, гипсофила, коробка',
                'image_url' => 'https://images.unsplash.com/photo-1558618666-fcd25c85f82e?w=600',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
        
        echo "✅ Добавлено " . count($products) . " товаров\n";
    }
}