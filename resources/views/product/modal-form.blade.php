<!-- Modal -->
<div class="modal fade" id="modal-form-product" role="dialog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
      <form class="modal-content" action="{{ route('product.updateProduct') }}" method="POST" id="update_product_form">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            @csrf
            <input type="hidden" name="product_id">
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
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          <button type="submit" class="btn btn-primary">Salvar alterações</button>
        </div>
      </form>
    </div>
</div>