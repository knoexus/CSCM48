<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show($id) 
    {
        $user = \App\Models\User::findOrFail($id);
        $journeys = $user->journeys()->orderBy('created_at', 'desc')->paginate(5);
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
            $fields['image'] = '/storage/'.$imgPath;
        }
        
        $profile = \App\Models\Profile::updateOrCreate(
            ['user_id' => $id],
            $fields
        );

        return redirect('/users/'.$id);
    }

    public function destroy($id) 
    {
        $current_user = auth()->user();
        if ($current_user->isAdmin() || $current_user->id == $id) {
            $user = \App\Models\User::findOrFail($id);
            if ($user) {
                $user->delete();
            }
        }
        return redirect('/');
    }

    public function unreadNotifications()
    {
        return auth()->user()->unreadNotifications()->orderBy('created_at', 'desc')->get()->toArray();
    }

    public function readAllNotifications()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return response()->json([
            'success' => '200'
        ]);
    }
}
