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
                <div class="col-11 mb-4">
                    <div class="input-group input-group-outline ms-1">
                        <select class="form-control form-select mt-0 fs-6" name="tambah_or_entry" id="tambah_or_entry" style="color:#000000;">
                            <option value="" selected disabled>Tambah Atau Entry</option>
                            <option value="tambah">Tambah</option>
                            <option value="entry">Entry</option>
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <form action="<?= base_url('/sub-tambah-pengguna'); ?>" method="post" class="tambah_pengguna pb-5" id="tambah">
                        <?= csrf_field(); ?>
                        <div class="col-11 mb-3">
                            <div class="input-group input-group-outline ms-1">
                                <input type="hidden" id="jenis_tambah" name="jenis_tambah" class="form-control form-control-md" placeholder="" aria-label="Jenis Tambah" value="tambah" required>
                            </div>
                        </div>
                        <div class="col-11 mb-3">
                            <label class="form-label text-rose" for="no_telp_pengguna">
                                No Telp Pengguna (Whatsapp)
                            </label>
                            <div class="input-group input-group-outline ms-1">
                                <input type="number" id="no_telp_pengguna" name="no_telp_pengguna" class="form-control form-control-md fs-6" placeholder="" aria-label="No Telp Pengguna (Whatsapp)" style="color:#000000;" required>
                            </div>
                        </div>
                        <div class="col-11 mb-3">
                            <label class="form-label text-rose" for="email_pengguna">
                                Email Pengguna
                            </label>
                            <div class="input-group input-group-outline ms-1">
                                <input type="text" id="email_pengguna" name="email_pengguna" class="form-control form-control-md fs-6" placeholder="" aria-label="Email Pengguna" style="color:#000000;" required>
                            </div>
                        </div>
                        <div class="col-11 mb-3">
                            <label class="form-label text-rose" for="nama_pengguna">
                                Nama Pengguna
                            </label>
                            <div class="input-group input-group-outline ms-1">
                                <input type="text" id="nama_pengguna" name="nama_pengguna" class="form-control form-control-md fs-6" placeholder="" aria-label="Nama Pengguna" style="color:#000000;" required>
                            </div>
                        </div>
                        <div class="col-11 mb-3">
                            <label class="form-label text-rose" for="instansi_asal_pengguna">
                                Instansi Asal Pengguna
                            </label>
                            <div class="input-group input-group-outline ms-1">
                                <input type="text" id="instansi_asal_pengguna" name="instansi_asal_pengguna" class="form-control form-control-md fs-6" placeholder="" aria-label="Instansi Asal Pengguna" style="color:#000000;" required>
                            </div>
                        </div>
                        <div class="col-11 mb-3 pt-3 ps-1">
                            <button type="submit" class="btn bg-gradient-primary font-weight-bolder">
                                Submit
                            </button>
                        </div>
                    </form>
                    <form action="<?= base_url('/sub-tambah-pengguna'); ?>" method="post" class="tambah_pengguna pb-5" id="entry">
                        <?= csrf_field(); ?>
                        <?php if ($jenis_akses == 'Admin') { ?>
                            <div class="col-2 mb-2">
                                <label class="form-label text-rose" for="tanggal_entry">
                                    Tanggal Entry
                                </label>
                                <div class="input-group input-group-outline ms-1">
                                    <input type="datetime-local" id="tanggal_entry" name="tanggal_entry" class="form-control form-control-md fs-6" placeholder="" aria-label="Instansi Asal Pengguna" style="color:#000000;" required>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="col-11 mb-2">
                                <label class="form-label text-rose" for="tanggal_entry">
                                    Tanggal Entry
                                </label>
                                <div class="input-group input-group-outline ms-1">
                                    <input type="hidden" id="tanggal_ditentukan" name="tanggal_ditentukan" class="form-control form-control-md fs-6" placeholder="" aria-label="Tanggal Entry" value="tanggal_ditentukan" style="color:#000000;" required>
                                    <input type="text" id="tanggal_entry" name="tanggal_entry" class="form-control form-control-md fs-6" placeholder="" aria-label="Instansi Asal Pengguna" value="<?php echo 'Tanggal Entry: ' . date('d M, Y H:i:s'); ?>" style="color:#000000;" disabled>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="col-11 mb-3">
                            <div class="input-group input-group-outline ms-1">
                                <input type="hidden" id="jenis_tambah" name="jenis_tambah" class="form-control form-control-md" placeholder="" aria-label="Jenis Tambah" value="entry" required>
                            </div>
                        </div>
                        <div class="col-11 mb-3">
                            <label class="form-label text-rose" for="no_telp_pengguna">
                                No Telp Pengguna (Whatsapp)
                            </label>
                            <div class="input-group input-group-outline ms-1">
                                <input type="number" id="no_telp_pengguna" name="no_telp_pengguna" class="form-control form-control-md fs-6" placeholder="" aria-label="No Telp Pengguna (Whatsapp)" style="color:#000000;" required>
                            </div>
                        </div>
                        <div class="col-11 mb-3">
                            <label class="form-label text-rose" for="email_pengguna">
                                Email Pengguna
                            </label>
                            <div class="input-group input-group-outline ms-1">
                                <input type="text" id="email_pengguna" name="email_pengguna" class="form-control form-control-md fs-6" placeholder="" aria-label="Email Pengguna" style="color:#000000;" required>
                            </div>
                        </div>
                        <div class="col-11 mb-3">
                            <label class="form-label text-rose" for="nama_pengguna">
                                Nama Pengguna
                            </label>
                            <div class="input-group input-group-outline ms-1">
                                <input type="text" id="nama_pengguna" name="nama_pengguna" class="form-control form-control-md fs-6" placeholder="" aria-label="Nama Pengguna" style="color:#000000;" required>
                            </div>
                        </div>
                        <div class="col-11 mb-3">
                            <label class="form-label text-rose" for="instansi_asal_pengguna">
                                Instansi Asal Pengguna
                            </label>
                            <div class="input-group input-group-outline ms-1">
                                <input type="text" id="instansi_asal_pengguna" name="instansi_asal_pengguna" class="form-control form-control-md fs-6" placeholder="" aria-label="Instansi Asal Pengguna" style="color:#000000;" required>
                            </div>
                        </div>
                        <div class="col-11 mb-3">
                            <label class="form-label text-rose" for="user_id">
                                Unit Kerja yang Ingin Dikonsultasikan
                            </label>
                            <div class="input-group input-group-outline ms-1">
                                <select class="form-control form-select form-select-unit-kerja mt-0 fs-6" name="user_id" id="user_id" style="color:#000000;">
                                    <option value="" selected disabled></option>
                                    <?php foreach ($data_user as $d) :
                                        if ($d['jenis_akses'] == 'Unit Kerja') { ?>
                                            <option value="<?= $d['user_id']; ?>"><?= $d['nama_unit_kerja']; ?></option>
                                    <?php }
                                    endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-11 mb-3">
                            <label class="form-label text-rose" for="jenis_layanan">
                                Jenis Layanan
                            </label>
                            <div class="input-group input-group-outline ms-1">
                                <select class="form-control form-select form-select-unit-kerja mt-0 fs-6" name="jenis_layanan" id="jenis_layanan" style="color:#000000;">
                                    <option value="" selected disabled></option>
                                    <?php foreach ($jenis_layanan as $j) : ?>
                                        <option value="<?= $j['jenis_layanan']; ?>"><?= $j['nama_jenis_layanan']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-11 mb-3">
                            <label class="form-label text-rose" for="perihal_konsultasi">
                                Perihal Konsultasi
                            </label>
                            <div class="input-group input-group-outline ms-1">
                                <input type="text" id="perihal_konsultasi" name="perihal_konsultasi" class="form-control form-control-md fs-6" placeholder="" aria-label="Perihal Konsultasi" style="color:#000000;" required>
                            </div>
                        </div>
                        <div class="col-11 mb-3">
                            <label class="form-label text-rose" for="jenis_konsultasi">
                                Jenis Konsultasi
                            </label>
                            <div class="input-group input-group-outline is-filled ms-1">
                                <select class="form-control form-select form-select-jenis-konsultasi jenis_konsultasi mt-0" name="jenis_konsultasi" id="jenis_konsultasi" style="color:#000000;" required>
                                    <option value="" selected disabled></option>
                                    <option value="Langsung">Langsung</option>
                                    <option value="Online">Online</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-11 mb-3 div_jadwal_konsultasi" id="Online">
                            <label class="form-label text-rose" for="jadwal_konsultasi">
                                Jadwal Konsultasi (Konsultasi dibuka dari jam 13:00 WIB - 15:00 WIB, jam konsultasi akan diinfokan melalui Whatsapp)
                            </label>
                            <div class="col-2">
                                <div class="input-group input-group-outline ms-1 jadwal_konsultasi">
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