<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('supplier.index');
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
    public function storeSupplier(Request $request)
    {
        //
        $request->validate([
            'cnpj'=>'required|unique:suppliers,cnpj',
            'nome'=>'required',
            'cep'=>'required',
            'endereco'=>'required',
            'numero'=>'required',
            'bairro'=>'required',
            'cidade'=>'required'
        ],[
            'cnpj.required'=>'CNPJ é obrigatório.',
            'cnpj.unique'=>'CNPJ já existe.',
            'nome.required'=>'Nome é obrigatório.',
            'cep.required'=>'CEP é obrigatório.',
            'endereco.required'=>'Endereço é obrigatório.',
            'numero.required'=>'Número é obrigatório.',
            'bairro.required'=>'Bairro é obrigatório.',
            'cidade.required'=>'Cidade é obrigatório.'
        ]);

        return response()->json(['status' => 1,'message' => 'sucesso']);
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
