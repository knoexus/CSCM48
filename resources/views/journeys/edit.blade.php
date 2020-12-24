@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/bootstrap-forms.css') }}">
@endsection

@section('content')
<div class="container mt-3">
    <h3>Update your journey</h3>
    <form method="POST" enctype="multipart/form-data" action="{{ route('journeys.update', [$journey->user->id,  $journey->id]) }}">
        @csrf
        @method('PUT')
        <div class="form-group mt-3">
            <label for="title">Title</label>
            <input type="text" class="form-control" name="title" placeholder="Title" value="{{ (old('title') || old('title') === '') ? old('title') : ($journey ? $journey->title : '')  }}">
            @if ($errors->has('title'))
                <span class="text-danger">{{ $errors->first('title') }}</span>
            @endif
        </div>
        <div class="form-group mt-3">
            <label for="image">Cover Photo</label>
            @if ($journey)
                @if ($journey->image)
                    <div class="mb-2">
                        <img src="{{ '/storage/'.$journey->image }}" height="50" width="50"/>
                    </div>
                @endif        
            @endif
            <input type="file" class="form-control-file" name="image" placeholder="Image" value="{{ old('image') ?? '' }}">
            @if ($errors->has('image'))
                <span class="text-danger">{{ $errors->first('image') }}</span>
            @endif
        </div>
        <div class="form-group mt-3">
            <label for="enjoyability">Enjoyability</label></br>
            <input name="enjoyability" type="range" min="1" max="10" oninput="this.nextElementSibling.value = this.value" value="{{ old('enjoyability') ?? ($journey ? $journey->enjoyability : '5')  }}">
            <output>{{ old('enjoyability') ?? ($journey ? $journey->enjoyability : '5') }}</output>
            @if ($errors->has('enjoyability'))
                <span class="text-danger">{{ $errors->first('enjoyability') }}</span>
            @endif
        </div>
        <div class="form-group mt-3">
            <label for="difficulty">Difficulty</label></br>
            <input name="difficulty" type="range" min="1" max="10" oninput="this.nextElementSibling.value = this.value" value="{{ old('difficulty') ?? ($journey ? $journey->difficulty : '5')  }}">
            <output>{{ old('difficulty') ?? ($journey ? $journey->difficulty : '5')  }}</output>
            @if ($errors->has('difficulty'))
                <span class="text-danger">{{ $errors->first('difficulty') }}</span>
            @endif
        </div>
        <div class="form-group mt-3">
            <label class="form-check-label">Would Recommend</label></br>
            <input name="would_recommend" type="checkbox" class="form-check-input" value="{{ old('would_recommend') ?? true }}" checked>
            @if ($errors->has('would_recommend'))
                <span class="text-danger">{{ $errors->first('would_recommend') }}</span>
            @endif
        </div>
        <div class="form-group mt-3">
            <label for="">Description</label>
            <textarea name="description" class="form-control" rows="3" placeholder="Description">{{ (old('description') || old('description') === '') ? old('description') : ($journey ? $journey->description : '')  }}</textarea>
            @if ($errors->has('description'))
                <span class="text-danger">{{ $errors->first('description') }}</span>
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection