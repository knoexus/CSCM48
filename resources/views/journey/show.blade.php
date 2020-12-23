@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">   
    <link rel="stylesheet" href="{{ asset('css/journey.css') }}">
@endsection

@section('content')
<div>
    <div class="journey-journey-full mt-3 d-flex flex-column">
        <h4>{{ $journey->title }}<h4>
        <img src="/storage/{{ $journey->image }}" height="100" width="100">
        <span>Description: {{ $journey->description ?? "Not Set" }}</span><br>
        <span>Enjoyability: {{ $journey->enjoyability ?? "Not Set" }}</span><br>
        <span>Difficulty: {{ $journey->enjoyability ?? "Not Set" }}</span><br>
        <span>{{ $journey->would_recommend ? "Recommended" : "Not Recommended" }}</span><br>
        <span>Posted by <a class="user-username" href="/user/{{ $journey->user->id }}">{{ $journey->user->user_name }}</a> on {{ $journey->created_at->format('d/m/Y h:m') }}</span>
        @if (Auth::user()->id == $journey->user->id)
            <a class="btn btn-outline-info" href="#" role="button">Edit post</a>
        @endif
    </div>
    <div class="comments">
        <form method="POST">
            @csrf
            <div class="form-group mt-3">
                <label>New comment:</label>
                <textarea name="body" class="form-control" rows="2" placeholder="Comment"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        <form>
        <div>
            <span>No comments</span>
        </div>
    </div> 
</div>
@endsection