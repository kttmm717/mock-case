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

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void {
        parent::setUp();
        $this->seed(CategoriesTableSeeder::class);
        $this->seed(ConditionsTableSeeder::class);
    }

    /** @test */  //支払い方法が即時反映されるかテスト
    public function payment_method_changes_immediately() {
        $user = User::factory()->create();
        /** @var User $user */
        $this->actingAs($user);

        $item = Item::factory()->create();

        $response = $this->get("/purchase/?id={$item->id}");
        $response->assertStatus(200);

        $postData = [
            'item_id' => $item->id,
            'paymentMethod' => 'konbini',
            '_token' => csrf_token(),
        ];
        // コンビニ支払いを選択してフォーム送信

        $postResponse = $this->post(route('purchase'), $postData);
        $postResponse->assertRedirect("/purchase/?id={$item->id}");

        $updatedResponse = $this->get("/purchase/?id={$item->id}");
        $updatedResponse->assertSee('コンビニ支払い');

        $postData['paymentMethod'] = 'card';
        $postResponse = $this->post(route('purchase'), $postData);
        $postResponse->assertRedirect("/purchase/?id={$item->id}");

        $updatedResponse = $this->get("/purchase/?id={$item->id}");
        $updatedResponse->assertSee('カード支払い');
    }
}
