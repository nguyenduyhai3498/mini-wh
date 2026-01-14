<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductModel;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name'     => 'Tôm sú',
                'unit'     => 'kg',
                'quantity' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'     => 'Cua biển',
                'unit'     => 'kg',
                'quantity' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'     => 'Mực ống',
                'unit'     => 'kg',
                'quantity' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'     => 'Cá hồi',
                'unit'     => 'kg',
                'quantity' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'     => 'Nghêu',
                'unit'     => 'kg',
                'quantity' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        ProductModel::insert($products);
    }
}
