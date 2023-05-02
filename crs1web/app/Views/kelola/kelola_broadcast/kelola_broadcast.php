<?= $this->extend('layout/layout_all'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-lg-12 col-md-12 mt-0 mb-4">
        <div class="card">
            <div class="card-header pb-0">
                <div class="col-lg-12 col-12">
                    <h4 class="font-weight-bolder" style="color:#252527;"><?= $nama_page; ?></h4>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-2">
                        <a href="<?= base_url('/tambah-broadcast'); ?>" class="btn bg-gradient-primary p-3 font-weight-normal">
                            Tambah Broadcast
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <table class="table-hover" id="table-broadcast">
                            <thead>
                                <th class="col-md-2 font-weight-normal ps-0" scope="col">
                                    Tanggal Broadcast
                                </th>
                                <?php if ($jenis_akses != 'Unit Kerja') { ?>
                                    <th class="col-md-2 font-weight-normal ps-0" scope="col">
                                        Nama Unit Kerja
                                    </th>
                                <?php } ?>
                                <th class="<?php if ($jenis_akses != 'Unit Kerja') { ?>col-md-3<? } else { ?>col-md-5<?php } ?> font-weight-normal ps-0" scope="col">
                                    Judul Broadcast
                                </th>
                                <th class="col-md-1 font-weight-normal ps-0" scope="col">
                                    Platform Broadcast
                                </th>
                                <th class="col-md-1 font-weight-normal ps-0" scope="col">Status</th>
                                <th class="col-md-1 font-weight-normal ps-0" scope="col"></th>
                                <th class="col-md-1 font-weight-normal ps-0" scope="col"></th>
                                <th class="col-md-1 font-weight-normal ps-0" scope="col"></th>
                            </thead>
                            <tbody>
                                <?php foreach ($data_broadcast as $d) : ?>
                                    <tr>
                                        <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;">
                                            <?= $d['tanggal_broadcast']; ?>
                                        </td>
                                        <?php if ($jenis_akses != 'Unit Kerja') { ?>
                                            <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;">
                                                <?= $d['nama_unit_kerja']; ?>
                                            </td>
                                        <?php } ?>
                                        <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;">
                                            <!-- buat maksimalnya  -->
                                            <?= $d['judul_broadcast']; ?>
                                        </td>
                                        <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;">
                                            <!-- buat maksimalnya  -->
                                            <?= $d['platform_broadcast']; ?>
                                        </td>
                                        <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;">
                                            <!-- buat maksimalnya  -->
                                            <?= $d['status_terkirim']; ?>
                                        </td>
                                        <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;">
                                            <a href="<?= base_url('/detail-broadcast/' . $d['id_broadcast']); ?>" class="" target="">
                                                <span class="material-symbols-outlined">
                                                    open_in_new
                                                </span>
                                            </a>
                                        </td>
                                        <?php if ($d['status_terkirim'] == 'Sudah') { ?>
                                            <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em; color:#D3D3D3;">
                                                <span class="material-symbols-outlined">
                                                    edit
                                                </span>
                                            </td>
                                            <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em; color:#D3D3D3;">
                                                <form action="" method="post" class="d-inline">
                                                    <?= csrf_field(); ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button href="" class="" onclick="return confirm('Anda Yakin?')" style="border: none; outline: none; background:none; color:#D3D3D3;" disabled>
                                                        <span class="material-symbols-outlined">
                                                            delete
                                                        </span>
                                                    </button>
                                                </form>
                                            </td>
                                        <?php } else { ?>
                                            <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;">
                                                <a href="<?= base_url('/edit-broadcast/' . $d['id_broadcast']); ?>" class="">
                                                    <span class="material-symbols-outlined">
                                                        edit
                                                    </span>
                                                </a>
                                            </td>
                                            <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;">
                                                <form action="<?= base_url('/hapus-broadcast/' . $d['id_broadcast']); ?>" method="post" class="d-inline">
                                                    <?= csrf_field(); ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button href="" class="link-tambahan" onclick="return confirm('Anda Yakin?')" style="border: none; outline: none; background:none;">
                                                        <span class="material-symbols-outlined">
                                                            delete
                                                        </span>
                                                    </button>
                                                </form>
                                            </td>
                                        <?php } ?>
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
<?= $this->endSection(); ?>