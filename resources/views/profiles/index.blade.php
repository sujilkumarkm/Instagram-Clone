@extends('layouts.app')

@section('content')
<div class="container">
   <div class="row">
       <div class="col-3 p-5">
        <img src="{{ $user->profile->profileImage() }}" class="rounded-circle w-100">
       </div>
       <div class="col-9">
            <div class="d-flex justify-content-between align-items-baseline">
                <div class="d-flex align-items-sm-center">
                    <h1 class="pr-3">{{ $user->username }}</h1>
                  <follow-button user-id="{{ $user->id  }}" follows="{{ $follows }}"></follow-button>
                </div>


            @can('update', $user->profile)
                <a href="/p/create">Add new post</a>
            @endcan

            </div>
            @can('update', $user->profile)
                <a href="/profile/{{ $user->id }}/edit">Edit Profile</a>
            @endcan
            <div class="d-flex">
                <div class="pr-5"><strong>{{ $postCount }}</strong> Posts</div>
                <div  class="pr-5"><strong>{{ $followersCount }}</strong> Followers</div>
                <div  class="pr-5"><strong>{{ $followingCount }}</strong> Following</div>
            </div>
            <div class="pt-4 font-weight-bold">{{ $user->profile->title }}</div>
            <div>{{ $user->profile->description }}</div>
            <div class="font-weight-blod"><a href="">{{ $user->profile->url ?? 'not available' }}</a></div>
        </div>
   </div>


   <div class="row pt-4">
        @foreach ($user->posts as $post)
        <div class="col-4">
           <a href="/p/{{ $post->id }}"> <img src="/storage/{{ $post->image }}" class="w-100 pb-4"></a>
        </div>
        @endforeach
    </div>
@endsection
