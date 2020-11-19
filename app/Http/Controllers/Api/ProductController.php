<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Lista;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Lista $lista)
    {
        return response([
            'products' => \App\Http\Resources\ProductResource::collection(
                Product::whereHas('lista', function ($query) use ($lista) {
                    $query->where('id', $lista->id)
                        ->where('user_id', auth()->id());
                })->get()
            ),
            'message' => 'Listado com sucesso.'
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Lista $lista, Request $request)
    {
        $data = $request->merge(['lista_id' => $lista->id])->all();

        $validator = \Illuminate\Support\Facades\Validator::make($data, [
            'title' => 'required|max:255',
            'lista_id' => \Illuminate\Validation\Rule::exists('listas', 'id'),
            'quantity' => 'required|int',
            'value' => "required|regex:/^\d*(\.\d{1,2})?$/",
        ]);

        if ($validator->fails()) {
            return response([
                'error' => $validator->errors(),
                'Validation Error'
            ]);
        }

        return response([
            'product' => new \App\Http\Resources\ProductResource(
                Product::create($data)
            ),
            'message' => 'Criado com sucesso.'
        ], 201);
    }

     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Lista $lista, Request $request, Product $product)
    {
        $data = $request->merge(['lista_id' => $lista->id])->all();

        $validator = \Illuminate\Support\Facades\Validator::make($data, [
            'title' => 'required|max:255',
            'lista_id' => \Illuminate\Validation\Rule::exists('listas', 'id'),
            'quantity' => 'required|int',
            'value' => "required|regex:/^\d*(\.\d{1,2})?$/",
        ]);

        if ($validator->fails()) {
            return response([
                'error' => $validator->errors(),
                'Validation Error'
            ]);
        }
        $product->update($data);

        return response([
            'product' => new \App\Http\Resources\ProductResource($product),
            'message' => 'Alterado com sucesso.'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lista $lista, Product $product)
    {
        try {
            $product->delete();
        } catch (\Exception $e) {
        }

        return response([
            'message' => 'Removido com sucesso.'
        ]);
    }
}
