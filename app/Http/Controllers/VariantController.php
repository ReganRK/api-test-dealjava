<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Variant;
use App\Http\Requests\AddVariantRequest;
use App\Http\Resources\VariantResource;
use Illuminate\Http\Exceptions\HttpResponseException;

class VariantController extends Controller
{
    public function addVariant(AddVariantRequest $request): VariantResource{
        $data = $request->validated();

        $inventory = new Variant($data);
        $inventory->save();

        return new VariantResource($inventory);
    }
}
