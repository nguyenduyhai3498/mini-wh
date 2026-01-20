<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductModel;
use App\Models\StockMovementModel;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\StockMovementCollection;
use App\Http\Resources\WarehouseCollection;
use App\Models\WarehouseModel;
use App\Models\InventoryItemModel;


class ProductController extends Controller
{
    public function index()
    {
        return view('warehouse.manager');
    }

    public function list(Request $request)
    {
        $limit = $request->input('limit', 10);
        $page = $request->input('page', 1);
        $search = $request->input('search', '');
        $sort = $request->input('sort', 'id');
        $order = $request->input('order', 'desc');

        $products = ProductModel::with('inventory_item')->orderBy($sort, $order)->where('name', 'ilike', '%' . $search . '%')->paginate($limit, ['*'], 'page', $page);
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
        $inventoryItem = InventoryItemModel::where('product_id', $product->id)->where('warehouse_id', $request->input('warehouse_id'))->first();
        if (!$inventoryItem) {
            return response()->json(['error' => 'Inventory item not found'], 400);
        }
        $inventoryItem->quantity = $inventoryItem->quantity + ($request->input('quantity') ?? 0);
        $inventoryItem->save();
        $data = [
            'product_id' => $product->id,
            'user_name' => $request->input('user_name'),
            'type' => StockMovementModel::TYPE_IN,
            'quantity' => $request->input('quantity') ?? 0,
            'note' => $request->input('note'),
        ];
        StockMovementModel::create($data);
        return response()->json(['success' => 'Product imported successfully'], 200);
    }


    public function export(Request $request) {
        $product = ProductModel::find($request->input('product_id'));
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 400);
        }
        $inventoryItem = InventoryItemModel::where('product_id', $product->id)->where('warehouse_id', $request->input('warehouse_id'))->first();
        if (!$inventoryItem) {
            return response()->json(['error' => 'Inventory item not found'], 400);
        }
        $inventoryItem->quantity = $inventoryItem->quantity - ($request->input('quantity') ?? 0);
        $inventoryItem->save();
        $data = [
            'product_id' => $product->id,
            'user_name' => $request->input('user_name'),
            'type' => StockMovementModel::TYPE_OUT,
            'quantity' => $request->input('quantity') ?? 0,
            'note' => $request->input('note'),
        ];
        StockMovementModel::create($data);
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

    
    public function warehouseList(Request $request) {
        $limit = $request->input('limit', 10);
        $page = $request->input('page', 1);
        $search = $request->input('search', '');
        $sort = $request->input('sort', 'id');
        $order = $request->input('order', 'desc');
        $warehouses = WarehouseModel::orderBy($sort, $order)->where('name', 'ilike', '%' . $search . '%')->paginate($limit, ['*'], 'page', $page);
        return new WarehouseCollection($warehouses);
    }

    public function createWarehouse(Request $request) {
        if($request->input('id')) {
            $warehouse = WarehouseModel::find($request->input('id'));
            if (!$warehouse) {
                return response()->json(['error' => 'Warehouse not found'], 400);
            }
            $warehouse->name = $request->input('name') ?? $warehouse->name;
            $warehouse->description = $request->input('description') ?? $warehouse->description;
            $warehouse->save();
        } else {
            $data = [
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'created_at' => now(),
                'updated_at' => now()
            ];
            $warehouse = WarehouseModel::create($data);
        }
        return response()->json(['success' => 'Warehouse created successfully'], 200);
    }

    public function deleteWarehouse(Request $request) {
        $warehouse = WarehouseModel::find($request->input('id'));
        if (!$warehouse) {
            return response()->json(['error' => 'Warehouse not found'], 400);
        }
        $warehouse->delete();
        InventoryItemModel::where('warehouse_id', $warehouse->id)->delete();
        return response()->json(['success' => 'Warehouse deleted successfully'], 200);
    }
}
