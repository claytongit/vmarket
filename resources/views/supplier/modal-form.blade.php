<!-- Modal -->
<div class="modal fade" id="modal-form-suppiler" role="dialog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
      <form class="modal-content" action="{{  route('updateSupplier') }}" method="POST" id="update_suppiler_form">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Editar Fornecedor</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            @csrf
            <input type="hidden" name="suppiler_id">
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
                <input type="text" id="cep" name="cep" class="form-control" placeholder="Digite o endereço">
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
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          <button type="submit" class="btn btn-primary">Salvar alterações</button>
        </div>
      </form>
    </div>
</div>