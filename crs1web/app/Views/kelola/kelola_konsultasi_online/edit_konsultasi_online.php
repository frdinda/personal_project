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
                    <form action="<?= base_url('/sub-edit-konsultasi-online'); ?>" method="post" class="edit_konsultasi_online pb-5" id="edit_konsultasi_online">
                        <?= csrf_field(); ?>
                        <div class="col-8 mb-3">
                            <input type="hidden" id="id_konsultasi_online" name="id_konsultasi_online" class="form-control form-control-md fs-6" placeholder="" aria-label="ID Entry" style="color:#000000;" value="<?= $detail_jadwal_konsultasi['id_konsultasi_online']; ?>" required>
                        </div>
                        <div class="col-11 mb-3">
                            <label class="form-label text-rose" for="tanggal_konsultasi">
                                Tanggal Konsultasi
                            </label>
                            <div class="input-group input-group-outline ms-1">
                                <input type="text" id="" name="" class="form-control form-control-md fs-6" placeholder="" aria-label="Nama Pengguna" value="<?= $detail_jadwal_konsultasi['tanggal_konsultasi_online'] . " " . $detail_jadwal_konsultasi['jam_konsultasi_online']; ?>" style="color:#000000;" disabled>
                            </div>
                        </div>
                        <div class="col-11 mb-3">
                            <label class="form-label text-rose" for="no_telp_pengguna">
                                Nama Pengguna
                            </label>
                            <div class="input-group input-group-outline ms-1">
                                <input type="hidden" id="no_telp_pengguna" name="no_telp_pengguna" class="form-control form-control-md fs-6" placeholder="" aria-label="Nama Pengguna" value="<?= $detail_jadwal_konsultasi['no_telp_pengguna']; ?>" style="color:#000000;" required>
                                <input type="text" id="" name="" class="form-control form-control-md fs-6" placeholder="" aria-label="Nama Pengguna" value="<?= $detail_jadwal_konsultasi['nama_pengguna']; ?>" style="color:#000000;" disabled>
                            </div>
                        </div>
                        <div class="col-11 mb-3">
                            <label class="form-label text-rose" for="user_id">
                                Unit Kerja
                            </label>
                            <div class="input-group input-group-outline ms-1">
                                <input type="hidden" id="user_id" name="user_id" class="form-control form-control-md fs-6" placeholder="" aria-label="Unit kerja" value="<?= $detail_jadwal_konsultasi['user_id']; ?>" style="color:#000000;" required>
                                <input type="text" id="" name="" class="form-control form-control-md fs-6" placeholder="" aria-label="Unit kerja" value="<?= $detail_jadwal_konsultasi['nama_unit_kerja']; ?>" style="color:#000000;" disabled>
                            </div>
                        </div>
                        <div class="col-11 mb-3">
                            <label class="form-label text-rose" for="id_entry">
                                Perihal Konsultasi
                            </label>
                            <div class="input-group input-group-outline ms-1">
                                <input type="hidden" id="id_entry" name="id_entry" class="form-control form-control-md fs-6" placeholder="" aria-label="Perihal Konsultasi" value="<?= $detail_jadwal_konsultasi['id_entry']; ?>" style="color:#000000;" required>
                                <input type="text" id="" name="" class="form-control form-control-md fs-6" placeholder="" aria-label="Perihal Konsultasi" value="<?= $detail_jadwal_konsultasi['perihal_konsultasi']; ?>" style="color:#000000;" disabled>
                            </div>
                        </div>
                        <div class="col-11 mb-3">
                            <label class="form-label text-rose" for="room_zoom">
                                Room Zoom
                            </label>
                            <?php if ($jenis_akses == 'Pegawai' || $jenis_akses == 'Unit Kerja') { ?>
                                <div class="input-group input-group-outline ms-1">
                                    <input type="hidden" id="room_zoom" name="room_zoom" class="form-control form-control-md fs-6" placeholder="" aria-label="Room Zoom" value="<?= $detail_jadwal_konsultasi['room_zoom']; ?>" style="color:#000000;" required>
                                    <input type="text" id="" name="" class="form-control form-control-md fs-6" placeholder="" aria-label="Room Zoom" value="<?= $detail_jadwal_konsultasi['room_zoom']; ?>" style="color:#000000;" disabled>
                                </div>
                            <?php } else if ($jenis_akses == 'Admin') { ?>
                                <div class="input-group input-group-outline ms-1">
                                    <input type="number" id="room_zoom" name="room_zoom" class="form-control form-control-md fs-6" placeholder="" aria-label="Room Zoom" value="<?= $detail_jadwal_konsultasi['room_zoom']; ?>" style="color:#000000;" required>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-11 mb-3">
                            <label class="form-label text-rose" for="NIP">
                                Pilih Konsultan
                            </label>
                            <div class="input-group input-group-outline ms-1">
                                <select class="form-control form-select form-select-unit-kerja mt-0" name="NIP" id="NIP" style="color:#000000;" required>
                                    <?php if (isset($detail_jadwal_konsultasi['NIP'])) { ?>
                                        <?php foreach ($data_user as $d) :
                                            if ($d['jenis_akses'] == 'Pegawai') {
                                                if ($d['user_id'] == '111') { ?>
                                                    <option value="" selected disabled>Konsultan</option>
                                                <?php } else if ($detail_jadwal_konsultasi['NIP'] == $d['user_id']) { ?>
                                                    <option value="<?= $d['user_id']; ?>" selected><?= $d['nama_kepala']; ?></option>
                                                <?php } else { ?>
                                                    <option value="<?= $d['user_id']; ?>"><?= $d['nama_kepala']; ?></option>
                                        <?php }
                                            }
                                        endforeach; ?>
                                    <?php } else { ?>
                                        <option value="" selected disabled>Konsultan</option>
                                        <?php foreach ($data_user as $d) :
                                            if ($d['jenis_akses'] == 'Pegawai') { ?>
                                                <option value="<?= $d['user_id']; ?>"><?= $d['nama_kepala']; ?></option>
                                        <?php }
                                        endforeach; ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-8 mb-3 pt-3 ps-1">
                            <button type="submit" class="btn bg-gradient-primary font-weight-bolder">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>