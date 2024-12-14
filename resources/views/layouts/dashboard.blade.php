<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | File Manager</title>


    <link rel="shortcut icon"
        href="data:image/svg+xml,%3csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%2033%2034'%20fill-rule='evenodd'%20stroke-linejoin='round'%20stroke-miterlimit='2'%20xmlns:v='https://vecta.io/nano'%3e%3cpath%20d='M3%2027.472c0%204.409%206.18%205.552%2013.5%205.552%207.281%200%2013.5-1.103%2013.5-5.513s-6.179-5.552-13.5-5.552c-7.281%200-13.5%201.103-13.5%205.513z'%20fill='%23435ebe'%20fill-rule='nonzero'/%3e%3ccircle%20cx='16.5'%20cy='8.8'%20r='8.8'%20fill='%2341bbdd'/%3e%3c/svg%3e"
        type="image/x-icon">
    <link rel="shortcut icon"
        href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACEAAAAiCAYAAADRcLDBAAAEs2lUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4KPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iWE1QIENvcmUgNS41LjAiPgogPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4KICA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIgogICAgeG1sbnM6ZXhpZj0iaHR0cDovL25zLmFkb2JlLmNvbS9leGlmLzEuMC8iCiAgICB4bWxuczp0aWZmPSJodHRwOi8vbnMuYWRvYmUuY29tL3RpZmYvMS4wLyIKICAgIHhtbG5zOnBob3Rvc2hvcD0iaHR0cDovL25zLmFkb2JlLmNvbS9waG90b3Nob3AvMS4wLyIKICAgIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIKICAgIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIgogICAgeG1sbnM6c3RFdnQ9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZUV2ZW50IyIKICAgZXhpZjpQaXhlbFhEaW1lbnNpb249IjMzIgogICBleGlmOlBpeGVsWURpbWVuc2lvbj0iMzQiCiAgIGV4aWY6Q29sb3JTcGFjZT0iMSIKICAgdGlmZjpJbWFnZVdpZHRoPSIzMyIKICAgdGlmZjpJbWFnZUxlbmd0aD0iMzQiCiAgIHRpZmY6UmVzb2x1dGlvblVuaXQ9IjIiCiAgIHRpZmY6WFJlc29sdXRpb249Ijk2LjAiCiAgIHRpZmY6WVJlc29sdXRpb249Ijk2LjAiCiAgIHBob3Rvc2hvcDpDb2xvck1vZGU9IjMiCiAgIHBob3Rvc2hvcDpJQ0NQcm9maWxlPSJzUkdCIElFQzYxOTY2LTIuMSIKICAgeG1wOk1vZGlmeURhdGU9IjIwMjItMDMtMzFUMTA6NTA6MjMrMDI6MDAiCiAgIHhtcDpNZXRhZGF0YURhdGU9IjIwMjItMDMtMzFUMTA6NTA6MjMrMDI6MDAiPgogICA8eG1wTU06SGlzdG9yeT4KICAgIDxyZGY6U2VxPgogICAgIDxyZGY6bGkKICAgICAgc3RFdnQ6YWN0aW9uPSJwcm9kdWNlZCIKICAgICAgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWZmaW5pdHkgRGVzaWduZXIgMS4xMC4xIgogICAgICBzdEV2dDp3aGVuPSIyMDIyLTAzLTMxVDEwOjUwOjIzKzAyOjAwIi8+CiAgICA8L3JkZjpTZXE+CiAgIDwveG1wTU06SGlzdG9yeT4KICA8L3JkZjpEZXNjcmlwdGlvbj4KIDwvcmRmOlJERj4KPC94OnhtcG1ldGE+Cjw/eHBhY2tldCBlbmQ9InIiPz5V57uAAAABgmlDQ1BzUkdCIElFQzYxOTY2LTIuMQAAKJF1kc8rRFEUxz9maORHo1hYKC9hISNGTWwsRn4VFmOUX5uZZ36oeTOv954kW2WrKLHxa8FfwFZZK0WkZClrYoOe87ypmWTO7dzzud97z+nec8ETzaiaWd4NWtYyIiNhZWZ2TvE946WZSjqoj6mmPjE1HKWkfdxR5sSbgFOr9Ll/rXoxYapQVik8oOqGJTwqPL5i6Q5vCzeo6dii8KlwpyEXFL519LjLLw6nXP5y2IhGBsFTJ6ykijhexGra0ITl5bRqmWU1fx/nJTWJ7PSUxBbxJkwijBBGYYwhBgnRQ7/MIQIE6ZIVJfK7f/MnyUmuKrPOKgZLpEhj0SnqslRPSEyKnpCRYdXp/9++msneoFu9JgwVT7b91ga+LfjetO3PQ9v+PgLvI1xkC/m5A+h7F32zoLXug38dzi4LWnwHzjeg8UGPGbFfySvuSSbh9QRqZ6H+Gqrm3Z7l9zm+h+iafNUV7O5Bu5z3L/wAdthn7QIme0YAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAJTSURBVFiF7Zi9axRBGIefEw2IdxFBRQsLWUTBaywSK4ubdSGVIY1Y6HZql8ZKCGIqwX/AYLmCgVQKfiDn7jZeEQMWfsSAHAiKqPiB5mIgELWYOW5vzc3O7niHhT/YZvY37/swM/vOzJbIqVq9uQ04CYwCI8AhYAlYAB4Dc7HnrOSJWcoJcBS4ARzQ2F4BZ2LPmTeNuykHwEWgkQGAet9QfiMZjUSt3hwD7psGTWgs9pwH1hC1enMYeA7sKwDxBqjGnvNdZzKZjqmCAKh+U1kmEwi3IEBbIsugnY5avTkEtIAtFhBrQCX2nLVehqyRqFoCAAwBh3WGLAhbgCRIYYinwLolwLqKUwwi9pxV4KUlxKKKUwxC6ZElRCPLYAJxGfhSEOCz6m8HEXvOB2CyIMSk6m8HoXQTmMkJcA2YNTHm3congOvATo3tE3A29pxbpnFzQSiQPcB55IFmFNgFfEQeahaAGZMpsIJIAZWAHcDX2HN+2cT6r39GxmvC9aPNwH5gO1BOPFuBVWAZue0vA9+A12EgjPadnhCuH1WAE8ivYAQ4ohKaagV4gvxi5oG7YSA2vApsCOH60WngKrA3R9IsvQUuhIGY00K4flQG7gHH/mLytB4C42EgfrQb0mV7us8AAMeBS8mGNMR4nwHamtBB7B4QRNdaS0M8GxDEog7iyoAguvJ0QYSBuAOcAt71Kfl7wA8DcTvZ2KtOlJEr+ByyQtqqhTyHTIeB+ONeqi3brh+VgIN0fohUgWGggizZFTplu12yW8iy/YLOGWMpDMTPXnl+Az9vj2HERYqPAAAAAElFTkSuQmCC"
        type="image/png">
    <link rel="stylesheet" crossorigin href="{{ asset('assets') }}/compiled/css/app.css">
    <link rel="stylesheet" crossorigin href="{{ asset('assets') }}/compiled/css/app-dark.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>
