<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Request $req, $id, $journey_id) {
        if ($req->ajax()) {
            $startId = $req->query('startId');
            $take = $req->query('take');
            $comments = \App\Models\Comment::where('journey_id', 1)->orderBy('created_at', 'desc')->where('id', '<', (int)$startId)->limit((int)$take)->with('user')->get();
            if (true) {
                return response()->json([
                    'comments' => $comments
                ]);
            }
            else {
                return response(500);
            }
        }
    }

    public function store(Request $req, $id, $journey_id) {
        if ($req->ajax()) {
            $comment = \App\Models\Comment::create([
                'body' => $req->body, 
                'user_id' => auth()->id(),
                'journey_id' => $journey_id
            ]);

            if ($comment) {
                return response()->json([
                    'comment' => $comment,
                    'user' => $comment->user
                ]);
            }
            else {
                return response(500);
            }
        }
        else {
            $this->validate($req, [
                'body' => 'required|string|max:255', 
            ]);
    
            $comment = \App\Models\Comment::create([
                'body' => $req->body, 
                'user_id' => auth()->id(),
                'journey_id' => $journey_id
            ]);
    
            return redirect()->back()->with('message', 'Comment Posted!');
        }
    }
}
