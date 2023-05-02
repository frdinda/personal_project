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
                <div class="col-12 pb-3">
                    <table class="table-hover" id=""">
                        <thead>
                            <th class=" col-md-4 font-weight-normal ps-1" scope="col">
                        </th>
                        <th class="col-md-1 font-weight-normal ps-1" scope="col"></th>
                        <th class="col-md-7 font-weight-normal ps-1" scope="col"></th>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                    Nama Pengguna
                                </td>
                                <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                    :
                                </td>
                                <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                    <?= $detail_pengguna['nama_pengguna']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                    Email Pengguna
                                </td>
                                <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                    :
                                </td>
                                <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                    <?= $detail_pengguna['email_pengguna']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                    No Telp Pengguna
                                </td>
                                <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                    :
                                </td>
                                <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                    <?= $detail_pengguna['no_telp_pengguna']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                    Instansi Asal Pengguna
                                </td>
                                <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                    :
                                </td>
                                <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                    <?= $detail_pengguna['instansi_asal_pengguna']; ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-12">
                    <table class="table-hover" id="table-biasa">
                        <thead>
                            <th class="col-md-2 font-weight-normal ps-1" scope="col">Tanggal Entry</th>
                            <th class="col-md-2 font-weight-normal ps-1" scope="col">Konsultasi Dengan</th>
                            <th class="col-md-3 font-weight-normal ps-1" scope="col">Perihal</th>
                            <th class="col-md-1 font-weight-normal ps-1" scope="col">Jenis Layanan</th>
                            <th class="col-md-1 font-weight-normal ps-1" scope="col">Jenis Konsultasi</th>
                            <th class="col-md-1 font-weight-normal ps-1" scope="col"></th>
                            <th class="col-md-1 font-weight-normal ps-1" scope="col"></th>
                            <th class="col-md-1 font-weight-normal ps-1" scope="col"></th>
                        </thead>
                        <tbody>
                            <?php foreach ($detail_entry_pengguna as $d) : ?>
                                <tr>
                                    <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                        <?= $d['tanggal_entry']; ?>
                                    </td>
                                    <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                        <?= $d['nama_unit_kerja']; ?>
                                    </td>
                                    <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                        <?= $d['perihal_konsultasi']; ?>
                                    </td>
                                    <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                        <?= $d['jenis_layanan']; ?>
                                    </td>
                                    <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                        <?= $d['jenis_konsultasi']; ?>
                                    </td>
                                    <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;">
                                        <a href="<?= base_url('/detail-entry-pengguna/' . $d['id_entry']); ?>" class="">
                                            <span class="material-symbols-outlined">
                                                open_in_new
                                            </span>
                                        </a>
                                    </td>
                                    <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                        <a href="<?= base_url('/edit-entry-pengguna/' . $d['id_entry']); ?>" class="">
                                            <span class="material-symbols-outlined">
                                                edit
                                            </span>
                                        </a>
                                    </td>
                                    <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                        <form action="<?= base_url('/hapus-entry-pengguna/' . $d['id_entry']); ?>" method="post" class="d-inline">
                                            <?= csrf_field(); ?>
                                            <a href="" class="" onclick="return confirm('Anda Yakin?')">
                                                <span class="material-symbols-outlined">
                                                    delete
                                                </span>
                                            </a>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <!-- id_entry (hidden) -->
                        <!-- tanggal_entry -->
                        <!-- user_id (siapa dia mau ketemu) -->
                        <!-- perihal_konsultasi (perihalnya) -->
                        <!-- jenis_layanan -->
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>