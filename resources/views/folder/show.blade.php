@extends('layouts.dashboard')
@section('title', $folder->name)

@section('content')
    <!-- Struktur HTML konten mirip dengan halaman home -->
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            @if (Auth::user()->role != 'admin')
                                <li class="breadcrumb-item"><a href="/">My Files</a></li>
                            @endif
                            @foreach ($breadcrumbs as $breadcrumb)
                                <li class="breadcrumb-item">
                                    <a
                                        href="{{ route('showFolder', ['id' => $breadcrumb->id]) }}">{{ $breadcrumb->name }}</a>
                                </li>
                            @endforeach
                        </ol>
                    </nav>
                </div>
                <div class="card-body">
                    <!-- Tombol Tambah, Share, Download, Delete -->
                    <div class="d-flex gap-2 justify-content-between">
                        @if (Auth::user()->role != 'admin')
                            <div>
                                <button class="btn btn-primary fw-bold text-white" data-bs-toggle="modal"
                                    data-bs-target="#addFolderModal">
                                    <i class="bi bi-plus"></i> Tambah
                                </button>
                            </div>
                            <div>
                                <button class="btn btn-info fw-bold text-white"><i class="bi bi-folder"></i> Share</button>
                                <button class="btn btn-success fw-bold text-white"><i class="bi bi-download"></i>
                                    Download</button>
                                <button class="btn btn-danger fw-bold text-white"><i class="bi bi-trash"></i>
                                    Delete</button>
                            </div>
                        @endif
                    </div>
                    <!-- Table Files & Folders -->
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Size</th>
                                <th>Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subfolders as $folder)
                                <tr class="folder-row-select" data-id="{{ $folder->id }}">
                                    <th>
                                        <div class="d-flex align-items-center gap-2">
                                            @if (Auth::user()->role != 'admin')
                                                <input type="checkbox" class="form-check-input item-checkbox"
                                                    data-id="{{ $folder->id }}">
                                                <a href="#" class="toggle-favorite" data-id="{{ $folder->id }}"
                                                    data-type="folder">
                                                    <i
                                                        class="bi {{ $folder->is_favorite ? 'bi-star-fill text-warning' : 'bi-star text-muted' }}"></i>
                                                </a>
                                                <a href="#"><i class="bi bi-pencil-fill text-primary rename-icon"
                                                        data-id="{{ $folder->id }}" data-type="folder"></i></a>
                                            @endif
                                        </div>
                                    </th>
                                    <td><i class="bi bi-folder-fill"></i> <a
                                            href="{{ route('showFolder', ['id' => $folder->id]) }}">{{ $folder->name }}</a>
                                    </td>
                                    <td><span class="badge bg-success">Folder</span></td>
                                    <td>-</td>
                                    <td>{{ $folder->created_at }}</td>
                                </tr>
                            @endforeach
                            @foreach ($files as $file)
                                <tr class="file-row-select" data-url="{{ asset($file->path) }}">
                                    <th>
                                        <div class="d-flex align-items-center gap-2">
                                            <input type="checkbox" class="form-check-input item-checkbox"
                                                data-id="{{ $file->id }}">
                                            <a href="#" class="toggle-favorite" data-id="{{ $file->id }}"
                                                data-type="file">
                                                <i
                                                    class="bi {{ $file->is_favorite ? 'bi-star-fill text-warning' : 'bi-star text-muted' }}"></i>
                                            </a>
                                            <a href="#"><i class="bi bi-pencil-fill text-primary rename-icon"
                                                    data-id="{{ $file->id }}" data-type="file"></i></a>
                                        </div>
                                    </th>
                                    <td><i class="bi bi-file-earmark"></i>
                                        <a href="#" class="file-row" data-name="{{ $file->name }}"
                                            data-size="{{ number_format($file->size / 1024, 2) }} KB"
                                            data-type="{{ $file->type }}"
                                            data-url="{{ asset($file->path) }}">{{ $file->name }}</a>
                                    </td>
                                    <td>{{ $file->type }}</td>
                                    <td>{{ number_format($file->size / 1024, 2) }} KB</td>
                                    <td>{{ \Carbon\Carbon::parse($file->created_at)->format('d F Y, H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Folder/File & Share -->
    @include('partials.add_folder_file_modal', ['folder_id' => $folder->id])
    @include('partials.rename_modal')
    @include('partials.show_file_modal')

    <!-- Modal untuk Share -->
    <div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="shareModalLabel">Share File/Folder</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="shareForm">
                        <div class="mb-3">
                            <label for="selectUser" class="form-label">Pilih Pengguna untuk Share</label>
                            <select id="selectUser" class="form-select" required>
                                <option value="">Pilih Pengguna</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="button" class="btn btn-primary" id="shareSubmitBtn">Share</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.toggle-favorite').on('click', function(event) {
                event.preventDefault();
                event.stopPropagation();
                const icon = $(this).find('i');
                const itemId = $(this).data('id');
                const itemType = $(this).data('type');

                $.ajax({
                    url: '{{ route('toggleFavorite') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: itemId,
                        type: itemType
                    },
                    success: function(response) {
                        if (response.success) {
                            icon.toggleClass('bi-star bi-star-fill text-muted text-warning');
                            Swal.fire({
                                title: 'Success!',
                                text: `Status favorit berhasil diperbarui. Item ini sekarang menjadi ${response.is_favorite ? 'difavoritkan' : 'tidak difavoritkan'}.`,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            Swal.fire({
                                title: 'Failed!',
                                text: 'Failed to update favorite status.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Error while updating favorite status.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });

            $('#downloadBtn').on('click', function() {
                const selectedFiles = [];
                const selectedFolders = [];

                $('.file-row-select').each(function() {
                    const checkbox = $(this).find('.item-checkbox');
                    if (checkbox.is(':checked')) {
                        const fileUrl = $(this).data('url');
                        if (fileUrl) {
                            selectedFiles.push(fileUrl);
                        }
                    }
                });

                $('.folder-row-select').each(function() {
                    const checkbox = $(this).find('.item-checkbox');
                    if (checkbox.is(':checked')) {
                        const folderId = $(this).data('id');
                        if (folderId) {
                            selectedFolders.push(folderId);
                        }
                    }
                });

                if (selectedFiles.length > 0) {
                    selectedFiles.forEach(function(fileUrl) {
                        const a = document.createElement('a');
                        a.href = fileUrl;
                        a.download = '';
                        document.body.appendChild(a);
                        a.click();
                        document.body.removeChild(a);
                    });
                }

                if (selectedFolders.length > 0) {
                    selectedFolders.forEach(function(folderId) {
                        const folderDownloadUrl = `/download-folder/${folderId}`;
                        const a = document.createElement('a');
                        a.href = folderDownloadUrl;
                        a.download = '';
                        document.body.appendChild(a);
                        a.click();
                        document.body.removeChild(a);
                    });
                }


                if (selectedFiles.length === 0 && selectedFolders.length === 0) {
                    Swal.fire({
                        title: 'No file or folder selected',
                        text: 'Please select files or folders to download.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                }
            });

            $('.btn-danger').on('click', function() {
                const selectedFileIds = [];
                const selectedFolderIds = [];

                $('.file-row-select').each(function() {
                    const checkbox = $(this).find('.item-checkbox');
                    if (checkbox.is(':checked')) {
                        selectedFileIds.push(checkbox.data('id'));
                    }
                });

                $('.folder-row-select').each(function() {
                    const checkbox = $(this).find('.item-checkbox');
                    if (checkbox.is(':checked')) {
                        selectedFolderIds.push(checkbox.data('id'));
                    }
                });


                console.log("Selected File IDs:", selectedFileIds);
                console.log("Selected Folder IDs:", selectedFolderIds);

                if (selectedFileIds.length === 0 && selectedFolderIds.length === 0) {
                    Swal.fire({
                        title: 'No file or folder selected',
                        text: 'Please select files or folders to delete.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You won\'t be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('deleteItems') }}',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                file_ids: selectedFileIds,
                                folder_ids: selectedFolderIds
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
                                    text: 'An error occurred while deleting items.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    }
                });
            });


        });

        $(document).ready(function() {
            const selectedFileIds = [];
            const selectedFolderIds = [];

            $('.btn-info').on('click', function() {
                selectedFileIds.length = 0;
                selectedFolderIds.length = 0;

                $('.file-row-select').each(function() {
                    const checkbox = $(this).find('.item-checkbox');
                    if (checkbox.is(':checked')) {
                        selectedFileIds.push(checkbox.data('id'));
                    }
                });

                $('.folder-row-select').each(function() {
                    const checkbox = $(this).find('.item-checkbox');
                    if (checkbox.is(':checked')) {
                        selectedFolderIds.push(checkbox.data('id'));
                    }
                });

                if (selectedFileIds.length === 0 && selectedFolderIds.length === 0) {
                    Swal.fire({
                        title: 'No file or folder selected',
                        text: 'Please select files or folders to share.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                $('#shareModal').modal('show');
            });

            $('#shareSubmitBtn').on('click', function() {
                const userId = $('#selectUser').val();
                const permission = $('#permission').val();

                if (!userId) {
                    Swal.fire({
                        title: 'User not selected',
                        text: 'Please select a user to share with.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                $.ajax({
                    url: '{{ route('shareItems') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        file_ids: selectedFileIds,
                        folder_ids: selectedFolderIds,
                        shared_with_id: userId,
                        permission: permission
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Shared!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                        $('#shareModal').modal('hide');
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Error!',
                            text: 'An error occurred while sharing items.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });
    </script>
@endsection
