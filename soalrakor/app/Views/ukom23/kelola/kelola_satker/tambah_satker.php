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
                            <form role="form" action="<?= base_url('/sub-tambah-satker-ukom23'); ?>" method="post" class="pb-5">
                                <div class="col-8">
                                    <div class="row mb-2 ms-1" style="font-size:1em;">
                                        ID Satuan Kerja
                                        <input id="id_satker" name="id_satker" type="text" class="form-control form-control-sm mt-2" placeholder="" aria-label="ID Satker" required>
                                    </div>
                                    <div class="row mb-2 ms-1" style="font-size:1em;">
                                        Nama Satuan Kerja
                                        <input id="nama_satker" name="nama_satker" type="text" class="form-control form-control-sm mt-2" placeholder="" aria-label="Nama Satker" required>
                                    </div>
                                    <div class="row mb-2 ms-1" style="font-size:1em;">
                                        Jenis Satuan Kerja
                                        <select class="form-select" name="jenis_satker" id="jenis_satker" required>
                                            <option value="" selected disabled></option>
                                            <option value="Pemasyarakatan">Pemasyarakatan</option>
                                            <option value="Keimigrasian">Keimigrasian</option>
                                            <option value="Pelayanan Hukum dan HAM">Pelayanan Hukum dan HAM</option>
                                            <option value="Kantor Wilayah">Kantor Wilayah</option>
                                        </select>
                                    </div>
                                    <div class="row">
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