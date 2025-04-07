@extends('layouts.dashboard')
@section('title', 'Shared By Me')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Shared By Me</div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Permission</th>
                                <th>Shared At</th>
                                <th>Shared To</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sharedItems as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <a href="#" class="toggle-favorite" data-id="{{ $item->id }}"
                                                data-type="{{ $item->file ? 'file' : 'folder' }}">
                                                <i
                                                    class="bi {{ $item->is_favorite ? 'bi-star-fill text-warning' : 'bi-star text-muted' }}"></i>
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($item->file)
                                            <i class="bi bi-file-earmark"></i><a href="#" class="file-row"
                                                data-name="{{ $item->file->name }}"
                                                data-size="{{ number_format($item->file->size / 1024, 2) }} KB"
                                                data-type="{{ $item->file->type }}"
                                                data-url="{{ asset($item->file->path) }}">{{ $item->file->name }}</a>
                                        @elseif ($item->folder)
                                            <i class="bi bi-folder-fill"></i> <a
                                                href="{{ route('showFolder', ['id' => $item->folder->id]) }}">{{ $item->folder->name }}</a>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->file)
                                            <span class="badge bg-info">File</span>
                                        @elseif ($item->folder)
                                            <span class="badge bg-warning">Folder</span>
                                        @endif
                                    </td>
                                    <td>
                                        <select class="form-select form-select-sm update-permission"
                                            data-id="{{ $item->id }}">
                                            <option value="view" {{ $item->permission === 'view' ? 'selected' : '' }}>
                                                View Only</option>
                                            <option value="delete" {{ $item->permission === 'delete' ? 'selected' : '' }}>
                                                Can Delete</option>
                                            <option value="full" {{ $item->permission === 'full' ? 'selected' : '' }}>
                                                Full Access</option>
                                        </select>
                                    </td>

                                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d F Y, H:i') }}</td>
                                    <td>{{ $item->sharedWith->name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('partials.show_file_modal')


<script>
    document.querySelectorAll('.update-permission').forEach(select => {
        select.addEventListener('change', function () {
            const id = this.dataset.id;
            const newPermission = this.value;

            console.log(`Updating permission for item ID ${id} to ${newPermission}`);

            fetch(`/shared-items/${id}/permission`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ permission: newPermission })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    swal.fire({
                        icon: 'success',
                        title: 'Permission Updated',
                        text: `Permission updated to ${newPermission} successfully!`,
                        showConfirmButton: true,
                        timer: 1500
                    });
                } else {
                    swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to update permission.',
                        showConfirmButton: true,
                        timer: 1500
                    });
                }
            })
            .catch(err => {
                console.error(err);
                swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while updating permission.',
                    showConfirmButton: true,
                    timer: 1500
                });
            });
        });
    });
</script>
@endsection

