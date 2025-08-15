<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     */
    public function test_show_all_categories(): void 
    {
        Category::factory(3)->create();

        $this->get('api/v1/categories')
            ->assertStatus(200)
            ->assertJsonCount(3, '1.data');
    }

    public function test_show_category(): void 
    {
        $category = Category::factory()->create();

        $this->get("api/v1/categories/{$category->id}")
            ->assertStatus(200)
            ->assertSee($category->name);

    }


    public function test_create_a_category(): void
    {
        $categoryBody = Category::factory()->raw();
        $response = $this->post('api/v1/categories', $categoryBody);
        $response->assertStatus(201);
        
        $this->assertDatabaseHas('categories',$categoryBody);
    }

    public function test_update_a_category(): void
    {
        $categoryBody = Category::factory()->create();

        $body = [
            'name' => 'new Category name'
        ];
        $response = $this->patch("api/v1/categories/{$categoryBody->id}", $body);
        $response->assertStatus(201);
        
        $this->assertDatabaseHas('categories',$body);
    }

    public function test_delete_a_category(): void
    {
        $categoryBody = Category::factory()->create();


        $response = $this->delete("api/v1/categories/{$categoryBody->id}");
        $response->assertStatus(201);
        
        $this->assertDatabaseMissing('categories',$categoryBody->toArray());
    }
}
