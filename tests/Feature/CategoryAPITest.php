<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Category;

class CategoryAPITest extends TestCase
{
    private $TOKEN = 'chandan_api_topken';

    public function test_api_middleware()
    {
        $response = $this->postJson('/api/category', [
            'name' => 'Cat API Test',
            'desc' => 'Test'
        ]);

        $response->assertStatus(403);
    }

    public function test_store_category()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->TOKEN,
        ])->postJson('/api/category', [
            'name' => 'Cat API Test',
            'desc' => 'Test'
        ]);
        $response->assertStatus(201);
    }

    public function test_update_category()
    {
        $category = Category::orderBy('id', 'DESC')->first();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->TOKEN,
        ])->putJson('/api/category/' . $category->id, [
            'name' => 'Cat API Test update test',
            'desc' => 'Test'
        ]);
        $response->assertStatus(200);
    }

    public function test_update_category_error()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->TOKEN,
        ])->putJson('/api/category/100000', [
            'name' => 'Cat API Test',
            'desc' => 'Test'
        ]);
        $response->assertStatus(404);
    }

    public function test_get_category()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->TOKEN,
        ])->getJson('/api/category');
        $response->assertStatus(200);
    }

    public function test_get_particular_category()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->TOKEN,
        ])->getJson('/api/category/7');
        $response->assertStatus(200);
    }

    public function test_get_particular_category_error()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->TOKEN,
        ])->getJson('/api/category/1000000');
        $response->assertStatus(404);
    }

    public function test_delete_category()
    {
        $category = Category::orderBy('id', 'DESC')->first();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->TOKEN,
        ])->delete('/api/category/' . $category->id);
        $response->assertStatus(200);
    }
	
	public function test_delete_category_error()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->TOKEN,
        ])->delete('/api/category/1000000');
        $response->assertStatus(400);
    }

    
}
