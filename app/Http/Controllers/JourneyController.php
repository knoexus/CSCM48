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

        $user = \App\Models\User::find($id);
        return view('journeys.create', [
            'id'=>$id
        ]);
    }

    public function store(Request $req, $id) 
    {
        $this->validate($req, [
            'title' => 'required|string|max:100', 
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'string|max:255|nullable', 
            'difficulty' => 'numeric|min:1|max:10',
            'enjoyability' => 'numeric|min:1|max:10',
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

    public function edit($id, $journey_id) 
    {
        if ($id != auth()->id()) {
            return redirect('/users/'.$id);
        }

        $journey = \App\Models\Journey::where([
            ['id', $journey_id],
            ['user_id', $id]
        ])->first();

        return view('journeys.edit', compact('journey'));
    }

    public function update(Request $req, $id, $journey_id) 
    {
        if ($id != auth()->id()) {
            return redirect('/users/'.$id);
        }

        $this->validate($req, [
            'title' => 'required|string|max:100', 
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|nullable',
            'description' => 'string|max:255|nullable', 
            'difficulty' => 'numeric|min:1|max:10',
            'enjoyability' => 'numeric|min:1|max:10',
            'would_recommend' => 'boolean'
        ]);

        $fields = [
            'title' => $req->title, 
            'difficulty' => intval($req->difficulty), 
            'enjoyability' => intval($req->enjoyability), 
            'would_recommend' => boolval($req->would_recommend), 
            'description' => $req->description, 
            'user_id' => $id
        ];

        if ($req->image) {
            $imgPath = $req->file('image')->store('uploads', 'public'); 
            $fields['image'] = $imgPath;
        }

        $journey = \App\Models\Journey::where([
            ['id', $journey_id],
            ['user_id', $id]
        ])->first()->update($fields);

        return redirect('/users/'.$id.'/journeys/'.$journey_id);
    }

    public function show($id, $journey_id) {
        $journey = \App\Models\Journey::where([
            ['id', $journey_id],
            ['user_id', $id],
        ])->firstOrFail();

        // view the journey and get like if exist
        $a_id = auth()->id();
        $like = null;

        if ($journey && $a_id) {
            $like = \App\Models\Like::where([
                ['journey_id', $journey_id],
                ['user_id', $a_id]
            ])->first();    

            if ($a_id != $id) {
                $view = \App\Models\View::create([
                    'journey_id' => $journey_id,
                    'user_id' => $a_id
                ]);
            }
        } 

        $comments = $journey->comments()->orderBy('created_at', 'desc')->take(5)->with('user')->get();

        return view('journeys.show', compact('journey', 'comments', 'like'));
    }

    public function destroy($id, $journey_id) 
    {
        $current_user = auth()->user();
        if ($current_user->isAdmin() || $current_user->id == $id) {
            $journey = \App\Models\Journey::where([
                ['id', $journey_id],
                ['user_id', $id]
            ])->firstOrFail();

            if ($journey) {
                $journey->delete();
            }
        }
        return redirect('/users/'.$id);
    }
}
