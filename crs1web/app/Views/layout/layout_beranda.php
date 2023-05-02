<!--
=========================================================
* Material Dashboard 2 - v3.0.4
=========================================================

* Product Page: https://www.creative-tim.com/product/material-dashboard
* Copyright 2022 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Pelayanan Terpadu Satu Pintu (PTSP) Kantor Wilayah Kementerian Hukum dan HAM Sumatera Utara">
    <meta name="author" content="HUMAS_KUSUMA">
    <meta name="keywords" content="kemenkumham, hukum, crs, pengguna, layanan, customer, relationship, system, medan, sumatera, sumut, adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/logo_fix.ico">
    <title>
        PTSP KUSUMA
    </title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Nucleo Icons -->
    <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link id="pagestyle" href="../assets/css/material-dashboard.css?v=3.0.4" rel="stylesheet" />
    <!-- DATATABLES -->
    <link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <!-- SELECT OPTION SEARCH -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css">
    <!-- SUMMERNOTE -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-bs4.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <!-- Or for RTL support -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />

</head>

<body class="g-sidenav-show  bg-gray-200">
    <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">
        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand m-0" href="<?= base_url('/'); ?>" target="_blank">
                <img src="../assets/img/Logo-Kementerian-Hukum-dan-HAM-RI.png" class="navbar-brand-img h-100" alt="main_logo">
                <span class="ms-1 font-weight-bold text-white">PTSP KUSUMA</span>
            </a>
        </div>
        <hr class="horizontal light mt-0 mb-2">
        <div class="collapse navbar-collapse w-auto h-auto" id="sidenav-collapse-main">
            <ul class="navbar-nav">
                <?php if (isset($jenis_akses)) { ?>
                    <?php if ($nama_page == 'Beranda') { ?>
                        <li class="nav-item">
                            <!-- active bg-gradient-dark stelah text-white -->
                            <a class="nav-link text-white active bg-gradient-dark" href="<?= base_url('/'); ?>">
                                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="material-icons opacity-10">dashboard</i>
                                </div>
                                <span class="nav-link-text ms-1">Beranda</span>
                            </a>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item">
                            <!-- active bg-gradient-dark stelah text-white -->
                            <a class="nav-link text-white" href="<?= base_url('/'); ?>">
                                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="material-icons opacity-10">dashboard</i>
                                </div>
                                <span class="nav-link-text ms-1">Beranda</span>
                            </a>
                        </li>
                    <?php } ?>
                <?php } ?>
                <?php if (isset($jenis_akses)) { ?>
                    <li class="nav-item mt-3">
                        <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Kelola Pages</h6>
                    </li>
                <?php } ?>
                <?php if (isset($jenis_akses)) {
                    if ($nama_page == 'Tambah Entry Pengguna Layanan' || $nama_page == 'Edit Entry Pengguna Layanan' || $nama_page == 'Kelola Pengguna Layanan' || $nama_page == 'Tambah Pengguna Layanan' || $nama_page == 'Detail Pengguna Layanan' || $nama_page == 'Edit Pengguna Layanan') { ?>
                        <li class="nav-item">
                            <a class="nav-link text-white active bg-gradient-dark" href="<?= base_url('/kelola-pengguna-layanan'); ?>">
                                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="material-icons opacity-10">table_view</i>
                                </div>
                                <span class="nav-link-text ms-1">Kelola Pengguna Layanan</span>
                            </a>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item">
                            <a class="nav-link text-white " href="<?= base_url('/kelola-pengguna-layanan'); ?>">
                                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="material-icons opacity-10">table_view</i>
                                </div>
                                <span class="nav-link-text ms-1">Kelola Pengguna Layanan</span>
                            </a>
                        </li>
                <?php }
                } ?>
                <?php if (isset($jenis_akses)) {
                    if ($jenis_akses == 'Admin' || $jenis_akses == 'Duta Layanan') {
                        if ($nama_page == 'Tambah Entry Pengguna Umum') { ?>
                            <li class="nav-item">
                                <a class="nav-link text-white active bg-gradient-dark" href="<?= base_url('/tambah-entry-pengguna-umum'); ?>">
                                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                        <i class="material-icons opacity-10">receipt_long</i>
                                    </div>
                                    <span class="nav-link-text ms-1">Entry Pengguna Layanan <br> (Khusus Pengguna)</span>
                                </a>
                            </li>
                        <?php } else { ?>
                            <li class="nav-item">
                                <a class="nav-link text-white " href="<?= base_url('/tambah-entry-pengguna-umum'); ?>">
                                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                        <i class="material-icons opacity-10">receipt_long</i>
                                    </div>
                                    <span class="nav-link-text ms-1">Entry Pengguna Layanan <br> (Khusus Pengguna)</span>
                                </a>
                            </li>
                        <?php }
                    }
                } else {
                    if ($nama_page == 'Tambah Entry Pengguna Umum') { ?>
                        <li class="nav-item">
                            <a class="nav-link text-white active bg-gradient-dark" href="<?= base_url('/tambah-entry-pengguna-umum'); ?>">
                                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="material-icons opacity-10">receipt_long</i>
                                </div>
                                <span class="nav-link-text ms-1">Entry Pengguna Layanan <br> (Khusus Pengguna)</span>
                            </a>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item">
                            <a class="nav-link text-white " href="<?= base_url('/tambah-entry-pengguna-umum'); ?>">
                                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="material-icons opacity-10">receipt_long</i>
                                </div>
                                <span class="nav-link-text ms-1">Entry Pengguna Layanan <br> (Khusus Pengguna)</span>
                            </a>
                        </li>
                <?php }
                } ?>
                <?php if (isset($jenis_akses)) {
                    if ($jenis_akses == 'Admin' || $jenis_akses == 'Unit Kerja' || $jenis_akses == 'Pegawai') {
                        if ($nama_page == 'Edit Konsultasi Online' || $nama_page == 'Kelola Konsultasi Online') { ?>
                            <li class="nav-item">
                                <a class="nav-link text-white active bg-gradient-dark" href="<?= base_url('/kelola-konsultasi-online'); ?>">
                                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                        <i class="material-icons opacity-10">receipt_long</i>
                                    </div>
                                    <span class="nav-link-text ms-1">Kelola Konsultasi Online</span>
                                </a>
                            </li>
                        <?php } else { ?>
                            <li class="nav-item">
                                <a class="nav-link text-white " href="<?= base_url('/kelola-konsultasi-online'); ?>">
                                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                        <i class="material-icons opacity-10">receipt_long</i>
                                    </div>
                                    <span class="nav-link-text ms-1">Kelola Konsultasi Online</span>
                                </a>
                            </li>
                <?php }
                    }
                } ?>
                <?php if ($jenis_akses == 'Admin' || $jenis_akses == 'Unit Kerja') { ?>
                    <?php if ($nama_page == 'Kelola Broadcast' || $nama_page == 'Tambah Broadcast' || $nama_page == 'Edit Broadcast' || $nama_page == 'Detail Broadcast') { ?>
                        <li class="nav-item">
                            <a class="nav-link text-white active bg-gradient-dark" href="<?= base_url('/kelola-broadcast'); ?>">
                                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="material-icons opacity-10">view_in_ar</i>
                                </div>
                                <span class="nav-link-text ms-1">Kelola Broadcast</span>
                            </a>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item">
                            <a class="nav-link text-white " href="<?= base_url('/kelola-broadcast'); ?>">
                                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="material-icons opacity-10">view_in_ar</i>
                                </div>
                                <span class="nav-link-text ms-1">Kelola Broadcast</span>
                            </a>
                        </li>
                <?php }
                } ?>
                <?php if ($jenis_akses == 'Admin' && $user_id == 'super_adm') { ?>
                    <?php if ($nama_page == 'Kelola User' || $nama_page == 'Tambah User' || $nama_page == 'Edit User') { ?>
                        <li class="nav-item">
                            <a class="nav-link text-white active bg-gradient-dark" href="<?= base_url('/kelola-user'); ?>">
                                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="material-icons opacity-10">table_view</i>
                                </div>
                                <span class="nav-link-text ms-1">Kelola User</span>
                            </a>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item">
                            <a class="nav-link text-white " href="<?= base_url('/kelola-user'); ?>">
                                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="material-icons opacity-10">table_view</i>
                                </div>
                                <span class="nav-link-text ms-1">Kelola User</span>
                            </a>
                        </li>
                <?php }
                } ?>
                <?php if ($jenis_akses == 'Admin' || $jenis_akses == 'Unit Kerja') { ?>
                    <?php if ($nama_page == 'Kelola Jenis Layanan' || $nama_page == 'Tambah Jenis Layanan' || $nama_page == 'Edit Jenis Layanan') { ?>
                        <li class="nav-item">
                            <a class="nav-link text-white active bg-gradient-dark" href="<?= base_url('/kelola-jenis-layanan'); ?>">
                                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="material-icons opacity-10">table_view</i>
                                </div>
                                <span class="nav-link-text ms-1">Kelola Jenis Layanan</span>
                            </a>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item">
                            <a class="nav-link text-white " href="<?= base_url('/kelola-jenis-layanan'); ?>">
                                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="material-icons opacity-10">table_view</i>
                                </div>
                                <span class="nav-link-text ms-1">Kelola Jenis Layanan</span>
                            </a>
                        </li>
                <?php }
                } ?>
                <?php if (isset($jenis_akses)) { ?>
                    <li class="nav-item mt-3">
                        <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Account Pages</h6>
                    </li>
                    <?php if ($nama_page == 'Edit Profil') { ?>
                        <li class="nav-item">
                            <a class="nav-link text-white active bg-gradient-dark" href="<?= base_url('/edit-profil'); ?>">
                                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="material-icons opacity-10">person</i>
                                </div>
                                <span class="nav-link-text ms-1">Edit Profil</span>
                            </a>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item">
                            <a class="nav-link text-white " href="<?= base_url('/edit-profil'); ?>">
                                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="material-icons opacity-10">person</i>
                                </div>
                                <span class="nav-link-text ms-1">Edit Profil</span>
                            </a>
                        </li>
                    <?php } ?>
                    <li class="nav-item">
                        <a class="nav-link text-white " href="<?= base_url('/logout') ?>">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">logout</i>
                            </div>
                            <span class="nav-link-text ms-1">Logout</span>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </aside>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;" style="color:#252527;">Pages</a></li>
                        <li class="breadcrumb-item text-sm text-dark active" aria-current="page" style="color:#252527;"><?= $nama_page; ?></li>
                    </ol>
                    <h6 class="font-weight-bolder mb-0" style="color:#252527;"><?= $nama_page; ?></h6>
                </nav>
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                        <!-- JANGAN DIHAPUS -->
                    </div>
                    <?php
                    if (isset($nama_user)) { ?>
                        <ul class="navbar-nav  justify-content-end">
                            <li class="nav-item dropdown d-flex align-items-center">
                                <a href="javascript:;" class="nav-link text-body font-weight-bold px-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-user me-sm-1 cursor-pointer" style="color:#404047;"></i>
                                    <span class="d-sm-inline d-none" style="color:#404047;">
                                        <?= $nama_user; ?>
                                    </span>
                                </a>
                                <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                                    <li class="mb-2">
                                        <a class="dropdown-item border-radius-md" href="<?= base_url('/edit-profil') ?>">
                                            <div class="d-flex py-1">
                                                <div class="my-auto">
                                                    <i class="material-icons opacity-10" style="color:#404047;">person</i>
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="text-sm font-weight-normal mb-1">
                                                        <span class="font-weight-light" style="color:#404047;">Edit Profil
                                                    </h6>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="mb-2">
                                        <a class="dropdown-item border-radius-md" href="<?= base_url('/logout') ?>">
                                            <div class="d-flex py-1">
                                                <div class="my-auto">
                                                    <i class="material-icons opacity-10" style="color:#404047;">logout</i>
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="text-sm font-weight-normal mb-1">
                                                        <span class="font-weight-light" style="color:#404047;">Logout
                                                    </h6>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                                <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                                    <div class="sidenav-toggler-inner">
                                        <i class="sidenav-toggler-line"></i>
                                        <i class="sidenav-toggler-line"></i>
                                        <i class="sidenav-toggler-line"></i>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    <?php } else {
                    } ?>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <?= $this->rendersection('content'); ?>
        </div>
    </main>
    <!--   Core JS Files   -->
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="../assets/js/plugins/chartjs.min.js"></script>
    <script src="../assets/js/plugins/chartist.min.js"></script>
    <script>
        var ctx = document.getElementById("chart-bars").getContext("2d");

        new Chart(ctx, {
            type: "line",
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Mobile apps",
                    tension: 0,
                    borderWidth: 0,
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(255, 255, 255, .8)",
                    pointBorderColor: "transparent",
                    borderColor: "rgba(255, 255, 255, .8)",
                    borderColor: "rgba(255, 255, 255, .8)",
                    borderWidth: 4,
                    backgroundColor: "transparent",
                    fill: true,
                    data: <?php echo ($json_jumlah_entry_bulanan); ?>,
                    maxBarThickness: 6

                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5],
                            color: 'rgba(255, 255, 255, .2)'
                        },
                        ticks: {
                            display: true,
                            color: '#f8f9fa',
                            padding: 10,
                            font: {
                                size: 14,
                                weight: 300,
                                family: "Roboto",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            color: '#f8f9fa',
                            padding: 10,
                            font: {
                                size: 14,
                                weight: 300,
                                family: "Roboto",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                },
            },
        });


        var ctx2 = document.getElementById("chart-line").getContext("2d");

        new Chart(ctx2, {
            type: "line",
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Mobile apps",
                    tension: 0,
                    borderWidth: 0,
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(255, 255, 255, .8)",
                    pointBorderColor: "transparent",
                    borderColor: "rgba(255, 255, 255, .8)",
                    borderColor: "rgba(255, 255, 255, .8)",
                    borderWidth: 4,
                    backgroundColor: "transparent",
                    fill: true,
                    data: <?php echo ($json_jumlah_broadcast); ?>,
                    maxBarThickness: 6

                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5],
                            color: 'rgba(255, 255, 255, .2)'
                        },
                        ticks: {
                            display: true,
                            color: '#f8f9fa',
                            padding: 10,
                            font: {
                                size: 14,
                                weight: 300,
                                family: "Roboto",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            color: '#f8f9fa',
                            padding: 10,
                            font: {
                                size: 14,
                                weight: 300,
                                family: "Roboto",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                },
            },
        });

        var ctx3 = document.getElementById("chart-line-tasks").getContext("2d");

        new Chart(ctx3, {
            type: "line",
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Mobile apps",
                    tension: 0,
                    borderWidth: 0,
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(255, 255, 255, .8)",
                    pointBorderColor: "transparent",
                    borderColor: "rgba(255, 255, 255, .8)",
                    borderWidth: 4,
                    backgroundColor: "transparent",
                    fill: true,
                    data: <?php echo ($json_jumlah_konsultasi_online); ?>,
                    maxBarThickness: 6

                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5],
                            color: 'rgba(255, 255, 255, .2)'
                        },
                        ticks: {
                            display: true,
                            padding: 10,
                            color: '#f8f9fa',
                            font: {
                                size: 14,
                                weight: 300,
                                family: "Roboto",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            color: '#f8f9fa',
                            padding: 10,
                            font: {
                                size: 14,
                                weight: 300,
                                family: "Roboto",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                },
            },
        });

        var ctx = document.getElementById("chart-pie").getContext("2d");

        new Chart(ctx, {
            type: "pie",
            data: {
                // NANTI ECHO JSON JENIS LAYANAN
                labels: <?php echo ($json_data_jenis_layanan); ?>,
                datasets: [{
                    label: "Mobile apps",
                    tension: 0,
                    borderWidth: 0,
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(63,63,71, .8)",
                    pointBorderColor: "",
                    borderColor: "rgba(63,63,71, .8)",
                    borderWidth: 4,
                    backgroundColor: <?php echo ($json_warna_jenis_layanan); ?>,
                    fill: true,
                    data: <?php echo ($json_jumlah_per_jenis_layanan); ?>,
                    maxBarThickness: 6

                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5],
                            color: 'rgba(255, 255, 255, .2)'
                        },
                        ticks: {
                            display: true,
                            color: '#f8f9fa',
                            padding: 10,
                            font: {
                                size: 14,
                                weight: 300,
                                family: "Roboto",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            color: '#f8f9fa',
                            padding: 10,
                            font: {
                                size: 14,
                                weight: 300,
                                family: "Roboto",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                },
            },
        });
    </script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="../assets/js/material-dashboard.min.js?v=3.0.4"></script>
    <!-- SCRIPT LAIN DARI SIAPARAT -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css"></script>
    <script src="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    <script src="/assets/extra-libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="/dist/js/pages/datatable/datatable-basic.init.js"></script>
    <script type="text/javascript" src="DataTables/datatables.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
    <!-- SUMMERNOTE -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-bs4.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <!-- TABEL -->
    <script>
        $(document).ready(function() {
            $('#table-biasa').DataTable({
                "dom": '<"toolbar">frtip',
                "info": false,
                "oLanguage": {
                    "sSearch": "Search"
                },
                "order": [
                    [0, 'asc']
                ]
            });
        });

        $(document).ready(function() {
            $('#table-biasa-2').DataTable({
                "dom": '<"toolbar">frtip',
                "info": false,
                "oLanguage": {
                    "sSearch": "Search"
                },
                "order": [
                    [0, 'asc']
                ]
            });
        });

        $(document).ready(function() {
            $('#table-entry').DataTable({
                "dom": '<"toolbar">frtip',
                "info": false,
                "oLanguage": {
                    "sSearch": "Search"
                },
                "order": [
                    [0, 'desc']
                ]
            });
        });

        $("#tambah_or_entry").on('change', function() {
            $(".tambah_pengguna").hide(0);
            $("#" + $(this).val()).fadeIn(700);
        }).change();

        $("#whatsapp_or_email").on('change', function() {
            $(".tambah_broadcast").hide(0);
            $("#" + $(this).val()).fadeIn(700);
        }).change();

        $(".form-select-unit-kerja").select2({
            theme: "bootstrap-5"
        });

        $(".form-select-pengguna-layanan-2").select2({
            theme: "bootstrap-5"
        });

        $(".form-select-pengguna-layanan").select2({
            theme: "bootstrap-5"
        });

        $(".form-select-tujuan-broadcast").select2({
            theme: "bootstrap-5"
        });

        $(".form-select-tujuan-broadcast-2").select2({
            theme: "bootstrap-5"
        });

        $(document).ready(function() {
            $('.js-example-basic-multiple').select2({
                maximumSelectionLength: 2
            });
        });

        $(document).ready(function() {
            $('.js-example-basic-multiple-2').select2({
                maximumSelectionLength: 1
            });
        });

        $(document).ready(function() {
            $('#email_pengguna').change(function() {
                var id = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "/entry/getdatapengguna",
                    data: {
                        id: id
                    },
                    dataType: "JSON",
                    success: function(response) {
                        console.log(response);
                        $('#no_telp_pengguna').val(response.no_telp_pengguna);
                        $('#no_telp_pengguna_tampilan').val(response.no_telp_pengguna);
                        $('#nama_pengguna').val(response.nama_pengguna);
                        $('#nama_pengguna_tampilan').val(response.nama_pengguna);
                        $('#instansi_asal_pengguna').val(response.instansi_asal_pengguna);
                        $('#instansi_asal_pengguna_tampilan').val(response.instansi_asal_pengguna);
                    }
                })
            });
        });

        $(document).ready(function() {
            $('#text_broadcast').summernote({
                width: 10000
            });
        });
    </Script>
</body>

</html>