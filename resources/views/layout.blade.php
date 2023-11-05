<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light" data-menu-styles="dark" data-toggled="close">
<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=no'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="PHP Bootstrap Responsive Admin Web Dashboard Template">
    <meta name="Author" content="Spruko Technologies Private Limited">
    <meta name="keywords" content="dashboard, template dashboard, Bootstrap dashboard, admin panel template, sales dashboard, Bootstrap admin panel, stocks dashboard, crm admin dashboard, ecommerce admin panel, admin template, admin panel dashboard, course dashboard, template ecommerce website, dashboard hrm, admin dashboard">
    <!-- TITLE -->
    <title> Hana Rama Motor </title>
    <!-- BOOTSTRAP CSS -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- ICONS CSS -->
    <link
        rel="stylesheet"
        href="https://site-assets.fontawesome.com/releases/v6.4.2/css/all.css"
    >

    <link
        rel="stylesheet"
        href="https://site-assets.fontawesome.com/releases/v6.4.2/css/sharp-solid.css"
    >

    <link
        rel="stylesheet"
        href="https://site-assets.fontawesome.com/releases/v6.4.2/css/sharp-regular.css"
    >

    <link
        rel="stylesheet"
        href="https://site-assets.fontawesome.com/releases/v6.4.2/css/sharp-light.css"
    >
    <!-- STYLES CSS -->
    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet">
    <!-- MAIN JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <!-- NODE WAVES CSS -->
    <link href="{{ asset('assets/js/waves.css') }}" rel="stylesheet">
    <!-- SIMPLEBAR CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/simplebar.min.css') }}">
    <!-- COLOR PICKER CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/nano.min.css') }}">
    <!-- CHOICES CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/choices.min.css') }}">
    <!-- CHOICES JS -->
    <script src="{{ asset('assets/js/choices.min.js') }}"></script>
    <!-- JSVECTORMAP CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/jsvectormap.min.css') }}">

    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>

    <!-- DATA TABLES CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap5.min.css">

    <!-- SWEETALERTS CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/sweetalert2.min.css') }}">

    <!-- PRISM CSS -->
    <link rel="stylesheet" href="https://php.spruko.com/ynex/ynex/assets/libs/prismjs/themes/prism-coy.min.css">

    <!-- SELECT2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">

    @yield('css')
</head>

<body>

