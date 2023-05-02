<?= $this->extend('layout/layout_all'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid py-4">
    <div class="row mt-4">
        <div class="col-lg-12 mb-lg-0 mb-4">
            <div class="card z-index-2 h-auto">
                <div class="card-header pb-0 pt-3 bg-transparent">
                    <b>
                        <h3 class="text-capitalize" style="color: #344767;">Edit Satuan Kerja</h3>
                    </b>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-12 col-xxl-12 d-flex" style="color: #344767;">
                        <div class="card flex-fill p-3">
                            <form role="form" action="<?= base_url('/form-penilaian'); ?>" method="post" class="pb-5">
                                <div class="col-8">
                                    <div class="row mb-2 ms-1" style="font-size:1em;">
                                        ID Satker
                                        <input id="id_satker" name="id_satker" type="hidden" class="form-control form-control-sm mt-2" placeholder="" aria-label="ID User" value="<?= $detail_satker['id_satker']; ?>" required>
                                        <input id="id_satker" name="id_satker" type="text" class="form-control form-control-sm mt-2" placeholder="" aria-label="ID User" value="<?= $detail_satker['id_satker']; ?>" disabled>
                                    </div>
                                    <div class="row mb-2 ms-1" style="font-size:1em;">
                                        Nama Satker
                                        <input id="nama_satker" name="nama_satker" type="hidden" class="form-control form-control-sm mt-2" placeholder="" aria-label="Nama Satker" value="<?= $detail_satker['nama_satker']; ?>" required>
                                        <input id="nama_satker" name="nama_satker" type="text" class="form-control form-control-sm mt-2" placeholder="" aria-label="Nama Satker" value="<?= $detail_satker['nama_satker']; ?>" disabled>
                                    </div>
                                    <div class="row mb-2 ms-1" style="font-size:1em;">
                                        Nama Kasatker
                                        <input id="nama_kasatker" name="nama_kasatker" type="hidden" class="form-control form-control-sm mt-2" placeholder="" aria-label="Nama Kasatker" value="<?= $detail_satker['nama_kasatker']; ?>" required>
                                        <input id="nama_kasatker" name="nama_kasatker" type="text" class="form-control form-control-sm mt-2" placeholder="" aria-label="Nama Kasatker" value="<?= $detail_satker['nama_kasatker']; ?>" disabled>
                                    </div>
                                    <div class="id_soal_selanjutnya">
                                        <input id="id_soal_selanjutnya" name="id_soal_selanjutnya" type="hidden" class="form-control form-control-sm mt-2" placeholder="" aria-label="Nama Kasatker" value="<?= $id_soal_selanjutnya; ?>" required>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <button type="submit" class="btn btn-lg btn-primary mt-2 mb-0" style="font-size:1em;">
                                                Mulai
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