<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreateProduct()
    {

        $data = [
            'name' => 'Product Name',
            'description' => 'Product desc',
            'price' => 100,
            'id_category' => 1
        ];

        $response = $this->postJson('/api/addProduct', $data);

        $response->assertStatus(200)
            ->assertJson(['success'=>true]);
    }
}
