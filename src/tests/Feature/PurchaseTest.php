<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Database\Seeders\CategoriesTableSeeder;
use Database\Seeders\ConditionsTableSeeder;
use App\Models\User;
use App\Models\Item;
use Illuminate\Support\Facades\Session;


class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void {
        parent::setUp();
        $this->seed(CategoriesTableSeeder::class);
        $this->seed(ConditionsTableSeeder::class);
    }

    /** @test */  //購入するボタン押下すると購入が完了するかテスト
    public function user_can_complete_purchase() {
        $user = User::factory()->create();
        /** @var User $user */
        $this->actingAs($user);

        $otherUser = User::factory()->create();

        $item = Item::factory()->create([
            'user_id' => $otherUser->id
        ]);

        $purchaseData = [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'paymentMethod' => 'card',
            'shipping_zipcode' => '123-1234', 
            'shipping_address' => '新潟県新潟市西区', 
            'shipping_building' => 'テストビル102号室',
        ];
        
        session(['purchase_data' => $purchaseData]);

        $response = $this->post(route('purchase'), [
            'item_id' => $item->id,
            'paymentMethod' => 'card',
        ]);
        
        $this->assertStringContainsString('checkout.stripe.com', $response->headers->get('Location'));
    
        $this->get(route('purchase.success', ['item_id' => $item->id]))
            ->assertStatus(200);
        
        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method' => 'card',
            'shipping_zipcode' => '123-1234', 
            'shipping_address' => '新潟県新潟市西区', 
            'shipping_building' => 'テストビル102号室',
        ]);
    }

    /** @test */ //購入した商品は商品一覧画面にて「sold」と表示されるかテスト
    public function sold_items_are_marked_on_product_list_page() {
        $user = User::factory()->create();
        /** @var User $user */
        $this->actingAs($user);

        $otherUser = User::factory()->create();

        $item = Item::factory()->create([
            'user_id' => $otherUser->id,
            'is_sold' => false
        ]);

        $purchaseData = [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'paymentMethod' => 'card',
            'shipping_zipcode' => '123-1234', 
            'shipping_address' => '新潟県新潟市西区', 
            'shipping_building' => 'テストビル102号室',
        ];
        session(['purchase_data' => $purchaseData]);   

        $response = $this->post(route('purchase'), [
            'item_id' => $item->id,
            'paymentMethod' => 'card',
        ]);
        
        $this->assertStringContainsString('checkout.stripe.com', $response->headers->get('Location'));
    
        $this->get(route('purchase.success', ['item_id' => $item->id]))
            ->assertStatus(200);

        $this->assertDatabaseHas('items', [
            'id' => $item->id,
            'is_sold' => true
        ]);

        $response = $this->get('/?page=best');
        $response->assertSee('Sold');
    }

    /** @test */ //購入した商品がプロフィールの購入した商品一覧に追加されているかテスト
    public function purchase_adds_item_to_profile() {
        $user = User::factory()->create();
        /** @var User $user */
        $this->actingAs($user);

        $otherUser = User::factory()->create();

        $item = Item::factory()->create([
            'user_id' => $otherUser->id,
            'is_sold' => false
        ]);

        $purchaseData = [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'paymentMethod' => 'card',
            'shipping_zipcode' => '123-1234', 
            'shipping_address' => '新潟県新潟市西区', 
            'shipping_building' => 'テストビル102号室',
        ];
        session(['purchase_data' => $purchaseData]);

        $response = $this->post(route('purchase'), [
            'item_id' => $item->id,
            'paymentMethod' => 'card',
        ]);
        
        $this->assertStringContainsString('checkout.stripe.com', $response->headers->get('Location'));
    
        $this->get(route('purchase.success', ['item_id' => $item->id]))
            ->assertStatus(200);

        $response = $this->get('/mypage/?page=buy');

        $response->assertSee($item->item_name);
        $response->assertSee($item->image);
    }
}
