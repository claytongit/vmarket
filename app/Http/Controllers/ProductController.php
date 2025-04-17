<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Supplier;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the product resources.
     * Retrieves all suppliers to be used in the product listing view.
     * @return \Illuminate\Contracts\View\View Returns the 'product.index' view with the list of suppliers.
     */
    public function index()
    {
        $suppliers = Supplier::all();
        return view('product.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new product resource.
     * This method currently does not have any specific logic.
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created product resource in storage.
     * Validates the incoming request data, creates a new Product model instance,
     * populates it with the request data, saves it to the database, and then
     * syncs the selected suppliers with the product. Returns a JSON response
     * indicating the success or failure of the operation.
     * @param  \Illuminate\Http\Request  $request The incoming HTTP request containing product data.
     * @return \Illuminate\Http\JsonResponse Returns a JSON response with the status and a message.
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
     * Display a listing of the product resources for DataTables.
     * Handles AJAX requests to fetch product data with associated suppliers,
     * formats the data for Yajra DataTables, and adds action and checkbox columns.
     * @param  \Illuminate\Http\Request  $request The incoming HTTP request.
     * @return \Yajra\DataTables\Facades\DataTables Returns a DataTables response with product data.
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
     * Show the form for editing the specified product resource.
     * Retrieves a specific product resource based on the provided ID.
     * Returns the product data as a JSON response.
     * @param  \Illuminate\Http\Request  $request The incoming HTTP request containing the product ID.
     * @return \Illuminate\Http\JsonResponse Returns a JSON response with the product data.
     */
    public function getProduct(Request $request)
    {
        $product_id = $request->id;
        $product = Product::findOrFail($product_id);

        return response()->json(['data' => $product]);
    }

    /**
     * Update the specified product resource in storage.
     * Validates the incoming request data, finds the existing Product model instance,
     * updates it with the request data, and saves the changes to the database.
     * Returns a JSON response indicating the success or failure of the update.
     * @param  \Illuminate\Http\Request  $request The incoming HTTP request containing updated product data.
     * @return \Illuminate\Http\JsonResponse Returns a JSON response with the status and a message.
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
     * Remove the specified product resource from storage.
     * Finds and deletes a specific product resource based on the provided ID.
     * Returns a JSON response indicating the success or failure of the deletion.
     * @param  \Illuminate\Http\Request  $request The incoming HTTP request containing the product ID to delete.
     * @return \Illuminate\Http\JsonResponse Returns a JSON response with the status and a message.
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

    /**
     * Remove multiple product resources from storage.
     * Receives an array of product IDs to be deleted and removes them from the database.
     * Returns a JSON response indicating the success or failure of the bulk deletion.
     * @param  \Illuminate\Http\Request  $request The incoming HTTP request containing an array of product IDs to delete.
     * @return \Illuminate\Http\JsonResponse Returns a JSON response with the status and a message.
     */
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
