<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_logout_successfully() {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('12345678')
        ]);
        /**@var User $user */
        $this->actingAs($user);  
        $response = $this->post('/logout'); 
        $this->assertGuest();  
        $response->assertRedirect('/'); 
    }
}
