<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Evaluasi Capaian Kinerja Kantor Wilayah Kementerian Hukum dan HAM Sumatera Utara">
    <meta name="author" content="HUMAS_KUSUMA">
    <meta name="keywords" content="kemenkumham, hukum, nomor, surat, adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets_argon/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets_argon/img/logo_fix.ico">
    <title>
        Evaluasi Capaian Kinerja
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
</head>

<body class="g-sidenav-show bg-gray-100">
    <div class="min-height-300 position-absolute w-100 top-0" style="background-image: url('../assets_argon/img/profile-layout-header2.jpg'); background-position-y: 50%;"></div>
    <!-- SIDEBAR -->
    <aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand m-0" href="<?= base_url('/beranda-tzi23'); ?>" target="_blank">
                <div class="col ms-0 ps-0">
                    <img src=" ../assets_argon/img/logo_fix.ico" class="navbar-brand-img h-100 pe-0" style="vertical-align: middle;" alt="main_logo">
                    <span class="ms-1 mt-0 font-weight-bold ps-0" style="font-size:1.75vw; vertical-align: middle">ECK SUMUT</span>
                </div>
            </a>
        </div>
        <hr class="horizontal dark mt-0">
        <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
            <ul class="navbar-nav">
                <!-- NOMOR SURAT -->
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/beranda-tzi23'); ?>">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Beranda</span>
                    </a>
                </li>

                <!-- PENILAIAN DAN SOAL -->
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">DAFTAR PERTANYAAN</h6>
                </li>
                <!-- Disini gue mau href-nya kalau ada data 'id_user', 'id_asesi', dan 'id_soal' di tabel penilaian, maka hrefnya ke id_penilaian, jatohnya ke form edit. tapi kalau nggak ada, jatohnya ke form input. -->
                <?php $nomor = 1;
                foreach ($soal_asesi as $s) :
                ?>
                    <li class="nav-item">
                        <form role="form" action="<?= base_url('/form-penilaian-tzi23'); ?>" method="post">
                            <div class="id_soal">
                                <input id="id_asesi" name="id_asesi" type="hidden" class="form-control form-control-sm mt-2" placeholder="" aria-label="" value="<?= $id_asesi; ?>" required>
                                <input id="id_soal_selanjutnya" name="id_soal_selanjutnya" type="hidden" class="form-control form-control-sm mt-2" placeholder="" aria-label="" value="<?= $s['id_soal']; ?>" required>
                            </div>
                            <button type="submit" class="nav-link active mb-0 pb-0" style="border-style: none;">
                                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="ni ni-collection text-primary text-sm opacity-10"></i>
                                </div>
                                <span class="nav-link-text ms-1">Pertanyaan <?= $nomor; ?></span>
                            </button>
                        </form>
                    </li>
                <?php $nomor++;
                endforeach; ?>
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
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                        <div class="input-group">
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
                        </div>
                    </div>
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
    <script>
        var ctx1 = document.getElementById("chart-line").getContext("2d");

        var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

        gradientStroke1.addColorStop(1, 'rgba(94, 114, 228, 0.2)');
        gradientStroke1.addColorStop(0.2, 'rgba(94, 114, 228, 0.0)');
        gradientStroke1.addColorStop(0, 'rgba(94, 114, 228, 0)');
        new Chart(ctx1, {
            type: "line",
            data: {
                labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Mobile apps",
                    tension: 0.4,
                    borderWidth: 0,
                    pointRadius: 0,
                    borderColor: "#5e72e4",
                    backgroundColor: gradientStroke1,
                    borderWidth: 3,
                    fill: true,
                    data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
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
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            padding: 10,
                            color: '#fbfbfb',
                            font: {
                                size: 11,
                                family: "Open Sans",
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
                            color: '#ccc',
                            padding: 20,
                            font: {
                                size: 11,
                                family: "Open Sans",
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
    <script>
        $(document).ready(function() {
            $('#table-surat-all').DataTable({
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
        $(document).ready(function() {
            $('#table-surat-bag').DataTable({
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
        $(document).ready(function() {
            $('#table-surat-user').DataTable({
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
    </Script>
</body>

</html>