<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeProduct(Request $request)
    {
        //
        $request->validate([
            'nome'=>'required',
            'descricao'=>'required',
            'preco'=>'required',
            'estoque'=>'required'
        ],[
            'nome.required'=>'Nome é obrigatório.',
            'descricao.required'=>'Descrição é obrigatório.',
            'preco.required'=>'Preço é obrigatório.',
            'estoque.required'=>'Estoque é obrigatório.'
        ]);

        return response()->json(['status' => 1,'all' => $request->all()]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
