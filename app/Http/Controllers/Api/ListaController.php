<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lista;
use Illuminate\Http\Request;

class ListaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response([
            'listas' => \App\Http\Resources\ListaResource::collection(
                Lista::where('user_id', auth()->id())->get()
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
    public function store(Request $request)
    {
        $data = $request->merge(['user_id' => auth()->id()])->all();

        $validator = \Illuminate\Support\Facades\Validator::make($data, [
            'title' => 'required|max:255',
            'user_id' => \Illuminate\Validation\Rule::exists('users', 'id'),
        ]);

        if ($validator->fails()) {
            return response([
                'error' => $validator->errors(),
                'Validation Error'
            ]);
        }

        return response([
            'lista' => new \App\Http\Resources\ListaResource(
                Lista::create($data)
            ),
            'message' => 'Criado com sucesso.'
        ], 201);
    }

     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lista  $lista
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lista $lista)
    {
        $data = $request->merge(['user_id' => auth()->id()])->all();

        $validator = \Illuminate\Support\Facades\Validator::make($data, [
            'title' => 'required|max:255',
            'user_id' => \Illuminate\Validation\Rule::exists('users', 'id'),
        ]);

        if ($validator->fails()) {
            return response([
                'error' => $validator->errors(),
                'Validation Error'
            ]);
        }
        $lista->update($data);

        return response([
            'lista' => new \App\Http\Resources\ListaResource($lista),
            'message' => 'Alterado com sucesso.'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lista  $lista
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lista $lista)
    {
        try {
            $lista->delete();
        } catch (\Exception $e) {
        }

        return response([
            'message' => 'Removido com sucesso.'
        ]);
    }
}
