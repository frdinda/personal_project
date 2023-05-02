<?= $this->extend('layout/layout_all'); ?>

<?= $this->section('content'); ?>
<?php if (count($pegawai_teladan) == 1) { ?>
    <div class="card shadow-lg mx-4 card-profile-bottom mt-8">
        <!-- DATANYA MASIH DUMMY -->
        <div class="card-body p-3">
            <div class="row gx-4">
                <div class="col-2">
                    <img src="../img/foto_pegawai/irene.jpg" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                </div>
                <div class="col-6 mt-3">
                    <div class="h-100">
                        <h3 class="mb-1">
                            SELAMAT
                        </h3>
                        <?php foreach ($data_pegawai as $d) :
                            if ($d['nip'] == $pegawai_teladan[0]['nip_pegawai']) { ?>
                                <h4 class="mb-1">
                                    <?= $d['nama_pegawai']; ?>
                                </h4>
                                <p class="mb-0 font-weight-bold text-lg">
                                    <?= $d['nama_jabatan'];; ?>
                                </p>
                        <?php }
                        endforeach; ?>
                        <p class="mb-0 font-weight-light text-lg">
                            Pegawai Teladan Periode: <?= date('M, Y'); ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } else if (count($pegawai_teladan) > 1) { ?>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="card-header pb-0 pt-3 bg-transparent">
                <b>
                    <h3 class="text-capitalize" style="color: #344767;">SELAMAT KEPADA PEGAWAI TELADAN PERIODE <?= date('M, Y'); ?></h3>
                </b>
            </div>
            <?php foreach ($pegawai_teladan as $p) : ?>
                <div class="col-md-4 mb-4">
                    <div class="card card-profile">
                        <img src="../assets_argon/img/bg-profile.jpg" alt="Image placeholder" class="card-img-top">
                        <div class="row justify-content-center">
                            <div class="col-4 col-lg-4 order-lg-2">
                                <div class="mt-n4 mt-lg-n6 mb-4 mb-lg-0">
                                    <a href="javascript:;">
                                        <img src="../img/foto_pegawai/irene.jpg" class="rounded-circle img-fluid border border-2 border-white">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="text-center mt-4">
                                <?php foreach ($data_pegawai as $d) :
                                    if ($d['nip'] == $p['nip_pegawai']) { ?>
                                        <h5>
                                            <?= $d['nama_pegawai']; ?>
                                        </h5>
                                        <div class="h6 font-weight-300">
                                            <?= $d['nama_jabatan']; ?>
                                        </div>
                                <?php }
                                endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php } ?>

<?= $this->endSection(); ?>