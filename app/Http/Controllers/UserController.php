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
            'country' => 'string|max:100|nullable', 
            'description' => 'string|max:255|nullable', 
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $fields = [
            'country' => $req->country, 
            'description' => $req->description,
            'user_id' => $id
        ];

        if ($req->image) {
            $imgPath = $req->file('image')->store('uploads', 'public'); 
            $fields['image'] = $imgPath;
        }
        
        $profile = \App\Models\Profile::updateOrCreate(
            ['user_id' => $id],
            $fields
        );

        return redirect('/');
    }

    public function notifications()
    {
        return auth()->user()->notifications()->get()->toArray();
    }
}
