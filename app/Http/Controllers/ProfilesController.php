<?php

namespace App\Http\Controllers;

use App\User;

use Intervention\Image\Facades\Image;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProfilesController extends Controller
{
    public function index(User $user)
    {
        $follows = (auth()->user()) ? auth()->user()->following->contains($user->id) : false;
        // dd($follows);

        $postCount = Cache::remember('count.posts.'.
        $user->id, now()->seconds(30),
        function() use ($user) {
            return $user->posts->count();
        });


        $followersCount = Cache::remember('counts.followers.'.
        $user->id, now()->seconds(30),
        function () use ($user) {
            return $user->profile->followers->count();
        });



        $followingCount = Cache::remember('counts.following.'.
        $user->id, now()->seconds(30),
        function () use ($user) {
            return $user->following->count();
        });
        return view('profiles.index' , compact('user','follows','postCount', 'followersCount', 'followingCount'));
    }
    public function edit(User $user)
    {
        $this->authorize('update', $user->profile);
        return view('profiles.edit', compact('user'));
    }
    public function update(User $user)
    {
        $data = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'url' => 'url',
            'image' => '',
        ]);


        if(request('image'))
        {
            $imagePath = request('image')->store('profile', 'public');
            $image = Image::make(public_path("storage/{$imagePath}"))->fit(1000, 1000);
            $image->save();

        auth()->user()->profile->update(array_merge(
            $data ,
            ['image' => $imagePath]
        ));
        }
        else{
            auth()->user()->profile->update($data);
        }

        return redirect("/profile/{$user->id}");
    }
}
