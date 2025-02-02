<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Database\Seeders\CategoriesTableSeeder;
use Database\Seeders\ConditionsTableSeeder;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;

class PurchaseTest extends TestCase
{
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

        $item = Item::factory()->create();

        $response = $this->post(route('purchase'), [
            'item_id' => $item->id,
            'paymentMethod' => 'card'
        ]);

        $response->assertRedirect();
        $this->assertStringContainsString('checkout.stripe.com', $response->headers->get('Location'));
    }
}
