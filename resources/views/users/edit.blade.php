@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <form method="POST" enctype="multipart/form-data" action="{{ route('users.update', $id) }}">
        @csrf
        <div class="form-group">
            <label for="country">Country</label>
            <input type="text" class="form-control" name="country" placeholder="Country" value="{{ $profile ? $profile->country: '' }}">
            <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" class="form-control" name="description" placeholder="Description" value="{{ $profile ? $profile->description : '' }}">
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <div class="mb-2">
                <img src="{{ $profile ? '/storage/'.$profile->image : '' }}" height="50" width="50"/>
            </div>
            <input type="file" class="form-control-file" name="image" placeholder="Image">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection