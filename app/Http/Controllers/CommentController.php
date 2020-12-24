<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $req, $id, $journey_id) {
        $this->validate($req, [
            'body' => 'required|string|max:255', 
        ]);

        $comment = \App\Models\Comment::create([
            'body' => $req->body, 
            'user_id' => auth()->id(),
            'journey_id' => $journey_id
        ]);

        return redirect()->back()->with('message', 'Comment Posted!');;
    }
}
