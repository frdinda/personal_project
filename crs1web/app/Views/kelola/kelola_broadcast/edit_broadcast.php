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
                    <form action="<?= base_url('/sub-edit-broadcast'); ?>" method="post" class="tambah_broadcast pb-5" id="entry">
                        <?= csrf_field(); ?>
                        <div class="col-8 mb-3">
                            <div class="input-group input-group-outline ms-1">
                                <input type="hidden" id="id_broadcast" name="id_broadcast" class="form-control form-control-md fs-6" placeholder="" aria-label="ID Broadcast" style="color:#000000;" value="<?= $detail_broadcast['id_broadcast']; ?>" required>
                            </div>
                        </div>
                        <div class="col-8 mb-3">
                            <div class="input-group input-group-outline ms-1">
                                <input type="hidden" id="platform_broadcast" name="platform_broadcast" class="form-control form-control-md fs-6" placeholder="" aria-label="Platform Broadcast" style="color:#000000;" value="<?= $detail_broadcast['platform_broadcast']; ?>" required>
                                <input type="text" id="platform_broadcast" name="platform_broadcast" class="form-control form-control-md fs-6" placeholder="" aria-label="Platform Broadcast" style="color:#000000;" value="<?= $detail_broadcast['platform_broadcast']; ?>" disabled>
                            </div>
                        </div>
                        <div class="col-2 mb-3">
                            <label class="form-label text-rose" for="tanggal_broadcast">
                                Tanggal Broadcast
                            </label>
                            <div class="input-group input-group-outline ms-1">
                                <input type="datetime-local" id="tanggal_broadcast" name="tanggal_broadcast" class="form-control form-control-md fs-6" placeholder="" aria-label="Tanggal Broadcast" style="color:#000000;" min="<?= date('Y-m-d H:i'); ?>" value="<?= $detail_broadcast['tanggal_broadcast']; ?>" required>
                            </div>
                        </div>
                        <?php if ($jenis_akses == 'Admin') { ?>
                            <div class="col-11 mb-3">
                                <label class="form-label text-rose" for="user_id">
                                    Nama Unit Kerja
                                </label>
                                <div class="input-group input-group-outline is-filled ms-1">
                                    <select class="form-control form-select form-select-pengguna-layanan mt-0" name="user_id" id="user_id" style="color:#000000;" required>
                                        <option value="" disabled selected></option>
                                        <?php foreach ($data_user as $d) : ?>
                                            <?php if ($detail_broadcast['user_id'] == $d['user_id']) { ?>
                                                <option value="<?= $d['user_id']; ?>" selected><?= $d['nama_unit_kerja']; ?></option>
                                            <?php } else { ?>
                                                <?php if ($d['jenis_akses'] == 'Unit Kerja') { ?>
                                                    <option value="<?= $d['user_id']; ?>"><?= $d['nama_unit_kerja']; ?></option>
                                                <?php } ?>
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
                                    <input type="hidden" id="user_id" name="user_id" class="form-control form-control-md fs-6" placeholder="" aria-label="Judul Broadcast" style="color:#000000;" value="<?= $user_id; ?>" required>
                                    <input type="text" id="user_id" name="user_id" class="form-control form-control-md fs-6" placeholder="" aria-label="Judul Broadcast" style="color:#000000;" value="<?= $nama_unit_kerja; ?>" disabled>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="col-11 mb-3">
                            <label class="form-label text-rose" for="text_broadcast">
                                Judul Broadcast
                            </label>
                            <div class="input-group input-group-outline ms-1">
                                <input type="text" id="judul_broadcast" name="judul_broadcast" class="form-control form-control-md fs-6" placeholder="" aria-label="Judul Broadcast" style="color:#000000;" value="<?= $detail_broadcast['judul_broadcast']; ?>" required>
                            </div>
                        </div>
                        <div class="col-11 mb-3">
                            <label class="form-label text-rose" for="text_broadcast">
                                Text Broadcast
                            </label>
                            <div class="input-group input-group-outline ms-1">
                                <?php if ($detail_broadcast['platform_broadcast'] == 'Whatsapp') { ?>
                                    <textarea id="text_broadcast_whatsapp" name="text_broadcast" type="text" class="text_broadcast form-control form-control-lg mt-1" placeholder="" aria-label="text_broadcast" required><?= $detail_broadcast['text_broadcast']; ?></textarea>
                                <?php } else { ?>
                                    <textarea id="text_broadcast" name="text_broadcast" type="text" class="text_broadcast form-control form-control-lg mt-1" placeholder="" aria-label="text_broadcast" required><?= $detail_broadcast['text_broadcast']; ?></textarea>
                                <?php } ?>
                            </div>
                        </div>
                        <?php if ($detail_broadcast['platform_broadcast'] == 'Whatsapp') { ?>
                            <div class="col-11 mb-3">
                                <label class="form-label text-rose" for="thumbnail_broadcast">
                                    Thumbnail Broadcast (Opsional: Dapatkan linknya dengan mengupload image di <a href="https://postimages.org/" target="_blank">https://postimages.org/</a> dan copy 'direct link')
                                </label>
                                <div class="input-group input-group-outline ms-1">
                                    <input type="text" id="thumbnail_broadcast" name="thumbnail_broadcast" class="form-control form-control-md fs-6" placeholder="" aria-label="Thumbnail Broadcast" style="color:#000000;" value="<?= $detail_broadcast['thumbnail_broadcast']; ?>">
                                </div>
                            </div>
                        <?php } ?>
                        <div class="col-11 mb-3">
                            <label class="form-label text-rose" for="tujuan_broadcast">
                                Tujuan Broadcast
                            </label>
                            <div class="input-group input-group-outline ms-1">
                                <?php if ($detail_broadcast['platform_broadcast'] == 'Whatsapp') { ?>
                                    <select class="form-control form-select form-select-tujuan-broadcast mt-0 fs-6 js-example-basic-multiple" name="tujuan_broadcast[]" id="tujuan_broadcast" style="color:#000000;" multiple="multiple" required>
                                        <?php $tujuan_broadcast = explode(",", $detail_broadcast['tujuan_broadcast']);
                                        foreach ($tujuan_broadcast as $t) :
                                            for ($i = 0; $i < count($jenis_layanan); $i++) {
                                                if ($t == $jenis_layanan[$i]['jenis_layanan']) { ?>
                                                    <option value="<?= $jenis_layanan[$i]['jenis_layanan']; ?>" selected><?= $jenis_layanan[$i]['nama_jenis_layanan']; ?></option>
                                                <?php $jenis_layanan[$i]['jenis_layanan'] = null;
                                                    $jenis_layanan[$i]['nama_jenis_layanan'] = null;
                                                }
                                            }
                                        endforeach;
                                        foreach ($jenis_layanan as $j) :
                                            if ($j['jenis_layanan'] != null) { ?>
                                                <option value="<?= $j['jenis_layanan']; ?>"><?= $j['nama_jenis_layanan']; ?></option>
                                        <?php }
                                        endforeach; ?>
                                    </select>
                                <?php } else { ?>
                                    <select class="form-control form-select form-select-tujuan-broadcast mt-0 fs-6 js-example-basic-multiple-2" name="tujuan_broadcast[]" id="tujuan_broadcast" style="color:#000000;" multiple="multiple" required>
                                        <?php $tujuan_broadcast = explode(",", $detail_broadcast['tujuan_broadcast']);
                                        foreach ($tujuan_broadcast as $t) :
                                            for ($i = 0; $i < count($jenis_layanan); $i++) {
                                                if ($t == $jenis_layanan[$i]['jenis_layanan']) { ?>
                                                    <option value="<?= $jenis_layanan[$i]['jenis_layanan']; ?>" selected><?= $jenis_layanan[$i]['nama_jenis_layanan']; ?></option>
                                                <?php $jenis_layanan[$i]['jenis_layanan'] = null;
                                                    $jenis_layanan[$i]['nama_jenis_layanan'] = null;
                                                }
                                            }
                                        endforeach;
                                        foreach ($jenis_layanan as $j) :
                                            if ($j['jenis_layanan'] != null) { ?>
                                                <option value="<?= $j['jenis_layanan']; ?>"><?= $j['nama_jenis_layanan']; ?></option>
                                        <?php }
                                        endforeach; ?>
                                    </select>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-8 mb-3 ps-1">
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