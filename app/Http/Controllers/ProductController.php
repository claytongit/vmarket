<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Supplier;
use Yajra\DataTables\Facades\DataTables;

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

        if ($product->save())
        {
            $product->suppliers()->sync($request->input('fornecedores'));

            return response()->json(['status' => 1,'message' => 'Produto cadastrado com sucesso.']);
        } else {
            return response()->json(['status' => 0,'message' => 'Erro ao cadastrar produto.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function getProducts(Request $request)
    {
        if ($request->ajax())
        {
            $data = Product::with('suppliers')->select(['id', 'nome', 'preco', 'estoque']);

            return DataTables::of($data)->addColumn('suppliers', function($row) {
                return $row->suppliers->pluck('nome')->implode(', ');
            })->addColumn(
                'actions', function($row)
                {
                    return '<div class="btn-group">
                                <button class="btn btn-sm btn-primary" data-id="' . $row['id'] . '" id="editProductBtn">Update</button>
                                <button class="btn btn-sm btn-danger" data-id="' . $row['id'] . '" id="deleteProductBtn">Delete</button>
                            </div>';
                }
            )->addColumn(
                'checkbox', function($row)
                {
                    return '<input type="checkbox" name="product_checkbox" data-id="' . $row['id'] . '">';
                }
            )->rawColumns(
                ['actions', 'checkbox']
            )->make(true);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function getProduct(Request $request)
    {
        $product_id = $request->id;
        $product = Product::findOrFail($product_id);

        return response()->json(['data' => $product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateProduct(Request $request)
    {
        $product_id = $request->product_id;
        $product = Product::findOrFail($product_id);

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

        $product->nome = htmlspecialchars($request->input('nome'));
        $product->descricao = htmlspecialchars($request->input('descricao'));
        $product->preco = $request->input('preco');
        $product->estoque = $request->input('estoque');

        if ($product->save())
        {
            return response()->json(['status' => 1,'message' => 'Atualizado com sucesso.']);
        } else {
            return response()->json(['status' => 0,'message' => 'Erro ao atualizar.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteProduct(Request $request)
    {
        $product = Product::findOrFail($request->id);

        if($product->delete()){
            return response()->json(['status'=>1,'message'=>'Deletado com sucesso.']);
        }else{
            return response()->json(['status'=>0,'message'=>'Erro ao deletar.']);
        }
    }

    public function deleteMultipleProduct(Request $request)
    {
        $ids = $request->checked_ids;
        $del = Product::whereIn('id',$ids)->delete();

        if($del){
            return response()->json(['status'=>1,'message'=>'Deletados com sucesso.']);
        }else{
            return response()->json(['status'=>0,'message'=>'Erro ao deletar.']);
        }
    }
}
