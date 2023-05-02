<?= $this->extend('layout/layout_all'); ?>

<?= $this->section('content'); ?>

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
                            <div class="col-2 ps-0 ms-0 mb-4">
                                <a href="<?= base_url('/tambah-pegawai'); ?>" class="btn btn-primary table text-lg">+ Tambah Pegawai</a>
                            </div>
                            <table class="table-hover" id="table-pilih-pegawai">
                                <thead>
                                    <th class="col-md-1 text-uppercase font-weight-bolder text-sm ps-0 text-center" scope="col">No</th>
                                    <th class="col-md-2 text-uppercase font-weight-bolder text-sm ps-0" scope="col">NIP</th>
                                    <th class="col-md-3 text-uppercase font-weight-bolder text-sm ps-0" scope="col">Nama Pegawai</th>
                                    <th class="col-md-3 text-uppercase font-weight-bolder text-sm ps-0" scope="col">Jabatan</th>
                                    <th class="col-md-1 text-uppercase font-weight-bolder text-sm ps-0" scope="col">Struktural</th>
                                    <th class="col-md-1 text-uppercase font-weight-bolder text-sm ps-0" scope="col">NIP Atasan Langsung</th>
                                    <th class="col-md-1 text-uppercase font-weight-bolder text-sm ps-0" scope="col"></th>
                                    <th class="col-md-1 text-uppercase font-weight-bolder text-sm ps-0" scope="col"></th>
                                </thead>
                                <tbody>
                                    <?php $a = 1; ?>
                                    <?php foreach ($data_pegawai as $p) : ?>
                                        <tr>
                                            <td class="mb-0 text-sm ps-0 text-center" scope="row"><?= $a; ?></td>
                                            <td class="mb-0 text-sm ps-0" scope="row"><?= $p['nip']; ?></td>
                                            <td class="mb-0 text-sm ps-0" scope="row"><?= $p['nama_pegawai']; ?></td>
                                            <td class="mb-0 text-sm ps-0" scope="row"><?= $p['nama_jabatan']; ?></td>
                                            <td class="mb-0 text-sm ps-0 text-center" scope="row"><?= $p['struktural']; ?></td>
                                            <td class="mb-0 text-sm ps-0" scope="row"><?= $p['nip_atasan_langsung']; ?></td>
                                            <td class="mb-0 text-sm ps-0 text-center" scope="row">
                                                <a href="<?= base_url('/edit-pegawai/' . $p['nip']); ?>" class="table text-sm">
                                                    <span class="material-symbols-outlined">
                                                        edit
                                                    </span>
                                                </a>
                                            </td>
                                            <td class="mb-0 text-sm ps-0 text-center" scope="row">
                                                <a href="<?= base_url('/hapus-pegawai/' . $p['nip']); ?>" onclick="return confirm('Anda Yakin?')" class="table text-sm">
                                                    <span class="material-symbols-outlined">
                                                        delete
                                                    </span>
                                                </a>
                                            </td>
                                            <?php $a++; ?>
                                        </tr>
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