@extends('layouts.app')

@section('scripts')
    <script>
        window.xcomments = @json($comments);
        window.xjourney = @json($journey);
    </script>
    @if (Auth::user())
    <script>
        window.xadmin = @json(Auth::user()->isAdmin());
    </script>
    @else
    <script>
        window.xadmin = null;
    </script>
    @endif
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">   
@endsection

@section('content')
<div class="container p-1 mt-2">
    @if (Auth::user())
        @if (Auth::user()->isAdmin() && (Auth::user()->id != $journey->user->id))
        <div class="d-flex">
            <div class="admin-info">
                <h4>Admin panel</h4>
                <span>Feel free to suspend the journey if its nature is ambiguous.</span>
                <form method="POST" action="{{ route('journeys.destroy', [$journey->user->id, $journey->id]) }}">
                    @method('DELETE')
                    @csrf
                    <button class="btn btn-outline-dark mt-2" type="submit">Delete Journey</button>
                </form>
            </div>
        </div>
        @endif
    @endif
    <div class="journey-full mt-3 d-flex flex-column">
        <h4 class="journey-full-title">{{ $journey->title }}</h4>
        @if (Auth::user())
            <div class="journey-full-alter-buttons">
                @if (Auth::user()->id == $journey->user->id)
                    <a class="btn btn-outline-info journey-full-alter-button" href="/users/{{ $journey->user->id }}/journeys/{{ $journey->id }}/edit" role="button">Edit</a>
                    <form method="POST" action="{{ route('journeys.destroy', [$journey->user->id, $journey->id]) }}">
                        @method('DELETE')
                        @csrf
                        <button class="btn btn-outline-danger journey-full-alter-button" type="submit">Delete</button>
                    </form>
                @endif
            </div>
        @endif
        <div class="journey-full-body">
            <img class="journey-full-image" src="/storage/{{ $journey->image }}">
            <div class="journey-full-jinfo">
                <div>
                    <span class="journey-full-jinfo-title">Description:</span><br>
                    <p class="journey-full-jinfo-description">{{ $journey->description ?? "Not Set" }}</p>
                </div>
                <div class="mt-3">
                    <div>
                        <span class="journey-full-jinfo-title">Enjoyability:</span><br>
                        <span>{{ ($journey->enjoyability).' / 10' ?? "Not Set" }}</span>
                    </div>
                    <div>
                        <span class="journey-full-jinfo-title">Difficulty:</span><br>
                        <span>{{ ($journey->difficulty).' / 10' ?? "Not Set" }}</span>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="journey-full-jinfo-recommended">{{ $journey->would_recommend ? "Recommended" : "Not Recommended" }}</span><br>
                </div>
            </div>
        </div>
        <div class="journey-full-uinfo mt-2">
            <div class="like" data-uId="{{ $journey->user->id }}" data-journeyId="{{ $journey->id }}" data-likeId="{{ $like ? $like->id : 'null' }}" data-likeCount="{{ $journey->likes->count() }}"></div>
            <div class="view">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="24" height="24"><path d="M320,256a64,64,0,1,1-64-64A64.07,64.07,0,0,1,320,256Zm189.81,9.42C460.86,364.89,363.6,426.67,256,426.67S51.14,364.89,2.19,265.42a21.33,21.33,0,0,1,0-18.83C51.14,147.11,148.4,85.33,256,85.33s204.86,61.78,253.81,161.25A21.33,21.33,0,0,1,509.81,265.42ZM362.67,256A106.67,106.67,0,1,0,256,362.67,106.79,106.79,0,0,0,362.67,256Z"/></svg>
                <span>{{ $journey->views->count() }} | {{ $journey->views->unique('user_id')->count() }}</span>
            </div>
            <div class="posted">
                <span>Posted by <a class="user-username" href="/users/{{ $journey->user->id }}">{{ $journey->user->user_name }}</a> at {{ $journey->created_at->format('d/m/Y H:i') }}</span>
            </div>
        </div>
    </div>
    <div class="comments mt-5"></div> 
</div>
@endsection