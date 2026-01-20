<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\WarehouseModel;
use App\Models\ProductModel;
use App\Models\InventoryItemModel;

class InitWarehouse extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $warehouses = [
            'name' => 'Warehouse 1',
            'created_at' => now(),
            'updated_at' => now()
        ];
        $newWh = WarehouseModel::create($warehouses);
        $products = ProductModel::where('id', '>', 0)->get();
        foreach($products as $product){
            InventoryItemModel::create([
                'warehouse_id' => $newWh->id,
                'product_id' => $product->id,
                'quantity' => $product->quantity
            ]);
        }
    }
}
