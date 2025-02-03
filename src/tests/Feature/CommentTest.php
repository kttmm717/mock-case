<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Database\Seeders\CategoriesTableSeeder;
use Database\Seeders\ConditionsTableSeeder;
use App\Models\User;
use App\Models\Item;
use App\Models\Comment;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void {
        parent::setUp();
        $this->seed(CategoriesTableSeeder::class);
        $this->seed(ConditionsTableSeeder::class);
    }

    /** @test */  //ログイン済みユーザーはコメントを送信でき、コメント数が増加するかテスト
    public function authenticated_user_can_post_comment_and_comment_count_increases() {
        $user = User::factory()->create();
        /** @var User $user */
        $this->actingAs($user);

        $item = Item::factory()->create();

        $initialCommentCount = Comment::where('item_id', $item->id)->count();

        $comment = [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'content' => 'これはテストコメントです'
        ];

        $response = $this->post("/items/{$item->id}/comments", $comment);

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'content' => 'これはテストコメントです'
        ]);

        $afterCommentCount = Comment::where('item_id', $item->id)->count();

        $this->assertEquals($initialCommentCount+1, $afterCommentCount);

        $response = $this->get("item/?id={$item->id}");
        $response->assertSee("{$afterCommentCount}");
    }

    /** @test */  //ログイン前ユーザーはコメント送信ができないかテスト
    public function noauthenticated_user_is_redirected_to_login() {
        $item = Item::factory()->create();

        $comment = [
            'content' => 'ログイン前ユーザーのコメント'
        ];

        $response = $this->post("/items/{$item->id}/comments", $comment);

        $response->assertRedirect('/login');
    }

    /** @test */  //コメントが入力されていない場合、バリデーションメッセージが表示されるかテスト
    public function validation_error_when_comment_is_empty() {
        $user = User::factory()->create();
        /** @var User $user */
        $this->actingAs($user);

        $item = Item::factory()->create();

        $comment = [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'content' => ''
        ];

        $response = $this->post("/items/{$item->id}/comments", $comment);

        $response->assertSessionHasErrors([
            'content' => 'コメントを入力してください'
        ]);
    }

    /** @test */  //コメントが255字以上の場合、バリデーションメッセージが表示されるかテスト
    public function comment_cannot_exceed_255_characters() {
        $user = User::factory()->create();
        /** @var User $user */
        $this->actingAs($user);

        $item = Item::factory()->create();

        $longComment = str_repeat('あ', 256);

        $comment = [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'content' => $longComment
        ];

        $response = $this->post("/items/{$item->id}/comments", $comment);

        $response->assertSessionHasErrors([
            'content' => 'コメントは255字以内で入力してください'
        ]);
    }
}
