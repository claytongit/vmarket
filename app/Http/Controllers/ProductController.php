<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Supplier;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::all();
        return view('product.index', compact('suppliers'));
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

        $product = new Product();
        $product->nome = htmlspecialchars($request->input('nome'));
        $product->descricao = htmlspecialchars($request->input('descricao'));
        $product->preco = $request->input('preco');
        $product->estoque = $request->input('estoque');

        if ($request->has('suppliers')) {
            $product->suppliers()->sync($request->input('suppliers'));
        }

        if ($product->save())
        {
            return response()->json(['status' => 1,'message' => 'sucesso']);
        } else {
            return response()->json(['status' => 0,'message' => 'erro']);
        }
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
