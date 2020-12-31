@extends('layouts.app')

@section('scripts')
    <script>
        window.xcomments = @json($comments);
        window.xadmin = @json(auth()->user()->isAdmin());
        window.xjourney = @json($journey);
    </script>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">   
    <link rel="stylesheet" href="{{ asset('css/journey.css') }}">
@endsection

@section('content')
<div>
    @if (Auth::user()->isAdmin() && (Auth::user()->id != $journey->user->id))
    <div class="d-flex">
        <form method="POST" action="{{ route('journeys.destroy', [$journey->user->id, $journey->id]) }}">
            @method('DELETE')
            @csrf
            <button class="btn btn-info" type="submit">Delete Journey</button>
        </form>
    </div>
    @endif
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
                <a class="btn btn-outline-info" href="/users/{{ $journey->user->id }}/journeys/{{ $journey->id }}/edit" role="button">Edit</a>
                <form method="POST" action="{{ route('journeys.destroy', [$journey->user->id, $journey->id]) }}">
                    @method('DELETE')
                    @csrf
                    <button class="btn btn-info" type="submit">Delete</button>
                </form>
            @endif
        @endif
    </div>
    <div class="comments mt-5"></div> 
</div>
@endsection