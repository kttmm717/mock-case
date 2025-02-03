<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ProfileEditTest extends TestCase
{
    use RefreshDatabase;

    /** @test */  //プロフィール編集画面で各項目の初期値が正しく表示されてるかテスト
    public function profile_edit_screen_displays_correct_initial_values() {
        Storage::fake('public');

        $image = UploadedFile::fake()->image('profile.jpg');
        $imagePath = 'profile/' . $image->getClientOriginalName();

        $user = User::factory()->create([
            'name' => 'テスト 太郎',
            'profile_image' => $imagePath,
            'zipcode' => '959-0000',
            'address' => '新潟県新潟市',
            'building' => 'マンション777'
        ]);

        Storage::disk('public')->put($imagePath, file_get_contents($image));

        /** @var User $user */
        $this->actingAs($user);

        $response = $this->get('/mypage/profile');
        $response->assertStatus(200);
        $response->assertSee('テスト 太郎');
        $response->assertSee("storage/{$user->image}");
        $response->assertSee('959-0000');
        $response->assertSee('新潟県新潟市');
        $response->assertSee('マンション777');
    }
}
