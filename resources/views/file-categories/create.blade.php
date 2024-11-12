@extends('layouts.dashboard')

@section('title', 'Create Category')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Create Department</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('file-categories.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" id="name" required>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
@endsection
