<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Product;
use App\Models\Sale;
use App\Models\DetailSale;
use App\Http\Requests\AddSalesRequest;
use App\Http\Resources\SalesResource;
use Illuminate\Http\Exceptions\HttpResponseException;

class SalesController extends Controller
{
    public function index(){
        $sales = Sale::all();

        foreach ($sales as $sale) {
            $id = $sale->id;

            $result_detail = DetailSale::select('product_id', 'variants')->where('sales_id', $id)->get();

            $cart_temp = [];

            foreach ($result_detail as $cart) {
                $data_product = Product::find($cart->product_id);

                $cart_temp[] = [
                    "product_id" => $data_product->id,
                    "price" => $data_product->price,
                    "variants" => json_decode($cart->variants)
                ];
            }

            $sale->cart = $cart_temp;
        }

        return SalesResource::collection($sales);
    }

    public function addSales(AddSalesRequest $request){
        $data = $request->validated();

        $sale = new Sale($data);
        $sale->save();

        $sale_id = $request['id'];

        $cart_temp = [];

        foreach($request->cart as $cart){
            $detail_sale = new DetailSale;

            $detail_sale->product_id = $cart['product_id'];
            $detail_sale->sales_id = $sale_id;
            $detail_sale->variants = json_encode($cart['variants']);

            $detail_sale->save();

            $cart_temp[] = [
                "product_id" => $detail_sale->product_id,
                "variants" => json_encode($cart['variants'])
            ];
        }

        $sale->cart = $cart_temp;
        $sale->id = $sale_id;

        return new SalesResource($sale);
    }
}
