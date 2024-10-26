@extends('layouts.dashboard')
@section('title', 'My Files')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">{{ __('Dashboard') }}</div>

            <div class="card-body">
                <div class="d-flex gap-2 justify-content-end">
                    <button class="btn btn-info  fw-bold text-white"><i class="bi bi-folder"></i> Share</button>
                    <button class="btn btn-success  fw-bold text-white "><i class="bi bi-download"></i> Download</button>
                    <button class="btn btn-danger  fw-bold text-white"><i class="bi bi-trash"></i> Delete</button>
                </div>
                <table class="table">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Size</th>
                        <th>Created</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th>
                            <div class="d-flex align-items-center gap-2">
                                <input type="checkbox" name="" class="form-check-input" id="">
                                <a href=""><i class="bi bi-star-fill text-warning"></i></a>
                                <a href=""><i class="bi bi-pencil-fill text-primary"></i></a>
                            </div>
                        </th>
                        <td> <i class="bi bi-folder"></i> <a href="#">File 1</a></td>
                        <td>12kb</td>
                        <td>12 Oktober 2010</td>
                      </tr>
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
</div>
@endsection
