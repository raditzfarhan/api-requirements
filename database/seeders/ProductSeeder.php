<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
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
                'sku' => '000001',
                'name' => 'Full coverage insurance',
                'category' => 'insurance',
                'price' => 89000,
            ],
            [
                'sku' => '000002',
                'name' => 'Compact Car X3',
                'category' => 'vehicle',
                'price' => 99000,
            ],
            [
                'sku' => '000003',
                'name' => 'SUV Vehicle, high end',
                'category' => 'vehicle',
                'price' => 150000,
            ],
            [
                'sku' => '000004',
                'name' => 'Basic coverage',
                'category' => 'insurance',
                'price' => 20000,
            ],
            [
                'sku' => '000005',
                'name' => 'Convertible X2, Electric',
                'category' => 'vehicle',
                'price' => 250000,
            ],
        ];

        foreach ($data as $item) {
            Product::create($item);
        }
    }
}
