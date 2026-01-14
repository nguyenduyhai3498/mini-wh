<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductModel;
use App\Models\StockMovementModel;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\StockMovementCollection;


class ProductController extends Controller
{
    public function index()
    {
        return view('warehouse.index');
    }

    public function list(Request $request)
    {
        $limit = $request->input('limit', 10);
        $page = $request->input('page', 1);
        $search = $request->input('search', '');
        $sort = $request->input('sort', 'id');
        $order = $request->input('order', 'desc');

        $products = ProductModel::orderBy($sort, $order)->where('name', 'ilike', '%' . $search . '%')->paginate($limit, ['*'], 'page', $page);
        return new ProductCollection($products);
    }


    public function create(Request $request) {
        $data = [
            'name' => $request->input('name'),
            'unit' => $request->input('unit'),
            'quantity' => $request->input('quantity') ?? 0,
            'created_at' => now(),
            'updated_at' => now()
        ];
        $checkProduct = ProductModel::where('name', strtolower($data['name']))->where('unit', strtolower($data['unit']))->first();
        if ($checkProduct) {
            return response()->json(['error' => 'Product already exists'], 400);
        }
        $product = ProductModel::create($data);
        return response()->json($product);
    }

    public function import(Request $request) {
        $product = ProductModel::find($request->input('product_id'));
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 400);
        }
        $quantity = $product->quantity + ($request->input('quantity') ?? 0);
        $data = [
            'product_id' => $product->id,
            'user_name' => $request->input('user_name'),
            'type' => StockMovementModel::TYPE_IN,
            'quantity' => $request->input('quantity') ?? 0,
            'note' => $request->input('note'),
        ];
        StockMovementModel::create($data);
        $product->quantity = $quantity;
        $product->save();
        return response()->json(['success' => 'Product imported successfully'], 200);
    }


    public function export(Request $request) {
        $product = ProductModel::find($request->input('product_id'));
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 400);
        }
        $quantity = $product->quantity - ($request->input('quantity') ?? 0);
        $data = [
            'product_id' => $product->id,
            'user_name' => $request->input('user_name'),
            'type' => StockMovementModel::TYPE_OUT,
            'quantity' => $request->input('quantity') ?? 0,
            'note' => $request->input('note'),
        ];
        StockMovementModel::create($data);
        $product->quantity = $quantity;
        $product->save();
        return response()->json(['success' => 'Product exported successfully'], 200);
    }

    public function history(Request $request) {
        return view('warehouse.history');
    }

    public function historyList(Request $request) {
        $limit = $request->input('limit', 10);
        $page = $request->input('page', 1);
        $search = $request->input('search', '');
        $sort = $request->input('sort', 'id');
        $order = $request->input('order', 'desc');
        $history = StockMovementModel::orderBy($sort, $order)
        ->whereHas('product', function ($query) use ($search) {
            $query->where('name', 'ilike', '%' . $search . '%');
        })
        ->where('user_name', 'ilike', '%' . $search . '%')
        ->paginate($limit, ['*'], 'page', $page);
        return new StockMovementCollection($history);
    }

    public function exportList(Request $request) {
        return view('warehouse.export');
    }
}
