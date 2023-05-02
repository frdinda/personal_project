<?= $this->extend('layout/layout_all'); ?>

<?= $this->section('content'); ?>

<div class="card shadow-lg mx-4 card-profile-bottom mt-8">
    <!-- DATANYA MASIH DUMMY -->
    <div class="card-body p-3">
        <?php if (count($pegawai_teladan) > 0) { ?>
            <div class="row gx-4">
                <div class="col-2">
                    <img src="../img/foto_pegawai/<?= $pegawai_teladan[0]['foto_profil']; ?>" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                </div>
                <div class="col-6 mt-3">
                    <div class="h-100">
                        <h4 class="mb-1">
                            <?= $pegawai_teladan[0]['nama_pegawai']; ?>
                        </h4>
                        <p class="mb-0 font-weight-bold text-lg">
                            <?= $pegawai_teladan[0]['nama_jabatan']; ?>
                        </p>
                        <p class="mb-0 font-weight-light text-lg">
                            Pegawai Teladan Periode: <?= $pegawai_teladan[0]['periode_pegawai_teladan'];; ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <div class="row gx-4">
                <div class="col-2">
                    <img src="../img/foto_pegawai/ivancik.jpg" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                </div>
                <div class="col-6 mt-3">
                    <div class="h-100">
                        <h4 class="mb-1">
                            ...
                        </h4>
                        <p class="mb-0 font-weight-bold text-lg">
                            ...
                        </p>
                        <p class="mb-0 font-weight-light text-lg">
                            Pegawai Teladan Periode: ...
                        </p>
                    </div>
                </div>
            </div>
        <?php } ?>

    </div>
</div>

<div class="container-fluid py-4">
    <div class="row">
        <?php if (count($pegawai_teladan) > 1) { ?>
            <?php for ($i = 1; $i < count($pegawai_teladan); $i++) { ?>
                <div class="col-md-4 mb-4">
                    <div class="card card-profile">
                        <img src="../assets_argon/img/bg-profile.jpg" alt="Image placeholder" class="card-img-top">
                        <div class="row justify-content-center">
                            <div class="col-4 col-lg-4 order-lg-2">
                                <div class="mt-n4 mt-lg-n6 mb-4 mb-lg-0">
                                    <a href="javascript:;">
                                        <img src="../img/foto_pegawai/<?= $pegawai_teladan[$i]['foto_profil']; ?>" class="rounded-circle img-fluid border border-2 border-white">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="text-center mt-4">
                                <h5>
                                    <?= $pegawai_teladan[$i]['nama_pegawai']; ?>
                                </h5>
                                <div class="h6 font-weight-300">
                                    <?= $pegawai_teladan[$i]['nama_jabatan']; ?>
                                </div>
                                <div class="h6 mt-4">
                                    Pegawai Teladan Periode: <?= $pegawai_teladan[$i]['periode_pegawai_teladan']; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
    </div>
<?php } ?>
</div>


<?= $this->endSection(); ?>