@extends('layout');
@section('konten')
    <!-- Page Header -->
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">Dashboard Utama</h1>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboards</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Sales</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header Close -->

    <!-- Start::row-1 -->
    <div class="row">
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 pe-0">
                            <p class="mb-2">
                                <span class="fs-16">Jumlah Penjualan</span>
                            </p>
                            <p class="mb-2 fs-12">
                                <span class="fs-25 fw-semibold lh-1 vertical-bottom mb-0">{{ $jumlahPenjualan }}</span>
                                <span class="d-block fs-10 fw-semibold text-muted">Bulan {{ getBulan() }}</span>
                            </p>
                            <a href="{{ route('daftar_transaksi') }}" class="fs-12 mb-0 text-primary">Lihat Detail<i class="ti ti-chevron-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 pe-0">
                            <p class="mb-2">
                                <span class="fs-16">Total Pendapatan Bersih</span>
                            </p>
                            <p class="mb-2 fs-12">
                                <span class="fs-25 fw-semibold lh-1 vertical-bottom mb-0">@currency($pendapatanBersih)</span>
                                <span class="d-block fs-10 fw-semibold text-muted">Pendapatan Bulan {{ getBulan() }}</span>
                            </p>
                            <a href="javascript:void(0);" class="fs-12 mb-0 text-primary">Lihat Detail Pendapatan<i class="ti ti-chevron-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 pe-0">
                            <p class="mb-2">
                                <span class="fs-16">Total Pendapatan Kotor</span>
                            </p>
                            <p class="mb-2 fs-12">
                                <span class="fs-25 fw-semibold lh-1 vertical-bottom mb-0">@currency($pendapatanKotor)</span>
                                <span class="d-block fs-10 fw-semibold text-muted">Pendapatan Bulan {{ getBulan() }}</span>
                            </p>
                            <a href="javascript:void(0);" class="fs-12 mb-0 text-primary">Lihat Detail Pendapatan<i class="ti ti-chevron-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 pe-0">
                            <p class="mb-2">
                                <span class="fs-16">Total Piutang</span>
                            </p>
                            <p class="mb-2 fs-12">
                                <span class="fs-25 fw-semibold lh-1 vertical-bottom mb-0">@currency($totalPiutang)</span>
                                <span class="d-block fs-10 fw-semibold text-muted">Piutang Bulan {{ getBulan() }}</span>
                            </p>
                            <a href="javascript:void(0);" class="fs-12 mb-0 text-primary">Lihat Detail Piutang<i class="ti ti-chevron-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End::row-1 -->

    <!-- Start::row-2 -->
    <div class="row">
        <div class="col-xxl-3 col-xl-12">
            <div class="card custom-card recent-transactions-card overflow-hidden">
                <div class="card-header justify-content-between">
                    <div class="card-title">Stok Barang Minimal </div>
                </div>
                <div class="card-body p-0">
                    <div class="list-group">
                        @foreach($stokMinimal as $m)
                            <a href="javascript:void(0);" class="border-0">
                                <div class="list-group-item border-0">
                                    <div class="d-flex align-items-start">
{{--                                    @if($m->barang->kategori_id == 1)--}}
{{--                                            <span class="tansaction-icon bg-primary">--}}
{{--                                                <svg xmlns="http://www.w3.org/2000/svg" class="svg-white" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><g><rect fill="none" height="24" width="24"/><path d="M18,6h-2c0-2.21-1.79-4-4-4S8,3.79,8,6H6C4.9,6,4,6.9,4,8v12c0,1.1,0.9,2,2,2h12c1.1,0,2-0.9,2-2V8C20,6.9,19.1,6,18,6z M12,4c1.1,0,2,0.9,2,2h-4C10,4.9,10.9,4,12,4z M18,20H6V8h2v2c0,0.55,0.45,1,1,1s1-0.45,1-1V8h4v2c0,0.55,0.45,1,1,1s1-0.45,1-1V8 h2V20z"/></g></svg>--}}
{{--                                            </span>--}}
{{--                                    @elseif($m->barang->kategori_id == 2)--}}
{{--                                            <span class="tansaction-icon bg-info">--}}
{{--                                                <svg xmlns="http://www.w3.org/2000/svg" class="svg-white" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><g><rect fill="none" height="24" width="24"/></g><g><g><path d="M20,2H4C3,2,2,2.9,2,4v3.01C2,7.73,2.43,8.35,3,8.7V20c0,1.1,1.1,2,2,2h14c0.9,0,2-0.9,2-2V8.7c0.57-0.35,1-0.97,1-1.69V4 C22,2.9,21,2,20,2z M19,20H5V9h14V20z M20,7H4V4h16V7z"/><rect height="2" width="6" x="9" y="12"/></g></g></svg>--}}
{{--                                            </span>--}}
{{--                                    @else--}}
{{--                                            <span class="tansaction-icon bg-warning">--}}
{{--                                                <svg xmlns="http://www.w3.org/2000/svg" class="svg-white" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2zm-1.45-5c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.37-.66-.11-1.48-.87-1.48H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6z"/></svg>--}}
{{--                                            </span>--}}
{{--                                    @endif--}}
                                        <div class="w-100">
                                            <div class="d-flex align-items-top justify-content-between">
                                                <div class="mt-0">
                                                    <p class="mb-0 fw-semibold"><span class="me-3">{{ $m->barang->nama_barang }}</span></p>
                                                    <span class="mb-0 fs-12 text-muted">SKU </span>
                                                </div>
                                                <div class="text-muted fs-12 text-center"></div>
                                                <span class="ms-auto">
                                                <span class="text-end fw-semibold d-block">
                                                    {{ $m->stok }} Pcs
                                                </span>
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-12 col-md-6 col-xxl-6 col-xl-8">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">
                        Sales Overview
                    </div>
                    <a aria-label="anchor" href="javascript:void(0);"  class="btn btn-icon btn-sm btn-light ms-auto" data-bs-toggle="dropdown">
                        <i class="fe fe-more-vertical"></i>
                    </a>
                    <div class="dropdown">
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="javascript:void(0);">Download</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0);">Import</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0);">Export</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div id="salesOverview"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-12 col-md-6 col-xxl-3 col-xl-4">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">Activities</div>
                    <div class="dropdown">
                        <a href="javascript:void(0);"  class="p-2 fs-12 text-muted" data-bs-toggle="dropdown">
                            View All<i class="ri-arrow-down-s-line align-middle ms-1 d-inline-block"></i>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a class="dropdown-item" href="javascript:void(0);">Download</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0);">Import</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0);">Export</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body mt-0 latest-timeline" id="latest-timeline">
                    <ul class="timeline-main mb-0 list-unstyled">
                        <li>
                            <div class="featured_icon1 featured-danger"></div>
                        </li>
                        <li class="mt-0 activity">
                            <a href="javascript:void(0);" class="fs-12">
                                <p class="mb-0"><span class="fw-semibold">#Anita</span> <span class="ms-2 fs-12">Lorem ipsum dolor, sit amet consectetur adipisicing  .</span></p>
                            </a>
                            <small class="text-muted mt-0 mb-0 fs-10">12 mins ago.</small>
                        </li>
                        <li>
                            <div class="featured_icon1 featured-success"> </div>
                        </li>
                        <li class="mt-0 activity">
                            <a href="javascript:void(0);" class="fs-12">
                                <p class="mb-0"><span class="me-2 fs-12">New Product reveived.</span><span class="fw-semibold">#FX-321</span> </p>
                            </a>
                            <small class="text-muted mt-0 mb-0 fs-10">28 mins ago.</small>
                        </li>
                        <li>
                            <div class="featured_icon1 featured-danger"></div>
                        </li>
                        <li class="mt-0 activity">
                            <div class="fs-12">
                                <p class="mb-0">
                                    <span class="fw-semibold text-primary">#Zlatan</span>
                                    <span class="ms-2 fs-12">shared a page.
                                                        <a href="https://themeforest.net/user/spruko/portfolio" target="_blank" class="text-success underlined fs-11">https://themeforest.net/user/spruko/portfolio</a>
                                                    </span>
                                </p>
                            </div>
                            <small class="text-muted mt-0 mb-0 fs-10">37 mins ago.</small>
                        </li>
                        <li>
                            <div class="featured_icon1 featured-success"></div>
                        </li>
                        <li class="mt-0 activity">
                            <div class="fs-12">
                                <p class="mb-0"><span class="fw-semibold text-primary">#Hussain</span> <span class="ms-2 fs-12">shared a file. </span></p>
                                <small class="text-muted mt-0 mb-0 fs-10">1 day ago.</small>
                                <p class="p-1 border border-dotted wp-50 br-5 mb-0">
                                    <a href="javascript:void(0);">
                                        <span class="badge bg-success text-fixed-white me-2">PPT</span> <span class="fs-11">Project_discussion</span>
                                    </a>
                                </p>
                            </div>
                        </li>
                        <li>
                            <div class="featured_icon1 featured-danger"></div>
                        </li>
                        <li class="mt-0 activity">
                            <a href="javascript:void(0);" class="fs-12">
                                <p class="mb-0">
                                    <span class="fw-semibold">#Emiley</span>
                                    <span class="ms-2 fs-12">Lorem ipsum dolor, sit amet consectetur adipisicing ipsum dolor...</span>
                                    <span class="fw-semibold ms-2">More</span>
                                </p>
                            </a>
                            <small class="text-muted mt-0 mb-0 fs-10">14 Mar 2022.</small>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End::row-2 -->

    <!-- Start::row-3 -->
    <div class="row">
        <div class="col-xxl-6 col-xl-12 col-md-12">
            <div class="card custom-card">
                <div class="card-header d-sm-flex d-block">
                    <div class="card-title">Task List</div>
                    <div class="tab-menu-heading border-0 p-0 ms-auto mt-sm-0 mt-2">
                        <div class="tabs-menu-task me-3">
                            <ul class="nav nav-tabs panel-tabs-task border-0" role="tablist">
                                <li><a href="javascript:void(0);" class="me-1 active" data-bs-toggle="tab" data-bs-target="#Active" role="tab" aria-selected="true">Active Tasks</a></li>
                                <li><a href="javascript:void(0);" data-bs-toggle="tab" data-bs-target="#Complete" role="tab" aria-selected="false">Completed Tasks</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="mt-sm-0 mt-2">
                        <button type="button" class="btn btn-sm btn-light align-items-center d-inline-flex"><i class="ti ti-plus me-1 fw-semibold"></i>Add Task</button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="tab-content p-0">
                        <div class="tab-pane active p-0 border-0" id="Active">
                            <div class="table-responsive">
                                <table class="table text-nowrap table-hover">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="text-center">
                                                                <span>
                                                                    <input class="form-check-input" type="checkbox" id="checkAll" value="" aria-label="...">
                                                                </span>
                                        </th>
                                        <th scope="col">Task details</th>
                                        <th scope="col">Assigned date</th>
                                        <th scope="col">Target</th>
                                        <th scope="col">Assigned to</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="text-center">
                                                                <span>
                                                                    <input class="form-check-input" type="checkbox" id="check1" value="" aria-label="...">
                                                                </span>
                                        </td>
                                        <td>Design task page for new template</td>
                                        <td class="text-muted">12.43pm</td>
                                        <td><span class="badge bg-primary">Today</span></td>
                                        <td>
                                            <div class="avatar-list-stacked mb-0">
                                                                    <span class="avatar avatar-xs">
                                                                        <img src="https://php.spruko.com/ynex/ynex/assets/images/faces/2.jpg" alt="img">
                                                                    </span>
                                                <span class="avatar avatar-xs">
                                                                        <img src="https://php.spruko.com/ynex/ynex/assets/images/faces/8.jpg" alt="img">
                                                                    </span>
                                                <span class="avatar avatar-xs">
                                                                        <img src="https://php.spruko.com/ynex/ynex/assets/images/faces/2.jpg" alt="img">
                                                                    </span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                                                <span>
                                                                    <input class="form-check-input" type="checkbox" id="check2" value="" aria-label="..." checked>
                                                                </span>
                                        </td>
                                        <td>Solve UI issues in new template</td>
                                        <td class="text-muted">11.25am</td>
                                        <td><span class="badge bg-secondary">Tomorrow</span></td>
                                        <td>
                                            <div class="avatar-list-stacked mb-0">
                                                                    <span class="avatar avatar-xs">
                                                                        <img src="https://php.spruko.com/ynex/ynex/assets/images/faces/6.jpg" alt="img">
                                                                    </span>
                                                <span class="avatar avatar-xs">
                                                                        <img src="https://php.spruko.com/ynex/ynex/assets/images/faces/9.jpg" alt="img">
                                                                    </span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                                                <span>
                                                                    <input class="form-check-input" type="checkbox" id="check3" value="" aria-label="...">
                                                                </span>
                                        </td>
                                        <td>prepare pre requisites</td>
                                        <td class="text-muted">9.56am</td>
                                        <td><span class="badge bg-primary">Today</span></td>
                                        <td>
                                            <div class="avatar-list-stacked mb-0">
                                                                    <span class="avatar avatar-xs">
                                                                        <img src="https://php.spruko.com/ynex/ynex/assets/images/faces/3.jpg" alt="img">
                                                                    </span>
                                                <span class="avatar avatar-xs">
                                                                        <img src="https://php.spruko.com/ynex/ynex/assets/images/faces/5.jpg" alt="img">
                                                                    </span>
                                                <span class="avatar avatar-xs">
                                                                        <img src="https://php.spruko.com/ynex/ynex/assets/images/faces/10.jpg" alt="img">
                                                                    </span>
                                                <span class="avatar avatar-xs">
                                                                        <img src="https://php.spruko.com/ynex/ynex/assets/images/faces/15.jpg" alt="img">
                                                                    </span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                                                <span>
                                                                    <input class="form-check-input" type="checkbox" id="check4" value="" aria-label="...">
                                                                </span>
                                        </td>
                                        <td>Change total styles od that dashboard</td>
                                        <td class="text-muted">8.15am</td>
                                        <td><span class="badge bg-primary">Today</span></td>
                                        <td>
                                            <div class="avatar-list-stacked mb-0">
                                                                    <span class="avatar avatar-xs">
                                                                        <img src="https://php.spruko.com/ynex/ynex/assets/images/faces/11.jpg" alt="img">
                                                                    </span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                                                <span>
                                                                    <input class="form-check-input" type="checkbox" id="check5" value="" aria-label="...">
                                                                </span>
                                        </td>
                                        <td>Update color theme</td>
                                        <td class="text-muted">4.20pm</td>
                                        <td><span class="badge bg-secondary">Tomorrow</span></td>
                                        <td>
                                            <div class="avatar-list-stacked mb-0">
                                                                    <span class="avatar avatar-xs">
                                                                        <img src="https://php.spruko.com/ynex/ynex/assets/images/faces/13.jpg" alt="img">
                                                                    </span>
                                                <span class="avatar avatar-xs">
                                                                        <img src="https://php.spruko.com/ynex/ynex/assets/images/faces/16.jpg" alt="img">
                                                                    </span>
                                                <span class="avatar avatar-xs">
                                                                        <img src="https://php.spruko.com/ynex/ynex/assets/images/faces/8.jpg" alt="img">
                                                                    </span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                                                <span>
                                                                    <input class="form-check-input" type="checkbox" id="check11" value="" aria-label="...">
                                                                </span>
                                        </td>
                                        <td>New dashboard design update</td>
                                        <td class="text-muted">8.29am</td>
                                        <td><span class="badge bg-primary">Today</span></td>
                                        <td>
                                            <div class="avatar-list-stacked mb-0">
                                                                    <span class="avatar avatar-xs">
                                                                        <img src="https://php.spruko.com/ynex/ynex/assets/images/faces/10.jpg" alt="img">
                                                                    </span>
                                                <span class="avatar avatar-xs">
                                                                        <img src="https://php.spruko.com/ynex/ynex/assets/images/faces/5.jpg" alt="img">
                                                                    </span>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane p-0 border-0" id="Complete">
                            <div class="table-responsive">
                                <table class="table text-nowrap table-hover">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="text-center">
                                                                <span>
                                                                    <input class="form-check-input" type="checkbox" id="checkAll1" value="" aria-label="...">
                                                                </span>
                                        </th>
                                        <th scope="col">Task details</th>
                                        <th scope="col">Assigned date</th>
                                        <th scope="col">Completed</th>
                                        <th scope="col">Assigned to</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="text-center">
                                                                <span>
                                                                    <input class="form-check-input" type="checkbox" id="check6" value="" aria-label="...">
                                                                </span>
                                        </td>
                                        <td>New landing page ui update</td>
                                        <td class="text-muted">24 Nov 2022</td>
                                        <td><span class="badge bg-success">4 hrs ago</span></td>
                                        <td>
                                            <div class="avatar-list-stacked mb-0">
                                                                    <span class="avatar avatar-xs">
                                                                        <img src="https://php.spruko.com/ynex/ynex/assets/images/faces/5.jpg" alt="img">
                                                                    </span>
                                                <span class="avatar avatar-xs">
                                                                        <img src="https://php.spruko.com/ynex/ynex/assets/images/faces/9.jpg" alt="img">
                                                                    </span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                                                <span>
                                                                    <input class="form-check-input" type="checkbox" id="check7" value="" aria-label="...">
                                                                </span>
                                        </td>
                                        <td>Job portal dashboard redesign</td>
                                        <td class="text-muted">30 Nov 2022</td>
                                        <td><span class="badge bg-success">Today</span></td>
                                        <td>
                                            <div class="avatar-list-stacked mb-0">
                                                                    <span class="avatar avatar-xs">
                                                                        <img src="https://php.spruko.com/ynex/ynex/assets/images/faces/11.jpg" alt="img">
                                                                    </span>
                                                <span class="avatar avatar-xs">
                                                                        <img src="https://php.spruko.com/ynex/ynex/assets/images/faces/12.jpg" alt="img">
                                                                    </span>
                                                <span class="avatar avatar-xs">
                                                                        <img src="https://php.spruko.com/ynex/ynex/assets/images/faces/13.jpg" alt="img">
                                                                    </span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                                                <span>
                                                                    <input class="form-check-input" type="checkbox" id="check8" value="" aria-label="...">
                                                                </span>
                                        </td>
                                        <td>New template layout update</td>
                                        <td class="text-muted">11 Dec 2022</td>
                                        <td><span class="badge bg-success">Yesterday</span></td>
                                        <td>
                                            <div class="avatar-list-stacked mb-0">
                                                                    <span class="avatar avatar-xs">
                                                                        <img src="https://php.spruko.com/ynex/ynex/assets/images/faces/4.jpg" alt="img">
                                                                    </span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                                                <span>
                                                                    <input class="form-check-input" type="checkbox" id="check29" value="" aria-label="...">
                                                                </span>
                                        </td>
                                        <td>All dashboard licenses page update</td>
                                        <td class="text-muted">6 Dec 2022</td>
                                        <td><span class="badge bg-success">Yesterday</span></td>
                                        <td>
                                            <div class="avatar-list-stacked mb-0">
                                                                    <span class="avatar avatar-xs">
                                                                        <img src="https://php.spruko.com/ynex/ynex/assets/images/faces/1.jpg" alt="img">
                                                                    </span>
                                                <span class="avatar avatar-xs">
                                                                        <img src="https://php.spruko.com/ynex/ynex/assets/images/faces/2.jpg" alt="img">
                                                                    </span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                                                <span>
                                                                    <input class="form-check-input" type="checkbox" id="check19" value="" aria-label="...">
                                                                </span>
                                        </td>
                                        <td>Update color theme of ynex template</td>
                                        <td class="text-muted">8 Dec 2022</td>
                                        <td><span class="badge bg-success">Yesterday</span></td>
                                        <td>
                                            <div class="avatar-list-stacked mb-0">
                                                                    <span class="avatar avatar-xs">
                                                                        <img src="https://php.spruko.com/ynex/ynex/assets/images/faces/5.jpg" alt="img">
                                                                    </span>
                                                <span class="avatar avatar-xs">
                                                                        <img src="https://php.spruko.com/ynex/ynex/assets/images/faces/3.jpg" alt="img">
                                                                    </span>
                                                <span class="avatar avatar-xs">
                                                                        <img src="https://php.spruko.com/ynex/ynex/assets/images/faces/11.jpg" alt="img">
                                                                    </span>
                                                <span class="avatar avatar-xs">
                                                                        <img src="https://php.spruko.com/ynex/ynex/assets/images/faces/12.jpg" alt="img">
                                                                    </span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                                                <span>
                                                                    <input class="form-check-input" type="checkbox" id="check9" value="" aria-label="...">
                                                                </span>
                                        </td>
                                        <td>New pages list noted</td>
                                        <td class="text-muted">21 Dec 2022</td>
                                        <td><span class="badge bg-success">Today</span></td>
                                        <td>
                                            <div class="avatar-list-stacked mb-0">
                                                                    <span class="avatar avatar-xs">
                                                                        <img src="https://php.spruko.com/ynex/ynex/assets/images/faces/1.jpg" alt="img">
                                                                    </span>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer border-top-0">
                    <div class="d-flex flex-wrap align-items-center justify-content-between">
                        <div>
                            <div class="d-flex align-items-center">
                                <div>
                                    Showing 6 Entries
                                </div>
                                <div class="transform-arrow ms-2">
                                    <i class="bi bi-arrow-right fw-semibold"></i>
                                </div>
                            </div>
                        </div>
                        <div>
                            <nav aria-label="Page navigation" class="pagination-style-4">
                                <ul class="pagination mb-0">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="javascript:void(0);">
                                            Prev
                                        </a>
                                    </li>
                                    <li class="page-item active"><a class="page-link" href="javascript:void(0);">1</a></li>
                                    <li class="page-item"><a class="page-link" href="javascript:void(0);">2</a></li>
                                    <li class="page-item">
                                        <a class="page-link text-primary" href="javascript:void(0);">
                                            next
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-6 col-xl-12 col-md-12">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Visitors By Countries
                    </div>
                    <div class="dropdown">
                        <a aria-label="anchor" href="javascript:void(0);" class="btn btn-icon btn-sm btn-light" data-bs-toggle="dropdown">
                            <i class="fe fe-more-vertical"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="javascript:void(0);">Action</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0);">Another action</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0);">Something else here</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="row g-0">
                        <div class="col-xxl-4 col-xl-12 sales-visitors-countries">
                            <div class="mt-2">
                                <ul class="list-unstyled p-4 my-auto">
                                    <li class="mb-3">
                                        <span class="fs-12"><i class="ri-checkbox-blank-circle-fill align-middle me-2 d-inline-block text-primary"></i>Usa</span><span class="fw-semibold float-end">3,201</span>
                                    </li>
                                    <li class="mb-3">
                                        <span class="fs-12"><i class="ri-checkbox-blank-circle-fill align-middle me-2 d-inline-block text-secondary"></i>India</span><span class="fw-semibold float-end">2,345</span>
                                    </li>
                                    <li class="mb-3">
                                        <span class="fs-12"><i class="ri-checkbox-blank-circle-fill align-middle me-2 d-inline-block text-danger"></i>Vatican City</span><span class="fw-semibold float-end">106</span>
                                    </li>
                                    <li class="mb-3">
                                        <span class="fs-12"><i class="ri-checkbox-blank-circle-fill align-middle me-2 d-inline-block text-info"></i>Canada</span><span class="fw-semibold float-end">2,857</span>
                                    </li>
                                    <li class="mb-3">
                                        <span class="fs-12"><i class="ri-checkbox-blank-circle-fill align-middle me-2 d-inline-block text-orange"></i>Mauritius</span><span class="fw-semibold float-end">169</span>
                                    </li>
                                    <li class="mb-3">
                                        <span class="fs-12"><i class="ri-checkbox-blank-circle-fill align-middle me-2 d-inline-block text-warning"></i>Singapore</span><span class="fw-semibold float-end">1,950</span>
                                    </li>
                                    <li class="mb-3">
                                        <span class="fs-12"><i class="ri-checkbox-blank-circle-fill align-middle me-2 d-inline-block text-success"></i>Palau</span><span class="fw-semibold float-end">224</span>
                                    </li>
                                    <li class="mb-3">
                                        <span class="fs-12"><i class="ri-checkbox-blank-circle-fill align-middle me-2 d-inline-block text-pink"></i>Maldives</span><span class="fw-semibold float-end">147</span>
                                    </li>
                                    <li class="mb-0">
                                        <span class="fs-12"><i class="ri-checkbox-blank-circle-fill align-middle me-2 d-inline-block"></i>São Tomé and Príncipe</span><span class="fw-semibold float-end">182</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xxl-8 col-xl-12 text-center">
                            <div id="visitors-countries"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End::row-3 -->

    <!-- Start:: row-4 -->
    <div class="row">
        <div class="col-xxl-3 col-xl-6">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">Customers</div>
                    <div class="dropdown">
                        <a href="javascript:void(0);"  class="p-2 fs-12 text-muted" data-bs-toggle="dropdown">
                            View All<i class="ri-arrow-down-s-line align-middle ms-1 d-inline-block"></i>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a class="dropdown-item" href="javascript:void(0);">Download</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0);">Import</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0);">Export</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body p-0 customers">
                    <ul class="list-group my-2">
                        <li class="list-group-item border-0">
                            <a href="javascript:void(0);" class="border-0">
                                <div class="d-flex align-items-top">
                                    <img class="avatar avatar-md me-3 my-auto" src="https://php.spruko.com/ynex/ynex/assets/images/faces/2.jpg" alt="Image description">
                                    <div class="mt-0">
                                        <p class="mb-1 fw-semibold">Samantha Melon</p>
                                        <p class="mb-0 fs-11 text-success">User ID: #1234</p>
                                    </div>
                                    <span class="ms-auto fs-12">
                                                        <span class="float-end text-muted fw-semibold">11.43am</span>
                                                    </span>
                                </div>
                            </a>
                        </li>
                        <li class="list-group-item border-0 mb-2">
                            <a href="javascript:void(0);" class="border-0">
                                <div class="d-flex align-items-top">
                                    <img class="avatar avatar-md me-3 my-auto" src="https://php.spruko.com/ynex/ynex/assets/images/faces/1.jpg" alt="Image description">
                                    <div class="mt-0">
                                        <p class="mb-1 fw-semibold">Allie Grater</p>
                                        <p class="mb-0 fs-11 text-success">User ID: #3432</p>
                                    </div>
                                    <span class="ms-auto fs-12">
                                                        <span class="float-end text-muted fw-semibold">12.35pm</span>
                                                    </span>
                                </div>
                            </a>
                        </li>
                        <li class="list-group-item border-0 mb-2">
                            <a href="javascript:void(0);" class="border-0">
                                <div class="d-flex align-items-top">
                                    <img class="avatar avatar-md me-3 my-auto" src="https://php.spruko.com/ynex/ynex/assets/images/faces/5.jpg" alt="Image description">
                                    <div class="mt-0">
                                        <p class="mb-1 fw-semibold">Gabe Lackmen</p>
                                        <p class="mb-0 fs-11 text-success">User ID: #2312</p>
                                    </div>
                                    <span class="ms-auto fs-12">
                                                        <span class="float-end text-muted fw-semibold">Yeserday</span>
                                                    </span>
                                </div>
                            </a>
                        </li>
                        <li class="list-group-item border-0 mb-2">
                            <a href="javascript:void(0);" class="border-0">
                                <div class="d-flex align-items-top">
                                    <img class="avatar avatar-md me-3 my-auto" src="https://php.spruko.com/ynex/ynex/assets/images/faces/7.jpg" alt="Image description">
                                    <div class="mt-0">
                                        <p class="mb-1 fw-semibold">Manuel Labor</p>
                                        <p class="mb-0 fs-11 text-success">User ID: #4231</p>
                                    </div>
                                    <span class="ms-auto fs-12">
                                                        <span class="float-end text-muted fw-semibold">24 Mar 2022</span>
                                                    </span>
                                </div>
                            </a>
                        </li>
                        <li class="list-group-item border-0 mb-2">
                            <a href="javascript:void(0);" class="border-0">
                                <div class="d-flex align-items-top">
                                    <img class="avatar avatar-md me-3 my-auto" src="https://php.spruko.com/ynex/ynex/assets/images/faces/9.jpg" alt="Image description">
                                    <div class="mt-0">
                                        <p class="mb-1 fw-semibold">Hercules Bing</p>
                                        <p class="mb-0 fs-11 text-success">User ID: #1754</p>
                                    </div>
                                    <span class="ms-auto fs-12">
                                                        <span class="float-end text-muted fw-semibold">18 Mar 2022</span>
                                                    </span>
                                </div>
                            </a>
                        </li>
                        <li class="list-group-item border-0">
                            <a href="javascript:void(0);" class="border-0">
                                <div class="d-flex align-items-top">
                                    <img class="avatar avatar-md me-3 my-auto" src="https://php.spruko.com/ynex/ynex/assets/images/faces/11.jpg" alt="Image description">
                                    <div class="mt-0">
                                        <p class="mb-1 fw-semibold">Manuel Labor</p>
                                        <p class="mb-0 fs-11 text-success">User ID: #1345</p>
                                    </div>
                                    <span class="ms-auto fs-12">
                                                        <span class="float-end text-muted fw-semibold">15 Mar 2022</span>
                                                    </span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-xl-6">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">Billing</div>
                    <div class="tab-menu-heading border-0 p-0 ms-auto">
                        <div class="tabs-menu-billing my-1">
                            <ul class="nav panel-tabs-billing">
                                <li class=""><a href="#Invoice" data-bs-toggle="tab" class="active">Invoices</a></li>
                                <li><a href="#Revenue" data-bs-toggle="tab">Revenue</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="tab-content">
                        <div class="tab-pane active border-0 p-0" id="Invoice">
                            <ul class="list-group border-0 py-2 my-1">
                                <li class="list-group-item align-items-start border-0 mb-2">
                                    <a href="javascript:void(0);">
                                        <div class="d-flex w-100 justify-content-between align-items-center">
                                            <div>
                                                <span class="badge bg-info me-3">Processing</span>
                                            </div>
                                            <div class="billing-invoice-details">
                                                <span class="mb-0 fw-semibold me-2">Invoice #A12-005 _ <span class="fs-12 ">$1,938</span></span>
                                                <span class="small text-muted fs-11 d-block">Nov 24,2022</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="list-group-item align-items-start border-0 mb-2">
                                    <a href="javascript:void(0);">
                                        <div class="d-flex w-100 justify-content-between align-items-center">
                                            <div>
                                                <span class="badge bg-success me-3">Sent</span>
                                            </div>
                                            <div class="billing-invoice-details">
                                                <span class="mb-0 fw-semibold me-2">Invoice #A12-006 _ <span class="fs-12">$1,098</span></span>
                                                <span class="small text-muted fs-11 d-block">Nov 28,2022</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="list-group-item align-items-start border-0 mb-2">
                                    <a href="javascript:void(0);">
                                        <div class="d-flex w-100 justify-content-between align-items-center">
                                            <div>
                                                <span class="badge bg-warning me-3">Pending</span>
                                            </div>
                                            <div class="billing-invoice-details">
                                                <span class="mb-0 fw-semibold me-2">Invoice #A12-007 _ <span class="fs-12 ">$3,672</span></span>
                                                <span class="small text-muted fs-11 d-block">Dec 20,2022</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="list-group-item align-items-start border-0 mb-2">
                                    <a href="javascript:void(0);">
                                        <div class="d-flex w-100 justify-content-between align-items-center">
                                            <div>
                                                <span class="badge bg-info me-3">Processing</span>
                                            </div>
                                            <div class="billing-invoice-details">
                                                <span class="mb-0 fw-semibold me-2">Invoice #A12-008 _ <span class="fs-12 ">$4,362</span></span>
                                                <span class="small text-muted fs-11 d-block">Dec 16,2022</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="list-group-item align-items-start border-0 mb-2">
                                    <a href="javascript:void(0);">
                                        <div class="d-flex w-100 justify-content-between align-items-center">
                                            <div>
                                                <span class="badge bg-success me-3">Sent</span>
                                            </div>
                                            <div class="billing-invoice-details">
                                                <span class="mb-0 fw-semibold me-2">Invoice #A12-009 _ <span class="fs-12 ">$2,389</span></span>
                                                <span class="small text-muted fs-11 d-block">Dec 10,2022</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="list-group-item align-items-start border-0">
                                    <a href="javascript:void(0);">
                                        <div class="d-flex w-100 justify-content-between align-items-center">
                                            <div>
                                                <span class="badge bg-success me-3">Sent</span>
                                            </div>
                                            <div class="billing-invoice-details">
                                                <span class="mb-0 fw-semibold me-2">Invoice #A12-002 _ <span class="fs-12 ">$4,390</span></span>
                                                <span class="small text-muted fs-11 d-block">Nov 30,2022</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-pane border-0 p-0" id="Revenue">
                            <ul class="list-group border-0 py-2">
                                <li class="list-group-item align-items-start border-0 mb-1">
                                    <a href="javascript:void(0);">
                                        <div class="d-flex w-100 justify-content-between">
                                            <p class="mb-0 fw-semibold">Order Picking</p>
                                            <p class="mb-0 fw-semibold text-success fs-14">+$3,876</p>
                                        </div>
                                        <div class="d-flex w-100 justify-content-between">
                                            <span class="text-muted fs-12"><i class="ri-arrow-up-fill align-middle text-success me-1"></i> <span class="text-success me-2">03%</span></span>
                                            <span class="text-muted  fs-11">5 days ago</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="list-group-item flex-column align-items-start border-0 mb-1">
                                    <a href="javascript:void(0);">
                                        <div class="d-flex w-100 justify-content-between">
                                            <p class="mb-0 fw-semibold">Storage</p>
                                            <p class="mb-0 fw-semibold text-danger fs-14">-$2,178</p>
                                        </div>
                                        <div class="d-flex w-100 justify-content-between">
                                            <span class="text-muted  fs-12"><i class="ri-arrow-down-fill align-middle text-danger me-1"></i><span class="text-danger"> 16%</span></span>
                                            <span class="text-muted  fs-11">2 days ago</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="list-group-item flex-column align-items-start border-0 mb-1">
                                    <a href="javascript:void(0);">
                                        <div class="d-flex w-100 justify-content-between">
                                            <p class="mb-0 fw-semibold">Shipping</p>
                                            <p class="mb-0 fw-semibold text-success fs-14">+$1,367</p>
                                        </div>
                                        <div class="d-flex w-100 justify-content-between">
                                            <span class="text-muted  fs-12"><i class="ri-arrow-up-fill align-middle text-success me-1"></i><span class="text-success"> 06%</span></span>
                                            <span class="text-muted  fs-11">1 days ago</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="list-group-item flex-column align-items-start border-0 mb-1">
                                    <a href="javascript:void(0);">
                                        <div class="d-flex w-100 justify-content-between">
                                            <p class="mb-0 fw-semibold">Receiving</p>
                                            <p class="mb-0 fw-semibold text-danger fs-14">-$678</p>
                                        </div>
                                        <div class="d-flex w-100 justify-content-between">
                                            <span class="text-muted  fs-12"><i class="ri-arrow-down-fill align-middle text-danger me-1"></i><span class="text-danger"> 25%</span></span>
                                            <span class="text-muted  fs-11">10 days ago</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="list-group-item flex-column align-items-start border-0 mb-1">
                                    <a href="javascript:void(0);">
                                        <div class="d-flex w-100 justify-content-between">
                                            <p class="mb-0 fw-semibold">Review</p>
                                            <p class="mb-0 fw-semibold text-success fs-14">+$578</p>
                                        </div>
                                        <div class="d-flex w-100 justify-content-between">
                                            <span class="text-muted  fs-12"><i class="ri-arrow-up-fill align-middle text-success me-1"></i><span class="text-success"> 55%</span></span>
                                            <span class="text-muted  fs-11">11 days ago</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="list-group-item flex-column align-items-start border-0 mb-0">
                                    <a href="javascript:void(0);">
                                        <div class="d-flex w-100 justify-content-between">
                                            <p class="mb-0 fw-semibold">Profit</p>
                                            <p class="mb-0 fw-semibold text-success fs-14">+$27,215</p>
                                        </div>
                                        <div class="d-flex w-100 justify-content-between">
                                            <span class="text-muted fs-12"><i class="ri-arrow-up-fill align-middle text-success me-1"></i><span class="text-success"> 32%</span></span>
                                            <span class="text-muted fs-11">11 days ago</span>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-xl-6">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Sale Value
                    </div>
                    <div class="dropdown">
                        <a aria-label="anchor" href="javascript:void(0);" class="btn btn-icon btn-sm btn-light" data-bs-toggle="dropdown">
                            <i class="fe fe-more-vertical"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="javascript:void(0);">Action</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0);">Another action</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0);">Something else here</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body pb-0 px-2">
                    <div id="sale-value" class="p-3"></div>
                    <div class="row pt-4">
                        <div class="col-xl-12 border-bottom pb-3 text-center d-flex flex-wrap"><span class="fw-semibold ms-2 text-primary px-4">60% Increase in sale value since last week</span></div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 border-end p-3 text-center">
                            <p class="mb-1">Sale Items</p>
                            <h5 class="mb-1 fw-semibold">567</h5>
                            <p class="fs-11 text-muted mb-0">Increased<span class="text-success ms-2"><i class="ri-arrow-up-s-line me-2 fw-bold align-middle d-inline-block"></i><span class="badge bg-success-transparent text-success fs-11">0.9%</span></span></p>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 p-3 text-center">
                            <p class="mb-1">Sale Revenue</p>
                            <h5 class="mb-1 fw-semibold">$11,197</h5>
                            <p class="fs-11 text-muted mb-0">Profit<span class="text-success ms-2"><i class="ri-arrow-down-s-line me-2 fw-bold align-middle d-inline-block"></i><span class="badge bg-success-transparent text-success fs-11">0.15%</span></span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-xl-6">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">Profitable Categories</div>
                    <div class="dropdown">
                        <a aria-label="anchor" href="javascript:void(0);" class="btn btn-icon btn-sm btn-light" data-bs-toggle="dropdown">
                            <i class="fe fe-more-vertical"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="javascript:void(0);">Action</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0);">Another action</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0);">Something else here</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="list-group mb-0">
                        <li class="list-group-item">
                            <div class="d-flex align-items-center">
                                <div class="me-2">
                                                    <span class="avatar avatar-sm bg-light text-default fw-semibold">
                                                        1
                                                    </span>
                                </div>
                                <div class="flex-fill">
                                    <p class="mb-0 fw-semibold">Clothing</p>
                                </div>
                                <div>
                                    <span class="text-success">$123.45M</span>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex align-items-center">
                                <div class="me-2">
                                                    <span class="avatar avatar-sm bg-light text-default fw-semibold">
                                                        2
                                                    </span>
                                </div>
                                <div class="flex-fill">
                                    <p class="mb-0 fw-semibold">Electronics</p>
                                </div>
                                <div>
                                    <span class="text-success">$765.89K</span>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex align-items-center">
                                <div class="me-2">
                                                    <span class="avatar avatar-sm bg-light text-default fw-semibold">
                                                        3
                                                    </span>
                                </div>
                                <div class="flex-fill">
                                    <p class="mb-0 fw-semibold">Grocery</p>
                                </div>
                                <div>
                                    <span class="text-success">$289.00M</span>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex align-items-center">
                                <div class="me-2">
                                                    <span class="avatar avatar-sm bg-light text-default fw-semibold">
                                                        4
                                                    </span>
                                </div>
                                <div class="flex-fill">
                                    <p class="mb-0 fw-semibold">Mobiles</p>
                                </div>
                                <div>
                                    <span class="text-success">$662.97K</span>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex align-items-center">
                                <div class="me-2">
                                                    <span class="avatar avatar-sm bg-light text-default fw-semibold">
                                                        5
                                                    </span>
                                </div>
                                <div class="flex-fill">
                                    <p class="mb-0 fw-semibold">Kitchen Appliances</p>
                                </div>
                                <div>
                                    <span class="text-success">$1.2B</span>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex align-items-center">
                                <div class="me-2">
                                                    <span class="avatar avatar-sm bg-light text-default fw-semibold">
                                                        6
                                                    </span>
                                </div>
                                <div class="flex-fill">
                                    <p class="mb-0 fw-semibold">Automobiles</p>
                                </div>
                                <div>
                                    <span class="text-success">$109.23k</span>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item text-center">
                            <button type="button" class="btn btn-primary-light btn-wave">See All Activity</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End:: row-4 -->

    <!-- Start:: row-5 -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Orders
                    </div>
                    <div class="d-flex flex-wrap">
                        <div class="me-3 my-1">
                            <input class="form-control form-control-sm" type="text" placeholder="Search Here" aria-label=".form-control-sm example">
                        </div>
                        <div class="dropdown m-1">
                            <a href="javascript:void(0);" class="btn btn-primary btn-sm btn-wave waves-effect waves-light" data-bs-toggle="dropdown" aria-expanded="false">
                                Sort By<i class="ri-arrow-down-s-line align-middle ms-1 d-inline-block"></i>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a class="dropdown-item" href="javascript:void(0);">New</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);">Popular</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);">Relevant</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-nowrap table-bordered">
                            <thead>
                            <tr>
                                <th scope="col">
                                                        <span>
                                                            <input class="form-check-input" type="checkbox" id="order_All" value="" aria-label="...">
                                                        </span>
                                </th>
                                <th scope="col">Order Id </th>
                                <th scope="col">Customer</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Price</th>
                                <th scope="col">Status</th>
                                <th scope="col">Ordered Date</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                                        <span>
                                                            <input class="form-check-input" type="checkbox" id="order_1" value="" aria-label="...">
                                                        </span>
                                </td>
                                <td>
                                    <span class="text-success fw-semibold">#1537890</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-2 lh-1">
                                                                <span class="avatar avatar-sm">
                                                                    <img src="https://php.spruko.com/ynex/ynex/assets/images/faces/15.jpg" alt="">
                                                                </span>
                                        </div>
                                        <div class="fs-14">Simon Cowall</div>
                                    </div>
                                </td>
                                <td>
                                    1
                                </td>
                                <td>
                                    <span class="fw-semibold fs-14">$4320.29</span>
                                </td>
                                <td>
                                    <span class="badge bg-success-transparent">Shipped</span>
                                </td>
                                <td>
                                    <span class="text-muted">25,Nov 2022</span>
                                </td>
                                <td>
                                    <div class="hstack gap-2 fs-1">
                                        <a aria-label="anchor" href="javascript:void(0);" class="btn btn-icon btn-sm btn-success-light btn-wave"><i class="ri-download-2-line"></i></a>
                                        <a aria-label="anchor" href="javascript:void(0);" class="btn btn-icon btn-sm btn-info-light btn-wave"><i class="ri-edit-line"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                                        <span>
                                                            <input class="form-check-input" type="checkbox" id="order_2" value="" aria-label="...">
                                                        </span>
                                </td>
                                <td>
                                    <span class="text-success fw-semibold">#1539078</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-2 lh-1">
                                                                <span class="avatar avatar-sm">
                                                                    <img src="https://php.spruko.com/ynex/ynex/assets/images/faces/4.jpg" alt="">
                                                                </span>
                                        </div>
                                        <div class="fs-14">Meisha Kerr</div>
                                    </div>
                                </td>
                                <td>
                                    1
                                </td>
                                <td>
                                    <span class="fw-semibold fs-14">$6745.99</span>
                                </td>
                                <td>

                                    <span class="badge bg-danger-transparent">Cancelled</span>
                                </td>
                                <td>
                                    <span class="text-muted">29,Nov 2022</span>
                                </td>
                                <td>
                                    <div class="hstack gap-2 fs-1">
                                        <a aria-label="anchor" href="javascript:void(0);" class="btn btn-icon btn-sm btn-success-light btn-wave"><i class="ri-download-2-line"></i></a>
                                        <a aria-label="anchor" href="javascript:void(0);" class="btn btn-icon btn-sm btn-info-light btn-wave"><i class="ri-edit-line"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                                        <span>
                                                            <input class="form-check-input" type="checkbox" id="order_3" value="" aria-label="...">
                                                        </span>
                                </td>
                                <td>
                                    <span class="text-success fw-semibold">#1539832</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-2 lh-1">
                                                                <span class="avatar avatar-sm">
                                                                    <img src="https://php.spruko.com/ynex/ynex/assets/images/faces/5.jpg" alt="">
                                                                </span>
                                        </div>
                                        <div class="fs-14">Jessica</div>
                                    </div>
                                </td>
                                <td>
                                    2
                                </td>
                                <td>
                                    <span class="fw-semibold fs-14">$1176.89</span>
                                </td>
                                <td>
                                    <span class="badge bg-info-transparent">Under Process</span>
                                </td>
                                <td>
                                    <span class="text-muted">04,Dec 2022</span>
                                </td>
                                <td>
                                    <div class="hstack gap-2 fs-1">
                                        <a aria-label="anchor" href="javascript:void(0);" class="btn btn-icon btn-sm btn-success-light btn-wave"><i class="ri-download-2-line"></i></a>
                                        <a aria-label="anchor" href="javascript:void(0);" class="btn btn-icon btn-sm btn-info-light btn-wave"><i class="ri-edit-line"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                                        <span>
                                                            <input class="form-check-input" type="checkbox" id="order_4" value="" aria-label="...">
                                                        </span>
                                </td>
                                <td>
                                    <span class="text-success fw-semibold">#1539832</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-2 lh-1">
                                                                <span class="avatar avatar-sm">
                                                                    <img src="https://php.spruko.com/ynex/ynex/assets/images/faces/6.jpg" alt="">
                                                                </span>
                                        </div>
                                        <div class="fs-14">Amanda B</div>
                                    </div>
                                </td>
                                <td>
                                    1
                                </td>
                                <td>
                                    <span class="fw-semibold fs-14">$1899.99</span>
                                </td>
                                <td>
                                    <span class="badge bg-success-transparent">Shipped</span>
                                </td>
                                <td>
                                    <span class="text-muted">10,Dec 2022</span>
                                </td>
                                <td>
                                    <div class="hstack gap-2 fs-1">
                                        <a aria-label="anchor" href="javascript:void(0);" class="btn btn-icon btn-sm btn-success-light btn-wave"><i class="ri-download-2-line"></i></a>
                                        <a aria-label="anchor" href="javascript:void(0);" class="btn btn-icon btn-sm btn-info-light btn-wave"><i class="ri-edit-line"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                                        <span>
                                                            <input class="form-check-input" type="checkbox" id="order_5" value="" aria-label="...">
                                                        </span>
                                </td>
                                <td>
                                    <span class="text-success fw-semibold">#1538267</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-2 lh-1">
                                                                <span class="avatar avatar-sm">
                                                                    <img src="https://php.spruko.com/ynex/ynex/assets/images/faces/11.jpg" alt="">
                                                                </span>
                                        </div>
                                        <div class="fs-14">Jason Stathman</div>
                                    </div>
                                </td>
                                <td>
                                    1
                                </td>
                                <td>
                                    <span class="fw-semibold fs-14">$1867.29</span>
                                </td>
                                <td>
                                    <span class="badge bg-warning-transparent">Pending</span>
                                </td>
                                <td>
                                    <span class="text-muted">18,Dec 2022</span>
                                </td>
                                <td>
                                    <div class="hstack gap-2 fs-1">
                                        <a aria-label="anchor" href="javascript:void(0);" class="btn btn-icon btn-sm btn-success-light btn-wave"><i class="ri-download-2-line"></i></a>
                                        <a aria-label="anchor" href="javascript:void(0);" class="btn btn-icon btn-sm btn-info-light btn-wave"><i class="ri-edit-line"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                                        <span>
                                                            <input class="form-check-input" type="checkbox" id="order_6" value="" aria-label="...">
                                                        </span>
                                </td>
                                <td>
                                    <span class="text-success fw-semibold">#1537890</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-2 lh-1">
                                                                <span class="avatar avatar-sm">
                                                                    <img src="https://php.spruko.com/ynex/ynex/assets/images/faces/13.jpg" alt="">
                                                                </span>
                                        </div>
                                        <div class="fs-14">Khabib Hussain</div>
                                    </div>
                                </td>
                                <td>
                                    1
                                </td>
                                <td>
                                    <span class="fw-semibold fs-14">$2439.99</span>
                                </td>
                                <td>
                                    <span class="badge bg-success-transparent">Success</span>
                                </td>
                                <td>
                                    <span class="text-muted">24,Dec 2022</span>
                                </td>
                                <td>
                                    <div class="hstack gap-2 fs-1">
                                        <a aria-label="anchor" href="javascript:void(0);" class="btn btn-icon btn-sm btn-success-light btn-wave"><i class="ri-download-2-line"></i></a>
                                        <a aria-label="anchor" href="javascript:void(0);" class="btn btn-icon btn-sm btn-info-light btn-wave"><i class="ri-edit-line"></i></a>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex align-items-center">
                        <div class="d-flex align-items-center">
                            <div>
                                Showing 6 Entries
                            </div>
                            <div class="transform-arrow ms-2">
                                <i class="bi bi-arrow-right fw-semibold"></i>
                            </div>
                        </div>
                        <div class="ms-auto">
                            <nav aria-label="Page navigation" class="pagination-style-4">
                                <ul class="pagination mb-0">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="javascript:void(0);">
                                            Prev
                                        </a>
                                    </li>
                                    <li class="page-item active"><a class="page-link" href="javascript:void(0);">1</a></li>
                                    <li class="page-item"><a class="page-link" href="javascript:void(0);">2</a></li>
                                    <li class="page-item">
                                        <a class="page-link text-primary" href="javascript:void(0);">
                                            next
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End:: row-5 -->
@endsection

