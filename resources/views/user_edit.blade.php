@extends('layouts.app')

@section('content')
<div class="container">
    <form method="POST" enctype="multipart/form-data" action="{{ route('user.update', $id) }}">
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
            <input type="file" class="form-control-file" name="image" placeholder="Image" value="{{ $profile ? $profile->image : '' }}">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection