<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\StockMovementModel;
use App\Models\WarehouseModel;
use App\Models\InventoryItemModel;

class ProductModel extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = ['name', 'unit', 'quantity'];

    public function movements()
    {
        return $this->hasMany(StockMovementModel::class, 'product_id', 'id');
    }

    public function inventory_item()
    {
        return $this->hasMany(InventoryItemModel::class, 'product_id', 'id');
    }
}   
