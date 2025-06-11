<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Portal Berita - Beranda</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/favicon.ico') }}" />
    <!-- Font -->
    <link href="{{asset('assets/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet" />
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
</head>

<body class="d-flex flex-column">
    <main class="flex-shrink-0">
        <!-- Navigation-->
        <nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-primary">
            <div class="container px-5">
                <a class="navbar-brand" href="{{ route('landing.index') }}" style="font-weight: bold">PORTAL BERITA</a>
                <button class="navbar-toggler mb-1 mb-lg-1" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation"><span
                        class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item position-relative d-none d-lg-block">
                            <button class="btn btn-outline-light" id="searchToggle" type="button">
                                <i class="bi bi-search"></i>
                            </button>

                            <form id="searchForm" action="{{ route('news.search') }}" method="GET"
                                class="d-none position-absolute top-100 start-0 mt-2 bg-white p-2 rounded shadow d-flex align-items-center"
                                style="z-index: 1000; width: 300px;">
                                <input type="text" name="q" class="form-control me-2" placeholder="Cari berita..."
                                    value="{{ request('q') }}" style="flex: 1;">
                                <button class="btn btn-outline-primary" type="submit">Cari</button>
                            </form>
                        </li>

                        <li class="nav-item w-100 mt-2 d-flex d-lg-none">
                            <form action="{{ route('news.search') }}" method="GET"
                                class="d-flex w-100 bg-white p-2 rounded shadow align-items-center"
                                style="z-index: 1000;">

                                <input type="text" name="q" class="form-control me-2" placeholder="Cari berita..."
                                    value="{{ request('q') }}" style="flex: 1; border-width: 1px;">

                                <button class="btn btn-outline-primary" type="submit"
                                    style="border-width: 1px;">Cari</button>
                            </form>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown">
                                Kategori
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end">
                                @foreach ($categories as $cat)
                                    <li>
                                        <a href="{{ route('news.byCategory', $cat->idCategory) }}" class="dropdown-item">
                                            {{ $cat->nameCategory }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>

                        @foreach ($menus as $data)
                            @if(count($data['subMenus']) > 0)
                                <li class="nav-item dropdown">
                                    <a href="{{ $data['menuUrl'] }}" class="nav-link dropdown-toggle" role="button"
                                        data-bs-toggle="dropdown">
                                        {{ $data['menuName'] }}
                                    </a>

                                    <ul class="dropdown-menu dropdown-menu-end">
                                        @foreach ($data['subMenus'] as $submenu)
                                            <li>
                                                <a class="dropdown-item" href="{{ $submenu['subMenuUrl'] }}"
                                                    target="{{ $submenu['subMenuTarget'] }}">
                                                    {{ $submenu['subMenuName'] }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                <li class="nav-item dropdown">
                                    <a class="nav-link" href="{{ $data['menuUrl'] }}" target="{{ $data['menuTarget'] }}">
                                        {{ $data['menuName'] }}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                        @if (auth('user')->check())
                            @php
                                $prefix = auth('user')->user()->role;
                                $name = auth('user')->user()->name;
                                $id = auth('user')->user()->id;
                            @endphp

                            @if ($prefix !== 'user')
                                <li class="nav-item">
                                    <a class="nav-link" href={{ url($prefix . '/') }}>Dashboard</a>
                                </li>
                            @else
                            @endif

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                                    role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="me-2">Akun</span>
                                </a>

                                <!-- Dropdown - User Information -->
                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                    aria-labelledby="userDropdown">
                                    @if ($prefix !== 'user')
                                        <a class="dropdown-item" href="{{ url($prefix . '/user/modify/' . $id) }}">
                                            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                            Profile
                                        </a>
                                    @else
                                        <a class="dropdown-item" href="{{ url($prefix . '/profile/' . $id) }}">
                                            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                            Profile
                                        </a>
                                    @endif
                                    <a class="dropdown-item" href="{{ url($prefix . '/resetPassword') }}">
                                        <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Reset Password
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Logout
                                    </a>
                                </div>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href={{ route('auth.index', ['redirect' => url()->full()]) }}>Masuk</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Page Content-->
        @yield('content')
    </main>

    <!-- Footer-->
    <footer class="bg-primary py-4 mt-auto">
        <div class="container px-5">
            <div class="row align-items-center justify-content-between flex-column flex-sm-row">
                <div class="col-auto">
                    <div class="small m-0 text-white">Copyright &copy; MHN 2025</div>
                </div>

                <div class="col-auto">
                    <a class="link-light small" href="#!">Privacy</a>
                    <span class="text-white mx-1">&middot;</span>
                    <a class="link-light small" href="#!">Terms</a>
                    <span class="text-white mx-1">&middot;</span>
                    <a class="link-light small" href="#!">Contact</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
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
    <script src="{{ asset('assets/js/scripts.js') }}"></script>

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

</body>

</html>