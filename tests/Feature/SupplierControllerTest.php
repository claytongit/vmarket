<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Supplier;

class SupplierControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_create_a_supplier()
    {
        $response = $this->postJson('/supplier/store', [
            'cnpj' => '12345678900011',
            'nome' => 'Fornecedor Teste',
            'endereco' => 'Rua Exemplo',
            'numero' => '123',
            'bairro' => 'Centro',
            'cidade' => 'São Paulo'
        ]);

        $response->assertStatus(200)
                 ->assertJson(['status' => 1]);

        $this->assertDatabaseHas('suppliers', ['cnpj' => '12345678900011']);
    }

    /** @test */
    public function it_should_fail_to_create_supplier_with_existing_cnpj()
    {
        Supplier::factory()->create(['cnpj' => '12345678900011']);

        $response = $this->postJson('/supplier/store', [
            'cnpj' => '12345678900011',
            'nome' => 'Fornecedor 2',
            'endereco' => 'Rua Teste',
            'numero' => '456',
            'bairro' => 'Bairro A',
            'cidade' => 'Cidade B'
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['cnpj']);
    }

    /** @test */
    public function it_should_update_a_supplier()
    {
        $supplier = Supplier::factory()->create();

        $response = $this->postJson('/supplier/update', [
            'suppiler_id' => $supplier->id,
            'cnpj' => '98765432100012',
            'nome' => 'Fornecedor Atualizado',
            'endereco' => 'Rua Nova',
            'numero' => '999',
            'bairro' => 'Novo Bairro',
            'cidade' => 'Rio de Janeiro'
        ]);

        $response->assertStatus(200)
                 ->assertJson(['status' => 1]);

        $this->assertDatabaseHas('suppliers', ['nome' => 'Fornecedor Atualizado']);
    }

    /** @test */
    public function it_should_delete_a_supplier()
    {
        $supplier = Supplier::factory()->create();

        $response = $this->postJson('/supplier/delete', ['id' => $supplier->id]);

        $response->assertStatus(200)
                 ->assertJson(['status' => 1]);

        $this->assertDatabaseMissing('suppliers', ['id' => $supplier->id]);
    }

    /** @test */
    public function it_should_bulk_delete_suppliers()
    {
        $suppliers = Supplier::factory()->count(3)->create();

        $ids = $suppliers->pluck('id')->toArray();

        $response = $this->postJson('/supplier/delete-multiple', ['checked_ids' => $ids]);

        $response->assertStatus(200)
                 ->assertJson(['status' => 1]);

        foreach ($ids as $id) {
            $this->assertDatabaseMissing('suppliers', ['id' => $id]);
        }
    }
}