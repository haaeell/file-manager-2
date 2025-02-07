@extends('layouts.dashboard')

@section('title', 'My Profile')

@section('content')
<div class="">
    @if (Auth::user()->role == 'admin')
    <div class="card mb-4">
        <div class="card-header">
            <h5>Profile Information</h5>
        </div>
        <div class="card-body">
            @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3 text-center">
                    <label for="image" class="form-label">Change Avatar</label>
                    <div class="mb-3">
                        <img id="previewImage"
                            src="{{ $user->image ? asset('storage/' . $user->image) : asset('assets/compiled/jpg/1.jpg') }}"
                            alt="Profile Image"
                            class="rounded-circle mb-2"
                            style="width: 150px; height: 150px;border:1px solid blue;object-fit:cover">
                    </div>
                    <input type="file" name="image" class="form-control" id="image" onchange="previewFile()">
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{ $user->name }}" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email" value="{{ $user->email }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5>Update Password</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('profile.updatePassword') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="current_password" class="form-label">Current Password</label>
                    <input type="password" name="current_password" class="form-control" id="current_password" required>
                </div>
                <div class="mb-3">
                    <label for="new_password" class="form-label">New Password</label>
                    <input type="password" name="new_password" class="form-control" id="new_password" required>
                </div>
                <div class="mb-3">
                    <label for="new_password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" name="new_password_confirmation" class="form-control" id="new_password_confirmation" required>
                </div>
                <button type="submit" class="btn btn-primary">Update Password</button>
            </form>
        </div>
    </div>
</div>

<script>
    function previewFile() {
        const preview = document.getElementById('previewImage');
        const file = document.getElementById('image').files[0];
        const reader = new FileReader();

        reader.onloadend = function() {
            preview.src = reader.result;
        }

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = "{{ $user->image ? asset('storage/' . $user->image) : asset('assets/compiled/jpg/1.jpg') }}";
        }
    }
</script>
@endsection