<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductModel;
use App\Models\WarehouseModel;
class StockMovementModel extends Model
{
    use HasFactory;

    protected $table = 'stock_movements';
    protected $fillable = [
        'product_id',
        'user_name',
        'type',
        'quantity',
        'note',
        'warehouse_id'
    ];

    const TYPE_IN = 'IN';
    const TYPE_OUT = 'OUT';

    public function product()
    {
        return $this->belongsTo(ProductModel::class, 'product_id', 'id');
    }

    public function warehouse()
    {
        return $this->belongsTo(WarehouseModel::class, 'warehouse_id', 'id');
    }
}
