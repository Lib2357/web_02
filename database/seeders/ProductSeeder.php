<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'category_slug' => 'dien-thoai',
                'name' => 'iPhone 15 128GB',
                'slug' => 'iphone-15-128gb',
                'description' => '<p>Mau dien thoai cao cap voi camera sac net va hieu nang on dinh.</p>',
                'price' => 21990000,
                'stock_quantity' => 15,
                'image_path' => null,
                'status' => 'published',
                'discount_percent' => 5,
            ],
            [
                'category_slug' => 'laptop',
                'name' => 'Dell Inspiron 15',
                'slug' => 'dell-inspiron-15',
                'description' => '<p>Laptop phu hop cho hoc tap, van phong va lap trinh co ban.</p>',
                'price' => 18490000,
                'stock_quantity' => 8,
                'image_path' => null,
                'status' => 'published',
                'discount_percent' => 10,
            ],
            [
                'category_slug' => 'phu-kien',
                'name' => 'Chuot khong day Logitech',
                'slug' => 'chuot-khong-day-logitech',
                'description' => '<p>Phu kien gon nhe, ket noi nhanh, pin su dung lau.</p>',
                'price' => 590000,
                'stock_quantity' => 0,
                'image_path' => null,
                'status' => 'draft',
                'discount_percent' => 0,
            ],
        ];

        foreach ($products as $item) {
            $category = Category::where('slug', $item['category_slug'])->first();

            if (! $category) {
                continue;
            }

            unset($item['category_slug']);
            $item['category_id'] = $category->id;

            Product::updateOrCreate(
                ['slug' => $item['slug']],
                $item
            );
        }
    }
}
