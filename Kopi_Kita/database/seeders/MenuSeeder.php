<?php

namespace Database\Seeders;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $menus = [
            [
                'category' => 'Kopi',
                'name' => 'Es Kopi Susu',
                'description' => 'Kopi susu dengan gula aren',
                'price' => 18000,
                'stock' => 30,
            ],
            [
                'category' => 'Kopi',
                'name' => 'Americano',
                'description' => 'Espresso dengan air',
                'price' => 15000,
                'stock' => 25,
            ],
            [
                'category' => 'Kopi',
                'name' => 'Cappuccino',
                'description' => 'Espresso dengan susu foam',
                'price' => 20000,
                'stock' => 20,
            ],
            [
                'category' => 'Non Kopi',
                'name' => 'Matcha Latte',
                'description' => 'Minuman matcha dengan susu',
                'price' => 22000,
                'stock' => 20,
            ],
            [
                'category' => 'Non Kopi',
                'name' => 'Chocolate',
                'description' => 'Minuman cokelat creamy',
                'price' => 18000,
                'stock' => 25,
            ],
            [
                'category' => 'Makanan',
                'name' => 'Nasi Goreng',
                'description' => 'Nasi goreng spesial',
                'price' => 25000,
                'stock' => 15,
            ],
            [
                'category' => 'Snack',
                'name' => 'Kentang Goreng',
                'description' => 'Kentang goreng crispy',
                'price' => 15000,
                'stock' => 20,
            ],
            [
                'category' => 'Snack',
                'name' => 'Roti Bakar',
                'description' => 'Roti bakar cokelat keju',
                'price' => 17000,
                'stock' => 15,
            ],
        ];

        foreach ($menus as $item) {
            $category = Category::where(
                'name',
                $item['category']
            )->firstOrFail();

            Menu::updateOrCreate(
                [
                    'name' => $item['name'],
                    'category_id' => $category->id,
                ],
                [
                    'description' => $item['description'],
                    'price' => $item['price'],
                    'stock' => $item['stock'],
                    'is_active' => true,
                ]
            );
        }
    }
}
