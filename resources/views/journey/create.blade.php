@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/bootstrap-forms.css') }}">
@endsection

@section('content')
<div class="container mt-3">
    <h3>Create new journey</h3>
    <form method="POST" enctype="multipart/form-data" action="{{ route('journey.create', $id) }}">
        @csrf
        <div class="form-group mt-3">
            <label for="country">Title</label>
            <input type="text" class="form-control" name="title" placeholder="Title">
        </div>
        <div class="form-group mt-3">
            <label for="image">Cover Photo</label>
            <input type="file" class="form-control-file" name="image" placeholder="Image">
        </div>
        <div class="form-group mt-3">
            <label for="difficulty">Difficulty</label></br>
            <input name="difficulty" type="range" min="0" max="10" oninput="this.nextElementSibling.value = this.value" value="5">
            <output>5</output>
        </div>
        <div class="form-group mt-3">
            <label for="enjoyability">Enjoyability</label></br>
            <input name="enjoyability" type="range" min="0" max="10" oninput="this.nextElementSibling.value = this.value" value="5">
            <output>5</output>
        </div>
        <div class="form-group mt-3">
            <label class="form-check-label">Would Recommend</label></br>
            <input name="would_recommend" type="checkbox" class="form-check-input" value="true" checked>
        </div>
        <div class="form-group mt-3">
            <label for="">Description</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection