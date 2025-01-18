<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Models\Item;

class CommentController extends Controller
{
    public function store(CommentRequest $request, Item $item) {
        $item->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->content
        ]);
        return redirect()->back();
    }
}
