@foreach ($folders as $folder)
    <li class="list-group-item">
        <i class="bi bi-folder-fill"></i>
        <a href="{{ route('showFolder', ['id' => $folder->id]) }}">{{ $folder->name }}</a>
        @if ($folder->subfolders->count() > 0)
            <ul class="list-group mt-2">
                @include('partials.folder_list', ['folders' => $folder->subfolders])
            </ul>
        @endif
    </li>
@endforeach
