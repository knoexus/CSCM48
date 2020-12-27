@extends('layouts.app')

@section('scripts')
    <script>
        var xcomments = @json($comments);
        var xjourney = @json($journey);
    </script>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">   
    <link rel="stylesheet" href="{{ asset('css/journey.css') }}">
@endsection

@section('content')
<div>
    <div class="journey-journey-full mt-3 d-flex flex-column">
        <h4>{{ $journey->title }}</h4>
        <img src="/storage/{{ $journey->image }}" height="100" width="100">
        <span>Description: {{ $journey->description ?? "Not Set" }}</span><br>
        <span>Enjoyability: {{ $journey->enjoyability ?? "Not Set" }}</span><br>
        <span>Difficulty: {{ $journey->difficulty ?? "Not Set" }}</span><br>
        <span>{{ $journey->would_recommend ? "Recommended" : "Not Recommended" }}</span><br>
        <span>Posted by <a class="user-username" href="/users/{{ $journey->user->id }}">{{ $journey->user->user_name }}</a> at {{ $journey->created_at->format('d/m/Y H:i') }}</span><br>
        <div class="like" data-uId="{{ $journey->user->id }}" data-journeyId="{{ $journey->id }}" data-likeId="{{ $like ? $like->id : 'null' }}" data-likeCount="{{ $journey->likes->count() }}"></div>
        <span>V: {{ $journey->views->count() }} | {{ $journey->views->unique('user_id')->count() }}</span>
        @if (Auth::user())
            @if (Auth::user()->id == $journey->user->id)
                <a class="btn btn-outline-info" href="/users/{{ $journey->user->id }}/journeys/{{ $journey->id }}/edit" role="button">Edit post</a>
            @endif
        @endif
    </div>
    <div class="comments mt-5"></div> 
</div>
@endsection