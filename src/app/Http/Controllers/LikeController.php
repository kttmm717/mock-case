<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class LikeController extends Controller
{
    public function store(Item $item) {
        $user = auth()->user();
        $item->likes()->create(['user_id' => $user->id]);
        $user->like_id = $item->id;
        return redirect()->back();
    }
    public function destroy(Item $item) {
        $item->likes()->where('user_id', auth()->id())->delete();
        return redirect()->back();
    }
}
