@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
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
</div>
@endsection

