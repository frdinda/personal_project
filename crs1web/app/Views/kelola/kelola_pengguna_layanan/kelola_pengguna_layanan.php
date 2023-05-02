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
                        <a href="<?= base_url('/tambah-entry-pengguna'); ?>" class="btn bg-gradient-primary p-3 font-weight-normal">
                            Tambah Entry Pengguna
                        </a>
                    </div>
                    <div class="col-xl-2">
                        <a href="<?= base_url('/tambah-pengguna-layanan'); ?>" class="btn bg-gradient-dark p-3 font-weight-normal">
                            Tambah Pengguna Layanan
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card flex-fill">
                            <div class="tab-content card-body flex-fill p-3 table-responsive" id="myTabContent">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="data-pengguna-layanan" data-bs-toggle="tab" data-bs-target="#tab-data-pengguna-layanan" type="button" role="tab" aria-controls="tab-data-pengguna-layanan" aria-selected="true">Data Pengguna Layanan</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="entry-pengguna-layanan" data-bs-toggle="tab" data-bs-target="#tab-entry-pengguna-layanan" type="button" role="tab" aria-controls="tab-entry-pengguna-layanan" aria-selected="true">Entry Pengguna Layanan</button>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content ps-4 pe-4 pb-4" id="myTabContent">
                                <div class="tab-pane fade show active" id="tab-data-pengguna-layanan" role="tabpanel" aria-labelledby="data-pengguna-layanan">
                                    <table class="table-hover" id="table-biasa-2">
                                        <thead>
                                            <th class="col-md-1 font-weight-normal ps-0" scope="col">
                                                No
                                            </th>
                                            <th class="col-md-3 font-weight-normal ps-0" scope="col">
                                                Nama
                                            </th>
                                            <th class="col-md-2 font-weight-normal ps-0" scope="col">
                                                Email
                                            </th>
                                            <th class="col-md-2 font-weight-normal ps-0" scope="col">
                                                No Telp
                                            </th>
                                            <th class="col-md-2 font-weight-normal ps-0" scope="col">
                                                Instansi Asal
                                            </th>
                                            <th class="col-md-1 font-weight-normal ps-0" scope="col"></th>
                                            <th class="col-md-1 font-weight-normal ps-0" scope="col"></th>
                                            <?php if ($jenis_akses == 'Admin') { ?>
                                                <th class="col-md-1 font-weight-normal ps-0" scope="col"></th>
                                            <?php } ?>
                                        </thead>
                                        <tbody>
                                            <?php $number = 0; ?>
                                            <?php foreach ($pengguna_layanan as $p) : ?>
                                                <tr>
                                                    <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;">
                                                        <?php $number++;
                                                        echo $number; ?>
                                                    </td>
                                                    <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;">
                                                        <?= $p['nama_pengguna']; ?>
                                                    </td>
                                                    <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;">
                                                        <?= $p['email_pengguna']; ?>
                                                    </td>
                                                    <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;">
                                                        <?= $p['no_telp_pengguna']; ?>
                                                    </td>
                                                    <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;">
                                                        <?= $p['instansi_asal_pengguna']; ?>
                                                    </td>
                                                    <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;">
                                                        <a href="<?= base_url('/detail-pengguna-layanan/' . $p['no_telp_pengguna']); ?>" class="" target="">
                                                            <span class="material-symbols-outlined">
                                                                open_in_new
                                                            </span>
                                                        </a>
                                                    </td>
                                                    <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;">
                                                        <a href="<?= base_url('/edit-pengguna-layanan/' . $p['no_telp_pengguna']); ?>" class="">
                                                            <span class="material-symbols-outlined">
                                                                edit
                                                            </span>
                                                        </a>
                                                    </td>
                                                    <?php if ($jenis_akses == 'Admin') { ?>
                                                        <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;">
                                                            <form action="<?= base_url('/hapus-pengguna-layanan/' . $p['no_telp_pengguna']); ?>" method="post" class="d-inline">
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
                                <div class="tab-pane fade" id="tab-entry-pengguna-layanan" role="tabpanel">
                                    <table class="table-hover" id="table-entry">
                                        <thead>
                                            <th class="col-md-1 font-weight-normal ps-0" scope="col">
                                                Tanggal Entry
                                            </th>
                                            <th class="col-md-2 font-weight-normal ps-0" scope="col">
                                                Nama
                                            </th>
                                            <th class="col-md-2 font-weight-normal ps-0" scope="col">
                                                Konsultasi Dengan
                                            </th>
                                            <th class="col-md-2 font-weight-normal ps-0" scope="col">
                                                Perihal
                                            </th>
                                            <th class="col-md-1 font-weight-normal ps-0" scope="col">
                                                Jenis Layanan
                                            </th>
                                            <th class="col-md-1 font-weight-normal ps-0" scope="col">
                                                Jenis Konsultasi
                                            </th>
                                            <th class="col-md-1 font-weight-normal ps-0" scope="col"></th>
                                            <th class="col-md-1 font-weight-normal ps-0" scope="col"></th>
                                            <th class="col-md-1 font-weight-normal ps-0" scope="col"></th>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($entry_pengguna_layanan as $e) : ?>
                                                <tr>
                                                    <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;">
                                                        <?= $e['tanggal_entry']; ?>
                                                    </td>
                                                    <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;">
                                                        <?= $e['nama_pengguna']; ?>
                                                    </td>
                                                    <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;">
                                                        <?= $e['nama_unit_kerja']; ?>
                                                    </td>
                                                    <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;">
                                                        <?= $e['perihal_konsultasi']; ?>
                                                    </td>
                                                    <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;">
                                                        <?= $e['jenis_layanan']; ?>
                                                    </td>
                                                    <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;">
                                                        <?= $e['jenis_konsultasi']; ?>
                                                    </td>
                                                    <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;">
                                                        <a href="<?= base_url('/detail-entry-pengguna/' . $e['id_entry']); ?>" class="">
                                                            <span class="material-symbols-outlined">
                                                                open_in_new
                                                            </span>
                                                        </a>
                                                    </td>
                                                    <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;">
                                                        <a href="<?= base_url('/edit-entry-pengguna/' . $e['id_entry']); ?>" class="">
                                                            <span class="material-symbols-outlined">
                                                                edit
                                                            </span>
                                                        </a>
                                                    </td>
                                                    <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;">
                                                        <form action="<?= base_url('/hapus-entry-pengguna/' . $e['id_entry']); ?>" method="post" class="d-inline">
                                                            <?= csrf_field(); ?>
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <button href="" class="link-tambahan" onclick="return confirm('Anda Yakin?')" style="border: none; outline: none; background:none;">
                                                                <span class="material-symbols-outlined">
                                                                    delete
                                                                </span>
                                                            </button>
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

<?= $this->endSection(); ?>