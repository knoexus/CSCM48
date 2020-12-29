<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Notifications\JourneyCommented;

class CommentController extends Controller
{
    public function index(Request $req, $id, $journey_id) {
        if ($req->ajax()) {
            $startId = $req->query('startId');
            $take = $req->query('take');
            $comments = \App\Models\Comment::where('journey_id', 1)->orderBy('created_at', 'desc')->where('id', '<', (int)$startId)->limit((int)$take)->with('user')->get();
            if ($comments) {
                return response()->json([
                    'comments' => $comments
                ]);
            }
            else {
                return response(500);
            }
        }
        else abort(404);
    }

    public function destroy(Request $req, $id, $journey_id, $comment_id) {
        $comment = \App\Models\Comment::where([
            ['journey_id', $journey_id],
            ['user_id', $id],
            ['id', $comment_id],
        ])->first();
        
        if ($comment) {
            if (auth()->id() == $comment->user_id) {
                $comment->delete();
                return response()->json([
                    'msg' => 'Comment successfully deleted!',
                ]); 
            }
            else {
                return response(401);
            }
        }
        else {
            return response(500);
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
                if (auth()->id() != $id) {
                    $user = \App\Models\User::find($id);
                    if ($user) {
                        $user->notify(new JourneyCommented(auth()->user(), $journey_id));
                    }
                }
                
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
