@extends('layouts.dashboard')

@section('title', 'Edit User')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Edit User</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('userManagement.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{ $user->name }}" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email" value="{{ $user->email }}" required>
                </div>
                <div class="mb-3">
                    <label for="department_id" class="form-label">Department</label>
                    <select name="department_id" class="form-select" id="department_id" required>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}" {{ $user->pegawai && $user->pegawai->department_id == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="disk_space" class="form-label">Disk Space (MB)</label>
                    <input type="number" name="disk_space" class="form-control" id="disk_space"
                           value="{{ $user->disk_space }}" required min="0" placeholder="Enter maximum disk space in MB">
                </div>
                <div class="mb-3">
                    <label for="phone_number" class="form-label">Phone Number</label>
                    <input type="text" name="phone_number" class="form-control" id="phone_number" value="{{ $user->pegawai->phone_number ?? '' }}">
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea name="address" class="form-control" id="address">{{ $user->pegawai->address ?? '' }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="position" class="form-label">Position</label>
                    <input type="text" name="position" class="form-control" id="position" value="{{ $user->pegawai->position ?? '' }}">
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection
