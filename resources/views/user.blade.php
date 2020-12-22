@extends('layouts.app')

@section('content')
<h3>{{ $user->first_name }} {{ $user->last_name }}</h3>
<img src="/storage/{{ $user->profile->image }}" alt="profile Pic" height="200" width="200"/>
<a class="btn btn-outline-secondary" href="/user/{{ Auth::user()->id }}/journey/create" role="button">Share new journey</a>
@endsection