<!-- PAGE -->
<div class="page">

    <!-- HEADER -->

    <header class="app-header">

        <!-- Start::main-header-container -->
        <div class="main-header-container container-fluid">

            <!-- Start::header-content-left -->
            <div class="header-content-left">

                <!-- Start::header-element -->
                <div class="header-element">
                    <div class="horizontal-logo">
                        <a href="#" class="header-logo">
                            <img src="{{ asset('assets/images/logo.png') }}" alt="logo" class="desktop-logo">
                        </a>
                    </div>
                </div>
                <!-- End::header-element -->

                <!-- Start::header-element -->
                <div class="header-element">
                    <!-- Start::header-link -->
                    <a aria-label="Hide Sidebar" class="sidemenu-toggle header-link animated-arrow hor-toggle horizontal-navtoggle" data-bs-toggle="sidebar" href="javascript:void(0);"><span></span></a>
                    <!-- End::header-link -->
                </div>
                <!-- End::header-element -->

            </div>
            <!-- End::header-content-left -->

            <!-- Start::header-content-right -->
            <div class="header-content-right">

                <!-- Start::header-element -->
                <div class="header-element">
                    <!-- Start::header-link|dropdown-toggle -->
                    <a href="javascript:void(0);" class="header-link dropdown-toggle" id="mainHeaderProfile" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                        <div class="d-flex align-items-center">
                            <div class="me-sm-2 me-0">
                                <img src="https://php.spruko.com/ynex/ynex/assets/images/faces/9.jpg" alt="img" width="32" height="32" class="rounded-circle">
                            </div>
                            <div class="d-sm-block d-none">
                                <p class="fw-semibold mb-0 lh-1">{{ Session::get('data_user')->name }}</p>
                                <span class="op-7 fw-normal d-block fs-11">Admin Gudang</span>
                            </div>
                        </div>
                    </a>
                    <!-- End::header-link|dropdown-toggle -->
                    <ul class="main-header-dropdown dropdown-menu pt-0 overflow-hidden header-profile-dropdown dropdown-menu-end" aria-labelledby="mainHeaderProfile">
                        <li><a class="dropdown-item d-flex" href="{{ route('logout') }}"><i class="ti ti-logout fs-18 me-2 op-7"></i>Log Out</a></li>
                    </ul>
                </div>
                <!-- End::header-element -->

            </div>
            <!-- End::header-content-right -->

        </div>
        <!-- End::main-header-container -->

    </header>
    <!-- END HEADER -->

    <!-- SIDEBAR -->

    <aside class="app-sidebar sticky" id="sidebar">

        <!-- Start::main-sidebar-header -->
        <div class="main-sidebar-header">
            <a href="#" class="header-logo">
                <img src="{{ asset('assets/images/logo.jpeg') }}" alt="logo" height="80">
            </a>
        </div>
        <!-- End::main-sidebar-header -->

        <!-- Start::main-sidebar -->
        <div class="main-sidebar" id="sidebar-scroll">

            <!-- Start::nav -->
            <nav class="main-menu-container nav nav-pills flex-column sub-open">
                <div class="slide-left" id="slide-left">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path> </svg>
                </div>

                <ul class="main-menu">
                    <li class="slide__category"><span class="category-name">Main</span></li>
                    <li class="slide has-sub {{ $title == "dashboard utama" ? "open" : "" }} {{ $title == "dashboard oli" ? "open" : "" }} {{ $title == "dashboard ban" ? "open" : "" }} {{ $title == "dashboard sparepart" ? "open" : "" }}">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <div  style="width: 20px;">
                                <i class="fa-regular fa-house fa-lg"></i>
                            </div>
                            <span class="ms-3 side-menu__label">Dashboard</span>
                            <div style="width: 20px">
                                <i class="ms-3 fa-solid fa-chevron-right fa-sm"></i>
                            </div>
                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide {{ $title == "dashboard utama" ? "active" : "" }}">
                                <a href="{{ route('dashboard') }}" class="side-menu__item {{ $title == "dashboard utama" ? "active" : "" }}">Dashboard Utama</a>
                            </li>
                            <li class="slide {{ $title == "dashboard oli" ? "active" : "" }}">
                                <a href="{{ route('dashboard_oli') }}" class="side-menu__item {{ $title == "dashboard oli" ? "active" : "" }}">Dashboard Oli</a>
                            </li>
                            <li class="slide {{ $title == "dashboard ban" ? "active" : "" }}">
                                <a href="{{ route('dashboard_ban') }}" class="side-menu__item {{ $title == "dashboard ban" ? "active" : "" }}">Dashboard Ban</a>
                            </li>
                            <li class="slide {{ $title == "dashboard sparepart" ? "active" : "" }}">
                                <a href="{{ route('dashboard_sparepart') }}" class="side-menu__item {{ $title == "dashboard sparepart" ? "active" : "" }}">Dashboard Sparepart</a>
                            </li>
                        </ul>
                    </li>

                    <li class="slide__category"><span class="category-name">Barang</span></li>
                    <li class="slide">
                        <a href="{{ route('oli') }}" class="side-menu__item {{ $title == "oli" ? "active" : "" }}">
                            <div style="width: 20px;">
                                <i class="fa-regular fa-oil-can-drip fa-lg"></i>
                            </div>
                            <span class="ms-3 side-menu__label">Oli</span>
                        </a>
                    </li>
                    <li class="slide">
                        <a href="{{ route('ban') }}" class="side-menu__item {{ $title == "ban" ? "active" : "" }}">
                            <div style="width: 20px;">
                                <i class="fa-light fa-tire fa-lg"></i>
                            </div>
                            <span class="ms-3 side-menu__label">Ban</span>
                        </a>
                    </li>
                    <li class="slide">
                        <a href="{{ route('sparepart') }}" class="side-menu__item {{ $title == "sparepart" ? "active" : "" }}">
                            <div style="width: 20px;">
                                <i class="fa-light fa-gears fa-lg"></i>
                            </div>
                            <span class="ms-3 side-menu__label">Sparepart</span>
                        </a>
                    </li>
                    <li class="slide">
                        <a href="{{ route('barang_rusak') }}" class="side-menu__item {{ $title == "barang rusak" ? "active" : "" }}">
                            <div style="width: 20px;">
                                <i class="fa-sharp fa-regular fa-square-fragile fa-lg"></i>
                            </div>
                            <span class="ms-3 side-menu__label">Barang Rusak</span>
                        </a>
                    </li>

                    <li class="slide__category"><span class="category-name">Inbound</span></li>
                    <li class="slide">
                        <a href="{{ route('tambah_barang_baru') }}" class="side-menu__item {{ $title == "tambah barang baru" ? "active" : "" }}">
                            <div style="width: 20px;">
                                <i class="fa-regular fa-box fa-lg"></i>
                            </div>
                            <span class="ms-3 side-menu__label">Tambah Barang Baru</span>
                        </a>
                    </li>
                    <li class="slide">
                        <a href="{{ route('tambah_pembelian_barang') }}" class="side-menu__item {{ $title == "tambah stok barang" ? "active" : "" }}">
                            <div style="width: 20px;">
                                <i class="fa-regular fa-boxes-stacked fa-lg"></i>
                            </div>
                            <span class="ms-3 side-menu__label">Buat Pembelian</span>
                        </a>
                    </li>
                    <li class="slide">
                        <a href="{{ route('daftar_pembelian') }}" class="side-menu__item {{ $title == "daftar pembelian" ? "active" : "" }}">
                            <div style="width: 20px;">
                                <i class="fa-light fa-list-dropdown fa-lg"></i>
                            </div>
                            <span class="ms-3 side-menu__label">Daftar Pembelian</span>
                        </a>
                    </li>
                    <li class="slide">
                        <a href="{{ route('return_pembelian') }}" class="side-menu__item {{ $title == "return pembelian" ? "active" : "" }}">
                            <div style="width: 20px;">
                                <i class="fa-solid fa-arrow-rotate-left fa-lg"></i>
                            </div>
                            <span class="ms-3 side-menu__label">Pembelian Return</span>
                        </a>
                    </li>
                    <li class="slide">
                        <a href="{{ route('list_return_pembelian') }}" class="side-menu__item {{ $title == "list return pembelian" ? "active" : "" }}">
                            <div style="width: 20px;">
                                <i class="fa-light fa-square-list fa-lg"></i>
                            </div>
                            <span class="ms-3 side-menu__label">List Pembelian Return</span>
                        </a>
                    </li>

                    <li class="slide__category"><span class="category-name">Outbound</span></li>
                    <li class="slide">
                        <a href="{{ route('buat_transaksi') }}" class="side-menu__item {{ $title == "buat transaksi" ? "active" : "" }}">
                            <div style="width: 20px;">
                                <i class="fa-solid fa-right-from-bracket fa-lg"></i>
                            </div>
                            <span class="ms-3 side-menu__label">Tambah Transaksi</span>
                        </a>
                    </li>
                    <li class="slide">
                        <a href="{{ route('daftar_transaksi') }}" class="side-menu__item {{ $title == "daftar transaksi" ? "active" : "" }}">
                            <div style="width: 20px;">
                                <i class="fa-regular fa-notebook fa-lg"></i>
                            </div>
                            <span class="ms-3 side-menu__label">List Transaksi</span>
                        </a>
                    </li>
                    <li class="slide">
                        <a href="{{ route('return_transaksi') }}" class="side-menu__item {{ $title == "return transaksi" ? "active" : "" }}">
                            <div style="width: 20px;">
                                <i class="fa-solid fa-arrow-rotate-left fa-lg"></i>
                            </div>
                            <span class="ms-3 side-menu__label">Transaksi Return</span>
                        </a>
                    </li>
                    <li class="slide">
                        <a href="{{ route('buat_sampel_sales') }}" class="side-menu__item {{ $title == "buat sampel" ? "active" : "" }}">
                            <div style="width: 20px;">
                                <i class="fa-regular fa-person-carry-box fa-lg"></i>
                            </div>
                            <span class="ms-3 side-menu__label">Buat Sampel</span>
                        </a>
                    </li>
                    <li class="slide">
                        <a href="{{ route('list_sampel') }}" class="side-menu__item {{ $title == "list sampel" ? "active" : "" }}">
                            <div style="width: 20px;">
                                <i class="fa-regular fa-list-check fa-lg"></i>
                            </div>
                            <span class="ms-3 side-menu__label">List Sampel</span>
                        </a>
                    </li>
                    <li class="slide">
                        <a href="{{ route('return_sampel') }}" class="side-menu__item {{ $title == "return sampel" ? "active" : "" }}">
                            <div style="width: 20px;">
                                <i class="fa-regular fa-box-circle-check fa-lg"></i>
                            </div>
                            <span class="ms-3 side-menu__label">Return Sampel</span>
                        </a>
                    </li>
                    <li class="slide has-sub {{ $title == "ambil barang" ? "open" : "" }} {{ $title == "sisa barang" ? "open" : "" }} {{ $title == "buat transaksi alif" ? "open" : "" }}">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <div  style="width: 20px;">
                                <i class="fa-regular fa-tag fa-lg"></i>
                            </div>
                            <span class="ms-3 side-menu__label">Transaksi Khusus</span>
                            <div style="width: 20px">
                                <i class="ms-3 fa-solid fa-chevron-right fa-sm"></i>
                            </div>
                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide {{ $title == "ambil barang" ? "active" : "" }}">
                                <a href="{{ route('pengambilan_barang') }}" class="side-menu__item {{ $title == "ambil barang" ? "active" : "" }}">Ambil Barang</a>
                            </li>
                            <li class="slide {{ $title == "sisa barang" ? "active" : "" }}">
                                <a href="{{ route('sisa_barang') }}" class="side-menu__item {{ $title == "sisa barang" ? "active" : "" }}">Daftar Pengambilan</a>
                            </li>
                            <li class="slide {{ $title == "buat transaksi alif" ? "active" : "" }}">
                                <a href="{{ route('transaksi_khusus_alif') }}" class="side-menu__item {{ $title == "buat transaksi alif" ? "active" : "" }}">Transaksi Khusus Alif</a>
                            </li>
                        </ul>
                    </li>

                    <li class="slide__category"><span class="category-name">Laporan</span></li>
                    <li class="slide has-sub {{ $title == "laporan transaksi" ? "open" : "" }}">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <div  style="width: 20px;">
                                <i class="fa-regular fa-calendar-lines fa-lg"></i>
                            </div>
                            <span class="ms-3 side-menu__label">Laporan Transaksi</span>
                            <div style="width: 20px">
                                <i class="ms-3 fa-solid fa-chevron-right fa-sm"></i>
                            </div>
                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide {{ $title == "laporan transaksi" ? "active" : "" }}">
                                <a href="{{ route('laporan_transaksi') }}" class="side-menu__item {{ $title == "laporan transaksi" ? "active" : "" }}">Laporan Transaksi</a>
                            </li>
                            <li class="slide">
                                <a href="#" class="side-menu__item">Laporan Oli</a>
                            </li>
                            <li class="slide">
                                <a href="#" class="side-menu__item">Laporan Ban</a>
                            </li>
                            <li class="slide">
                                <a href="#" class="side-menu__item">Laporan Sparepart</a>
                            </li>
                        </ul>
                    </li>

                    <li class="slide__category"><span class="category-name">Lain - Lain</span></li>
                    <li class="slide">
                        <a href="{{ route('absen') }}" class="side-menu__item {{ $title == "absen" ? "active" : "" }}">
                            <div style="width: 20px;">
                                <i class="fa-regular fa-person-to-door fa-lg"></i>
                            </div>
                            <span class="ms-3 side-menu__label">Absen Sales</span>
                        </a>
                    </li>
                    <li class="slide">
                        <a href="{{ route('pelanggan') }}" class="side-menu__item {{ $title == "pelanggan" ? "active" : "" }}">
                            <div style="width: 20px;">
                                <i class="fa-light fa-users fa-lg"></i>
                            </div>
                            <span class="ms-3 side-menu__label">Pelanggan</span>
                        </a>
                    </li>
                    <li class="slide">
                        <a href="{{ route('supplier') }}" class="side-menu__item {{ $title == "supplier" ? "active" : "" }}">
                            <div style="width: 20px;">
                                <i class="fa-regular fa-shop fa-lg"></i>
                            </div>
                            <span class="ms-3 side-menu__label">Supplier</span>
                        </a>
                    </li>
                    <li class="slide">
                        <a href="{{ route('sales') }}" class="side-menu__item {{ $title == "sales" ? "active" : "" }}">
                            <div style="width: 20px;">
                                <i class="fa-regular fa-user-helmet-safety fa-lg"></i>
                            </div>
                            <span class="ms-3 side-menu__label">Sales</span>
                        </a>
                    </li>
                    <li class="slide">
                        <a href="#" class="side-menu__item">
                            <div style="width: 20px;">
                                <i class="fa-regular fa-wallet fa-lg"></i>
                            </div>
                            <span class="ms-3 side-menu__label">Biaya Lainnya</span>
                        </a>
                    </li>
                </ul>
                <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path> </svg></div>
            </nav>
            <!-- End::nav -->

        </div>
        <!-- End::main-sidebar -->

    </aside>


    <!-- END SIDEBAR -->

    <!-- MAIN-CONTENT -->

    <div class="main-content app-content">


        <div class="container-fluid">

        @yield('konten')

        </div>


    </div>
    <!-- END MAIN-CONTENT -->

    <footer class="footer mt-auto py-3 bg-white text-center">
        <div class="container">
                    <span class="text-muted"> Copyright © <span id="year"></span> <a
                            href="javascript:void(0);" class="text-dark fw-semibold">Hana Rama Motor</a>
                    </span>
        </div>
    </footer>
    <!-- END FOOTER -->

