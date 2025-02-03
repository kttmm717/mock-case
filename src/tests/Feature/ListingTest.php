<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\Models\User;
use Database\Seeders\CategoriesTableSeeder;
use Database\Seeders\ConditionsTableSeeder;
use App\Models\Category;
use Illuminate\Support\Facades\DB;


class ListingTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void {
        parent::setUp();
        $this->seed(CategoriesTableSeeder::class);
        $this->seed(ConditionsTableSeeder::class);
    }

    /** @test */  //商品出品画面で必要な情報が保存できるかテスト
    public function item_create_screen_saves_the_item_info() {
        Storage::fake('public');
        //ストレージを擬似化

        $image = UploadedFile::fake()->image('item.jpg');
        //仮の画像item.jpgを作成
        $imagePath = $image->store('images', 'public');

        $user = User::factory()->create();

        $categories = Category::inRandomOrder()->take(2)->get();

        $data = [
            'user_id' => $user->id,
            'name' => 'テスト商品',
            'image' => $image,
            'price' => 1000,
            'content' => 'これはテスト商品です。',
            'condition_id' => 1,
            'categories' => $categories->pluck('id')->toArray()
        ];

        /** @var User $user */
        $response = $this->actingAs($user)->post('/sale', $data);
        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('items', [
            'user_id' => $user->id,
            'item_name' => 'テスト商品',
            'image' => $imagePath,
            'price' => 1000,
            'item_description' => 'これはテスト商品です。',
            'condition_id' => 1
        ]);

        $itemId = DB::table('items')->latest('id')->first()->id; // 最新の item_id を取得
        foreach ($categories as $category) {
            $this->assertDatabaseHas('category_item', [
                'item_id' => $itemId,
                'category_id' => $category->id
            ]);
        }
    }
}
