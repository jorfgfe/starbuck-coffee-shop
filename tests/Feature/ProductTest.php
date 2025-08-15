<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     */
    public function test_show_all_products(): void 
    {
        Product::factory(3)->create();

        $this->get('api/v1/products')
            ->assertStatus(200)
            ->assertJsonCount(3, '1.data');
    }

    public function test_show_products(): void 
    {
        $product = Product::factory()->create();

        $this->get("api/v1/products/{$product->id}")
            ->assertStatus(200)
            ->assertSee($product->name);

    }


    public function test_create_a_products(): void
    {
        $productsBody = Product::factory()->raw();
        $response = $this->post('api/v1/products', $productsBody);
        $response->assertStatus(201);
        
        $this->assertDatabaseHas('products',$productsBody);
    }

    public function test_update_a_products(): void
    {
        $productsBody = Product::factory()->create();

        $body = [
            'name' => 'new Products name'
        ];
        $response = $this->patch("api/v1/products/{$productsBody->id}", $body);
        $response->assertStatus(201);
        
        $this->assertDatabaseHas('Products',$body);
    }

    public function test_delete_a_products(): void
    {
        $productsBody = Product::factory()->create();


        $response = $this->delete("api/v1/products/{$productsBody->id}");
        $response->assertStatus(201);
        
        $this->assertDatabaseMissing('products',$productsBody->toArray());
    }
}
