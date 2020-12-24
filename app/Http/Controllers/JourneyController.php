<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JourneyController extends Controller
{
    public function create(Request $req, $id) 
    {
        if ($id != auth()->id()) {
            return redirect('/users/'.$id);
        }

        if ($req->isMethod('get')) {
            $user = \App\Models\User::find($id);
            return view('journeys.create', [
                'id'=>$id
            ]);
        } 
        else {
            $this->validate($req, [
                'title' => 'required|string|max:100', 
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'description' => 'string|max:255|nullable', 
                'difficulty' => 'numeric',
                'enjoyability' => 'numeric',
                'would_recommend' => 'boolean'
            ]);
    
            $imgPath = $req->file('image')->store('uploads', 'public'); 
    
            $journey = \App\Models\Journey::create([
                    'title' => $req->title, 
                    'image' => $imgPath,
                    'difficulty' => intval($req->difficulty), 
                    'enjoyability' => intval($req->enjoyability), 
                    'would_recommend' => boolval($req->would_recommend), 
                    'description' => $req->description, 
                    'user_id' => $id
                ]
            );
    
            return redirect('/users/'.$id);
        }
    }

    public function show($id, $journey_id) {
        $journey = \App\Models\Journey::where([
            ['id', '=', $journey_id],
            ['user_id', '=', $id],
        ])->firstOrFail();

        $comments = $journey->comments()->paginate(5);

        return view('journeys.show', compact('journey', 'comments'));
    }
}
