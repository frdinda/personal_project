<?= $this->extend('layout/layout_all'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid py-4">
    <div class="row mt-4">
        <div class="col-lg-12 mb-lg-0 mb-4">
            <div class="card z-index-2 h-auto">
                <div class="card-header pb-0 pt-3 bg-transparent">
                    <b>
                        <h3 class="text-capitalize" style="color: #344767;">Kelola Satuan Kerja</h3>
                    </b>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-12 col-xxl-12 d-flex" style="color: #344767;">
                        <div class="card flex-fill p-3">
                            <div class="tab-content card-body flex-fill p-3 table-responsive" id="myTabContent">
                                <div class="tab-content mt-4 ms-2 me-2" id="myTabContent">
                                    <div class="col-2 ps-0 ms-0">
                                        <a href="<?= base_url('/tambah-satker/'); ?>" class="btn btn-primary table text-lg">Tambah Satker</a>
                                    </div>
                                    <div class="tab-pane fade show active" id="surat-all" role="tabpanel" aria-labelledby="surat-all-tab">
                                        <table class="table-hover" id="table-biasa">
                                            <thead>
                                                <th class="col-md-2 text-uppercase font-weight-bolder text-sm ps-0" scope="col">ID Satker</th>
                                                <th class="col-md-4 text-uppercase font-weight-bolder text-sm ps-0" scope="col">Nama Satker</th>
                                                <th class="col-md-2 text-uppercase font-weight-bolder text-sm ps-0" scope="col">Nama Kasatker</th>
                                                <th class="col-md-2 text-uppercase font-weight-bolder text-sm ps-0" scope="col">Jenis Satker</th>
                                                <th class="col-md-1 text-uppercase font-weight-bolder text-sm ps-0" scope="col"></th>
                                                <th class="col-md-1 text-uppercase font-weight-bolder text-sm ps-0" scope="col"></th>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($data_satker as $s) : ?>
                                                    <tr>
                                                        <td class="mb-0 text-sm ps-0" scope="row"><?= $s['id_satker']; ?></td>
                                                        <td class="mb-0 text-sm ps-0" scope="row"><?= $s['nama_satker']; ?></td>
                                                        <td class="mb-0 text-sm ps-0" scope="row"><?= $s['nama_kasatker']; ?></td>
                                                        <td class="mb-0 text-sm ps-0" scope="row"><?= $s['jenis_satker']; ?></td>
                                                        <td class="mb-0 text-sm ps-0" scope="row">
                                                            <a href="<?= base_url('/edit-satker/' . $s['id_satker']); ?>" class="btn btn-primary table text-sm">Edit</a>
                                                        </td>
                                                        <td class="mb-0 text-sm" scope="row">
                                                            <form action="<?= base_url('/hapus-satker/' . $s['id_satker']); ?>" method="post" class="d-inline">
                                                                <?= csrf_field(); ?>
                                                                <button class="btn btn-danger table" type="submit" onclick="return confirm('Anda Yakin?')">Hapus</button>
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