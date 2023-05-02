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
                            <div class="col-3 ps-0 ms-0 mb-4">
                                <a href="<?= base_url('/tambah-pertanyaan'); ?>" class="btn btn-primary table text-lg">+ Tambah Pertanyaan</a>
                            </div>
                            <table class="table-hover" id="table-pertanyaan">
                                <thead>
                                    <th class="col-md-1 text-uppercase font-weight-bolder text-sm ps-0 text-center" scope="col">No</th>
                                    <th class="col-md-7 text-uppercase font-weight-bolder text-sm ps-0" scope="col">Jabaran Pertanyaan</th>
                                    <th class="col-md-2 text-uppercase font-weight-bolder text-sm ps-0" scope="col">Kategori Pertanyaan</th>
                                    <th class="col-md-1 text-uppercase font-weight-bolder text-sm ps-0" scope="col"></th>
                                    <th class="col-md-1 text-uppercase font-weight-bolder text-sm ps-0" scope="col"></th>
                                </thead>
                                <tbody>
                                    <?php $a = 1; ?>
                                    <?php foreach ($data_pertanyaan as $p) : ?>
                                        <tr>
                                            <td class="mb-0 text-sm ps-0 text-center" scope="row"><?= $a; ?></td>
                                            <td class="mb-0 text-sm ps-0" scope="row"><?= $p['jabaran_pertanyaan']; ?></td>
                                            <td class="mb-0 text-sm ps-0" scope="row"><?= $p['kategori_pertanyaan']; ?></td>
                                            <td class="mb-0 text-sm ps-0 text-center" scope="row">
                                                <a href="<?= base_url('/edit-pertanyaan/' . $p['id_pertanyaan']); ?>" class="table text-sm">
                                                    <span class="material-symbols-outlined">
                                                        edit
                                                    </span>
                                                </a>
                                            </td>
                                            <td class="mb-0 text-sm ps-0 text-center" scope="row">
                                                <a href="<?= base_url('/hapus-pertanyaan/' . $p['id_pertanyaan']); ?>" onclick="return confirm('Anda Yakin?')" class="table text-sm">
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