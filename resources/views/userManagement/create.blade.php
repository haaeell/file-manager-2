@extends('layouts.dashboard')

@section('title', 'Create User')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Create User</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('userManagement.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" id="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password" required>
                </div>
                <div class="mb-3">
                    <label for="department_id" class="form-label">Department</label>
                    <select name="department_id" class="form-select" id="department_id" required>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="no_pegawai" class="form-label">No Pegawai</label>
                    <input type="no_pegawai" name="no_pegawai" class="form-control" id="no_pegawai" required>
                </div>
                <div class="mb-3">
                    <label for="disk_space" class="form-label">Disk Space (MB)</label>
                    <input type="number" name="disk_space" class="form-control" id="disk_space" required min="0" placeholder="Enter maximum disk space in MB">
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
@endsection
