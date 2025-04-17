<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use Yajra\DataTables\Facades\DataTables;

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

        $supplier = new Supplier();
        $supplier->cnpj = htmlspecialchars($request->input('cnpj'));
        $supplier->nome = htmlspecialchars($request->input('nome'));
        $supplier->cep = htmlspecialchars($request->input('cep'));
        $supplier->endereco = htmlspecialchars($request->input('endereco'));
        $supplier->numero = htmlspecialchars($request->input('numero'));
        $supplier->bairro = htmlspecialchars($request->input('bairro'));
        $supplier->cidade = htmlspecialchars($request->input('cidade'));

        if ($supplier->save())
        {
            return response()->json(['status' => 1,'message' => 'Fornecedor cadastrado com sucesso.']);
        } else {
            return response()->json(['status' => 0,'message' => 'Erro ao cadastrar fornecedor.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function getSuppliers(Request $request)
    {
        if ($request->ajax())
        {
            $data = Supplier::select(['id', 'nome', 'cnpj']);

            return DataTables::of($data)->addColumn(
                'actions', function($row)
                {
                    return '<div class="btn-group">
                                <button class="btn btn-sm btn-primary" data-id="' . $row['id'] . '" id="editSupplierBtn">Update</button>
                                <button class="btn btn-sm btn-danger" data-id="' . $row['id'] . '" id="deleteSupplierBtn">Delete</button>
                            </div>';
                }
            )->addColumn(
                'checkbox', function($row)
                {
                    return '<input type="checkbox" name="supplier_checkbox" data-id="' . $row['id'] . '">';
                }
            )->rawColumns(
                ['actions', 'checkbox']
            )->make(true);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function getSupplier(Request $request)
    {
        $supplier_id = $request->id;
        $supplier = Supplier::findOrFail($supplier_id);

        return response()->json(['data' => $supplier]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateSupplier(Request $request)
    {
        $supplier_id = $request->suppiler_id;
        $supplier = Supplier::findOrFail($supplier_id);

        $request->validate([
            'cnpj'=>'required|unique:suppliers,cnpj,'.$supplier->id,
            'nome'=>'required',
            'endereco'=>'required',
            'cep'=>'required',
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

        $supplier->cnpj = htmlspecialchars($request->input('cnpj'));
        $supplier->nome = htmlspecialchars($request->input('nome'));
        $supplier->cep = htmlspecialchars($request->input('cep'));
        $supplier->endereco = htmlspecialchars($request->input('endereco'));
        $supplier->numero = htmlspecialchars($request->input('numero'));
        $supplier->bairro = htmlspecialchars($request->input('bairro'));
        $supplier->cidade = htmlspecialchars($request->input('cidade'));

        if ($supplier->save())
        {
            return response()->json(['status' => 1,'message' => 'Atualizado com sucesso.']);
        } else {
            return response()->json(['status' => 0,'message' => 'Erro ao atualizar.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
