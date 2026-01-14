<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductModel;

class StockMovementModel extends Model
{
    use HasFactory;

    protected $table = 'stock_movements';
    protected $fillable = [
        'product_id',
        'user_name',
        'type',
        'quantity',
        'note'
    ];

    const TYPE_IN = 'IN';
    const TYPE_OUT = 'OUT';

    public function product()
    {
        return $this->belongsTo(ProductModel::class);
    }
}
