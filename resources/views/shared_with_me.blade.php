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
                                            <i class="bi bi-folder-fill"></i>
                                             <a href="{{ route('showFolder', ['id' => $item->folder->id]) }}">{{ $item->folder->name }}</a>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->file)
                                            <span class="badge bg-info">File</span>
                                        @elseif ($item->folder)
                                            <span class="badge bg-warning">Folder</span>
                                        @endif
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
@endsection
