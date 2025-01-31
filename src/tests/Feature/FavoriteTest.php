<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Database\Seeders\ConditionsTableSeeder;
use Database\Seeders\CategoriesTableSeeder;
use App\Models\User;
use App\Models\Item;
use App\Models\Like;

class FavoriteTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void {
        parent::setUp();
        $this->seed(ConditionsTableSeeder::class);
        $this->seed(CategoriesTableSeeder::class);
    }

    /** @test */  //いいねアイコンを押下することによっていいねした商品を登録することができ、いいね合計値が増加表示されるかテスト
    public function user_can_like_an_item_by_clicking_icon() {
        $user = User::factory()->create();
        /** @var User $user */
        $this->actingAs($user);

        $item = Item::factory()->create();

        $initialLikeCount = Like::where('item_id', $item->id)->count();

        $previousUrl = "/item?id={$item->id}";

        $response = $this->withHeaders(['Referer' => $previousUrl])
            ->post("/posts/{$item->id}/like");

        $response->assertRedirect($previousUrl);

        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id
        ]);

        $afterLikeCount = Like::where('item_id', $item->id)->count();

        $this->assertEquals($initialLikeCount+1, $afterLikeCount);

        $response = $this->get("item/?id={$item->id}");
        $response->assertSee("{$afterLikeCount}");
    }

    /** @test */  //いいねアイコンが押下されている状態では色が変化しているかテスト
    public function liked_icon_changes_color() {
        $user = User::factory()->create();
        /** @var User $user */
        $this->actingAs($user);

        $item = Item::factory()->create();

        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id
        ]);

        $response = $this->get("/item?id={$item->id}");

        $response->assertSee('fas fa-star liked');
    }

    /** @test */  //いいねアイコンを押下することによって、いいねを解除でき、いいね合計値が減少表示されるかテスト
    public function user_can_unlike_an_item() {
        $user = User::factory()->create();
        /** @var User $user */
        $this->actingAs($user);

        $item = Item::factory()->create();

        Like::factory()->create([
            'item_id' => $item->id,
            'user_id' => $user->id
        ]);

        $initialLikeCount = Like::where('item_id', $item->id)->count();

        $previousUrl = "/item?id={$item->id}";
        $response = $this->withHeaders(['Referer' => $previousUrl])
            ->delete("/posts/{$item->id}/like");
        $response->assertRedirect($previousUrl);

        $this->assertDatabaseMissing('likes', [
            'item_id' => $item->id,
            'user_id' => $user->id
        ]);

        $afterLikeCount = Like::where('item_id', $item->id)->count();

        $this->assertEquals($initialLikeCount-1, $afterLikeCount);

        $response = $this->get("item/?id={$item->id}");
        $response->assertSee("{$afterLikeCount}");
        
    }

}
