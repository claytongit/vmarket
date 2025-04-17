@include('parts/header')
    <div class="container">
        <div class="text-center mt-3">
            <div class="d-flex justify-content-between">
                <a class="btn btn-primary btn-sm" href="{{ url('/product') }}">Ir para area de produto</a>
            </div>
            <hr>
        </div>
        <div class="row" style="margin-top: 45px">
             <div class="col-md-8">
                <div class="card shadow mb-3">
                    <div class="card-header">
                        <h5 class="card-title">Fornecedores</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-condensed table-sm" id="supplier">
                               <thead>
                                <th><input type="checkbox" name="main_checkbox"></th>
                                <th>Nome</th>
                                <th>CNPJ</th>
                                <th class="text-right">
                                    <button class="btn btn-sm btn-danger d-none" id="multipleDeleteSupplierBtn">Delete</button>
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
                        <form action="{{ route('store') }}" method="POST" id="form-supplier"> 
                            @csrf
                            <div class="form-group">
                                <label for="nome">Nome</label>
                                <input type="text" id="nome" name="nome" class="form-control" placeholder="Digite o nome">
                                <span class="text-danger error-text nome_error"></span>
                            </div>
                            <div class="form-group">
                                <label for="cnpj">CNPJ</label>
                                <input type="text" id="cnpj" name="cnpj" class="form-control" placeholder="Digite o CNPJ">
                                <span class="text-danger error-text cnpj_error"></span>
                            </div>
                            <div class="form-group">
                                <label for="cep">CEP</label>
                                <input type="text" id="cep" name="cep" class="form-control" placeholder="Digite o CEP">
                                <span class="text-danger error-text cep_error"></span>
                            </div>
                            <div class="form-group">
                                <label for="endereco">Endereço</label>
                                <input type="text" id="endereco" name="endereco" class="form-control" placeholder="Digite o endereço">
                                <span class="text-danger error-text endereco_error"></span>
                            </div>
                            <div class="form-group">
                                <label for="numero">Número</label>
                                <input type="text" id="numero" name="numero" class="form-control" placeholder="Digite o número">
                                <span class="text-danger error-text numero_error"></span>
                            </div>
                            <div class="form-group">
                                <label for="bairro">Bairro</label>
                                <input type="text" id="bairro" name="bairro" class="form-control" placeholder="Digite o bairro">
                                <span class="text-danger error-text bairro_error"></span>
                            </div>
                            <div class="form-group">
                                <label for="cidade">Cidade</label>
                                <input type="text" id="cidade" name="cidade" class="form-control" placeholder="Digite a cidade">
                                <span class="text-danger error-text cidade_error"></span>
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
    @include('supplier/modal-form')
@include('parts/footer')