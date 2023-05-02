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
</head>

<body class="bg-gray-200">
    <div class="container position-sticky z-index-sticky top-0">
        <div class="row">
            <div class="col-12">
                <!-- Navbar -->
                <nav class="navbar navbar-expand-lg blur border-radius-xl top-0 z-index-3 shadow position-absolute my-3 py-2 start-0 end-0 mx-4">
                    <div class="container-fluid ps-2 pe-0">
                        <a class="navbar-brand font-weight-bolder text-dark text-gradient ms-lg-0 ms-3 " href="<?= base_url('/'); ?>">
                            Pelayanan Terpadu Satu Pintu (PTSP)
                        </a>
                        <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon mt-2">
                                <span class="navbar-toggler-bar bar1"></span>
                                <span class="navbar-toggler-bar bar2"></span>
                                <span class="navbar-toggler-bar bar3"></span>
                            </span>
                        </button>
                        <div class="collapse navbar-collapse" id="navigation">
                            <ul class="navbar-nav mx-auto">

                            </ul>
                            <ul class="navbar-nav d-lg-flex d-none">
                                <li class="nav-item">
                                    <a href="<?= base_url('/'); ?>" class="btn btn-sm mb-0 me-1 bg-gradient-dark">Login</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <!-- End Navbar -->
            </div>
        </div>
    </div>
    <main class="main-content">
        <div class="page-header align-items-start min-vh-100" style="background-image: url('../assets/img/login-bg.jpg');">
            <span class="mask bg-gradient-dark opacity-6"></span>
            <div class="container my-auto">
                <div class="row mt-4">
                    <div class="col-lg-4 col-md-8 col-12 mx-auto">
                        <div class="card z-index-0 fadeIn3 fadeInBottom">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-dark shadow-dark border-radius-lg py-3 pe-1">
                                    <img class="mb-2" src="../assets/img/Logo-Kementerian-Hukum-dan-HAM-RI.png" alt="" style="width:4em; height:auto; margin:auto; display:block;">
                                    <h5 class="text-white font-weight-normal text-center mt-2 mb-0 ms-2 me-2">Pelayanan Terpadu Satu Pintu (PTSP)</h5>
                                    <h6 class="text-white font-weight-light text-center mb-0 ms-2 me-2">Kantor Wilayah Kementerian Hukum dan HAM Sumatera Utara</p>
                                </div>
                            </div>
                            <div class="card-body">
                                <form role="form" class="text-start" action="<?= base_url('/proslogin'); ?>" method="post">
                                    <div class="input-group input-group-outline my-3">
                                        <input type="text" class="form-control" id="user_id" name="user_id" placeholder="User ID">
                                    </div>
                                    <div class="input-group input-group-outline mb-3">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Login</button>
                                    </div>
                                    <p class="mt-4 text-sm text-center">
                                        Belum memiliki akun atau ada pertanyaan?
                                        <a href="https://wa.link/tekfds" class="text-dark text-gradient font-weight-bold">Help Desk</a>
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!--   Core JS Files   -->
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
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
</body>

</html>