@extends('layouts.dashboard')
@section('title', 'Trash')

@section('content')
<div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Deleted Files</h5>
                </div>
                <div class="card-body">
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
                            <td> <i class="bi bi-file-earmark"></i>
                                <a href="#" class="file-row"
                                    data-name="{{ $file->name }}"
                                    data-size="{{ number_format($file->size / 1024, 2) }} KB"
                                    data-type="{{ $file->type }}"
                                    data-url="{{ asset($file->path) }}">{{ $file->name }}</a>
                            </td>
                            <td>{{ $file->type }}</td>
                            <td>{{ \Carbon\Carbon::parse($file->deleted_at)->format('d F Y, H:i') }}</td>
                            <td>
                                <button class="btn btn-success btn-sm btn-restore" data-id="{{ $file->id }}"
                                    data-type="file">
                                    Restore
                                </button>
                                <button class="btn btn-danger btn-sm rounded-2 btn-delete-permanent"
                                    data-id="{{ $file->id }}" data-type="file">
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
        </div>

            <div class="col-md-12">
                <div class="card">
                <div class="card-header">
                    <h5>Deleted Folders</h5>
                </div>
                <div class="card-body">
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
                                <button class="btn btn-success btn-sm btn-restore" data-id="{{ $folder->id }}"
                                    data-type="folder">
                                    Restore
                                </button>
                                <button class="btn btn-danger btn-sm btn-delete-permanent"
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

@include('partials.show_file_modal')
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
                        url: '{{ route( 'trash.delete') }}',
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