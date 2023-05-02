<?= $this->extend('layout/layout_all'); ?>
<?= $this->section('content'); ?>
<?php if ($voted == 'yes') { ?>
    <div class="card shadow-lg mx-4 card-profile-bottom mt-8">
        <!-- DATANYA MASIH DUMMY -->
        <div class="card-body p-3">
            <div class="row gx-4">
                <div class="col-2">
                    <img src="../img/foto_pegawai/<?= $detail_pegawai_usulan_sebelumnya['foto_profil']; ?>" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                </div>
                <div class="col-6 mt-3">
                    <div class="h-100">
                        <h4 class="mb-1">
                            PILIHAN ANDA
                        </h4>
                        <p class="mb-0 font-weight-bold text-lg">
                            <?= $detail_pegawai_usulan_sebelumnya['nama_pegawai']; ?>
                        </p>
                        <p class="mb-0 font-weight-light text-lg">
                            <?= $detail_pegawai_usulan_sebelumnya['nama_jabatan']; ?>
                        </p>
                        <p class="mb-0 font-weight-light text-lg">
                            <?php foreach ($pegawai_yang_diusulkan as $p) :
                                if ($p['nip_pegawai'] == $detail_pegawai_usulan_sebelumnya['nip']) { ?>
                                    Nilai Atasan Langsung : <?= $p['nilai']; ?>
                            <?php }
                            endforeach; ?>
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
                            <table class="" id="table-polling-pegawai">
                                <thead>
                                    <th></th>
                                </thead>
                                <tbody>
                                    <?php foreach ($data_pegawai as $d) : ?>
                                        <?php foreach ($pegawai_yang_diusulkan as $p) : ?>
                                            <?php if ($d['nip'] == $p['nip_pegawai']) { ?>
                                                <tr class="mb-3">
                                                    <td>
                                                        <div class="card card-profile-bottom mt-0">
                                                            <div class="card-body p-3">
                                                                <div class="row gx-4">
                                                                    <div class="col-1">
                                                                        <div class="avatar avatar-xl position-relative">
                                                                            <img src="../img/foto_pegawai/<?= $d['foto_profil']; ?>" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6 my-auto">
                                                                        <div class="h-100">
                                                                            <h5 class="mb-1">
                                                                                <?= $d['nama_pegawai']; ?>
                                                                            </h5>
                                                                            <p class="mb-0 font-weight-light text-sm">
                                                                                <?= $d['nama_jabatan']; ?>
                                                                            </p>
                                                                            <p class="mb-0 font-weight-light text-sm">
                                                                                Nilai dari Atasan Langsung: <?= $p['nilai']; ?>
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                                                                        <div class="nav-wrapper position-relative end-0">

                                                                            <form action="<?= base_url('/proses-polling-pegawai'); ?>" method="post" class="polling_pegawai pb-2" id="Polling_Pegawai">
                                                                                <input id="nip_pegawai" name="nip_pegawai" type="hidden" class="form-control form-control-sm" placeholder="" aria-label="Save" value="<?= $d['nip']; ?>" required>
                                                                                <button type="submit" class="btn btn-lg btn-primary mt-2 mb-0" style="font-size:1em;">
                                                                                    <i class="ni ni-app"></i>
                                                                                    <span class="ms-2">Beri Vote</span>
                                                                                </button>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
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