<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;
use App\Models\Supplier;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_create_a_product()
    {
        $supplier = Supplier::factory()->create();

        $response = $this->postJson('/product/store', [
            'nome' => 'Produto Teste',
            'descricao' => 'Descrição Teste',
            'preco' => 10.50,
            'estoque' => 5,
            'fornecedores' => [$supplier->id]
        ]);

        $response->assertStatus(200)
                 ->assertJson(['status' => 1, 'message' => 'Produto cadastrado com sucesso.']);

        $this->assertDatabaseHas('products', ['nome' => 'Produto Teste']);
    }

    /** @test */
    public function it_should_return_validation_errors_on_create()
    {
        $response = $this->postJson('/product/store', []);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['nome', 'descricao', 'preco', 'estoque']);
    }

    /** @test */
    public function it_should_update_a_product()
    {
        $product = Product::factory()->create();

        $response = $this->postJson('/product/update', [
            'product_id' => $product->id,
            'nome' => 'Produto Atualizado',
            'descricao' => 'Descrição Atualizada',
            'preco' => 99.90,
            'estoque' => 10
        ]);

        $response->assertStatus(200)
                 ->assertJson(['status' => 1, 'message' => 'Atualizado com sucesso.']);

        $this->assertDatabaseHas('products', ['nome' => 'Produto Atualizado']);
    }

    /** @test */
    public function it_should_delete_a_product()
    {
        $product = Product::factory()->create();

        $response = $this->postJson('/product/delete', ['id' => $product->id]);

        $response->assertStatus(200)
                 ->assertJson(['status' => 1]);

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    /** @test */
    public function it_should_bulk_delete_products()
    {
        $products = Product::factory()->count(3)->create();

        $ids = $products->pluck('id')->toArray();

        $response = $this->postJson('/product/delete-multiple', ['checked_ids' => $ids]);

        $response->assertStatus(200)
                 ->assertJson(['status' => 1]);

        foreach ($ids as $id) {
            $this->assertDatabaseMissing('products', ['id' => $id]);
        }
    }
}