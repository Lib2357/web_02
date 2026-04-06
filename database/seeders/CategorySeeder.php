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
                'name' => 'Dien thoai',
                'slug' => 'dien-thoai',
                'description' => 'Danh muc cac dong dien thoai thong minh.',
                'is_visible' => true,
            ],
            [
                'name' => 'Laptop',
                'slug' => 'laptop',
                'description' => 'Danh muc laptop phuc vu hoc tap va cong viec.',
                'is_visible' => true,
            ],
            [
                'name' => 'Phu kien',
                'slug' => 'phu-kien',
                'description' => 'Danh muc phu kien cong nghe.',
                'is_visible' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
