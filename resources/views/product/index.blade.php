@include('parts/header')
    <div class="container">
        <div class="text-center mt-3">
            <div class="d-flex justify-content-between">
                <a class="btn btn-primary btn-sm" href="{{ url('/') }}">Ir para area de Fornecedores</a>
            </div>
            <hr>
        </div>
        <div class="row" style="margin-top: 45px">
             <div class="col-md-8">
                <div class="card shadow mb-3">
                    <div class="card-header">
                        <h5 class="card-title">Produtos</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-condensed table-sm" id="products">
                               <thead>
                                <th><input type="checkbox" name="main_checkbox"></th>
                                <th>Nome</th>
                                <th>Descrição</th>
                                <th>Preço</th>
                                <th>Estoque</th>
                                <th>Fornecedores</th>
                                <th class="text-right">
                                    <button class="btn btn-sm btn-danger d-none" id="multipleDeleteBtn">Delete</button>
                                </th>
                               </thead>
                            </table>
                        </div>
                    </div>
                </div>
             </div>
             <div class="col-md-4">
                <div class="card shadow mb-3">
                    <div class="card-header">
                        <h5 class="card-title">Form</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('product.store') }}" method="POST" id="form-product">
                            @csrf
                            <div class="form-group">
                                <label for="nome">Nome</label>
                                <input type="text" id="nome" name="nome" class="form-control" placeholder="Digite o nome">
                                <span class="text-danger error-text nome_error"></span>
                            </div>
                            <div class="form-group">
                                <label for="descricao">Descrição</label>
                                <textarea id="descricao" name="descricao" class="form-control" placeholder="Digite a descrição"></textarea>
                                <span class="text-danger error-text descricao_error"></span>
                            </div>
                            <div class="form-group">
                                <label for="preco">Preço</label>
                                <input type="text" id="preco" name="preco" class="form-control" placeholder="Digite o preço">
                                <span class="text-danger error-text preco_error"></span>
                            </div>                            
                            <div class="form-group">
                                <label for="estoque">Estoque</label>
                                <input type="number" id="estoque" name="estoque" class="form-control" placeholder="Digite a quantidade em estoque" value="0">
                                <span class="text-danger error-text estoque_error"></span>
                            </div>
                            <div class="form-group">
                                <label for="fornecedores">Fornecedores</label>
                                <select id="fornecedores" class="form-control"name="fornecedores[]" multiple size="2" >
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-block btn-success">SALVAR</button> 
                            </div>
                        </form>
                    </div>
                </div>
             </div>
        </div>
    </div>
@include('parts/footer')
