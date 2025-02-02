<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Item;

class PaymentTest extends DuskTestCase
{
    /** @test */  //支払い方法が即時反映されるかテスト
    public function payment_method_changes_immediately() {
        $this->browse(function(Browser $browser) {
        //この記述はDuskテストの書き方で、$browserを使ってブラウザ操作をするための記述
            
            $user = User::factory()->create();
            $item = Item::factory()->create();

            $browser->loginAs($user)
                ->visit("/purchase?id={$item->id}")
                ->select('paymentMethod', 'konbini')
                ->waitForText('コンビニ支払い')
                ->assertSee('コンビニ支払い');
        });
    }
}
