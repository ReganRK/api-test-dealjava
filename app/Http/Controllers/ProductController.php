<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Variant;
use App\Http\Requests\AddProductRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductController extends Controller
{
    public function index(){
        $products = Product::all();
        
        foreach($products as $product){
            $id = $product->id;

            $result_variants = ProductVariant::select('variant_id')->where('product_id', $id)->get();

            $variant_temp = [];

            foreach($result_variants as $variant){
                $data_variant = Variant::find($variant->variant_id);

                $variant_temp[] = [
                    "name" => $data_variant->name,
                    "additional_price" => $data_variant->price,
                ];
            }

            $product->variant = $variant_temp;
        }

        return ProductResource::collection($products);
    }

    public function addProduct(AddProductRequest $request): ProductResource{
        $data = $request->validated();

        $product = new Product($data);
        $product->save();

        $product_id = $product->id;

        $variant_temp = [];

        foreach($request->variant as $variant){
            $product_variant = new ProductVariant;

            $product_variant->product_id = $product_id;
            $product_variant->variant_id = $variant;

            $product_variant->save();

            $data_variant = Variant::find($variant);

            $variant_temp[] = [
                "name" => $data_variant->name,
                "additional_price" => $data_variant->price,
            ];
        }

        $product->variant = $variant_temp;

        return new ProductResource($product);
    }

    public function deleteProduct($id){
        $product = Product::where('id', $id)->first();

        if (!$product) {
            throw new HttpResponseException(response()->json([
                "code" => 400,
                "message" => "Data not found"
            ]), 400);
        }

        $product->delete();

        $variants = ProductVariant::where('product_id', $id);
        $variants->delete();

        return response()->json([
            'message' => 'Data successfuly deleted'
        ], 200);
    }

    public function updateProduct(AddProductRequest $request, $id){
        $product = Product::where('id', $id)->first();

        if (!$product) {
            throw new HttpResponseException(response()->json([
                "code" => 400,
                "message" => "Data not found"
            ]), 400);
        }

        $data = $request->validated();
        $product->fill($data);
        $product->save();

        $variants = ProductVariant::where('product_id', $id);
        $variants->delete();

        $variant_temp = [];

        foreach($request->variant as $variant){
            $product_variant = new ProductVariant;

            $product_variant->product_id = $id;
            $product_variant->variant_id = $variant;

            $product_variant->save();

            $data_variant = Variant::find($variant);

            $variant_temp[] = [
                "name" => $data_variant->name,
                "additional_price" => $data_variant->price,
            ];
        }

        $product->variant = $variant_temp;

        return new ProductResource($product);
    }
}
