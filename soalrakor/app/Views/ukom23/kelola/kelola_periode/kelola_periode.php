<?= $this->extend('layout_ukom23/layout_all'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid py-4">
    <div class="row mt-4">
        <div class="col-lg-12 mb-lg-0 mb-4">
            <div class="card z-index-2 h-auto">
                <div class="card-header pb-0 pt-3 bg-transparent">
                    <b>
                        <h3 class="text-capitalize" style="color: #344767;"><?= $nama_subpage; ?></h3>
                    </b>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-12 col-xxl-12 d-flex" style="color: #344767;">
                        <div class="card flex-fill p-3">
                            <div class="tab-content card-body flex-fill p-3 table-responsive" id="myTabContent">
                                <div class="col-6 ps-0 ms-0">
                                    <a href="<?= base_url('/tambah-periode-ukom23/'); ?>" class="btn btn-primary me-2" style="font-size:1em;">Tambah Periode</a>
                                    <a href="<?= base_url('/edit-periode-berjalan-ukom23/'); ?>" class="btn btn-success me-2" style="font-size:1em;">Edit Periode Berjalan</a>
                                </div>
                                <div class="tab-content mt-4 ms-2 me-2" id="myTabContent">
                                    <div class="tab-pane fade show active" id="surat-all" role="tabpanel" aria-labelledby="surat-all-tab">
                                        <table class="table-hover" id="table-kelola-soal">
                                            <thead>
                                                <th class="col-md-1 text-uppercase font-weight-bolder text-sm ps-0" scope="col">ID Periode</th>
                                                <th class="col-md-4 text-uppercase font-weight-bolder text-sm ps-0" scope="col">Nama Periode</th>
                                                <th class="col-md-1 text-uppercase font-weight-bolder text-sm ps-0" scope="col"></th>
                                                <th class="col-md-1 text-uppercase font-weight-bolder text-sm ps-0" scope="col"></th>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($data_periode as $s) : ?>
                                                    <tr>
                                                        <td class="mb-0 text-sm" scope="row"><?= $s['id_periode']; ?></td>
                                                        <td class="mb-0 text-sm" scope="row"><?= $s['nama_periode']; ?></td>
                                                        <td class="mb-0 text-sm" scope="row">
                                                            <a href="<?= base_url('/edit-periode-ukom23/' . $s['id_periode']); ?>" class="btn btn-primary table text-sm">Edit</a>
                                                        </td>
                                                        <td class="mb-0 text-sm" scope="row">
                                                            <form action="<?= base_url('/hapus-periode-ukom23/' . $s['id_periode']); ?>" method="post" class="d-inline">
                                                                <?= csrf_field(); ?>
                                                                <button class="btn btn-danger table text-sm" type="submit" onclick="return confirm('Anda Yakin?')">Hapus</button>
                                                            </form>
                                                        </td>
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
        </div>
    </div>
</div>

<?= $this->endSection(); ?>