<style>
    .ram-usage {
        padding: 15px;
        color: #333;
    }

    .progress {
        background-color: #d1d1d1;
        border-radius: 5px;
        height: 30px;
    }

    .progress-bar {
        background-color: #cf2f2f;
        text-align: center;
        color: white;
        height: 100%;
        border-radius: 5px;
    }

    .search-bar {
        max-width: 300px;
        margin-right: 10px;
    }

    #searchResults {
        max-height: 200px;
        overflow-y: auto;
    }

    .list-group-item {
        cursor: pointer;
    }
</style>

<body>
    <script src="{{ asset('assets') }}/static/js/initTheme.js"></script>
    <div id="app">
        <div id="sidebar">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header position-relative">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="logo">
                            <a href="index.html"><img src="{{ asset('assets') }}/img/logo.jpeg" alt="Logo"
                                    srcset=""></a>
                        </div>
                        <div class="theme-toggle d-flex gap-2  align-items-center mt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                aria-hidden="true" role="img" class="iconify iconify--system-uicons" width="20"
                                height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                                <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2"
                                        opacity=".3"></path>
                                    <g transform="translate(-210 -1)">
                                        <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                                        <circle cx="220.5" cy="11.5" r="4"></circle>
                                        <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2">
                                        </path>
                                    </g>
                                </g>
                            </svg>
                            <div class="form-check form-switch fs-6">
                                <input class="form-check-input  me-0" type="checkbox" id="toggle-dark"
                                    style="cursor: pointer">
                                <label class="form-check-label"></label>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                aria-hidden="true" role="img" class="iconify iconify--mdi" width="20"
                                height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z">
                                </path>
                            </svg>
                        </div>
                        <div class="sidebar-toggler  x">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i
                                    class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        @if (Auth::user()->role == 'admin')
                            <li class="sidebar-title">MENU</li>

                            <li class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <a href="/dashboard" class="sidebar-link">
                                    <i class="bi bi-folder"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>
                        @endif
                        @if (Auth::user()->role != 'admin')
                            <li class="sidebar-title">Menu</li>

                            <li class="sidebar-item {{ request()->routeIs('home') ? 'active' : '' }}">
                                <a href="/home" class="sidebar-link">
                                    <i class="bi bi-folder"></i>
                                    <span>My Files</span>
                                </a>
                            </li>
                            <li class="sidebar-item {{ request()->routeIs('departemen-files') ? 'active' : '' }}">
                                <a href="/departemen-files/{{ Auth::user()->pegawai->department_id }}"
                                    class="sidebar-link">
                                    <i class="bi bi-folder"></i>
                                    <span>Departement Files</span>
                                </a>
                            </li>

                            <li class="sidebar-item {{ request()->routeIs('sharedWithMe') ? 'active' : '' }}">
                                <a href="{{ route('sharedWithMe') }}" class="sidebar-link">
                                    <i class="bi bi-people"></i>
                                    <span>Shared With Me</span>
                                </a>
                            </li>

                            <li class="sidebar-item {{ request()->routeIs('sharedByMe') ? 'active' : '' }}">
                                <a href="{{ route('sharedByMe') }}" class="sidebar-link">
                                    <i class="bi bi-share"></i>
                                    <span>Shared By Me</span>
                                </a>
                            </li>

                            <li class="sidebar-item {{ request()->routeIs('trash') ? 'active' : '' }}">
                                <a href="{{ route('trash') }}" class="sidebar-link">
                                    <i class="bi bi-trash"></i>
                                    <span>Trash</span>
                                </a>
                            </li>

                            <li class="sidebar-item {{ request()->routeIs('favorites') ? 'active' : '' }}">
                                <a href="{{ route('favorites') }}" class="sidebar-link">
                                    <i class="bi bi-star"></i>
                                    <span>Favorites</span>
                                </a>
                            </li>
                        @endif
                        @if (Auth::user()->role == 'admin')
                            <li class="sidebar-item {{ request()->routeIs('departments.*') ? 'active' : '' }}">
                                <a href="{{ route('departments.index') }}" class="sidebar-link">
                                    <i class="bi bi-building"></i>
                                    <span>Departments</span>
                                </a>
                            </li>
                            <li class="sidebar-item {{ request()->routeIs('file-categories.*') ? 'active' : '' }}">
                                <a href="{{ route('file-categories.index') }}" class="sidebar-link">
                                    <i class="bi bi-folder"></i>
                                    <span>File Categories</span>
                                </a>
                            </li>

                            <li class="sidebar-item {{ request()->routeIs('userManagement') ? 'active' : '' }}">
                                <a href="{{ route('userManagement') }}" class="sidebar-link">
                                    <i class="bi bi-people-fill"></i>
                                    <span>User Management</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                    @if (Auth::user()->role != 'admin')
                        <div class="disk-usage mx-4 mt-5">
                            <h6>Disk Space Usage</h6>
                            @php
                                $user = Auth::user();
                                $usedSpace = $user->calculateDiskSpace();
                                $maxSpace = $user->disk_space;
                                $usagePercentage = $maxSpace > 0 ? ($usedSpace / $maxSpace) * 100 : 0;
                            @endphp
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: {{ $usagePercentage }}%;"
                                    aria-valuenow="{{ $usagePercentage }}" aria-valuemin="0" aria-valuemax="100">
                                    {{ number_format($usedSpace, 2) }} MB / {{ number_format($maxSpace, 2) }} MB
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div id="main" class='layout-navbar navbar-fixed'>
            <header>
                <nav class="navbar navbar-expand navbar-light navbar-top">
                    <div class="container-fluid">
                        <a href="#" class="burger-btn d-block">
                            <i class="bi bi-justify fs-3"></i>
                        </a>
                        @if (Auth::user()->role != 'admin')
                            <div class="search-bar ms-auto me-3 position-relative">
                                <input type="text" id="searchInput" class="form-control p-2 rounded-4"
                                    placeholder="Search files or folders...">
                                <div id="searchResults" class="position-absolute w-100 bg-white border"
                                    style="z-index: 1000; display: none;">
                                    <ul class="list-group" id="resultsList"></ul>
                                </div>
                            </div>
                        @endif

                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">

                            <ul class="navbar-nav ms-auto mb-lg-0">
                                @if (Auth::user()->role != 'admin')
                                    <li class="nav-item dropdown me-3">
                                        <a class="nav-link active dropdown-toggle text-gray-600" href="#"
                                            data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                            <i class='bi bi-bell bi-sub fs-4'></i>
                                            @if (Auth::user()->unreadNotifications->count() > 0)
                                                <span class="badge badge-notification bg-danger">
                                                    {{ Auth::user()->unreadNotifications->count() }}
                                                </span>
                                            @endif
                                        </a>
                                        <ul class="dropdown-menu dropdown-center dropdown-menu-sm-end notification-dropdown"
                                            aria-labelledby="dropdownMenuButton">
                                            <li class="dropdown-header">
                                                <h6>Notifications</h6>
                                            </li>
                                            @forelse (Auth::user()->unreadNotifications as $notification)
                                                <li class="dropdown-item notification-item">
                                                    <a class="d-flex align-items-center" href="/shared-with-me">
                                                        <div class="notification-icon bg-primary">
                                                            <i class="bi bi-share"></i>
                                                        </div>
                                                        <div class="notification-text ms-4">
                                                            <p class="notification-title font-bold">
                                                                {{ $notification->data['message'] }}</p>
                                                            <small
                                                                class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                                        </div>
                                                    </a>
                                                </li>
                                            @empty
                                                <li class="dropdown-item text-center">
                                                    <p class="text-muted">No new notifications</p>
                                                </li>
                                            @endforelse
                                        </ul>
                                    </li>
                                @endif
                            </ul>

                            <div class="dropdown">
                                <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="user-menu d-flex">
                                        <div class="user-name text-end me-3">
                                            <h6 class="mb-0 text-gray-600">{{ Auth::user()->name }}</h6>
                                            <p class="mb-0 text-sm text-gray-600">{{ Auth::user()->role }}</p>
                                        </div>
                                        <div class="user-img d-flex align-items-center">
                                            <div class="avatar avatar-md">

                                                <img
                                                    src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : asset('assets/compiled/jpg/1.jpg') }}">
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton"
                                    style="min-width: 11rem;">
                                    <li>
                                        <h6 class="dropdown-header">Hello, {{ Auth::user()->name }}!</h6>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                            <i class="icon-mid bi bi-person me-2"></i> My Profile
                                        </a>
                                    </li>

                                    <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="#">
                                            <form action="{{ route('logout') }}" method="POST">
                                                @csrf
                                                <button class="dropdown-item" type="submit">
                                                    <i class="bi bi-power"></i>
                                                    <span>Logout</span>
                                                </button>
                                            </form>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
            </header>
            <div id="main-content">
                <div class="page-heading">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-12 col-md-6 order-md-1 order-last">
                                <h3>@yield('title')</h3>
                            </div>
                            <div class="col-12 col-md-6 order-md-2 order-first">
                                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">
                                            @yield('title')
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <section class="section">
                        @yield('content')
                    </section>
                </div>

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets') }}/static/js/components/dark.js"></script>
    <script src="{{ asset('assets') }}/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>

    <script src="{{ asset('assets') }}/compiled/js/app.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            let allData = []; // Menyimpan semua data yang diambil dari backend

            // Ambil semua data dari server
            $.ajax({
                url: '/search',
                method: 'GET',
                success: function(data) {
                    allData = data;
                    console.log(allData);
                }
            });

            // Fungsi untuk mencari berdasarkan input pengguna
            $('#searchInput').on('input', function() {
                let query = $(this).val().toLowerCase(); // Menyaring input menjadi huruf kecil
                if (query.length > 1) {
                    // Filter data yang sesuai dengan query
                    let filteredData = allData.filter(item => {
                        return item.name.toLowerCase().includes(query) ||
                            item.type?.toLowerCase().includes(
                            query); // Menambahkan filter berdasarkan nama atau type
                    });

                    // Update hasil pencarian
                    $('#resultsList').empty();
                    if (filteredData.length > 0) {
                        filteredData.forEach(item => {
                            if (item.type) {
                                $('#resultsList').append(
                                    `<li class="list-group-item">
                                <a href="${item.path}" target="_blank"> 
                                    <i class="bi bi-file-earmark"></i>${item.name}
                                </a>
                            </li>`
                                );
                            } else {
                                $('#resultsList').append(
                                    `<li class="list-group-item">
                                <a href="/folders/${item.id}"> 
                                    <i class="bi bi-folder"></i> ${item.name}
                                </a>
                            </li>`
                                );
                            }
                        });
                        $('#searchResults').show();
                    } else {
                        $('#resultsList').append(
                            '<li class="list-group-item text-muted">No results found</li>'
                        );
                        $('#searchResults').show();
                    }
                } else {
                    $('#searchResults').hide();
                }
            });

            $(document).click(function(e) {
                if (!$(e.target).closest('.search-bar').length) {
                    $('#searchResults').hide();
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.notification-item a').on('click', function(event) {
                event.preventDefault();
                const url = $(this).attr('href');
                $.ajax({
                    url: '{{ route('notifications.markAsRead') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            window.location.href = url;
                        } else {
                            console.error('Failed to mark notifications as read');
                        }
                    },
                    error: function() {
                        console.error('Error while marking notifications as read');
                    }
                });
            });
        });
    </script>
    @if ($errors->any())
        <script>
            let errorMessages = '';
            @foreach ($errors->all() as $error)
                errorMessages += "{{ $error }}\n";
            @endforeach

            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: errorMessages,
            });
        </script>
    @endif
    @if (session('success') || session('error'))
        <script>
            $(document).ready(function() {
                var successMessage = "{{ session('success') }}";
                var errorMessage = "{{ session('error') }}";

                if (successMessage) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: successMessage,
                    });
                }

                if (errorMessage) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMessage,
                    });
                }
            });
        </script>
    @endif

    @yield('scripts')


</body>

</html>
