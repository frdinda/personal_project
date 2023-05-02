<?= $this->extend('layout/layout_all'); ?>

<?= $this->section('content'); ?>
<?php if ($detail_pegawai_yang_diusulkan != null) { ?>
    <div class="card shadow-lg mx-4 card-profile-bottom mt-8">
        <!-- DATANYA MASIH DUMMY -->
        <div class="card-body p-3">
            <div class="row gx-4">
                <div class="col-2">
                    <img src="../img/foto_pegawai/<?= $detail_pegawai_yang_diusulkan['foto_profil']; ?>" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                </div>
                <div class="col-6 mt-3">
                    <div class="h-100">
                        <h4 class="mb-1">
                            Pegawai yang Diusulkan Periode <?= date('M, Y'); ?>
                        </h4>
                        <p class="mb-0 font-weight-bold text-lg">
                            <?= $detail_pegawai_yang_diusulkan['nama_pegawai']; ?> - <?= $detail_pegawai_yang_diusulkan['nip']; ?>
                        </p>
                        <p class="mb-0 font-weight-light text-lg">
                            <?= $detail_pegawai_yang_diusulkan['nama_jabatan']; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card z-index-2 h-auto">
                <div class="card-header pb-0 pt-3 bg-transparent">
                    <b>
                        <h3 class="text-capitalize" style="color: #344767;"><?= $nama_sub_page; ?></h3>
                    </b>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-12 col-xxl-12 d-flex" style="color: #344767;">
                        <div class="card flex-fill p-4">
                            <table class="table-hover" id="table-pilih-pegawai">
                                <thead>
                                    <th class="col-md-2 text-uppercase font-weight-bolder text-sm ps-0" scope="col">No</th>
                                    <th class="col-md-2 text-uppercase font-weight-bolder text-sm ps-0" scope="col">NIP</th>
                                    <th class="col-md-3 text-uppercase font-weight-bolder text-sm ps-0" scope="col">Nama Pegawai</th>
                                    <th class="col-md-3 text-uppercase font-weight-bolder text-sm ps-0" scope="col">Jabatan</th>
                                    <th class="col-md-1 text-uppercase font-weight-bolder text-sm ps-0" scope="col"></th>
                                </thead>
                                <tbody>
                                    <?php $a = 1; ?>
                                    <?php foreach ($pegawai_per_atasan_langsung as $p) : ?>
                                        <?php if ($p['struktural'] == 'T') { ?>
                                            <tr>
                                                <td class="mb-0 text-sm ps-0" scope="row"><?= $a; ?></td>
                                                <td class="mb-0 text-sm ps-0" scope="row"><?= $p['nip']; ?></td>
                                                <td class="mb-0 text-sm ps-0" scope="row"><?= $p['nama_pegawai']; ?></td>
                                                <td class="mb-0 text-sm ps-0" scope="row"><?= $p['nama_jabatan']; ?></td>
                                                <td class="mb-0 text-sm ps-0" scope="row">
                                                    <a href="<?= base_url('/penilaian-atasan-langsung/' . $p['nip']); ?>" class="btn btn-primary table text-sm">Nilai</a>
                                                </td>
                                                <?php $a++; ?>
                                            </tr>
                                    <?php }
                                    endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>