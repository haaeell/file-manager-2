@extends('layouts.dashboard')

@section('title', 'CATEGORIES')

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('file-categories.create') }}" class="btn btn-primary">Add Category</a>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>
                                <a href="{{ route('file-categories.edit', $item) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('file-categories.destroy', $item) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
