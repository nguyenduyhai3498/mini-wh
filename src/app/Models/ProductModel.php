<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\StockMovementModel;
class ProductModel extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = ['name', 'unit', 'quantity'];

    public function movements()
    {
        return $this->hasMany(StockMovementModel::class);
    }
}
