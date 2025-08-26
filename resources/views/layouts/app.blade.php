<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Skripsi')</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/CSS/bootstrap.min.css') }}">
    <!-- AOS Animate CSS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />

    <style>
        /* ==============================
           Global Body
           ============================== */
        body {
            background: linear-gradient(135deg, #1e1e2f, #3a3b5a, #1e1e2f);
            background-attachment: fixed;
            color: #f1f1f1 !important;
            font-family: 'Segoe UI', sans-serif;
        }

        /* ==============================
           Sidebar
           ============================== */
        .sidebar {
            width: 220px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            background: rgba(21, 22, 29, 0.6);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            padding-top: 20px;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.6);
            border-right: 1px solid rgba(255, 255, 255, 0.08);
            z-index: 1000;
        }

        .sidebar h5 {
            text-align: center;
            color: #ccc !important;
            margin-bottom: 15px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: #ccc !important;
            padding: 12px 20px;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .sidebar a:hover,
        .sidebar .active {
            background: rgba(78, 154, 241, 0.15); /* biru lembut transparan */
            color: #fff !important;
            transform: translateX(5px);
            box-shadow: 0 0 10px rgba(78, 154, 241, 0.3); /* glow tipis */
        }

        /* ==============================
           Dropdown Menu
           ============================== */
        .dropdown-sub {
            background-color: #1c1d26;
        }

        .dropdown-sub a {
            padding-left: 40px;
            font-size: 0.95rem;
        }

        .slide-menu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease, opacity 0.4s ease;
            opacity: 0;
        }

        .slide-menu.open {
            max-height: 500px;
            opacity: 1;
        }

        /* Arrow rotation animation */
        #arrowIcon {
            font-size: 1.2rem;
            transition: transform 0.3s ease;
            margin-left: 8px;
        }

        .rotate {
            transform: rotate(180deg);
        }

        /* ==============================
           Main Content
           ============================== */
        .main {
            margin-left: 220px;
            padding: 40px 20px;
            min-height: 100vh;
        }

        .card {
            background-color: #2a2b3d;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            color: #f1f1f1 !important;
        }

        /* ==============================
           Profile Section (within main)
           ============================== */
        .profile {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
        }

        .profile img {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #4e9af1;
        }

        /* ==============================
           History Boxes
           ============================== */
        .history-box {
            background-color: #1e1e2f;
            padding: 15px 20px;
            margin-bottom: 10px;
            border-left: 4px solid #4e9af1;
            border-radius: 8px;
            color: #f1f1f1 !important;
            transition: all 0.3s ease;
        }

        .history-box:hover {
            background-color: #2d2e42;
            transform: translateX(5px);
        }

        /* Status Colors */
        .status-menunggu { color: #ffc107; font-weight: bold; }
        .status-diterima { color: #4caf50; font-weight: bold; }
        .status-ditolak { color: #f44336; font-weight: bold; }

        /* Quote Box */
        .quote {
            background-color: #343a40;
            border-left: 4px solid #4e9af1;
            padding: 15px 20px;
            border-radius: 8px;
            font-style: italic;
            color: #eee;
            margin-bottom: 25px;
        }

        /* ==============================
           Responsive
           ============================== */
        @media (max-width: 768px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
                box-shadow: none;
            }

            .main {
                margin-left: 0;
                padding: 20px;
            }

            footer {
                width: 100%;
                margin-left: 0;
            }
        }

        /* ==============================
           Wrapper & Footer
           ============================== */
        .main-wrapper {
            display: flex;
            flex-direction: column;
            margin-left: 220px; /* jangan tembus sidebar */
            min-height: 100vh;
        }

        .main-content {
            flex: 1;
            padding: 40px 20px;
        }

        footer {
            background-color: #343a40;
            text-align: center;
            color: #fff;
            padding: 10px 0;
            width: 100%;
            box-shadow: 0 -2px 6px rgba(0,0,0,0.3);
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- ==============================
         Sidebar
         ============================== -->
    @auth
        @if(Auth::user()->role === 'mahasiswa')
            @include('partials.mahasiswa_sidebar')
        @elseif(Auth::user()->role === 'dosen')
            @include('partials.dosen_sidebar')
        @elseif(Auth::user()->role === 'admin')
            @include('partials.admin_sidebar')
        @endif
    @endauth

    <!-- ==============================
         Main Wrapper & Content
         ============================== -->
    <div class="main-wrapper">
        <div class="main-content">
            @yield('content')
        </div>

        @include('partials.footer')
    </div>

    <!-- ==============================
         JS Scripts
         ============================== -->
    <script src="{{ asset('assets/JS/bootstrap.bundle.min.js') }}"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();

        /* Toggle dropdown menu */
        function toggleDropdown() {
            const menu = document.getElementById("dropdownMenu");
            const arrow = document.getElementById("arrowIcon");

            menu.classList.toggle("open");
            arrow.classList.toggle("rotate");
        }
    </script>
    @stack('scripts')
</body>

</html>
