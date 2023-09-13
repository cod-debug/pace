<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- <link rel="stylesheet" href="{{ mix('css/app.css') }}" type="text/css"> --}}

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" />
    
    @vite(['resources/js/app.js', 'resources/css/app.css', 'resources/css/font-awesome.min.css', 'resources/js/font-awesome.min.js', 'resources/css/sidebar.min.css'])

</head>

<body>
    <div class="s-layout"><div class="layout has-sidebar fixed-sidebar fixed-header">
        <div class="sidebar">
            <div class="logo-details">
                <i class='bx bx-book-content'></i>
                <span class="logo_name">PACE</span>
            </div>
            
            <div class="border-top border-bottom border-secondary bg-white text-center py-1">
                <small class="mb-0 text-secondary">ADMIN</small>
            </div> 

            <ul class="nav-links">
                <li>
                    <a href="{{route('dashboard')}}">
                        <i class='bx bx-home'></i>
                        <span class="link_name">Dashboard</span>
                    </a>
                    <ul class="sub-menu blank">
                        <li><a class="link_name" href="#">Dashboard</a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{route('office.list')}}">
                        <i class='bx bx-building'></i>
                        <span class="link_name">Departments</span>
                    </a>
                    <ul class="sub-menu blank">
                        <li><a class="link_name" href="#">Departments</a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{route('employee.list')}}">
                        <i class='bx bx-user'></i>
                        <span class="link_name">Employees</span>
                    </a>
                    <ul class="sub-menu blank">
                        <li><a class="link_name" href="#">Employees</a></li>
                    </ul>
                </li>
                {{-- <li>
                    <div class="icon-link">
                    <a href="#">
                        <i class='bx bx-file-find'></i>
                        <span class="link_name">Insights</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                    </div>
                    <ul class="sub-menu">
                    <li><a class="link_name" href="#">Insights</a></li>
                    <li><a href="#">Money Movement</a></li>
                    <li><a href="#">Enterprise Spotlight</a></li>
                    <li><a href="#">Financial Burnout</a></li>
                    </ul>
                </li> --}}
            </ul>
        </div>
        <section class="home-section">
            <div class="home-content">
                <i class='bx bx-menu'></i>
                <span class="text">
                    @yield('title')
                </span>
            </div>
            <div id="app" class="p-2">
                @yield('content')
            </div>
        </section>
      </div>
    </div>
</body>

    <script src="/assets/js/sidebar.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/bootstrap-bundle.min.js"></script>
</html>