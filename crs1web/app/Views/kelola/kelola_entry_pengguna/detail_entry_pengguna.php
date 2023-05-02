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
                            <th class=" col-md-3 font-weight-normal ps-1" scope="col">
                        </th>
                        <th class="col-md-1 font-weight-normal ps-1" scope="col"></th>
                        <th class="col-md-8 font-weight-normal ps-1" scope="col"></th>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                    Tanggal Entry
                                </td>
                                <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                    :
                                </td>
                                <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                    <?= $detail_entry_pengguna['tanggal_entry']; ?>
                                </td>
                            </tr>
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
                                    Konsultasi dengan
                                </td>
                                <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                    :
                                </td>
                                <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                    <?= $detail_user['nama_unit_kerja']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                    Perihal Konsultasi
                                </td>
                                <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                    :
                                </td>
                                <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                    <?= $detail_entry_pengguna['perihal_konsultasi']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                    Jenis Konsultasi
                                </td>
                                <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                    :
                                </td>
                                <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                    <?= $detail_entry_pengguna['jenis_konsultasi']; ?>
                                </td>
                            </tr>
                            <?php if ($detail_entry_pengguna['jenis_konsultasi'] == 'Online') { ?>
                                <tr>
                                    <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                        Jadwal Konsultasi
                                    </td>
                                    <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                        :
                                    </td>
                                    <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                        <?= $detail_jadwal_konsultasi['tanggal_konsultasi_online'] . " " . $detail_jadwal_konsultasi['jam_konsultasi_online']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                        Nama Konsultan
                                    </td>
                                    <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                        :
                                    </td>
                                    <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                        <?php if ($detail_konsultan['user_id'] != '111') { ?>
                                            <?= $detail_konsultan['nama_unit_kerja']; ?>
                                        <?php } else { ?>
                                            Belum Ditentukan
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                        Room Zoom
                                    </td>
                                    <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                        :
                                    </td>
                                    <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                        <?= $detail_jadwal_konsultasi['room_zoom']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                        Link Zoom
                                    </td>
                                    <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                        :
                                    </td>
                                    <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                        <a href=""></a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <?php if ($detail_entry_pengguna['jenis_konsultasi'] == 'Online') { ?>
                        <p class="ms-1 mt-3 font-weight-bolder">Silahkan masuk ke link zoom maksimal 15 menit dari waktu yang telah ditentukan dan pilih room zoom yang telah ditentukan. Terima kasih. </p>
                    <?php } ?>
                    <?php if ($detail_entry_pengguna['jenis_konsultasi'] == 'Online' && isset($jenis_akses)) { ?>
                        <?php $jam_konsultasi_diatas_15_menit = explode(":", $detail_jadwal_konsultasi['jam_konsultasi_online']);
                        $jam_konsultasi_diatas_15_menit[1] = '15';
                        $jam_konsultasi_diatas_15_menit = implode(":", $jam_konsultasi_diatas_15_menit);
                        if ($detail_jadwal_konsultasi['tanggal_konsultasi_online'] <= date('Y-m-d') && $jam_konsultasi_diatas_15_menit < date('H:i:s')) { ?>
                            <form action="<?= base_url('/sub-feedback-entry-pengguna'); ?>" method="post" class="edit_entry_pengguna pb-5" id="edit_entry">
                                <div class="col-11 mb-3">
                                    <div class="input-group input-group-outline is-filled ms-1">
                                        <input type="hidden" id="id_entry" name="id_entry" class="form-control form-control-md fs-6" placeholder="" aria-label="Perihal Konsultasi" value="<?= $detail_entry_pengguna['id_entry']; ?>" style="color:#000000;" required>
                                        <input type="hidden" id="id_konsultasi_online" name="id_konsultasi_online" class="form-control form-control-md fs-6" placeholder="" aria-label="Perihal Konsultasi" value="<?= $detail_jadwal_konsultasi['id_konsultasi_online']; ?>" style="color:#000000;" required>
                                    </div>
                                </div>
                                <div class="col-11 mb-3">
                                    <label class="form-label text-rose" for="status_jalan_konsultasi">
                                        Status Konsultasi
                                    </label>
                                    <div class="input-group input-group-outline is-filled ms-1">
                                        <?php if ($detail_jadwal_konsultasi['status_jalan_konsultasi'] != null) { ?>
                                            <?php if ($detail_jadwal_konsultasi['status_jalan_konsultasi'] == 'Selesai') { ?>
                                                <select class="form-control form-select form-select-unit-kerja mt-0" name="status_jalan_konsultasi" id="status_jalan_konsultasi" style="color:#000000;">
                                                    <option value="Selesai" selected>Selesai</option>
                                                    <option value="Pengguna Layanan Tidak Join">Pengguna Layanan Tidak Join</option>
                                                </select>
                                            <?php } else if ($detail_jadwal_konsultasi['status_jalan_konsultasi'] == 'Pengguna Layanan Tidak Join') { ?>
                                                <select class="form-control form-select form-select-unit-kerja mt-0" name="status_jalan_konsultasi" id="status_jalan_konsultasi" style="color:#000000;">
                                                    <option value="Selesai">Selesai</option>
                                                    <option value="Pengguna Layanan Tidak Join" selected>Pengguna Layanan Tidak Join</option>
                                                </select>
                                            <?php } else { ?>
                                                <select class="form-control form-select form-select-unit-kerja mt-0" name="status_jalan_konsultasi" id="status_jalan_konsultasi" style="color:#000000;">
                                                    <option value="" selected disabled></option>
                                                    <option value="Selesai">Selesai</option>
                                                    <option value="Pengguna Layanan Tidak Join">Pengguna Layanan Tidak Join</option>
                                                </select>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <select class="form-control form-select form-select-unit-kerja mt-0" name="status_jalan_konsultasi" id="status_jalan_konsultasi" style="color:#000000;">
                                                <option value="" selected disabled></option>
                                                <option value="Selesai">Selesai</option>
                                                <option value="Pengguna Layanan Tidak Join">Pengguna Layanan Tidak Join</option>
                                            </select>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="col-11 mb-3">
                                    <label class="form-label text-rose" for="feedback_jalan_konsultasi">
                                        Feedback Konsultasi
                                    </label>
                                    <div class="input-group input-group-outline is-filled ms-1">
                                        <textarea type="text" id="feedback_jalan_konsultasi" name="feedback_jalan_konsultasi" class="form-control form-control-md fs-6" placeholder="" aria-label="Perihal Konsultasi" style="color:#000000;" required><?= $detail_jadwal_konsultasi['feedback_jalan_konsultasi'] ?></textarea>
                                    </div>
                                </div>
                                <div class="col-8 mb-3 pt-3 ps-1">
                                    <button type="submit" class="btn bg-gradient-primary font-weight-bolder">
                                        Submit
                                    </button>
                                </div>
                            </form>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>