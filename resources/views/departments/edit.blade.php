@extends('layouts.dashboard')

@section('title', 'Edit Department')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Edit Department</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('departments.update', $department) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" value="{{ $department->name }}" class="form-control" id="name" required>
            </div>
            <!-- <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" class="form-control" id="description">
                        {{ $department->description }}
                    </textarea>
                </div> -->
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>
@endsection