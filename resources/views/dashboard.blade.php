@extends('layouts.dashboard')
@section('title', 'Dashboard')

@section('content')
    <div class="row justify-content-start">
        @foreach ($departments as $item)
            <div class="col-md-3">
                <a href="{{ route('departemen-files', ['id' => $item->id]) }}">
                    <div class="card">
                        <div class="card-header">
                            <i class="bi bi-folder-fill fs-1"></i>
                        </div>

                        <div class="card-body">
                            <h4 class="fw-bold">
                                {{ $item->name }}
                            </h4>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

@endsection

@section('scripts')
@endsection
