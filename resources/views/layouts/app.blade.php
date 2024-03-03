<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="../assets/darkpan/img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet"> 
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Libraries Stylesheet -->
    <link href="../assets/darkpan/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="../assets/darkpan/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../assets/darkpan/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../assets/darkpan/css/style.css" rel="stylesheet">
    <style>
        /* Custom background color for the card */
        .custom-bg-color {
            background-color: rgb(19, 19, 19)
        }

    </style>
</head>
<body>
    <div id="app">
        @if (!in_array(Route::currentRouteName(), ['login', 'register']))
        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3 d-flex flex-column justify-content-between"">
            <nav class="navbar bg-secondary navbar-dark">
                <a href="{{ route('home') }}" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>DarkPan</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="../assets/darkpan/img/user.jpg" alt="" style="width: 40px; height: 40px;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0">{{ auth()->user()->name }}</h6>
                        <span>{{ auth()->user()->level }}</span>
                    </div>                        
                </div>
                <div class="navbar-nav w-100">
                <a href="{{ route('home') }}" class="nav-item nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                    <i class="fa fa-tachometer-alt me-2"></i>Dashboard
                </a>
                <a href="{{ route('pelanggan') }}" class="nav-item nav-link {{ request()->routeIs('pelanggan') ? 'active' : '' }}">
                    <i class="fa fa-user me-2"></i>Pelanggan
                </a>
                <a href="{{ route('supplier') }}" class="nav-item nav-link {{ request()->routeIs('supplier') ? 'active' : '' }}">
                    <i class="fa fa-id-card me-2"></i>Supplier
                </a>
                <a href="{{ route('barang') }}" class="nav-item nav-link {{ request()->routeIs('barang') ? 'active' : '' }}">
                    <i class="fa fa-cubes me-2"></i>Barang
                </a>
                <a href="{{ route('order') }}" class="nav-item nav-link {{ request()->routeIs('order') ? 'active' : '' }}">
                    <i class="fa fa-handshake me-2"></i>Pesanan
                </a>
            </div>
            </nav>
            <div class="navbar-nav px-4">
                <a href="#" class="nav-item nav-link text-primary" data-bs-toggle="modal" data-bs-target="#logoutConfirmationModal"><i class="fa fa-sign-out-alt me-2"></i>Logout</a>
            </div>
        </div>
        <!-- Sidebar End -->
        @endif

        <!-- Logout Confirmation Modal -->
        <div class="modal fade" id="logoutConfirmationModal" tabindex="-1" aria-labelledby="logoutConfirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-secondary">
                    <div class="modal-body">
                        Are you sure you want to logout?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <a href="{{ route('logout') }}" class="btn btn-primary">Logout</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Logout Confirmation Modal -->

        <main>
            @yield('content')
        </main>
    </div>

    <script>
        // Add event listener to the dropdown links
        const dropdownLinks = document.querySelectorAll('.dropdown-menu a.dropdown-item');
        dropdownLinks.forEach(link => {
            link.addEventListener('click', (event) => {
                event.stopPropagation(); // Prevent default action for the event
            });
        });
    </script>

        <!-- JavaScript Libraries -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/darkpan/lib/chart/chart.min.js"></script>
        <script src="../assets/darkpan/lib/easing/easing.min.js"></script>
        <script src="../assets/darkpan/lib/waypoints/waypoints.min.js"></script>
        <script src="../assets/darkpan/lib/owlcarousel/owl.carousel.min.js"></script>
        <script src="../assets/darkpan/lib/tempusdominus/js/moment.min.js"></script>
        <script src="../assets/darkpan/lib/tempusdominus/js/moment-timezone.min.js"></script>
        <script src="../assets/darkpan/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

        <!-- Template Javascript -->
        <script src="../assets/darkpan/js/main.js"></script>
</body>
</html>
