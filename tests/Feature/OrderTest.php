<?php

namespace Tests\Feature;

use App\Models\Extra;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     */

     public function test_a_order_cannot_create_without_enough_product_stock(): void
    {

        Product::factory(3)->create(['stock' => 1]);
        Extra::factory(3)->create();

        $orderBody = [
            'order' => [
                [
                    "productId" => 1,
                    "quantity"  => 1,
                    "extra" => [
                        1
                    ]
                ],
                [
                    "productId" => 2,
                    "quantity"  => 5,
                    "extra" => [
                        1,
                        2
                    ]
                ],
                [
                    "productId" => 1,
                    "quantity"  => 1
                ],
            ],
            "payment" => 2
        ];

        $this->post('api/v1/orders', $orderBody)
                    ->assertStatus(200)
                    ->assertSee('Insufficient stock for product:');
    }
    public function test_a_order_cannot_create_without_enough_money(): void
    {

        Product::factory(3)->create();
        Extra::factory(3)->create();

        $orderBody = [
            'order' => [
                [
                    "productId" => 1,
                    "quantity"  => 1,
                    "extra" => [
                        1
                    ]
                ],
                [
                    "productId" => 2,
                    "quantity"  => 5,
                    "extra" => [
                        1,
                        2
                    ]
                ],
                [
                    "productId" => 1,
                    "quantity"  => 1
                ],
            ],
            "payment" => 2
        ];

        $this->post('api/v1/orders', $orderBody)
                    ->assertStatus(200)
                    ->assertSee('Insufficient funds');
    }

    public function test_make_order(): void
    {

        Product::factory(3)->create();
        Extra::factory(3)->create();

        $orderBody = [
            'order' => [
                [
                    "productId" => 1,
                    "quantity"  => 1,
                    "extra" => [
                        1
                    ]
                ],
                [
                    "productId" => 2,
                    "quantity"  => 5,
                    "extra" => [
                        1,
                        2
                    ]
                ],
                [
                    "productId" => 1,
                    "quantity"  => 1
                ],
            ],
            "payment" => PHP_INT_MAX
        ];

        $this->post('api/v1/orders', $orderBody)
                    ->assertStatus(201)
                   ->assertSee('Order created successfully');
    }
}
