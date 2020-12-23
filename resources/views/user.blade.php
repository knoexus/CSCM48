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
                <img class="user-picture" src="/storage/{{ $user->profile->image }}" alt="profile Pic" height="200" width="200"/>
            </div>
            <div class="ml-4 d-flex flex-column">
                <div class="mt-4">
                    <h3>{{ $user->first_name }} {{ $user->last_name }}</h3>
                    <h4 class="user-username">{{ $user->user_name }}</h4>
                </div>
            </div>
            <div class="ml-4">
                @if (Auth::user()->id == $user->id)
                    <a class="btn btn-outline-info" href="/user/{{ Auth::user()->id }}/edit" role="button">Edit profile</a>
                @endif
            </div>
        </div>
    </div>
    <div class="posts mt-4">
        <a class="btn btn-outline-secondary" href="/user/{{ Auth::user()->id }}/journey/create" role="button">Share new journey</a>
    </div>
    <div class="journeys">
        <div>
            @foreach($journeys as $journey)
                <div class="journey mt-4 border">
                    <!-- <a href="/p/{{ $journey->id }}"> -->
                    <h4>{{ $journey->title }}<h4>
                    <img src="/storage/{{ $journey->image }}" height="100" width="100">
                    <span>Enjoyability: {{ $journey->enjoyability ?? "Not Set" }}</span>
                    <span>Difficulty: {{ $journey->enjoyability ?? "Not Set" }}</span>
                    <span>{{ $journey->would_recommend ? "Recommended" : "Not Recommended" }}</span>
                </div>
            @endforeach
        </div>
        <div class="mt-10">
            {!! $journeys->render() !!}
        </div>
    </div>
</div>
@endsection

