<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JourneyController extends Controller
{
    public function create(Request $req, $id) 
    {
        if ($id != auth()->id()) {
            return redirect('/user/'.$id);
        }

        if ($req->isMethod('get')) {
            $user = \App\Models\User::find($id);
            return view('journey.create', [
                'id'=>$id
            ]);
        } 
        else {
            // $this->validate($req, [
            //     'country' => 'required', 
            //     'description' => 'required', 
            //     'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // ]);
    
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
    
            return redirect('/user/'.$id);
        }
    }
}
