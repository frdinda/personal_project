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
                            <form role="form" action="<?= base_url('/sub-tambah-soal-ukom23'); ?>" method="post" class="pb-5">
                                <div class="col-8">
                                    <div class="row mb-4 ms-1" style="font-size:1.25em;">
                                        Soal
                                        <textarea id="soal" name="soal" type="text" class="soal form-control form-control-lg mt-1" placeholder="" aria-label="Soal" required></textarea>
                                    </div>
                                    <div class="row mb-4 ms-1" style="font-size:1.25em;">
                                        Jawaban
                                        <textarea id="jawaban" name="jawaban" type="text" class="jawaban form-control form-control-lg mt-1" placeholder="" aria-label="Jawaban" required></textarea>
                                    </div>
                                    <div class="row mb-5 ms-1" style="font-size:1.25em;">
                                        Kategori
                                        <select class="form-select" name="kategori" id="kategori" required>
                                            <option value="" selected disabled></option>
                                            <option value="pas">pas</option>
                                            <option value="imi">imi</option>
                                            <option value="min">min</option>
                                            <option value="yankumham">yankumham</option>
                                        </select>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <button type="submit" class="btn btn-lg btn-primary btn-lg mt-2 mb-0">
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