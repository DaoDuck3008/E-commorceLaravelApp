<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run()
    {
        $brands = [
            [
                'BrandID' => 4,
                'BrandName' => 'Iphone',
                'CategoryID' => 10,
                'Description' => 'Quả táo cắn nửa!',
            ],
            [
                'BrandID' => 5,
                'BrandName' => 'Macbook',
                'CategoryID' => 4,
                'Description' => 'Laptop của táo cắn nửa!',
            ],
            [
                'BrandID' => 6,
                'BrandName' => 'Levoit',
                'CategoryID' => 7,
                'Description' => 'không biết',
            ],
            [
                'BrandID' => 7,
                'BrandName' => 'SamSung',
                'CategoryID' => 10,
                'Description' => 'Điện thoại hàn quốc',
            ],
            [
                'BrandID' => 8,
                'BrandName' => 'Oppo',
                'CategoryID' => 10,
                'Description' => 'oppo',
            ],
            [
                'BrandID' => 9,
                'BrandName' => 'Xiaomi',
                'CategoryID' => 10,
                'Description' => 'Điện thoại trung quốc',
            ],
            [
                'BrandID' => 10,
                'BrandName' => 'Asus',
                'CategoryID' => 10,
                'Description' => 'cũng không biết nữa',
            ],
            [
                'BrandID' => 11,
                'BrandName' => 'Asus',
                'CategoryID' => 3,
                'Description' => 'Màn hình, vỏ case, CPU các kiểu',
            ],
            [
                'BrandID' => 12,
                'BrandName' => 'Dell',
                'CategoryID' => 3,
                'Description' => 'dell',
            ],
            [
                'BrandID' => 13,
                'BrandName' => 'LG',
                'CategoryID' => 3,
                'Description' => 'LG',
            ],
            [
                'BrandID' => 14,
                'BrandName' => 'Macbook',
                'CategoryID' => 4,
                'Description' => 'laptop của quả táo cắn nửa',
            ],
            [
                'BrandID' => 15,
                'BrandName' => 'Dell',
                'CategoryID' => 4,
                'Description' => 'máy tính của Dell',
            ],
            [
                'BrandID' => 16,
                'BrandName' => 'Lenonvo',
                'CategoryID' => 4,
                'Description' => 'Lenovo',
            ],
            [
                'BrandID' => 17,
                'BrandName' => 'HP',
                'CategoryID' => 4,
                'Description' => 'cũng không rõ lắm',
            ],
            [
                'BrandID' => 18,
                'BrandName' => 'Acer',
                'CategoryID' => 4,
                'Description' => 'chuyên chơi game',
            ],
            [
                'BrandID' => 19,
                'BrandName' => 'Samsung',
                'CategoryID' => 11,
                'Description' => 'Tivi của SamSung',
            ],
            [
                'BrandID' => 20,
                'BrandName' => 'AirPod (Apple)',
                'CategoryID' => 5,
                'Description' => 'Tai nghe của Apple',
            ],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}