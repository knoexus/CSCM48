@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
    <link rel="stylesheet" href="{{ asset('css/journey.css') }}">
@endsection

@section('content')
<div class="container mt-3">
    <div class="user-main_info">
        <div class="d-flex">
            <div>
                @if ($user->profile)
                    @if ($user->profile->image)
                        <img class="user-picture" src="/storage/{{ $user->profile->image }}" alt="profile Pic" height="200" width="200"/>
                    @endif
                @endif
            </div>
            <div class="ml-4 d-flex flex-column">
                <div class="mt-4">
                    <h3>{{ $user->first_name }} {{ $user->last_name }}</h3>
                    <h4 class="user-username">{{ $user->user_name }}</h4>
                </div>
            </div>
            <div class="ml-4">
                @if (Auth::user())
                    @if (Auth::user()->id == $user->id)
                        <a class="btn btn-outline-info" href="/users/{{ Auth::user()->id }}/edit" role="button">Edit profile</a>
                    @endif
                @endif
            </div>
        </div>
    </div>
    <div class="journeys">
        @if (Auth::user())
            @if (Auth::user()->id == $user->id)
                <a class="btn btn-outline-secondary mt-4" href="/users/{{ Auth::user()->id }}/journeys/create" role="button">Share new journey</a>
            @endif
        @endif
        <div>
            @foreach($journeys->sortByDesc('created_at') as $journey)
                <a class="journey-referrer" href="/users/{{ $user->id }}/journeys/{{ $journey->id }}">
                    <div class="journey mt-4">
                        <!-- <a href="/p/{{ $journey->id }}"> -->
                        <h4>{{ $journey->title }}<h4>
                        <img src="/storage/{{ $journey->image }}" height="100" width="100">
                        <span>Enjoyability: {{ $journey->enjoyability ?? "Not Set" }}</span>
                        <span>Difficulty: {{ $journey->difficulty ?? "Not Set" }}</span>
                        <span>{{ $journey->would_recommend ? "Recommended" : "Not Recommended" }}</span><br>
                        <span>Posted at {{ $journey->created_at->format('d/m/Y H:i') }}</span><br>
                        <span>Posted by <a class="user-username" href="/users/{{ $journey->user->id }}">{{ $journey->user->user_name }}</a></span><br>
                        <span>C: {{ $journey->comments->count() }}</span>
                        <span>L: x</span>
                        <span>V: x|x</span>
                    </div>
                </a>
            @endforeach
        </div>
        <div class="mt-10">
            {!! $journeys->render() !!}
        </div>
    </div>
</div>
@endsection

