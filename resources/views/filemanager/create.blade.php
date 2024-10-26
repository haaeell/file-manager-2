@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Upload File</h1>

    <form action="{{ route('filemanager.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="folder_id" value="{{ $parentId }}">
        <div class="form-group">
            <label for="name">File Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="file">Choose File</label>
            <input type="file" name="file" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>
</div>
@endsection
