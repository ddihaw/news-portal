<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Portal Berita - Beranda</title>

    @yield('meta')
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="{{ secure_asset('assets/favicon.ico') }}" />
    <!-- Font -->
    <link href="{{ secure_asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="{{ secure_asset('assets/css/styles.css') }}" rel="stylesheet" />
    <!-- Bootstrap core JavaScript-->
    <script src="{{ secure_asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ secure_asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</head>

<body class="d-flex flex-column">
    <main class="flex-shrink-0">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg fixed-top custom-navbar">
            <div class="container px-5">
                <a class="navbar-brand d-flex align-items-center" href="{{ route('landing.index') }}">
                    <img src="{{ secure_asset('storage/images/banner-logo.png') }}" alt="Winni Code"
                        style="height: 45px; margin-right: 10px;">
                </a>

                <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
                        <!-- Search for Desktop -->
                        <li class="nav-item position-relative d-none d-lg-block">
                            <button class="btn btn-outline-light" id="searchToggle" type="button">
                                <i class="bi bi-search"></i>
                            </button>
                            <form id="searchForm" action="{{ route('news.search') }}" method="GET"
                                class="d-none position-absolute top-100 start-0 mt-2 bg-white p-2 rounded-3 shadow-sm d-flex align-items-center gap-2"
                                style="z-index: 1000; width: 300px;">
                                <input type="text" name="q" class="form-control border-0 shadow-none"
                                    placeholder="Cari berita..." value="{{ request('q') }}"
                                    style="flex: 1; font-size: 0.95rem;">
                                <button class="btn btn-gradient px-3" type="submit"
                                    style="background: #012d61; border: none; color: white">
                                    Cari
                                </button>
                            </form>
                        </li>

                        <!-- Search for Mobile -->
                        <li class="nav-item w-100 mt-2 d-flex d-lg-none px-2">
                            <form action="{{ route('news.search') }}" method="GET"
                                class="d-flex w-100 bg-white px-3 py-2 rounded-3 shadow-sm align-items-center gap-2"
                                style="z-index: 1000;">

                                <input type="text" name="q" class="form-control border-0 shadow-none"
                                    placeholder="Cari berita..." value="{{ request('q') }}"
                                    style="flex: 1; font-size: 0.95rem;">

                                <button class="btn btn-gradient px-3" type="submit"
                                    style="background: #012d61; border: none; color: white;">
                                    Cari
                                </button>
                            </form>
                        </li>

                        <!-- Categories -->
                        <li class="nav-item dropdown mx-2">
                            <a class="nav-link dropdown-toggle text-white" role="button" data-bs-toggle="dropdown">
                                Kategori
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @foreach ($categories as $cat)
                                    <li>
                                        <a href="{{ route('newsIndex.byCategory', $cat->idCategory) }}"
                                            class="dropdown-item">
                                            {{ $cat->nameCategory }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>

                        @foreach ($menus as $data)
                            <li class="nav-item dropdown mx-2">
                                @if(count($data['subMenus']) > 0)
                                    <a href="{{ $data['menuUrl'] }}" class="nav-link dropdown-toggle text-white" role="button"
                                        data-bs-toggle="dropdown">{{ $data['menuName'] }}</a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        @foreach ($data['subMenus'] as $submenu)
                                            <li>
                                                <a class="dropdown-item" href="{{ $submenu['subMenuUrl'] }}"
                                                    target="{{ $submenu['subMenuTarget'] }}">{{ $submenu['subMenuName'] }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <a class="nav-link text-white" href="{{ $data['menuUrl'] }}"
                                        target="{{ $data['menuTarget'] }}">{{ $data['menuName'] }}</a>
                                @endif
                            </li>
                        @endforeach

                        <!-- Login / User -->
                        @if (auth('user')->check())
                            @php
                                $prefix = auth('user')->user()->role;
                                $name = auth('user')->user()->name;
                                $id = auth('user')->user()->id;
                            @endphp

                            @if ($prefix !== 'user')
                                <li class="nav-item mx-2">
                                    <a class="nav-link text-white" href={{ url($prefix . '/') }}>Dashboard</a>
                                </li>
                            @else
                            @endif

                            <li class="nav-item dropdown mx-2">
                                <a class="nav-link dropdown-toggle text-white" href="#" id="userDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Akun
                                </a>
                                <div class="dropdown-menu dropdown-menu-end shadow">
                                    @if ($prefix !== 'user')
                                        <a class="dropdown-item" href="{{ url($prefix . '/user/modify/' . $id) }}">Profile</a>
                                    @else
                                        <a class="dropdown-item"
                                            href="{{ route('user.account', ['id' => $id, 'return' => url()->current()]) }}">Profile</a>
                                    @endif
                                    <a class="dropdown-item" href="{{ url($prefix . '/resetPassword') }}">Reset Password</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#" data-toggle="modal"
                                        data-target="#logoutModal">Logout</a>
                                </div>
                            </li>
                        @else
                            <li class="nav-item mx-2">
                                <a class="nav-link text-white"
                                    href="{{ route('auth.index', ['redirect' => url()->full()]) }}">Masuk</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Page Content-->
        @yield('content')
    </main>

    <!-- Footer -->
    <footer style="background-color: #012d61;" class="text-white py-4 mt-auto">
        <div class="container px-4 text-center">
            <img src="{{ secure_asset('storage/images/banner-logo.png') }}" alt="Logo" style="height: 40px;"
                class="mb-2">
            <p class="small mb-0">&copy; PT. WINNICODE GARUDA TEKNOLOGI. All rights reserved.</p>
        </div>
    </footer>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Apakah Anda yakin?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih "Logout" di bawah ini jika Anda siap untuk mengakhiri sesi Anda saat ini.
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="{{ route('auth.logout') }}">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="{{ secure_asset('assets/js/scripts.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleBtn = document.getElementById('searchToggle');
            const searchForm = document.getElementById('searchForm');

            toggleBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                searchForm.classList.toggle('d-none');
            });

            document.addEventListener('click', function (e) {
                if (!searchForm.contains(e.target) && e.target !== toggleBtn && !toggleBtn.contains(e.target)) {
                    searchForm.classList.add('d-none');
                }
            });
        });
    </script>

    <script>
        window.addEventListener('scroll', function () {
            const navbar = document.querySelector('.custom-navbar');
            if (window.scrollY > 10) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>


</body>

</html>