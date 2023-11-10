<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Inventory;
use App\Http\Requests\AddInventoryRequest;
use App\Http\Resources\InventoryResource;
use Illuminate\Http\Exceptions\HttpResponseException;

class InventoriesController extends Controller
{
    public function index(){
        $inventories = Inventory::all();
        
        return InventoryResource::collection($inventories);
    }

    public function addInventory(AddInventoryRequest $request): InventoryResource{
        $data = $request->validated();

        $inventory = new Inventory($data);
        $inventory->save();

        return new InventoryResource($inventory);
    }

    public function updateInventory(AddInventoryRequest $request, $id){
        $inventory = Inventory::where('id', $id)->first();

        if (!$inventory) {
            throw new HttpResponseException(response()->json([
                "code" => 400,
                "message" => "Data not found"
            ]), 400);
        }

        $data = $request->validated();
        $inventory->fill($data);
        $inventory->save();

        return new InventoryResource($inventory);
    }

    public function deleteInventory($id){
        $inventory = Inventory::where('id', $id)->first();

        if (!$inventory) {
            throw new HttpResponseException(response()->json([
                "code" => 400,
                "message" => "Data not found"
            ]), 400);
        }

        $inventory->delete();

        return response()->json([
            'message' => 'Data successfuly deleted'
        ], 200);
    }
}
