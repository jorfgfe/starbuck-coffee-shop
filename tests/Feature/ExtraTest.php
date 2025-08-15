<?php

namespace Tests\Feature;

use App\Models\Extra;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExtraTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     */
    public function test_show_all_extras(): void 
    {
        Extra::factory(3)->create();

        $this->get('api/v1/extras')
            ->assertStatus(200)
            ->assertJsonCount(3, '1.data');
    }

    public function test_show_Extras(): void 
    {
        $extra = Extra::factory()->create();

        $this->get("api/v1/extras/{$extra->id}")
            ->assertStatus(200)
            ->assertSee($extra->name);

    }


    public function test_create_a_Extras(): void
    {
        $extrasBody = Extra::factory()->raw();
        $response = $this->post('api/v1/extras', $extrasBody);
        $response->assertStatus(201);
        
        $this->assertDatabaseHas('extras',$extrasBody);
    }

    public function test_update_a_Extras(): void
    {
        $extrasBody = Extra::factory()->create();

        $body = [
            'name' => 'new Extras name'
        ];
        $response = $this->patch("api/v1/extras/{$extrasBody->id}", $body);
        $response->assertStatus(201);
        
        $this->assertDatabaseHas('extras',$body);
    }

    public function test_delete_a_Extras(): void
    {
        $extrasBody = Extra::factory()->create();


        $response = $this->delete("api/v1/extras/{$extrasBody->id}");
        $response->assertStatus(201);
        
        $this->assertDatabaseMissing('extras',$extrasBody->toArray());
    }
}
