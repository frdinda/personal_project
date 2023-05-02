<?= $this->extend('layout_ukom23/layout_all'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid py-4">
    <div class="row mt-4">
        <div class="col-lg-12 mb-lg-0 mb-4">
            <div class="card z-index-2 h-auto">
                <div class="card-header pb-0 pt-3 bg-transparent">
                    <b>
                        <h3 class="text-capitalize" style="color: #344767;"><?= $nama_subpage; ?></h3>
                    </b>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-12 col-xxl-12 d-flex" style="color: #344767;">
                        <div class="card flex-fill p-3">
                            <form role="form" action="<?= base_url('/sub-tambah-peserta-ukom23'); ?>" method="post" class="pb-5">
                                <div class="col-8">
                                    <div class="row mb-2 ms-2 ps-1" style="font-size:1em;">
                                        NIP Peserta
                                        <input id="id_peserta" name="id_peserta" type="text" class="form-control form-control-sm mt-2" placeholder="" aria-label="ID Peserta" style="font-size:1em;" required>
                                    </div>
                                    <div class="row mb-2 ms-2 ps-1" style="font-size:1em;">
                                        Nama Peserta
                                        <input id="nama_peserta" name="nama_peserta" type="text" class="form-control form-control-sm mt-2" placeholder="" aria-label="Nama Peserta" style="font-size:1em;" required>
                                    </div>
                                    <div class="row mb-2 ms-2 ps-1" style="font-size:1em;">
                                        Nama Jabatan
                                        <input id="nama_jabatan" name="nama_jabatan" type="text" class="form-control form-control-sm mt-2" placeholder="" aria-label="Nama Jabatan" style="font-size:1em;" required>
                                    </div>
                                    <div class="row mb-2 ms-0" style="font-size:1em;">
                                        <div class="mb-2 ms-0">Satuan Kerja</div>
                                        <select class="form-select form-select-satker mt-1 ms-2 w-100" name="id_satker" id="id_satker" required>
                                            <option value="" selected disabled></option>
                                            <?php foreach ($data_satker as $d) : ?>
                                                <option value="<?= $d['id_satker']; ?>"><?= $d['nama_satker']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="row ms-0">
                                        <div class="col">
                                            <button type="submit" class="btn btn-lg btn-primary mt-2 mb-0" style="font-size:1em;">
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>