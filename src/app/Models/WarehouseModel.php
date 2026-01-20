<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductModel;

class WarehouseModel extends Model
{
    use HasFactory;
    protected $table = 'warehouses';
    protected $fillable = ['name', 'description'];

    public function products()
    {
        return $this->hasMany(ProductModel::class);
    }
}
