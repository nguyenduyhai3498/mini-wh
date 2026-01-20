<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WarehouseModel;

class HomeController extends Controller
{
    public function home()
    {
        return redirect('dashboard');
    }

    public function warehouse()
    {
        $warehouses = WarehouseModel::all();
        return view('warehouse.index', compact('warehouses'));
    }
}
