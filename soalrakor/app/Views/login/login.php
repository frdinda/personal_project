<?= $this->extend('layout/layout_login'); ?>

<?= $this->section('content'); ?>
<!-- NAVBAR ATAS -->
<div class="container position-sticky z-index-sticky top-0">
    <div class="row">
        <div class="col-12">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg blur border-radius-lg top-0 z-index-3 shadow position-absolute mt-4 py-2 start-0 end-0 mx-4">
                <div class="container-fluid">
                    <a class="navbar-brand font-weight-bolder ms-lg-0 ms-3 " href="<?= base_url('/'); ?>">
                        ASSESSMENT
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
                            <li class="nav-item">
                                <!-- <a class="nav-link d-flex align-items-center me-2 active" aria-current="page" href="../pages/dashboard.html">
                                    <i class="fa fa-chart-pie opacity-6 text-dark me-1"></i>
                                    Dashboard
                                </a> -->
                            </li>
                        </ul>
                        <ul class="navbar-nav d-lg-block d-none">
                            <li class="nav-item">
                                <a href="<?= base_url('/login'); ?>" class="btn btn-sm mb-0 me-1 btn-primary">Login</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- End Navbar -->
        </div>
    </div>
</div>
<!-- FORM LOGIN DAN GAMBAR KANAN -->
<main class="main-content  mt-0">
    <section>
        <div class="page-header min-vh-100">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                        <div class="card card-plain">
                            <div class="card-header pb-0 text-start">
                                <h4 class="font-weight-bolder">Login</h4>
                                <p class="mb-0">Masukkan User ID dan Password</p>
                            </div>
                            <div class="card-body">
                                <!-- ganti base_urlnya jadi proslogin, method ganti post -->
                                <form role="form" action="<?= base_url('/proslogin'); ?>" method="post">
                                    <div class="mb-3">
                                        <input id="id_user" name="id_user" type="text" class="form-control form-control-lg" placeholder="User ID" aria-label="User ID" required>
                                    </div>
                                    <div class="mb-3">
                                        <input id="password" name="password" type="password" class="form-control form-control-lg" placeholder="Password" aria-label="Password" required>
                                    </div>
                                    <div class="input-group input-group-outline is-filled mb-3">
                                        <select class="form-control form-select form-select-jenis-assessment" name="jenis_assessment" id="jenis_assessment" required>
                                            <option value="" selected disabled>Jenis Assessment</option>
                                            <option value="Uji Kompetensi Pengisian Jabatan Tahun 2023">Uji Kompetensi Pengisian Jabatan Tahun 2023</option>
                                            <option value="Assessment Pembangunan Zona Integritas 2023">Assessment Pembangunan Zona Integritas 2023</option>
                                            <option value="Evaluasi Capaian Kinerja Tahun 2022">Evaluasi Capaian Kinerja Tahun 2022</option>
                                        </select>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-2 mb-0">Login</button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                <p class="mb-4 text-sm mx-auto">
                                    Ada pertanyaan?
                                    <a href="https://wa.link/tekfds" class="text-primary text-gradient font-weight-bold">Help Desk</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                        <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden" style="background-image: url('../assets_argon/img/signin-ill2.jpg');
          background-size: cover;">
                            <span class="mask bg-gradient-primary opacity-7"></span>
                            <img class="position-relative" src="../assets_argon/img/logo_pengayoman.png" alt="" style="height:10vh; width:fit-content; margin:5vh auto 2vh auto; padding:0px;">
                            <h4 class="mt-1 text-white font-weight-bolder position-relative">ASSESSMENT KANWIL SUMUT</h4>
                            <p class="text-white position-relative">Sistem Penilaian Assessment <br> Kantor Wilayah Kementerian Hukum dan HAM Sumatera Utara</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?= $this->endSection(); ?>