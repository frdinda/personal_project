<?= $this->extend('layout/layout_login'); ?>

<?= $this->section('content'); ?>
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
                                <p class="mb-3">Masukkan NIP dan Password</p>
                            </div>
                            <div class="card-body">
                                <!-- ganti base_urlnya jadi proslogin, method ganti post -->
                                <form role="form" action="<?= base_url('/proslogin'); ?>" method="post">
                                    <div class="mb-3">
                                        <input id="nip" name="nip" type="text" class="form-control form-control-lg" placeholder="NIP" aria-label="NIP" required>
                                    </div>
                                    <div class="mb-3">
                                        <input id="password" name="password" type="password" class="form-control form-control-lg" placeholder="Password" aria-label="Password" required>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-2 mb-0">Login</button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                <p class="mb-1 mt-2 text-sm mx-auto">
                                    Ada pertanyaan?
                                    <a href="https://wa.link/tekfds" class="text-primary text-gradient font-weight-bold">Help Desk</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                        <div class="position-relative bg-gradient-primary-2 h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden" style="background-image: url('../assets_argon/img/signin-ill2.jpg');
          background-size: cover;">
                            <span class="mask bg-gradient-primary-2 opacity-7"></span>
                            <img class="position-relative" src="../assets_argon/img/logo_pengayoman.png" alt="" style="height:10vh; width:fit-content; margin:5vh auto 2vh auto; padding:0px;">
                            <h4 class="mt-1 text-white font-weight-bolder position-relative" style="font-size:3vw;">SEPADAN</h4>
                            <p class="text-white position-relative">Sistem Penilaian Pegawai Teladan <br> Kantor Wilayah Kementerian Hukum dan HAM Sumatera Utara</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?= $this->endSection(); ?>