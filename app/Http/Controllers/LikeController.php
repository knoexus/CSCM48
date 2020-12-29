<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Notifications\JourneyLiked;

class LikeController extends Controller
{
    public function store($id, $journey_id) {
        $like = \App\Models\Like::create([
            'user_id' => auth()->id(),
            'journey_id' => $journey_id
        ]);
        
        if (auth()->id() != $id) {
            $user = \App\Models\User::find($id);
            $journey = \App\Models\Journey::find($journey_id);
            if ($user && $journey) {
                $user->notify(new JourneyLiked(auth()->user(), $journey));
            }
        }

        return response()->json([
            'success' => '200',
            'likeId' => $like->id
        ]);
    }

    public function destroy($id, $journey_id, $like_id) {
        $like = \App\Models\Like::where([
            ['id', $like_id],
            ['user_id', auth()->id()],
            ['journey_id', $journey_id],
        ])->first()->delete();

        return response()->json([
            'success' => '200',
        ]);
    }
}
