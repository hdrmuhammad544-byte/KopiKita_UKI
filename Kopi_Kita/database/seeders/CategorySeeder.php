<?php

namespace Database\Seeders;
use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Kopi',
                'description' => 'Berbagai pilihan minuman kopi',
            ],
            [
                'name' => 'Non Kopi',
                'description' => 'Minuman tanpa kopi',
            ],
            [
                'name' => 'Makanan',
                'description' => 'Makanan utama dan pendamping',
            ],
            [
                'name' => 'Snack',
                'description' => 'Camilan ringan',
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['name' => $category['name']],
                $category
            );
        }
    }
}
