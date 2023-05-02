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
                    <form action="<?= base_url('/sub-edit-entry-pengguna'); ?>" method="post" class="edit_entry_pengguna pb-5" id="edit_entry">
                        <?= csrf_field(); ?>
                        <div class="col-8 mb-3">
                            <input type="hidden" id="id_entry" name="id_entry" class="form-control form-control-md fs-6" placeholder="" aria-label="ID Entry" style="color:#000000;" value="<?= $detail_entry['id_entry']; ?>" required>
                        </div>
                        <?php if ($jenis_akses == 'Admin') { ?>
                            <div class="col-2 mb-3">
                                <label class="form-label text-rose" for="tanggal_entry">
                                    Tanggal Entry
                                </label>
                                <div class="input-group input-group-outline ms-1">
                                    <input type="datetime-local" id="tanggal_entry" name="tanggal_entry" class="form-control form-control-md fs-6" placeholder="" aria-label="Tanggal Entry" style="color:#000000;" value="<?= $detail_entry['tanggal_entry']; ?>" required>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="col-11 mb-3">
                                <label class="form-label text-rose" for="tanggal_entry">
                                    Tanggal Entry
                                </label>
                                <div class="input-group input-group-outline ms-1">
                                    <input type="hidden" id="tanggal_ditentukan" name="tanggal_ditentukan" class="form-control form-control-md fs-6" placeholder="" aria-label="Tanggal Entry" value="tanggal_ditentukan" style="color:#000000;" required>
                                    <input type="text" id="tanggal_entry" name="tanggal_entry" class="form-control form-control-md fs-6" placeholder="" aria-label="Tanggal Entry" value="<?php echo 'Tanggal Entry: ' . $detail_entry['tanggal_entry']; ?>" style="color:#000000;" disabled>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="col-11 mb-3">
                            <label class="form-label text-rose" for="no_telp_pengguna">
                                Nama Pengguna
                            </label>
                            <div class="input-group input-group-outline is-filled ms-1">
                                <select class="form-control form-select form-select-pengguna-layanan mt-0" name="no_telp_pengguna" id="no_telp_pengguna" style="color:#000000;" required>
                                    <?php if (isset($detail_entry['no_telp_pengguna'])) { ?>
                                        <option value="" disabled>Nama Pengguna Layanan</option>
                                        <?php foreach ($data_pengguna_layanan as $d) :
                                            if ($detail_entry['no_telp_pengguna'] == $d['no_telp_pengguna']) { ?>
                                                <option value="<?= $d['no_telp_pengguna']; ?>" selected><?= $d['nama_pengguna']; ?></option>
                                            <?php } else { ?>
                                                <option value="<?= $d['no_telp_pengguna']; ?>"><?= $d['nama_pengguna']; ?></option>
                                        <?php }
                                        endforeach; ?>
                                    <?php } else { ?>
                                        <option value="" selected disabled>Nama Pengguna Layanan</option>
                                        <?php foreach ($data_pengguna_layanan as $d) : ?>
                                            <option value="<?= $d['no_telp_pengguna']; ?>"><?= $d['nama_pengguna']; ?></option>
                                        <?php endforeach; ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-11 mb-3">
                            <label class="form-label text-rose" for="user_id">
                                Unit Kerja
                            </label>
                            <div class="input-group input-group-outline is-filled ms-1">
                                <select class="form-control form-select form-select-unit-kerja mt-0" name="user_id" id="user_id" style="color:#000000;" required>
                                    <?php if (isset($detail_entry['user_id'])) { ?>
                                        <option value="" disabled>Unit Kerja</option>
                                        <?php foreach ($data_user as $d) :
                                            if ($detail_entry['user_id'] == $d['user_id']) { ?>
                                                <option value="<?= $d['user_id']; ?>" selected><?= $d['nama_unit_kerja']; ?></option>
                                            <?php } else { ?>
                                                <option value="<?= $d['user_id']; ?>"><?= $d['nama_unit_kerja']; ?></option>
                                        <?php }
                                        endforeach; ?>
                                    <?php } else { ?>
                                        <select class="form-control form-select form-select-unit-kerja mt-0" name="user_id" id="user_id" style="color:#000000;">
                                            <option value="" selected disabled>Unit Kerja</option>
                                            <?php foreach ($data_user as $d) : ?>
                                                <option value="<?= $d['user_id']; ?>"><?= $d['nama_unit_kerja']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-11 mb-3">
                            <label class="form-label text-rose" for="jenis_layanan">
                                Jenis Layanan
                            </label>
                            <div class="input-group input-group-outline is-filled ms-1">
                                <select class="form-control form-select form-select-unit-kerja mt-0" name="jenis_layanan" id="jenis_layanan" style="color:#000000;" required>
                                    <?php if (isset($detail_entry['jenis_layanan'])) { ?>
                                        <option value="" disabled>Jenis Layanan</option>
                                        <?php foreach ($jenis_layanan as $j) :
                                            if ($detail_entry['jenis_layanan'] == $j['jenis_layanan']) { ?>
                                                <option value="<?= $j['jenis_layanan']; ?>" selected><?= $j['nama_jenis_layanan']; ?></option>
                                            <?php } else { ?>
                                                <option value="<?= $j['jenis_layanan']; ?>"><?= $j['nama_jenis_layanan']; ?></option>
                                        <?php }
                                        endforeach; ?>
                                    <?php } else { ?>
                                        <select class="form-control form-select form-select-unit-kerja mt-0" name="jenis_layanan" id="jenis_layanan" style="color:#000000;">
                                            <option value="" selected disabled>Jenis Layanan</option>
                                            <?php foreach ($jenis_layanan as $j) : ?>
                                                <option value="<?= $j['jenis_layanan']; ?>"><?= $j['nama_jenis_layanan']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-11 mb-3">
                            <label class="form-label text-rose" for="perihal_konsultasi">
                                Perihal Konsultasi
                            </label>
                            <div class="input-group input-group-outline is-filled ms-1">
                                <input type="text" id="perihal_konsultasi" name="perihal_konsultasi" class="form-control form-control-md fs-6" placeholder="" aria-label="Perihal Konsultasi" value="<?= $detail_entry['perihal_konsultasi'] ?>" style="color:#000000;" required>
                            </div>
                        </div>
                        <div class="col-11 mb-3">
                            <label class="form-label text-rose" for="jenis_konsultasi">
                                Jenis Konsultasi
                            </label>
                            <div class="input-group input-group-outline is-filled ms-1">
                                <select class="form-control form-select form-select-jenis-konsultasi mt-0" name="jenis_konsultasi" id="jenis_konsultasi" style="color:#000000;" required>
                                    <?php if ($detail_entry['jenis_konsultasi'] == 'Langsung') { ?>
                                        <option value="Langsung" selected>Langsung</option>
                                        <option value="Online">Online</option>
                                    <?php } else if ($detail_entry['jenis_konsultasi'] == 'Online') { ?>
                                        <option value="Langsung">Langsung</option>
                                        <option value="Online" selected>Online</option>
                                    <?php } else { ?>
                                        <option value="" selected disabled></option>
                                        <option value="Langsung">Langsung</option>
                                        <option value="Online">Online</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-11 mb-3">
                            <div class="input-group input-group-outline is-filled ms-1">
                                <?php if (isset($detail_jadwal_konsultasi)) { ?>
                                    <input type="hidden" id="id_konsultasi_online" name="id_konsultasi_online" class="form-control form-control-md fs-6" placeholder="" aria-label="ID Konsultasi Online" value="<?= $detail_jadwal_konsultasi['id_konsultasi_online'] ?>" style="color:#000000;" required>
                                <?php } else { ?>
                                    <input type="hidden" id="id_konsultasi_online" name="id_konsultasi_online" class="form-control form-control-md fs-6" placeholder="" aria-label="ID Konsultasi Online" value="" style="color:#000000;">
                                <?php } ?>

                            </div>
                        </div>
                        <?php if ($detail_entry['jenis_konsultasi'] == 'Online') { ?>
                            <div class="col-11 mb-3 div_jadwal_konsultasi" id="Online">
                                <label class="form-label text-rose" for="jadwal_konsultasi">
                                    Jadwal Konsultasi (Konsultasi dibuka dari jam 13:00 WIB - 15:00 WIB, harap pilih jam konsultasi di antara waktu yang telah ditentukan, jam konsultasi akan diinfokan melalui Whatsapp)
                                </label>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-3 mb-3">
                                            <?php if (date('H:i:s') >= '15:00:00') { ?>
                                                <div class="input-group input-group-outline ms-1 jadwal_konsultasi">
                                                    <input type="date" id="jadwal_konsultasi" name="jadwal_konsultasi" class="form-control form-control-md fs-6" placeholder="" aria-label="Jadwal Konsultasi" style="color:#000000;" min="<?= date("Y-m-d", strtotime('+1 day')) ?>" value="
                                                <?php if (isset($detail_jadwal_konsultasi)) {
                                                    echo $detail_jadwal_konsultasi['tanggal_konsultasi_online'];
                                                } else {
                                                } ?>">
                                                </div>
                                            <?php } else { ?>
                                                <div class="input-group input-group-outline ms-1 jadwal_konsultasi">
                                                    <input type="date" id="jadwal_konsultasi" name="jadwal_konsultasi" class="form-control form-control-md fs-6" placeholder="" aria-label="Jadwal Konsultasi" style="color:#000000;" min="<?= date('Y-m-d'); ?>" value="
                                                <?php if (isset($detail_jadwal_konsultasi)) {
                                                    echo $detail_jadwal_konsultasi['tanggal_konsultasi_online'];
                                                } else {
                                                } ?>">
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <div class="col-3 ms-1">
                                            <select class="form-control form-select form-select-jam-konsultasi mt-0" name="jam_konsultasi" id="jam_konsultasi" style="color:#000000;">
                                                <?php if (isset($detail_jadwal_konsultasi)) { ?>
                                                    <?php if ($detail_jadwal_konsultasi['jam_konsultasi_online'] == '13:00:00') { ?>
                                                        <option value="13:00:00" selected>13:00:00</option>
                                                        <option value="14:00:00">14:00:00</option>
                                                        <option value="15:00:00">15:00:00</option>
                                                    <?php } else if ($detail_jadwal_konsultasi['jam_konsultasi_online'] == '14:00:00') { ?>
                                                        <option value="13:00:00">13:00:00</option>
                                                        <option value="14:00:00" selected>14:00:00</option>
                                                        <option value="15:00:00">15:00:00</option>
                                                    <?php } else if ($detail_jadwal_konsultasi['jam_konsultasi_online'] == '15:00:00') { ?>
                                                        <option value="13:00:00">13:00:00</option>
                                                        <option value="14:00:00">14:00:00</option>
                                                        <option value="15:00:00" selected>15:00:00</option>
                                                    <?php } else { ?>
                                                        <option value="" selected disabled>Jam Konsultasi</option>
                                                        <option value="13:00:00">13:00:00</option>
                                                        <option value="14:00:00">14:00:00</option>
                                                        <option value="15:00:00">15:00:00</option>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <option value="" selected disabled>Jam Konsultasi</option>
                                                    <option value="13:00:00">13:00:00</option>
                                                    <option value="14:00:00">14:00:00</option>
                                                    <option value="15:00:00">15:00:00</option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="col-11 mb-3 div_jadwal_konsultasi" id="Online">
                                <label class="form-label text-rose" for="jadwal_konsultasi">
                                    Jadwal Konsultasi (Konsultasi dibuka dari jam 13:00 WIB - 15:00 WIB, harap pilih jam konsultasi di antara waktu yang telah ditentukan, jam konsultasi akan diinfokan melalui Whatsapp)
                                </label>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-3">
                                            <?php if (date('H:i:s') >= '15:00:00') { ?>
                                                <div class="input-group input-group-outline ms-1 jadwal_konsultasi">
                                                    <input type="date" id="jadwal_konsultasi" name="jadwal_konsultasi" class="form-control form-control-md fs-6" placeholder="" aria-label="Jadwal Konsultasi" style="color:#000000;" min="<?= date("Y-m-d", strtotime('+1 day')) ?>">
                                                </div>
                                            <?php } else { ?>
                                                <div class="input-group input-group-outline ms-1 jadwal_konsultasi">
                                                    <input type="date" id="jadwal_konsultasi" name="jadwal_konsultasi" class="form-control form-control-md fs-6" placeholder="" aria-label="Jadwal Konsultasi" style="color:#000000;" min="<?= date('Y-m-d'); ?>">
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <div class="col-3 ms-1">
                                            <select class="form-control form-select form-select-jam-konsultasi mt-0" name="jam_konsultasi" id="jam_konsultasi" style="color:#000000;">
                                                <option value="" selected disabled>Jam Konsultasi</option>
                                                <option value="13:00:00">13:00:00</option>
                                                <option value="14:00:00">14:00:00</option>
                                                <option value="15:00:00">15:00:00</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
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