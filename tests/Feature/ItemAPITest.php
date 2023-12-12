<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Category;
use App\Models\Item;

class ItemAPITest extends TestCase
{
    private $TOKEN = 'chandan_api_topken';
    
    public function test_item_list_api()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->TOKEN,
        ])->getJson('/api/item');
        $response->assertStatus(200);
    }

    public function test_store_item()
    {
        $categories = Category::pluck('id');
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->TOKEN,
        ])
            ->postJson('/api/item', [
                'name' => 'Item22',
                'desc' => 'Test',
                'price' => 200.00,
                'qty' => 50,
                'cat_id' => $categories
            ]);
        $response->assertStatus(201);
    }

    public function test_update_item()
    {
        // get a valid item from database
        $item = Item::orderBy('id', 'ASC')->first();
        $categories = Category::pluck('id')->first();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->TOKEN,
        ])
            ->put('/api/item/' . $item->id, [
                'name' => 'Test category',
                'desc' => 'Test',
                'price' => 200.00,
                'qty' => 501,
                'cat_id' => [$categories]
            ]);
        $response->assertStatus(200);
    }

    public function test_get_particular_item()
    {
        $item = Item::orderBy('id', 'DESC')->first();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->TOKEN,
        ])->getJson('/api/item/'.$item->id);
        $response->assertStatus(200);
    }

    public function test_delete_item_error()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->TOKEN,
        ])
            ->delete('/api/item/1000000');
        $response->assertStatus(400);
    }

    public function test_delete_item()
    {
        $category = Item::orderBy('id', 'DESC')->first();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->TOKEN,
        ])
            ->delete('/api/item/' . $category->id);
        $response->assertStatus(200);
    }
}