</div>
<!-- END PAGE-->

<!-- SCRIPTS -->


<!-- SCROLL-TO-TOP -->
<div class="scrollToTop">
    <span class="arrow"><i class="ri-arrow-up-s-fill fs-20"></i></span>
</div>
<div id="responsive-overlay"></div>

<!-- POPPER JS -->
<script src="{{ asset('assets/js/popper.min.js') }}"></script>

<!-- BOOTSTRAP JS -->
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

<!-- NODE WAVES JS -->
<script src="{{ asset('assets/js/waves.min.js') }}"></script>

<!-- SIMPLEBAR JS -->
<script src="{{ asset('assets/js/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/js/simplebar.js') }}"></script>

<!-- COLOR PICKER JS -->
<script src="{{ asset('assets/js/pickr.es5.min.js') }}"></script>

<!-- DEFAULTMENU JS -->
<script src="{{ asset('assets/js/defaultmenu.js') }}"></script>

<!-- APEX CHARTS JS -->
{{--<script src="{{ asset('assets/js/apexcharts.min.js') }}"></script>--}}

<!-- JSVECTOR MAPS JS -->
<script src="{{ asset('assets/js/jsvectormap.min.js') }}"></script>

<!-- JSVECTOR MAPS WORLD JS -->
<script src="{{ asset('assets/js/world-merc.js') }}"></script>

