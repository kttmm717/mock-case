<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Database\Seeders\CategoriesTableSeeder;
use Database\Seeders\ConditionsTableSeeder;
use App\Models\Item;
use App\Models\User;
use App\Models\Purchase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void {
        parent::setUp();
        $this->seed(CategoriesTableSeeder::class);
        $this->seed(ConditionsTableSeeder::class);
    }

    /** @test */  //マイページで必要な情報を取得できるかテスト
    public function mypage_displays_all_information() {
        $user = User::factory()->create();
        /** @var User $user */
        $this->actingAs($user);

        $item = Item::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->get('/mypage/?page=sell');
        $response->assertStatus(200);
        $response->assertSee($user->profile_image);
        $response->assertSee($user->name);
        $response->assertSee($item->image);
        $response->assertSee($item->item_name);

        $purchasedItem = Purchase::factory()->create([
            'user_id' => $user->id
        ]);
        
        $response = $this->get('/mypage/?page=buy');
        $response->assertStatus(200);
        $response->assertSee($user->profile_image);
        $response->assertSee($user->name);
        $response->assertSee($purchasedItem->image);
        $response->assertSee($purchasedItem->item_name);
    }
}
