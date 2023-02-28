<?php

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data = [
            [
                'img_path' => "public/facility/3c09a0fac53d2524e492c4fa95cf8317_w.jpeg",
                'product_name' => "商品A",
                'price' => 100,
                'stock' => 100,
                'company_id' => 1,
                'comment' => "aaa",
            ],
            [
                'img_path' => "public/facility/3c09a0fac53d2524e492c4fa95cf8317_w.jpeg",
                'product_name' => "商品B",
                'price' => 100,
                'stock' => 100,
                'company_id' => 2,
                'comment' => "aaa",
            ],
            [
                'img_path' => "public/facility/3c09a0fac53d2524e492c4fa95cf8317_w.jpeg",
                'product_name' => "商品C",
                'price' => 100,
                'stock' => 100,
                'company_id' => 1,
                'comment' => "aaa",
            ],
        ];
        DB::table('products')->insert($data);
    }
}