<!-- DATE & TIME PICKER JS -->
<script src="{{ asset('assets/js/flatpickr.min.js') }}"></script>

<!-- SALES-DASHNBOARD JS -->
<script src="{{ asset('assets/js/sales-dashboard.js') }}"></script>


<!-- STICKY JS -->
<script src="{{ asset('assets/js/sticky.js') }}"></script>

<!-- CUSTOM JS -->
<script src="{{ asset('assets/js/custom.js') }}"></script>

<!-- CUSTOM-SWITCHER JS -->
<script src="{{ asset('assets/js/switcher.js') }}"></script>

<!-- JQUERY JS -->
<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

<!-- DATATABLES CDN JS -->
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.6/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<script src="{{ asset('assets/js/datatable.js') }}"></script>

<!-- SWEETALERTS JS -->
<script src="{{ asset('assets/js/sweetalert2.min.js') }}"></script>

<!-- PRISM JS -->
<script src="https://php.spruko.com/ynex/ynex/assets/libs/prismjs/prism.js"></script>
<script src="https://php.spruko.com/ynex/ynex/assets/js/prism-custom.js"></script>

<!-- SELECT2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

@if($alert = Session::get('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '{{ $alert }}',
        })
    </script>
@endif

@if($alert = Session::get('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: '{{ $alert }}',
        })
    </script>
@endif

@yield('js')

<!-- END SCRIPTS -->

</body>
</html>
