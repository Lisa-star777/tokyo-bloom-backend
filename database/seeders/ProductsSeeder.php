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
            ],
            [
                'title' => 'Счастье',
                'price' => 4500,
                'category' => 'bouquets',
                'description' => 'Яркий букет из роз и гербер',
                'materials' => 'Розы, герберы, альстромерия',
            ],
            [
                'title' => 'Любовь',
                'price' => 5500,
                'category' => 'bouquets',
                'description' => 'Роскошный букет из 101 розы',
                'materials' => 'Розы красные',
            ],
            [
                'title' => 'Весеннее настроение',
                'price' => 3800,
                'category' => 'bouquets',
                'description' => 'Яркий весенний букет',
                'materials' => 'Тюльпаны, ирисы, гипсофила',
            ],
            
            // Подарки
            [
                'title' => 'Медвежонок',
                'price' => 1500,
                'category' => 'gifts',
                'description' => 'Плюшевый мишка',
                'materials' => 'Плюш, текстиль',
            ],
            [
                'title' => 'Шоколад премиум',
                'price' => 1200,
                'category' => 'gifts',
                'description' => 'Коробка бельгийского шоколада',
                'materials' => 'Шоколад, упаковка',
            ],
            [
                'title' => 'Воздушные шары',
                'price' => 800,
                'category' => 'gifts',
                'description' => 'Набор гелиевых шаров',
                'materials' => 'Латекс, гелий, лента',
            ],
            
            // Цветы в коробках
            [
                'title' => 'Розы в шляпной коробке',
                'price' => 4000,
                'category' => 'box-flowers',
                'description' => 'Элегантная композиция из роз в коробке',
                'materials' => 'Розы, коробка, флористическая губка',
            ],
            [
                'title' => 'Пионы в коробке',
                'price' => 4500,
                'category' => 'box-flowers',
                'description' => 'Нежные пионы в стильной коробке',
                'materials' => 'Пионы, коробка, флористическая губка',
            ],
            [
                'title' => 'Микс цветов в коробке',
                'price' => 4200,
                'category' => 'box-flowers',
                'description' => 'Ассорти из роз, хризантем и гипсофилы',
                'materials' => 'Розы, хризантемы, гипсофила, коробка',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
        
        echo "✅ Добавлено " . count($products) . " товаров\n";
    }
}