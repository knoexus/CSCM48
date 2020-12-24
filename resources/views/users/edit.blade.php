@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <form method="POST" enctype="multipart/form-data" action="{{ route('users.update', $id) }}">
        @csrf
        <div class="form-group">
            <label for="country">Country</label>
            <input type="text" class="form-control" name="country" placeholder="Country" value="{{ (old('country') || old('country') === '') ? old('country') : ($profile ? $profile->country: '') }}">
            @if ($errors->has('country'))
                <span class="text-danger">{{ $errors->first('country') }}</span>
            @endif
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" class="form-control" name="description" placeholder="Description" value="{{ (old('description') || old('description') === '') ? old('description') : ($profile ? $profile->description : '') }}">
            @if ($errors->has('description'))
                <span class="text-danger">{{ $errors->first('description') }}</span>
            @endif
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            @if ($profile)
                @if ($profile->image)
                    <div class="mb-2">
                        <img src="{{ '/storage/'.$profile->image }}" height="50" width="50"/>
                    </div>
                @endif        
            @endif
            <input type="file" class="form-control-file" name="image" placeholder="Image">
            @if ($errors->has('image'))
                <span class="text-danger">{{ $errors->first('image') }}</span>
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection