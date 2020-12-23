<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function create(Request $req, $id, $journey_id) {
        $this->validate($req, [
            'body' => 'required|string|max:255', 
        ]);

        $comment = \App\Models\Comment::create([
            'body' => $req->body, 
            'user_id' => Auth::user()->id,
            'journey_id' => $journey_id
        ]);

        return redirect()->back()->with('message', 'Comment Posted!');;
    }
}
