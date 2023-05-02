<?= $this->extend('layout/layout_form_penilaian'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid py-4">
    <div class="row mt-4">
        <div class="col-lg-12 mb-lg-0 mb-4">
            <div class="card z-index-2 h-auto">
                <div class="card-header pb-0 pt-3 bg-transparent">
                    <b>
                        <h3 class="text-capitalize" style="color: #344767;">Form Penilaian</h3>
                    </b>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-12 col-xxl-12 d-flex" style="color: #344767;">
                        <div class="card flex-fill p-3">
                            <form role="form" action="<?= base_url('/form-penilaian'); ?>" method="post">
                                <div class="col-12">
                                    <div class="row mb-1 ms-1" style="font-size:1.25em;">
                                        Pertanyaan <?= $nomor_soal; ?>
                                    </div>
                                    <div class="row mb-1 ms-1" style="font-size:1.5em;">
                                        <b class="ms-0 ps-0"><?= $detail_soal['soal']; ?></b>
                                        <textarea id="soal" name="soal" hidden="hidden" class="form-control form-control-lg mt-1" placeholder="" aria-label="Soal" required><?= $detail_soal['soal']; ?></textarea>
                                    </div>
                                    <div class="row mb-3 ms-1" style="font-size:1.1em;">
                                        <b class="ms-0 ps-0"> Jawaban : </b> <?= $detail_soal['jawaban']; ?>
                                        <textarea id="jawaban" name="jawaban" hidden="hidden" class="form-control form-control-lg mt-1" placeholder="" aria-label="Jawaban" required><?= $detail_soal['jawaban']; ?></textarea>
                                    </div>

                                    <?php if ($detail_soal['kategori'] == 'simpulan') {
                                        if (isset($nilai_satker_persoal)) { ?>
                                            <div class="row mb-3 ms-1 ps-0 col-8">
                                                <textarea id="simpulan" name="simpulan" class="form-control form-control-lg mt-1" placeholder="" aria-label="Simpulan" required><?= $nilai_satker_persoal['simpulan']; ?></textarea>
                                            </div>
                                        <?php } else { ?>
                                            <div class="row mb-3 ms-1 ps-0 col-8">
                                                <textarea id="simpulan" name="simpulan" class="form-control form-control-lg mt-1" placeholder="" aria-label="Simpulan" required></textarea>
                                            </div>
                                        <?php }
                                    } else { ?>
                                        <?php if (isset($nilai_satker_persoal)) { ?>
                                            <div class="row mb-3 ms-1 ps-0 col-3">
                                                <input id="nilai" name="nilai" type="number" class="form-control form-control-lg" placeholder="Nilai" aria-label="Nilai" min="0" max="100" value="<?= $nilai_satker_persoal['nilai']; ?>" required>
                                            </div>
                                        <?php } else { ?>
                                            <div class="row mb-3 ms-1 ps-0 col-3">
                                                <input id="nilai" name="nilai" type="number" class="form-control form-control-lg" placeholder="Nilai" aria-label="Nilai" min="0" max="100" required>
                                            </div>
                                    <?php }
                                    } ?>

                                    <div class="row mb-3 text-sm ms-1 ps-0" style="font-size:1em;">
                                        <?php if ($detail_soal['kategori'] == 'ppt' || $detail_soal['kategori'] == 'video' || $detail_soal['kategori'] == 'simpulan') {
                                        } else { ?>
                                            Keterangan: <br>
                                            Evaluatee dapat menjelaskan dan memahami seluruh jawaban dengan sesuai = 91-100 <br>
                                            Evaluatee dapat menjelaskan dan memahami sebagian jawaban dengan sesuai = 76-90 <br>
                                            Evaluatee kurang dapat menjelaskan dan memahami jawaban dengan sesuai = 60-75 <br>
                                            Evaluatee sama sekali tidak dapat menjelaskan jawaban = 0-50 <br>
                                        <?php } ?>
                                    </div>
                                    <div class="id_soal_selanjutnya">
                                        <input id="id_soal" name="id_soal" type="hidden" class="form-control form-control-sm mt-2" placeholder="" aria-label="" value="<?= $detail_soal['id_soal']; ?>" required>
                                        <input id="id_satker" name="id_satker" type="hidden" class="form-control form-control-sm mt-2" placeholder="" aria-label="" value="<?= $id_satker; ?>" required>
                                        <?php if (isset($id_soal_selanjutnya)) { ?>
                                            <input id="id_soal_selanjutnya" name="id_soal_selanjutnya" type="hidden" class="form-control form-control-sm mt-2" placeholder="" aria-label="" value="<?= $id_soal_selanjutnya; ?>" required>
                                        <?php } ?>
                                    </div>
                                    <div class="row">
                                        <?php if ($soal_ke == 'terakhir') { ?>
                                            <div class="col-3 text-center">
                                                <button type="submit" class="btn btn-lg btn-danger btn-lg w-100 mt-2 mb-0">
                                                    Submit
                                                </button>
                                            </div>
                                        <?php } else { ?>
                                            <div class="col-3 text-center">
                                                <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-2 mb-0">
                                                    Simpan
                                                </button>
                                            </div>
                                        <?php } ?>
                                    </div>
                            </form>
                            <div class="row">
                                <?php if ($soal_ke == 'pertama') {
                                } else { ?>
                                    <div class="col-3 text-center">
                                        <form role="form" action="<?= base_url('/form-penilaian-sebelum'); ?>" method="post">
                                            <div class="id_soal">
                                                <input id="id_satker" name="id_satker" type="hidden" class="form-control form-control-sm mt-2" placeholder="" aria-label="" value="<?= $id_satker; ?>" required>
                                                <input id="id_soal_sebelum" name="id_soal_sebelum" type="hidden" class="form-control form-control-sm mt-2" placeholder="" aria-label="" value="<?= $id_soal_sebelumnya; ?>" required>
                                            </div>
                                            <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-2 mb-0">
                                                << Sebelumnya </button>
                                        </form>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>

<?= $this->endSection(); ?>