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
                    <form action="<?= base_url('/sub-edit-profil'); ?>" method="post" class="edit_profil pb-5" id="Edit">
                        <div class="col-11 mb-3">
                            <?php if ($jenis_akses == 'Pegawai') { ?>
                                <label class="form-label text-rose" for="user_id">
                                    NIP Pegawai
                                </label>
                            <?php } else { ?>
                                <label class="form-label text-rose" for="user_id">
                                    User ID
                                </label>
                            <?php } ?>
                            <div class="input-group input-group-outline is-filled ms-1">
                                <input type="hidden" id="user_id" name="user_id" class="form-control form-control-md fs-6" placeholder="" aria-label="User ID" style="color:#000000;" value="<?= $detail_user['user_id']; ?>" required>
                                <input type="text" id="user_id" name="user_id" class="form-control form-control-md fs-6" placeholder="" aria-label="User ID" style="color:#000000;" value="<?= $detail_user['user_id']; ?>" disabled>
                            </div>
                        </div>
                        <div class="col-11 mb-3">
                            <label class="form-label text-rose" for="nama_unit_kerja">
                                Nama Unit Kerja
                            </label>
                            <div class="input-group input-group-outline is-filled ms-1">
                                <input type="text" id="nama_unit_kerja" name="nama_unit_kerja" class="form-control form-control-md fs-6" placeholder="" aria-label="Nama Unit Kerja" style="color:#000000;" value="<?= $detail_user['nama_unit_kerja']; ?>" required>
                            </div>
                        </div>
                        <div class="col-11 mb-3">
                            <?php if ($jenis_akses == 'Pegawai') { ?>
                                <label class="form-label text-rose" for="nama_kepala">
                                    Nama Pegawai
                                </label>
                            <?php } else { ?>
                                <label class="form-label text-rose" for="nama_kepala">
                                    Nama Kepala Unit Kerja
                                </label>
                            <?php } ?>
                            <div class="input-group input-group-outline is-filled ms-1">
                                <input type="text" id="nama_kepala" name="nama_kepala" class="form-control form-control-md fs-6" placeholder="" aria-label="Nama Kepala Unit Kerja" style="color:#000000;" value="<?= $detail_user['nama_kepala']; ?>" required>
                            </div>
                        </div>
                        <?php if ($jenis_akses != 'Pegawai') { ?>
                            <div class="col-11 mb-3">
                                <label class="form-label text-rose" for="nip_kepala">
                                    NIP Kepala Unit Kerja
                                </label>
                                <div class="input-group input-group-outline is-filled ms-1">
                                    <input type="text" id="nip_kepala" name="nip_kepala" class="form-control form-control-md fs-6" placeholder="" aria-label="NIP Kepala Unit Kerja" style="color:#000000;" value="<?= $detail_user['nip_kepala']; ?>" required>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="col-11 mb-3">
                            <?php if ($jenis_akses == 'Pegawai') { ?>
                                <label class="form-label text-rose" for="no_telp_representatif">
                                    Nomor Telepon Pegawai
                                </label>
                            <?php } else { ?>
                                <label class="form-label text-rose" for="no_telp_representatif">
                                    Nomor Telepon Representatif
                                </label>
                            <?php } ?>
                            <div class="input-group input-group-outline is-filled ms-1">
                                <input type="number" id="no_telp_representatif" name="no_telp_representatif" class="form-control form-control-md fs-6" placeholder="" aria-label="Nomor Telepon Representatif" style="color:#000000;" value="<?= $detail_user['no_telp_representatif']; ?>" required>
                            </div>
                        </div>
                        <div class="col-11 mb-3">
                            <label class="form-label text-rose" for="password">
                                Password
                            </label>
                            <div class="input-group input-group-outline is-filled ms-1">
                                <input type="password" id="password" name="password" class="form-control form-control-md fs-6" placeholder="" aria-label="Password" style="color:#000000;" value="" required>
                            </div>
                        </div>
                        <div class="col-11 mb-3">
                            <label class="form-label text-rose" for="konfirmasi_password">
                                Konfirmasi Password
                            </label>
                            <div class="input-group input-group-outline is-filled ms-1">
                                <input type="password" id="konfirmasi_password" name="konfirmasi_password" class="form-control form-control-md fs-6" placeholder="" aria-label="Konfirmasi Password" style="color:#000000;" value="" required>
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