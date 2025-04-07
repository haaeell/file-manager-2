@extends('layouts.dashboard')
@section('title', 'Shared With Me')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Shared With Me</div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Permission</th>
                                <th>Shared At</th>
                                <th>Shared By</th>
                                <th>Aksi</th>
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
                                            <i class="bi bi-folder-fill"></i>
                                            <a
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
                                    <td>{{ $item->permission }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d F Y, H:i') }}</td>
                                    @if ($item->file)
                                        <td>{{ $item->file->user->name }}</td>
                                    @elseif ($item->folder)
                                        <td>{{ $item->folder->user->name }}</td>
                                    @endif
                                    <td>
                                        @if ($item->file)
                                            {{-- Download jika bisa --}}
                                            @if ($item->permission === 'view' || $item->permission === 'full')
                                                <a href="{{ asset($item->file->path) }}"
                                                    class="btn btn-sm btn-primary mb-1" download>
                                                    <i class="bi bi-download"></i> Download
                                                </a>
                                            @endif

                                            {{-- Delete file jika punya hak --}}
                                            @if ($item->permission === 'delete' || $item->permission === 'full')
                                                <form action="{{ route('fileShare.delete', $item->file->id) }}" method="POST"
                                                    style="display:inline-block;"
                                                    onsubmit="return confirm('Yakin mau hapus file ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="bi bi-trash"></i> Hapus File
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            <span>-</span>
                                        @endif
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('partials.show_file_modal')
@endsection
