<?= $this->extend('layout_tzi23/layout_all'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid py-4">
    <div class="row mt-4">
        <div class="col-lg-12 mb-lg-0 mb-4">
            <div class="card z-index-2 h-auto">
                <div class="card-header pb-0 pt-3 bg-transparent">
                    <b>
                        <h3 class="text-capitalize" style="color: #344767;">Edit Soal</h3>
                    </b>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-12 col-xxl-12 d-flex" style="color: #344767;">
                        <div class="card flex-fill p-3">
                            <?php if ($detail_soal['kategori'] != 'pilgan') { ?>
                                <form role="form" action="<?= base_url('/sub-edit-soal-tzi23'); ?>" method="post" class="pb-5">
                                    <div class="col-8">
                                        <input id="id_soal" name="id_soal" type="hidden" class="form-control form-control-lg" placeholder="" aria-label="ID Soal" value="<?= $detail_soal['id_soal']; ?>" required>
                                        <div class="row mb-4 ms-1" style="font-size:1.25em;">
                                            Soal
                                            <textarea id="soal" name="soal" type="text" class="soal form-control form-control-lg mt-1" placeholder="" aria-label="Soal" required><?= $detail_soal['soal']; ?></textarea>
                                        </div>
                                        <div class="row mb-4 ms-1" style="font-size:1.25em;">
                                            Jawaban
                                            <textarea id="jawaban" name="jawaban" type="text" class="jawaban form-control form-control-lg mt-1" placeholder="" aria-label="Jawaban" required><?= $detail_soal['jawaban']; ?></textarea>
                                        </div>
                                        <div class="row mb-5 ms-1" style="font-size:1.25em;">
                                            Kategori
                                            <select class="form-select" name="kategori" id="kategori" required>
                                                <?php if ($detail_soal['kategori'] == 'acak 1') { ?>
                                                    <option value="acak 1" selected>acak 1</option>
                                                    <option value="wajib">wajib1</option>
                                                    <option value="wajib2">wajib2</option>
                                                <?php } else if ($detail_soal['kategori'] == 'wajib') { ?>
                                                    <option value="acak">acak</option>
                                                    <option value="wajib" selected>wajib</option>
                                                    <option value="wajib2">wajib2</option>
                                                <?php } else if ($detail_soal['kategori'] == 'wajib2') { ?>
                                                    <option value="acak">acak</option>
                                                    <option value="wajib">wajib</option>
                                                    <option value="wajib2" selected>wajib2</option>
                                                <?php } else { ?>
                                                    <option value="" selected disabled></option>
                                                    <option value="acak">acak</option>
                                                    <option value="wajib">wajib</option>
                                                    <option value="wajib2">wajib2</option>
                                                <?php } ?>
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
                            <?php } else { ?>
                                <form role="form" action="<?= base_url('/sub-edit-soal-tzi23'); ?>" method="post" class="pb-5">
                                    <div class="col-8">
                                        <input id="id_soal" name="id_soal" type="hidden" class="form-control form-control-lg" placeholder="" aria-label="ID Soal" value="<?= $detail_soal['id_soal']; ?>" required>
                                        <input id="kategori" name="kategori" type="hidden" class="form-control form-control-lg" placeholder="" aria-label="ID Soal" value="<?= $detail_soal['kategori']; ?>" required>
                                        <div class="row mb-4 ms-1" style="font-size:1.25em;">
                                            Soal
                                            <textarea id="soal" name="soal" type="text" class="soal2 form-control form-control-lg mt-1" placeholder="" aria-label="Soal" required><?= $detail_soal['soal']; ?></textarea>
                                        </div>
                                        <div class="row mb-4 ms-1" style="font-size:1.25em;">
                                            Jawaban 1
                                            <input id="jawaban_1" name="jawaban_1" type="text" class="form-control form-control-lg" placeholder="" aria-label="jawaban_1" value="<?= $detail_soal['jawaban_1'] ?>" required>
                                        </div>
                                        <div class="row mb-4 ms-1" style="font-size:1.25em;">
                                            Jawaban 2
                                            <input id="jawaban_2" name="jawaban_2" type="text" class="form-control form-control-lg" placeholder="" aria-label="jawaban_2" value="<?= $detail_soal['jawaban_2'] ?>" required>
                                        </div>
                                        <div class="row mb-4 ms-1" style="font-size:1.25em;">
                                            Jawaban 3
                                            <input id="jawaban_3" name="jawaban_3" type="text" class="form-control form-control-lg" placeholder="" aria-label="jawaban_3" value="<?= $detail_soal['jawaban_3'] ?>" required>
                                        </div>
                                        <div class="row mb-4 ms-1" style="font-size:1.25em;">
                                            Jawaban 4
                                            <input id="jawaban_4" name="jawaban_4" type="text" class="form-control form-control-lg" placeholder="" aria-label="jawaban_4" value="<?= $detail_soal['jawaban_4'] ?>" required>
                                        </div>
                                        <div class="row mb-5 ms-1" style="font-size:1.25em;">
                                            Jawaban Benar
                                            <select class="form-select" name="jawaban" id="jawaban" required>
                                                <?php if ($detail_soal['jawaban'] == 'jawaban_1') { ?>
                                                    <option value="jawaban_1" selected>Jawaban 1</option>
                                                    <option value="jawaban_2">Jawaban 2</option>
                                                    <option value="jawaban_3">Jawaban 3</option>
                                                    <option value="jawaban_4">Jawaban 4</option>
                                                <?php } else if ($detail_soal['jawaban'] == 'jawaban_2') { ?>
                                                    <option value="jawaban_1">Jawaban 1</option>
                                                    <option value="jawaban_2" selected>Jawaban 2</option>
                                                    <option value="jawaban_3">Jawaban 3</option>
                                                    <option value="jawaban_4">Jawaban 4</option>
                                                <?php } else if ($detail_soal['jawaban'] == 'jawaban_3') { ?>
                                                    <option value="jawaban_1">Jawaban 1</option>
                                                    <option value="jawaban_2">Jawaban 2</option>
                                                    <option value="jawaban_3" selected>Jawaban 3</option>
                                                    <option value="jawaban_4">Jawaban 4</option>
                                                <?php } else if ($detail_soal['jawaban'] == 'jawaban_4') { ?>
                                                    <option value="jawaban_1">Jawaban 1</option>
                                                    <option value="jawaban_2">Jawaban 2</option>
                                                    <option value="jawaban_3">Jawaban 3</option>
                                                    <option value="jawaban_4" selected>Jawaban 4</option>
                                                <?php } else { ?>
                                                    <option value="" selected disabled></option>
                                                    <option value="jawaban_1">Jawaban 1</option>
                                                    <option value="jawaban_2">Jawaban 2</option>
                                                    <option value="jawaban_3">Jawaban 3</option>
                                                    <option value="jawaban_4">Jawaban 4</option>
                                                <?php } ?>
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
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>