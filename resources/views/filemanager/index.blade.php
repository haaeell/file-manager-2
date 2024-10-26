@extends('layouts.app')

@section('content')
<div class="container">
    <h1>File Manager</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('filemanager.create', ['folder_id' => $parentId]) }}" class="btn btn-primary">Upload File</a>
    <a href="{{ route('filemanager.create.folder', ['parent_id' => $parentId]) }}" class="btn btn-secondary">Create Folder</a>

    <h2>Files</h2>
    <ul class="list-group">
        @foreach ($files as $file)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ $file->name }}
                <a href="{{ asset($file->path) }}" class="btn btn-link" target="_blank">Download</a>
            </li>
        @endforeach
    </ul>

    <h2>Folders</h2>
    <ul class="list-group">
        @foreach ($folders as $folder)
            <li class="list-group-item">
                <a href="{{ route('filemanager.index', $folder->id) }}">{{ $folder->name }}</a>
            </li>
        @endforeach
    </ul>
</div>
@endsection
