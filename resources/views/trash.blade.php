@extends('layouts.dashboard')
@section('title', 'Trash')

@section('content')
    <div class="card shadow border-0 my-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="card-header">
                        <h5>Deleted Files</h5>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Deleted At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($deletedFiles && count($deletedFiles) > 0)
                                @foreach ($deletedFiles as $file)
                                    <tr>
                                        <td>{{ $file->name }}</td>
                                        <td>File</td>
                                        <td>{{ $file->deleted_at }}</td>
                                        <td>
                                            <button class="btn btn-success btn-restore" data-id="{{ $file->id }}"
                                                data-type="file">
                                                Restore
                                            </button>
                                            <button class="btn btn-danger btn-delete-permanent" data-id="{{ $file->id }}"
                                                data-type="file">
                                                Delete Permanently
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="text-center">No deleted files found.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <div class="card-header">
                        <h5>Deleted Folders</h5>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Deleted At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($deletedFolders && count($deletedFolders) > 0)
                                @foreach ($deletedFolders as $folder)
                                    <tr>
                                        <td>{{ $folder->name }}</td>
                                        <td>Folder</td>
                                        <td>{{ $folder->deleted_at }}</td>
                                        <td>
                                            <button class="btn btn-success btn-restore" data-id="{{ $folder->id }}"
                                                data-type="folder">
                                                Restore
                                            </button>
                                            <button class="btn btn-danger btn-delete-permanent"
                                                data-id="{{ $folder->id }}" data-type="folder">
                                                Delete Permanently
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="text-center">No deleted folders found.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Restore item
            $('.btn-restore').on('click', function() {
                const id = $(this).data('id');
                const type = $(this).data('type');

                $.ajax({
                    url: '{{ route('trash.restore') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id,
                        type: type
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Restored!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => location.reload());
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Error!',
                            text: 'An error occurred while restoring the item.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });

            $('.btn-delete-permanent').on('click', function() {
                const id = $(this).data('id');
                const type = $(this).data('type');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This item will be permanently deleted!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('trash.delete') }}',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id: id,
                                type: type
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: response.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(() => location.reload());
                            },
                            error: function() {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'An error occurred while deleting the item permanently.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>

@endsection
