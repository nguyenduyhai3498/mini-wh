<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\WarehouseModel;
use App\Models\ProductModel;

class InventoryItemModel extends Model
{
    use HasFactory;

    protected $table = 'inventory_items';
    protected $fillable = ['warehouse_id', 'product_id', 'quantity'];

    public function warehouse()
    {
        return $this->belongsTo(WarehouseModel::class, 'warehouse_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(ProductModel::class, 'product_id', 'id');
    }
}
