<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'CategoryID' => 3,
                'CategoryName' => 'PC',
                'Description' => 'Personal computer',
                'Priority' => 2,
            ],
            [
                'CategoryID' => 4,
                'CategoryName' => 'Laptop',
                'Description' => 'Laptop văn phòng, laptop gaming',
                'Priority' => 3,
            ],
            [
                'CategoryID' => 5,
                'CategoryName' => 'Phụ kiện',
                'Description' => 'Tai nghe, loa, bàn phím,...',
                'Priority' => 4,
            ],
            [
                'CategoryID' => 7,
                'CategoryName' => 'Đồ gia dụng',
                'Description' => 'Furnitures',
                'Priority' => 5,
            ],
            [
                'CategoryID' => 8,
                'CategoryName' => 'Khác',
                'Description' => 'Các vật phẩm khác',
                'Priority' => 6,
            ],
            [
                'CategoryID' => 10,
                'CategoryName' => 'Điện thoại, Tablet',
                'Description' => 'SmartPhone',
                'Priority' => 1,
            ],
            [
                'CategoryID' => 11,
                'CategoryName' => 'Tivi',
                'Description' => 'Tivi thông minh',
                'Priority' => 100,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}