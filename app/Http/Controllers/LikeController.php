<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store($id, $journey_id) {
        $like = \App\Models\Like::create([
            'user_id' => auth()->id(),
            'journey_id' => $journey_id
        ]);

        return response()->json([
            'success' => '200',
            'likeId' => $like->id
        ]);
    }

    public function destroy($id, $journey_id, $like_id) {
        $like = \App\Models\Like::where([
            ['id', $like_id],
            ['user_id', $id],
            ['journey_id', $journey_id],
        ])->first()->delete();

        return response()->json([
            'success' => '200',
        ]);
    }
}
