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
                    <div class="col-11 mb-4">
                        <div class="input-group input-group-outline ms-1">
                            <select class="form-control form-select mt-0 fs-6" name="whatsapp_or_email" id="whatsapp_or_email" style="color:#000000;">
                                <option value="" selected disabled>Whatsapp atau Email</option>
                                <option value="Whatsapp">Whatsapp</option>
                                <option value="Email">Email</option>
                            </select>
                        </div>
                    </div>
                    <form action="<?= base_url('/sub-tambah-broadcast'); ?>" method="post" class="tambah_broadcast pb-5" id="Whatsapp">
                        <?= csrf_field(); ?>
                        <div class="col-2 mb-3">
                            <div class="input-group input-group-outline ms-1">
                                <input type="hidden" id="platform_broadcast" name="platform_broadcast" class="form-control form-control-md fs-6" placeholder="" aria-label="Platform Broadcast" style="color:#000000;" value="Whatsapp" required>
                            </div>
                        </div>
                        <div class="col-2 mb-3">
                            <label class="form-label text-rose" for="tanggal_broadcast">
                                Tanggal Broadcast
                            </label>
                            <div class="input-group input-group-outline ms-1">
                                <input type="datetime-local" id="tanggal_broadcast" name="tanggal_broadcast" class="form-control form-control-md fs-6" placeholder="" aria-label="Tanggal Broadcast" style="color:#000000;" min="<?= date('Y-m-d H:i'); ?>" required>
                            </div>
                        </div>
                        <?php if ($jenis_akses == 'Admin') { ?>
                            <div class="col-11 mb-3">
                                <label class="form-label text-rose" for="user_id">
                                    Nama Unit Kerja
                                </label>
                                <div class="input-group input-group-outline is-filled ms-1">
                                    <select class="form-control form-select form-select-pengguna-layanan-2 mt-0" name="user_id" id="user_id" style="color:#000000;" required>
                                        <option value="" disabled selected></option>
                                        <?php foreach ($data_user as $d) : ?>
                                            <?php if ($d['jenis_akses'] == 'Unit Kerja') { ?>
                                                <option value="<?= $d['user_id']; ?>"><?= $d['nama_unit_kerja']; ?></option>
                                            <?php } ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="col-11 mb-3">
                                <label class="form-label text-rose" for="user_id">
                                    Nama Unit Kerja
                                </label>
                                <div class="input-group input-group-outline is-filled ms-1">
                                    <input type="hidden" id="user_id" name="user_id" class="form-control form-control-md fs-6" placeholder="" aria-label="User ID" style="color:#000000;" value="<?= $user_id; ?>" required>
                                    <input type="text" id="user_id" name="user_id" class="form-control form-control-md fs-6" placeholder="" aria-label="User ID" style="color:#000000;" value="<?= $nama_unit_kerja; ?>" disabled>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="col-11 mb-3">
                            <label class="form-label text-rose" for="text_broadcast">
                                Judul Broadcast
                            </label>
                            <div class="input-group input-group-outline ms-1">
                                <input type="text" id="judul_broadcast" name="judul_broadcast" class="form-control form-control-md fs-6" placeholder="" aria-label="Judul Broadcast" style="color:#000000;" required>
                            </div>
                        </div>
                        <div class="col-11 mb-3">
                            <label class="form-label text-rose" for="text_broadcast">
                                Text Broadcast
                            </label>
                            <div class="input-group input-group-outline ms-1">
                                <textarea id="text_broadcast_whatsapp" name="text_broadcast" type="text" class="text_broadcast form-control form-control-lg mt-1" placeholder="" aria-label="text_broadcast" required></textarea>
                            </div>
                        </div>
                        <div class="col-11 mb-3">
                            <label class="form-label text-rose" for="thumbnail_broadcast">
                                Thumbnail Broadcast (Opsional: Dapatkan linknya dengan mengupload image di <a href="https://postimages.org/" target="_blank">https://postimages.org/</a> dan copy 'direct link')
                            </label>
                            <div class="input-group input-group-outline ms-1">
                                <input type="text" id="thumbnail_broadcast" name="thumbnail_broadcast" class="form-control form-control-md fs-6" placeholder="" aria-label="Thumbnail Broadcast" style="color:#000000;" value="">
                            </div>
                        </div>
                        <div class="col-11 mb-3">
                            <label class="form-label text-rose" for="tujuan_broadcast">
                                Tujuan Broadcast
                            </label>
                            <div class="input-group input-group-outline ms-1">
                                <select class="form-control form-select form-select-tujuan-broadcast-2 mt-0 fs-6 js-example-basic-multiple" name="tujuan_broadcast[]" id="tujuan_broadcast_2" style="color:#000000; width:100%;" multiple="multiple" required>
                                    <?php foreach ($jenis_layanan as $j) : ?>
                                        <option value="<?= $j['jenis_layanan']; ?>"><?= $j['nama_jenis_layanan']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-8 mb-3 pt-3 ps-1">
                            <button type="submit" class="btn bg-gradient-primary font-weight-bolder">
                                Submit
                            </button>
                        </div>
                    </form>
                    <form action="<?= base_url('/sub-tambah-broadcast'); ?>" method="post" class="tambah_broadcast pb-5" id="Email">
                        <?= csrf_field(); ?>
                        <div class="col-2 mb-3">
                            <div class="input-group input-group-outline ms-1">
                                <input type="hidden" id="platform_broadcast" name="platform_broadcast" class="form-control form-control-md fs-6" placeholder="" aria-label="Platform Broadcast" style="color:#000000;" value="Email" required>
                            </div>
                        </div>
                        <div class="col-2 mb-3">
                            <label class="form-label text-rose" for="tanggal_broadcast">
                                Tanggal Broadcast
                            </label>
                            <div class="input-group input-group-outline ms-1">
                                <input type="datetime-local" id="tanggal_broadcast" name="tanggal_broadcast" class="form-control form-control-md fs-6" placeholder="" aria-label="Tanggal Broadcast" style="color:#000000;" min="<?= date('Y-m-d H:i'); ?>" required>
                            </div>
                        </div>
                        <?php if ($jenis_akses == 'Admin') { ?>
                            <div class="col-11 mb-3">
                                <label class="form-label text-rose" for="user_id">
                                    Nama Unit Kerja
                                </label>
                                <div class="input-group input-group-outline is-filled ms-1">
                                    <select class="form-control form-select form-select-pengguna-layanan mt-0" name="user_id" id="user_id_2" style="color:#000000;" required>
                                        <option value="" disabled selected></option>
                                        <?php foreach ($data_user as $d) : ?>
                                            <option value="<?= $d['user_id']; ?>"><?= $d['nama_unit_kerja']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="col-11 mb-3">
                                <label class="form-label text-rose" for="user_id">
                                    Nama Unit Kerja
                                </label>
                                <div class="input-group input-group-outline is-filled ms-1">
                                    <input type="hidden" id="user_id" name="user_id" class="form-control form-control-md fs-6" placeholder="" aria-label="Judul Broadcast" style="color:#000000;" value="<?= $user_id; ?>" required>
                                    <input type="text" id="user_id" name="user_id" class="form-control form-control-md fs-6" placeholder="" aria-label="Judul Broadcast" style="color:#000000;" value="<?= $nama_user; ?>" disabled>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="col-11 mb-3">
                            <label class="form-label text-rose" for="text_broadcast">
                                Judul Broadcast
                            </label>
                            <div class="input-group input-group-outline ms-1">
                                <input type="text" id="judul_broadcast" name="judul_broadcast" class="form-control form-control-md fs-6" placeholder="" aria-label="Judul Broadcast" style="color:#000000;" required>
                            </div>
                        </div>
                        <div class="col-11 mb-3">
                            <label class="form-label text-rose" for="text_broadcast">
                                Text Broadcast (Image bisa ditambahkan dengan mengupload image di <a href="https://postimages.org/" target="_blank">https://postimages.org/</a> dan mempaste 'direct link' ke dalam menu picture)
                            </label>
                            <div class="input-group input-group-outline ms-1">
                                <textarea id="text_broadcast" name="text_broadcast" type="text" class="text_broadcast form-control form-control-lg mt-1" placeholder="" aria-label="text_broadcast" required></textarea>
                            </div>
                        </div>
                        <div class="col-11 mb-3">
                            <label class="form-label text-rose" for="tujuan_broadcast">
                                Tujuan Broadcast
                            </label>
                            <div class="input-group input-group-outline ms-1">
                                <select class="form-control form-select form-select-tujuan-broadcast mt-0 fs-6 js-example-basic-multiple-2" name="tujuan_broadcast[]" id="tujuan_broadcast" style="color:#000000; width:100%;" multiple="multiple" required>
                                    <?php foreach ($jenis_layanan as $j) : ?>
                                        <option value="<?= $j['jenis_layanan']; ?>"><?= $j['nama_jenis_layanan']; ?></option>
                                    <?php endforeach; ?>
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