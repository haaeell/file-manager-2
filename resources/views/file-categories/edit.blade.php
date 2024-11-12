@extends('layouts.dashboard')

@section('title', 'Edit category')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Edit category</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('file-categories.update', $category) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" value="{{ $category->name }}" class="form-control" id="name" required>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
@endsection
