<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Like;
use Database\Seeders\ConditionsTableSeeder;
use Database\Seeders\CategoriesTableSeeder;

class MylistTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void {
        parent::setUp();
        $this->seed(CategoriesTableSeeder::class);
        $this->seed(ConditionsTableSeeder::class);
    }

    /** @test */  //マイリスト画面でいいねした商品だけが表示されるかテスト
    public function only_liked_items_are_displayed_on_mylist_page() {
        $user = User::factory()->create();
        /**@var User $user */
        $this->actingAs($user);

        $otherUser = User::factory()->create(); 
        
        $userItem = Item::factory()->create([
            'user_id' => $user->id
        ]);

        $anotherUserItem = Item::factory()->create([
            'user_id' => $otherUser->id
        ]);

        $unLikedItem = Item::factory()->create([
            'user_id' => $otherUser->id
        ]);

        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $userItem
        ]);

        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $anotherUserItem
        ]);
        
        $response = $this->get('/find?page=mylist&keyword=');

        $response->assertSee($anotherUserItem->item_name);
        $response->assertDontSee($userItem->item_name);
        $response->assertDontSee($unLikedItem->item_name);
    }
        

    /** @test */  //マイリスト画面で購入済み商品はSoldと表示されるかテスト
    public function sold_item_is_displayed_as_sold() {
        $user = User::factory()->create();
        /**@var User $user */
        $this->actingAs($user);

        $otherUser = User::factory()->create();

        $anotherUserItem = Item::factory()->create([
            'user_id' => $otherUser->id,
            'is_sold' => true
        ]);

        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $anotherUserItem->id
        ]);

        $response = $this->get('/find?page=mylist&keyword=');

        $response->assertSee($anotherUserItem->item_name);
        $response->assertSeeText('Sold');
    }
    
    /** @test */  //マイリスト画面で自分が出品した商品が表示されないかテスト
    public function own_items_are_not_displayed_on_mylist_page() {
        $user = User::factory()->create();

        Item::factory()->create([
            'user_id' => $user->id,
            'item_name' => '自分のアイテム'
        ]);

        /**@var User $user */
        $this->actingAs($user);

        $response = $this->get('/find?page=mylist&keyword=');
        $response->assertDontSee('自分のアイテム');
    }

    /** @test */  //マイリスト画面で未認証の場合は何も表示されないかテスト
    public function mylist_is_empty_for_guest() {
        $item = Item::factory()->create();

        $response = $this->get('/find?page=mylist&keyword=');
        $response->assertStatus(200);
        $response->assertDontSee($item);
    }

}
