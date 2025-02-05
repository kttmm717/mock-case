<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use Database\Seeders\CategoriesTableSeeder;
use Database\Seeders\ConditionsTableSeeder;

class ShippingAddressEditTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void {
        parent::setUp();
        $this->seed(CategoriesTableSeeder::class);
        $this->seed(ConditionsTableSeeder::class);
    }

    /** @test */  //送付先住所変更画面にて登録した住所が商品購入画面に反映されているかテスト
    public function updated_shipping_address_is_displayed_on_purchase_page() {
        $user = User::factory()->create();
        /** @var User $user */
        $this->actingAs($user);
        //ユーザー作成してログインさせる

        $item = Item::factory()->create();
        //アイテム作成

        $this->get("/purchase/address/?id={$item->id}")->assertStatus(200);
        //住所変更画面へアクセス

        $data = [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'shipping_zipcode' => '123-4567',
            'shipping_address' => '東京都新宿区西新宿',
            'shipping_building' => 'テストビル101号室',
        ];
        //住所変更データ作成

        $response = $this->post("/purchase/address/update?id={$item->id}", $data);
        
        $this->assertEquals('123-4567', session('purchase_data.shipping_zipcode'));
        $this->assertEquals('東京都新宿区西新宿', session('purchase_data.shipping_address'));
        $this->assertEquals('テストビル101号室', session('purchase_data.shipping_building'));
        //assertEqualsとsession()で、セッションに保存されているか確認

        $response->assertSee('123-4567');
        $response->assertSee('東京都新宿区西新宿');
        $response->assertSee('テストビル101号室');
        //ビューに送付先住所が表示されているか確認
        //assertSeeはビューがproduct-purchaseかどうかではなく、
        //レスポンスのHTML内に特定のテキストが含まれているかをチェックするだけ

        $response->assertViewIs('product-purchase');
        //レスポンスがproduct-purchaseのビューを返しているか確認
    }

    /** @test */  //購入した商品に送付先住所が紐づいて登録されるかテスト
    public function purchased_item_has_shipping_address_associated() {
        $user = User::factory()->create();
        /** @var User $user */
        $this->actingAs($user);
        //ユーザー作成してログインさせる

        $item = Item::factory()->create();
        //アイテム作成

        $this->get("/purchase/address/?id={$item->id}")->assertStatus(200);
        //住所変更画面へアクセス

        $data = [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'shipping_zipcode' => '123-1234',
            'shipping_address' => '新潟県新潟市西区',
            'shipping_building' => 'テストビル102号室',
            'paymentMethod' => 'card',
        ];
        //住所変更データ作成

        $this->post("/purchase/address/update?id={$item->id}", $data);
        //住所変更のリクエスト

        $purchaseData = [
            'item_id' => $item->id,
            'paymentMethod' => 'card',
            'shipping_zipcode' => '123-1234', 
            'shipping_address' => '新潟県新潟市西区', 
            'shipping_building' => 'テストビル102号室',
        ];

        $response = $this->post(route('purchase'), $purchaseData);

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

}
