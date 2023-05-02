<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Assessment Pembangunan Zona Integritas Kantor Wilayah Kementerian Hukum dan HAM Sumatera Utara Tahun 2023">
    <meta name="author" content="HUMAS_KUSUMA">
    <meta name="keywords" content="kemenkumham, hukum, nomor, surat, adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets_argon/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets_argon/img/logo_fix.ico">
    <title>
        Assessment Pembangunan Zona Integritas
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="../assets_argon/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../assets_argon/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="../assets_argon/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="../assets_argon/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
    <link type="text/css" href="css/style.css" rel="stylesheet" />
    <!-- LINK CSS LAIN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- DATATABLES -->
    <link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <!-- SELECT OPTION SEARCH -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <!-- chart -->
    <link rel="stylesheet" type="text/css" href="http://www.shieldui.com/shared/components/latest/css/light/all.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
</head>

<body class="g-sidenav-show bg-gray-100">
    <div class="min-height-300 position-absolute w-100 top-0" style="background-image: url('../assets_argon/img/profile-layout-header2.jpg'); background-position-y: 50%;"></div>
    <!-- SIDEBAR -->
    <aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main" aria-labelledby="iconNavbarSidenav">
        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand m-0" href="<?= base_url('/beranda-tzi23'); ?>" target="">
                <div class="col ms-0 ps-0">
                    <img src=" ../assets_argon/img/logo_fix.ico" class="navbar-brand-img h-100 pe-0" style="vertical-align: middle;" alt="main_logo">
                    <span class="ms-1 mt-0 font-weight-bold ps-0" style="font-size:1.75em; vertical-align: middle">TZI SUMUT</span>
                </div>
            </a>
        </div>
        <hr class="horizontal dark mt-0">
        <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
            <ul class="navbar-nav">
                <!-- NOMOR SURAT -->
                <?php if ($nama_page == 'Beranda' || $nama_page == 'Detail Penilaian') { ?>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?= base_url('/beranda-tzi23'); ?>">
                            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Beranda</span>
                        </a>
                    </li>
                <?php } else { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/beranda-tzi23'); ?>">
                            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Beranda</span>
                        </a>
                    </li>
                <?php } ?>

                <!-- PENILAIAN DAN SOAL -->
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Penilaian dan Soal</h6>
                </li>
                <?php if ($nama_page == 'Form Penilaian') { ?>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?= base_url('/form-pilih-asesi-tzi23'); ?>">
                            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="ni ni-single-copy-04 text-primary text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Form Penilaian</span>
                        </a>
                    </li>
                <?php } else { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/form-pilih-asesi-tzi23'); ?>">
                            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="ni ni-single-copy-04 text-primary text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Form Penilaian</span>
                        </a>
                    </li>
                <?php } ?>
                <?php if ($akses == 'admin') { ?>
                    <!-- PENILAIAN DAN SOAL ADMIN -->
                    <?php if ($nama_page == 'Kelola Soal') { ?>
                        <li class="nav-item">
                            <a class="nav-link active" href="<?= base_url('/kelola-soal-tzi23'); ?>">
                                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
                                </div>
                                <span class="nav-link-text ms-1">Kelola Soal</span>
                            </a>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item">
                            <a class="nav-link " href="<?= base_url('/kelola-soal-tzi23'); ?>">
                                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
                                </div>
                                <span class="nav-link-text ms-1">Kelola Soal</span>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if ($nama_page == 'Kelola Nilai') { ?>
                        <li class="nav-item">
                            <a class="nav-link active" href="<?= base_url('/kelola-nilai-tzi23'); ?>">
                                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="ni ni-credit-card text-success text-sm opacity-10"></i>
                                </div>
                                <span class="nav-link-text ms-1">Kelola Nilai</span>
                            </a>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item">
                            <a class="nav-link " href="<?= base_url('/kelola-nilai-tzi23'); ?>">
                                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="ni ni-credit-card text-success text-sm opacity-10"></i>
                                </div>
                                <span class="nav-link-text ms-1">Kelola Nilai</span>
                            </a>
                        </li>
                    <?php } ?>

                    <!-- KELOLA USER DAN ASESI ADMIN-->
                    <li class="nav-item mt-3">
                        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Kelola User dan Asesi</h6>
                    </li>
                    <?php if ($nama_page == 'Kelola User') { ?>
                        <li class="nav-item">
                            <a class="nav-link active" href="<?= base_url('/kelola-user-tzi23'); ?>">
                                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="ni ni-app text-info text-sm opacity-10"></i>
                                </div>
                                <span class="nav-link-text ms-1">Kelola User</span>
                            </a>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item">
                            <a class="nav-link " href="<?= base_url('/kelola-user-tzi23'); ?>">
                                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="ni ni-app text-info text-sm opacity-10"></i>
                                </div>
                                <span class="nav-link-text ms-1">Kelola User</span>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if ($nama_page == 'Kelola Asesi') { ?>
                        <li class="nav-item">
                            <a class="nav-link active" href="<?= base_url('/kelola-asesi-tzi23'); ?>">
                                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="ni ni-world-2 text-danger text-sm opacity-10"></i>
                                </div>
                                <span class="nav-link-text ms-1">Kelola Asesi</span>
                            </a>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item">
                            <a class="nav-link " href="<?= base_url('/kelola-asesi-tzi23'); ?>">
                                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="ni ni-world-2 text-danger text-sm opacity-10"></i>
                                </div>
                                <span class="nav-link-text ms-1">Kelola Asesi</span>
                            </a>
                        </li>
                    <?php } ?>
                <?php } ?>

                <!-- KELOLA AKUN PRIBADI -->
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Kelola Akun Pribadi</h6>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="<?= base_url('/logout') ?>">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-single-02 text-warning text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    <!-- TOPBAR -->
    <main class="main-content position-relative border-radius-lg ">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="<?= base_url('/beranda-tzi23'); ?>">Beranda</a></li>
                        <li class="breadcrumb-item text-sm text-white active" aria-current="page"><?= $nama_page; ?></li>
                    </ol>
                    <h6 class="font-weight-bolder text-white mb-0"><?= $nama_page; ?></h6>
                </nav>
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4 justify-content-end" id="navbar">
                    <ul class="navbar-nav  justify-content-end">
                        <li class="nav-item d-xl-none ps-3 d-flex align-items-center pe-3">
                            <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line bg-white"></i>
                                    <i class="sidenav-toggler-line bg-white"></i>
                                    <i class="sidenav-toggler-line bg-white"></i>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item dropdown pe-2 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-white p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-user me-sm-1"></i>
                                <span class="d-sm-inline d-none"><?= $nama_user; ?></span>
                            </a>
                            <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                                <li class="mb-2">
                                    <a class="dropdown-item border-radius-md" href="<?= basename('/logout'); ?>">
                                        <div class="d-flex py-1">
                                            <div class="my-auto">
                                                <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="text-sm font-weight-normal mb-1">
                                                    <span class="nav-link-text ms-1">Logout</span>
                                                </h6>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->
        <?= $this->rendersection('content'); ?>
    </main>



    <!-- SCRIPT DARI ARGON -->
    <script src=".../assets_argon/js/core/popper.min.js"></script>
    <script src=".../assets_argon/js/core/bootstrap.min.js"></script>
    <script src=".../assets_argon/js/plugins/perfect-scrollbar.min.js"></script>
    <script src=".../assets_argon/js/plugins/smooth-scrollbar.min.js"></script>
    <script src=".../assets/js/plugins/chartjs.min.js"></script>
    <!-- chart -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.bundle.min.js'></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>

    <script>
        const iconNavbarSidenav = document.getElementById('iconNavbarSidenav');
        const iconSidenav = document.getElementById('iconSidenav');
        const sidenav = document.getElementById('sidenav-main');
        let body = document.getElementsByTagName('body')[0];
        let className = 'g-sidenav-pinned';

        if (iconNavbarSidenav) {
            iconNavbarSidenav.addEventListener("click", toggleSidenav);
        }

        if (iconSidenav) {
            iconSidenav.addEventListener("click", toggleSidenav);
        }

        function toggleSidenav() {
            if (body.classList.contains(className)) {
                body.classList.remove(className);
                setTimeout(function() {
                    sidenav.classList.remove('bg-white');
                }, 100);
                sidenav.classList.remove('bg-transparent');

            } else {
                body.classList.add(className);
                sidenav.classList.add('bg-white');
                sidenav.classList.remove('bg-transparent');
                iconSidenav.classList.remove('d-none');
            }
        }

        let html = document.getElementsByTagName('html')[0];

        html.addEventListener("click", function(e) {
            if (body.classList.contains('g-sidenav-pinned') && !e.target.classList.contains('sidenav-toggler-line')) {
                body.classList.remove(className);
            }
        });
    </script>

    <script>
        $(".form-select-asesi").select2();

        $("#tipe_soal").on('change', function() {
            $(".tambah_soal").hide();
            $("#" + $(this).val()).fadeIn(700);
        }).change();
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src=".../assets_argon/js/argon-dashboard.min.js?v=2.0.4"></script>

    <!-- SCRIPT LAIN DARI SIAPARAT -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="/public/js/script.js"></script>
    <script src="js/app.js"></script>
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
    <!-- SUMMERNOTE -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#table-detail-nilai').DataTable({
                "dom": '<"toolbar">frtip',
                "info": false,
                "paging": false,
                "searching": false,
                "order": [
                    [0, 'asc']
                ]
            });
        });
        $(document).ready(function() {
            var t = $('#table-surat-all-2').DataTable({
                "dom": '<"toolbar">Bfrtip',
                "info": false,
                "order": [
                    [0, 'desc']
                ],
                "buttons": [{
                    extend: 'print',
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }
                }]
            });
        });
        $(document).ready(function() {
            var t = $('#table-surat-all-3').DataTable({
                "dom": '<"toolbar">Bfrtip',
                "info": false,
                "order": [
                    [0, 'desc']
                ],
                "buttons": [{
                    extend: 'print',
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }
                }]
            });
        });
        $(document).ready(function() {
            var t = $('#table-surat-all').DataTable({
                "dom": '<"toolbar">Bfrtip',
                "info": false,
                "order": [
                    [0, 'desc']
                ],
                "buttons": [{
                    extend: 'print',
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }
                }]
            });
        });
        $(document).ready(function() {
            var t = $('#table-ranking').DataTable({
                "dom": '<"toolbar">Bfrtip',
                "searching": false,
                "info": false,
                "columnDefs": [{
                    "search": false,
                    "order": false,
                    "targets": 2
                }],
                "order": [
                    [2, 'desc']
                ],
                "buttons": [{
                    extend: 'print',
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }
                }]
            });

            t.on('order.dt search.dt', function() {
                t.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();
        });
        $(document).ready(function() {
            var t = $('#table-kelola-nilai').DataTable({
                "dom": '<"toolbar">Bfrtip',
                "searching": true,
                "info": false,
                "order": [
                    [0, 'desc']
                ],
                "buttons": [{
                    extend: 'print',
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }
                }]
            });
        });
        $(document).ready(function() {
            $('#table-kelola-soal').DataTable({
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
            $('#table-edit-penilaian').DataTable({
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
    </Script>
    <!-- SUMMERNOTE -->
    <Script>
        $(document).ready(function() {
            $('.soal').summernote();
        });
        $(document).ready(function() {
            $('.jawaban').summernote();
        });
        $(document).ready(function() {
            $('.soal2').summernote();
        });
        $(document).ready(function() {
            $('.jawaban2').summernote();
        });
        $(document).ready(function() {
            $('.soal3').summernote();
        });
    </Script>
</body>

</html>