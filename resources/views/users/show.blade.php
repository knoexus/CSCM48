@extends('layouts.app')

@section('content')
<div class="container mt-3">
    @if (Auth::user())
        @if (Auth::user()->isAdmin() && (Auth::user()->id != $user->id))
        <div class="d-flex mb-4">
            <div class="admin-info">
                <h4>Admin panel</h4>
                <span>Feel free to suspend the users if their actions are ambiguous.</span>
                <form method="POST" action="{{ route('users.destroy', $user->id) }}">
                    @method('DELETE')
                    @csrf
                    <button class="btn btn-outline-dark mt-2" type="submit">Delete Profile</button>
                </form>
            </div>
        </div>
        @endif
    @endif
    <div class="user-main_info">
        <div class="user-main_info-juice">
            <div class="user-main_info-juice-primary">
                <div class="user-picture-container">
                    @if ($user->profile)
                        @if ($user->profile->image)
                            <img class="user-picture" src="{{ $user->profile->image }}" alt="Profile picture" height="200" width="200"/>
                        @else
                            <img class="user-picture" src="/images/no-user-image.gif" alt="profile Pic" height="200" width="200"/>
                        @endif
                    @else
                        <img class="user-picture" src="/images/no-user-image.gif" alt="profile Pic" height="200" width="200"/>
                    @endif
                </div>
                <div class="user-names">
                    <span class="user-name">{{ $user->first_name }} {{ $user->last_name }}</span><br>
                    <span class="user-username">{{ $user->user_name }}</span>
                </div>
            </div>
            <div class="user-main_info-juice-secondary">
                @if ( $user->profile )
                <div>
                    <div>
                        <h4>Country: </h4>
                        <span>{{ $user->profile->country ?? "Unknown" }}</span>
                    </div>
                    <div class="mt-2">
                        <h4>Description: </h4>
                        <span>{{ $user->profile->description ?? "Not set" }}</span>
                    </div>
                </div>
                @endif
                @if (Auth::user())
                    @if (Auth::user()->id == $user->id)
                        @if (!Auth::user()->isAdmin())
                            <a class="btn btn-outline-info" href="/users/{{ Auth::user()->id }}/edit" role="button">Edit profile</a>
                        @endif
                    @endif
                @endif
            </div>
        </div>
    </div>
    @if (Auth::user())
        @if (!(($user->id == Auth::user()->id) && Auth::user()->isAdmin()))
        <div class="journeys">
            <h4 class="mt-3">Journeys</h4>
                @if (Auth::user()->id == $user->id)
                <div class="mt-4">
                    <a class="btn btn-outline-secondary" href="/users/{{ Auth::user()->id }}/journeys/create" role="button">Share new journey</a>
                </div>
                @endif
            <div>
                @foreach($journeys->sortByDesc('created_at') as $journey)
                <div class="journey mt-4" onclick="window.location.href='/users/{{ $user->id }}/journeys/{{ $journey->id }}';">
                    <div class="journey-body">
                        <div class="journey-image">
                            <img src="{{ $journey->image }}">
                        </div>
                        <div class="journey-info">
                            <h4 class="journey-title">{{ $journey->title }}</h4>
                            <p class="journey-info-description">{{ $journey->description }}</p>
                            <div class="journey-info-subinfo">
                                <span class="journey-info-subtitle">Enjoyability: {{ ($journey->enjoyability).' / 10' ?? "Not Set" }}</span>
                                <span class="journey-info-subtitle">Difficulty: {{ ($journey->difficulty).' / 10' ?? "Not Set" }}</span>
                                <span class="journey-info-recommended">{{ $journey->would_recommend ? "Recommended" : "Not Recommended" }}</span>
                            </div>
                            <div class="journey-info-meta">
                                <div class="like-inactive">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -28 512.00002 512" width="24" height="24"><path d="m471.382812 44.578125c-26.503906-28.746094-62.871093-44.578125-102.410156-44.578125-29.554687 0-56.621094 9.34375-80.449218 27.769531-12.023438 9.300781-22.917969 20.679688-32.523438 33.960938-9.601562-13.277344-20.5-24.660157-32.527344-33.960938-23.824218-18.425781-50.890625-27.769531-80.445312-27.769531-39.539063 0-75.910156 15.832031-102.414063 44.578125-26.1875 28.410156-40.613281 67.222656-40.613281 109.292969 0 43.300781 16.136719 82.9375 50.78125 124.742187 30.992188 37.394531 75.535156 75.355469 127.117188 119.3125 17.613281 15.011719 37.578124 32.027344 58.308593 50.152344 5.476563 4.796875 12.503907 7.4375 19.792969 7.4375 7.285156 0 14.316406-2.640625 19.785156-7.429687 20.730469-18.128907 40.707032-35.152344 58.328125-50.171876 51.574219-43.949218 96.117188-81.90625 127.109375-119.304687 34.644532-41.800781 50.777344-81.4375 50.777344-124.742187 0-42.066407-14.425781-80.878907-40.617188-109.289063zm0 0"/></svg>
                                    <span>{{ $journey->likes->count() }}</span>
                                </div>
                                <div class="view">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="24" height="24"><path d="M320,256a64,64,0,1,1-64-64A64.07,64.07,0,0,1,320,256Zm189.81,9.42C460.86,364.89,363.6,426.67,256,426.67S51.14,364.89,2.19,265.42a21.33,21.33,0,0,1,0-18.83C51.14,147.11,148.4,85.33,256,85.33s204.86,61.78,253.81,161.25A21.33,21.33,0,0,1,509.81,265.42ZM362.67,256A106.67,106.67,0,1,0,256,362.67,106.79,106.79,0,0,0,362.67,256Z"/></svg>
                                    <span>{{ $journey->views->count() }} | {{ $journey->views->unique('user_id')->count() }}</span>
                                </div>
                                <div class="comment-inactive">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="-21 -47 682.66669 682" width="682pt"><path d="m552.011719-1.332031h-464.023438c-48.515625 0-87.988281 39.472656-87.988281 87.988281v283.972656c0 48.421875 39.300781 87.824219 87.675781 87.988282v128.871093l185.183594-128.859375h279.152344c48.515625 0 87.988281-39.472656 87.988281-88v-283.972656c0-48.515625-39.472656-87.988281-87.988281-87.988281zm-83.308594 330.011719h-297.40625v-37.5h297.40625zm0-80h-297.40625v-37.5h297.40625zm0-80h-297.40625v-37.5h297.40625zm0 0"/></svg>
                                    <span>{{ $journey->comments->count() }}</span>
                                </div>
                                <div class="posted journey-posted">
                                    <span>Posted by <a class="user-username" href="/users/{{ $journey->user->id }}">{{ $journey->user->user_name }}</a> at {{ $journey->created_at->format('d/m/Y H:i') }}</span>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-10">
                {!! $journeys->render() !!}
            </div>
        </div>
        @endif
    @endif
</div>
@endsection

