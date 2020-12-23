<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show($id) 
    {
        $user = \App\Models\User::findOrFail($id);
        $journeys = $user->journeys()->paginate(5);
        return view('users.show', compact('user', 'journeys'));
    }

    public function edit($id) 
    {
        if ($id != auth()->id()) {
            return redirect('/users/'.$id);
        }

        $profile = \App\Models\Profile::where('user_id', $id)->first();

        return view('users.edit', [
            'id'=>$id,
            'profile'=>$profile
        ]);
    }

    public function update(Request $req, $id) 
    {
        if ($id != auth()->id()) {
            return redirect('/users/'.$id);
        }

        $this->validate($req, [
            'country' => 'required', 
            'description' => 'required', 
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imgPath = $req->file('image')->store('uploads', 'public'); 

        $profile = \App\Models\Profile::updateOrCreate(
            ['user_id' => $id],
            [
                'country' => $req->country, 
                'description' => $req->description,
                'image' => $imgPath,
                'user_id' => $id
            ]
        );

        return redirect('/');
    }
}
