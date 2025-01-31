<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Database\Seeders\CategoriesTableSeeder;
use Database\Seeders\ConditionsTableSeeder;
use App\Models\User;
use App\Models\Item;
use App\Models\Like;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void {
        parent::setUp();
        $this->seed(CategoriesTableSeeder::class);
        $this->seed(ConditionsTableSeeder::class);
    }

    /** @test */  //商品名で部分一致検索ができるかテスト
    public function user_can_search_items_by_partial_match() {
        $matchingItem1 = Item::factory()->create([
            'item_name' => '赤いりんご'
        ]);
        $matchingItem2 = Item::factory()->create([
            'item_name' => '青いりんご'
        ]);
        $nomatchingItem = Item::factory()->create([
            'item_name' => 'バナナ'
        ]);

        $response = $this->get('/find?page=best&keyword=りんご');
        $response->assertStatus(200);

        $response->assertSee($matchingItem1->item_name);
        $response->assertSee($matchingItem2->item_name);
        $response->assertDontSee($nomatchingItem->item_name);
    }

    /** @test */  //検索状態がマイリストでも保持されているかテスト
    public function search_keyword_is_retained_on_mylist_page() {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        /** @var User $user */
        $this->actingAs($user);

        $keyword = 'りんご';

        $matchingItem = Item::factory()->create([
            'user_id' => $otherUser->id,
            'item_name' => '赤いりんご'
        ]);
        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $matchingItem->id
        ]);

        $response = $this->get("/find?page=best&keyword={$keyword}");
        $response->assertSee($matchingItem->item_name);

        $response = $this->get("/find?page=mylist&keyword={$keyword}");
        $response->assertSee("keyword={$keyword}");
        $response->assertSee($matchingItem->item_name);
    }
}
