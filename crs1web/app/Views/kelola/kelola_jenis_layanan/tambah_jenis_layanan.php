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
                    <form action="<?= base_url('/sub-tambah-jenis-layanan'); ?>" method="post" class="tambah_jenis_layanan pb-5" id="Tambah">
                        <div class="col-11 mb-3">
                            <label class="form-label text-rose" for="jenis_layanan">
                                Jenis Layanan
                            </label>
                            <div class="input-group input-group-outline is-filled ms-1">
                                <input type="text" id="jenis_layanan" name="jenis_layanan" class="form-control form-control-md fs-6" placeholder="" aria-label="Jenis Layanan" style="color:#000000;" value="" required>
                            </div>
                        </div>
                        <div class="col-11 mb-3">
                            <label class="form-label text-rose" for="nama_jenis_layanan">
                                Nama Jenis Layanan (Samakan dengan Jenis Layanan)
                            </label>
                            <div class="input-group input-group-outline is-filled ms-1">
                                <input type="text" id="nama_jenis_layanan" name="nama_jenis_layanan" class="form-control form-control-md fs-6" placeholder="" aria-label="Nama Jenis Layanan" style="color:#000000;" value="" required>
                            </div>
                        </div>
                        <div class="col-11 mb-3">
                            <label class="form-label text-rose" for="warna_jenis_layanan">
                                Warna Jenis Layanan (Masukkan warna jenis layanan dengan format seperti berikut: rgba(63,63,71, .8). Tidak boleh sama!)
                            </label>
                            <div class="input-group input-group-outline is-filled ms-1">
                                <input type="text" id="warna_jenis_layanan" name="warna_jenis_layanan" class="form-control form-control-md fs-6" placeholder="" aria-label="Warna Jenis Layanan" style="color:#000000;" value="" required>
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