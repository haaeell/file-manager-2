@extends('layouts.dashboard')
@section('title', 'Favorites')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">File Favorites</div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Shared At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($fileFavorites as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <a href="#" class="toggle-favorite" data-id="{{ $item->id }}">
                                                <i
                                                    class="bi {{ $item->is_favorite ? 'bi-star-fill text-warning' : 'bi-star text-muted' }}"></i>
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <i class="bi bi-file-earmark"></i>
                                        <a href="#" class="file-row" data-name="{{ $item->name }}"
                                            data-size="{{ number_format($item->size / 1024, 2) }} KB"
                                            data-type="{{ $item->type }}"
                                            data-url="{{ asset($item->path) }}">{{ $item->name }}</a>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $item->type }}</span>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d F Y, H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card my-3">
                <div class="card-header">Folder Favorites</div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Shared At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($folderFavorites as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <a href="#" class="toggle-favorite" data-id="{{ $item->id }}">
                                                <i
                                                    class="bi {{ $item->is_favorite ? 'bi-star-fill text-warning' : 'bi-star text-muted' }}"></i>
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <i class="bi bi-folder"></i>
                                        <a href="{{ route('showFolder', ['id' => $item->id]) }}">{{ $item->name }}</a>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">FOLDER</span>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d F Y, H:i') }}</td>
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
