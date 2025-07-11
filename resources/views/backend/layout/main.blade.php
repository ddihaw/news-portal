<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="{{ secure_asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ secure_asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- Bootstrap core JavaScript-->
    <script src="{{ secure_asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ secure_asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body id="page-top">

    @php
        $prefix = Auth::user()->role;
        $name = Auth::user()->name;
        $id = Auth::user()->id;
    @endphp


    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url($prefix . '/') }}">
                <img src="{{ secure_asset('storage/images/logo.png') }}" alt="Logo"
                    class="sidebar-logo img-fluid d-inline d-md-none">
                <img src="{{ secure_asset('storage/images/banner-logo.png') }}" alt="Banner Logo"
                    class="sidebar-banner img-fluid d-none d-md-inline">
            </a>

            <hr class="sidebar-divider my-0">

            <li class="nav-item active">
                <a class="nav-link" href="{{ url($prefix . '/') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <hr class="sidebar-divider">

            <div class="sidebar-heading">
                Artikel Berita
            </div>

            <li class="nav-item">
                <a class="nav-link" href="{{ url($prefix . '/news') }}">
                    <i class="fas fa-fw fa-newspaper"></i>
                    <span>Daftar Artikel</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ url($prefix . '/news/adding') }}">
                    <i class="fas fa-fw fa-plus"></i>
                    <span>Artikel Baru</span></a>
            </li>

            @if(Auth::user()->role === 'admin' || Auth::user()->role === 'editor')
                <li class="nav-item">
                    <a class="nav-link" href="{{ url($prefix . '/category') }}">
                        <i class="fas fa-fw fa-list"></i>
                        <span>Daftar Kategori</span></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ url($prefix . '/category/adding') }}">
                        <i class="fas fa-fw fa-plus"></i>
                        <span>Kategori Baru</span></a>
                </li>
            @endif

            @if(Auth::user()->role === 'admin')
                <hr class="sidebar-divider">

                <div class="sidebar-heading">
                    Pengguna
                </div>

                <li class="nav-item">
                    <a class="nav-link" href="{{ url($prefix . '/user') }}">
                        <i class="fas fa-fw fa-users"></i>
                        <span>List Pengguna</span></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ url($prefix . '/user/adding') }}">
                        <i class="fas fa-fw fa-user-plus"></i>
                        <span>Pengguna Baru</span></a>
                </li>

                <div class="sidebar-heading">
                    Halaman
                </div>

                <li class="nav-item">
                    <a class="nav-link" href="{{ url($prefix . '/page') }}">
                        <i class="fas fa-fw fa-window-restore"></i>
                        <span>Daftar Halaman</span></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ url($prefix . '/page/adding') }}">
                        <i class="fas fa-fw fa-folder-plus"></i>
                        <span>Halaman Baru</span></a>
                </li>

                <div class="sidebar-heading">
                    Menu
                </div>

                <li class="nav-item">
                    <a class="nav-link" href="{{ url($prefix . '/menu') }}">
                        <i class="fas fa-fw fa-bars"></i>
                        <span>Daftar Menu</span></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ url($prefix . '/menu/adding') }}">
                        <i class="fas fa-fw fa-plus"></i>
                        <span>Menu Baru</span></a>
                </li>
            @endif

            <hr class="sidebar-divider d-none d-md-block">

            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>

        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form id="searchForm" action="{{ url($prefix . '/search') }}" method="GET"
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control bg-light border-0 small"
                                placeholder="Cari berita..." value="{{ request('q') }}" aria-label="Search"
                                aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form id="searchForm" action="{{ url($prefix . '/search') }}" method="GET"
                                    class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" name="q" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." value="{{ request('q') }}" aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle hover-custom" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Filter Kategori</span>
                                <i class="bi bi-tags-fill"></i>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                @foreach ($categories as $cat)
                                    <a href="{{ url($prefix . '/getNews/' . $cat->idCategory) }}" class="dropdown-item">
                                        {{ $cat->nameCategory }}
                                    </a>
                                @endforeach
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link hover-custom" href="{{ route('landing.index') }}" role="button"
                                aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Beranda</span>
                                <i class="bi bi-house-fill"></i>
                            </a>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle hover-custom" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ $name }}</span>
                                <img class="img-profile rounded-circle"
                                    src="{{ secure_asset('assets/img/undraw_profile.svg') }}">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ url($prefix . '/profile') }}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
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

                    </ul>

                </nav>
                <!-- End of Topbar -->

                @yield('content')

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; PT. WINNICODE GARUDA TEKNOLOGI</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

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

    <!-- Core plugin JavaScript-->
    <script src="{{ secure_asset('assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ secure_asset('assets/js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Page level custom scripts -->
    <script src="{{ secure_asset('assets/js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ secure_asset('assets/js/demo/chart-pie-demo.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/ckeditor5-classic-plus@41.3.0/build/ckeditor.min.js"></script>

    <script>
        function showPreview(image, idPreview) {
            var pic = image.files;
            for (var i = 0; i < pic.length; i++) {
                var picPreview = pic[i];
                var imageType = /image.*/;
                var preview = document.getElementById(idPreview);
                var fileReader = new FileReader();

                if (picPreview.type.match(imageType)) {
                    preview.file = picPreview;
                    fileReader.onload = (function (preview) {
                        return function (e) {
                            preview.src = e.target.result;
                            preview.style.display = "block";
                        };
                    })(preview);
                    fileReader.readAsDataURL(picPreview);
                } else {
                    alert("File yang dipilih bukan gambar.");
                }
            }
        }
    </script>

    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .then(editor => {
                console.log(editor);
            })
            .catch(error => {
                console.error(error);
            });
    </script>
</body>

</html>