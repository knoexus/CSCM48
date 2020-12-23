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
        <span>Posted by <a class="user-username" href="/users/{{ $journey->user->id }}">{{ $journey->user->user_name }}</a> at {{ $journey->created_at->format('d/m/Y H:i') }}</span><br>
        <span>C: {{ $journey->comments->count() }}</span>
        <span>L: x</span>
        <span>V: x|x</span>
        @if (Auth::user()->id == $journey->user->id)
            <a class="btn btn-outline-info" href="#" role="button">Edit post</a>
        @endif
    </div>
    <div class="comments mt-5">
        <h4>Comments</h4>
        <form method="POST" action="{{ route('comments.create', [$journey->user->id,  $journey->id]) }}">
            @csrf
            <div class="form-group mt-3">
                <label>New comment:</label>
                <textarea name="body" class="form-control" rows="2" placeholder="Comment"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        <form>
        <div>
            @if($journey->comments->count() == 0)
                <span>No comments</span>
            @endif
            @foreach($comments->sortByDesc('created_at') as $comment)
                <div class="col-sm-2 col-xl-2 border">
                    <span>{{ $comment->body }}</span><br>
                    <span>Created at {{ $comment->created_at->format('d/m/Y H:i') }}</span>
                    <span>Posted by <a class="user-username" href="/users/{{ $comment->user->id }}">{{ $comment->user->user_name }}</a></span>
                    @if (Auth::user()->id == $comment->user->id)
                        <a class="btn btn-outline-info" href="#" role="button">Edit comment</a>
                    @endif
                </div>
            @endforeach
        </div>
        <div class="mt-10">
            {!! $comments->render() !!}
        </div>
    </div> 
</div>
@endsection