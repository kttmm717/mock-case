<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Database\Seeders\CategoriesTableSeeder;
use Database\Seeders\ConditionsTableSeeder;
use App\Models\Item;
use App\Models\Comment;
use App\Models\User;


class ItemDetailTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void {
        parent::setUp();
        $this->seed(CategoriesTableSeeder::class);
        $this->seed(ConditionsTableSeeder::class);
    }

    /** @test */  //商品詳細ページで全ての情報が表示されるかテスト
                  //複数選択されたカテゴリが表示されているかテスト
    public function item_detail_page_displays_all_information() {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $comment = Comment::factory()->create([
            'item_id' => $item->id,
            'user_id' => $user->id
        ]);

        $categories = Category::inRandomOrder()->take(2)->get();
        $item->categories()->attach($categories->pluck('id'));

        $response = $this->get("/item?id={$item->id}");

        $response->assertStatus(200);
        $response->assertSee($item->image);
        $response->assertSee($item->item_name);        
        $response->assertSee(number_format($item->price));
        $response->assertSee($item->likes->count());
        $response->assertSee($item->comments->count());
        $response->assertSee($item->item_description);
        $response->assertSee($item->condition->content);

        foreach($categories as $category) {
            $response->assertSee($category->name);
        }

        $response->assertSee($comment->user->image);
        $response->assertSee($comment->user->name);
        $response->assertSee($comment->content);
    }
}
