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
                <div class="col-12">
                    <form action="<?= base_url('/sub-edit-pengguna'); ?>" method="post" class="edit_pengguna pb-5" id="edit">
                        <?= csrf_field(); ?>
                        <div class=" col-11 mb-3">
                            <label class="form-label text-rose" for="no_telp_pengguna">
                                No Telp Pengguna (Whatsapp)
                            </label>
                            <div class="input-group input-group-outline is-filled  ms-1">
                                <input type="hidden" id="no_telp_pengguna" name="no_telp_pengguna" class="form-control form-control-md fs-6" placeholder="" aria-label="No Telp Pengguna (Whatsapp)" value="<?= $detail_pengguna['no_telp_pengguna']; ?>" style="color:#000000;" required>
                                <input type="number" id="" name="" class="form-control form-control-md fs-6" placeholder="" aria-label="No Telp Pengguna (Whatsapp)" value="<?= $detail_pengguna['no_telp_pengguna']; ?>" style="color:#000000;" disabled>
                            </div>
                        </div>
                        <div class="col-11 mb-3">
                            <label class="form-label text-rose" for="email_pengguna">
                                Email Pengguna
                            </label>
                            <div class="input-group input-group-outline is-filled ms-1">
                                <input type="text" id="email_pengguna" name="email_pengguna" class="form-control form-control-md fs-6" placeholder="" aria-label="Email Pengguna" value="<?= $detail_pengguna['email_pengguna']; ?>" style="color:#000000;" required>
                            </div>
                        </div>
                        <div class="col-11 mb-3">
                            <label class="form-label text-rose" for="nama_pengguna">
                                Nama Pengguna
                            </label>
                            <div class="input-group input-group-outline is-filled  ms-1">
                                <input type="text" id="nama_pengguna" name="nama_pengguna" class="form-control form-control-md fs-6" placeholder="" aria-label="Nama Pengguna" value="<?= $detail_pengguna['nama_pengguna']; ?>" style="color:#000000;" required>
                            </div>
                        </div>
                        <div class="col-11 mb-3">
                            <label class="form-label text-rose" for="instansi_asal_pengguna">
                                Instansi Asal Pengguna
                            </label>
                            <div class="input-group input-group-outline is-filled  ms-1">
                                <input type="text" id="instansi_asal_pengguna" name="instansi_asal_pengguna" class="form-control form-control-md fs-6" placeholder="" aria-label="Instansi Asal Pengguna" value="<?= $detail_pengguna['instansi_asal_pengguna']; ?>" style="color:#000000;" required>
                            </div>
                        </div>
                        <div class="col-8 pt-3 mb-3">
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