<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use Database\Seeders\ConditionsTableSeeder;
use Database\Seeders\CategoriesTableSeeder;

class TopTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void {
        parent::setUp();
        $this->seed(CategoriesTableSeeder::class);
        $this->seed(ConditionsTableSeeder::class);
    }

    /** @test */  //トップ画面で全ての商品を取得できるかテスト
    public function top_page_display_items() {
        $items = Item::factory()->count(3)->create();
        $response = $this->get('/');
        $response->assertStatus(200);
        foreach($items as $item) {
            $response->assertSee($item->item_name);
            $response->assertSee($item->image);
        }
    }

    /** @test */  //購入済み商品はSoldと表示されるかテスト
    public function sold_item_is_displayed_as_sold() {
        $item = Item::factory()->create([
            'is_sold' => true
        ]);
        $response = $this->get('/');
        $response->assertStatus(200);

        $response->assertSee($item->item_name);
        $response->assertSee($item->image);

        $response->assertSee('Sold');
    }

    /** @test */  //自分が出品した商品がトップ画面で表示されないかテスト
    public function own_items_are_not_displayed_on_top_page() {
        
    }
}