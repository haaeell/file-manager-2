@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Folder</h1>

    <form action="{{ route('filemanager.store.folder') }}" method="POST">
        @csrf
        <input type="hidden" name="parent_id" value="{{ $parentId }}">
        <div class="form-group">
            <label for="name">Folder Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>
@endsection
