<?= $this->extend('layout_tzi23/layout_form_penilaian'); ?>

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
                            <?php if ($akses == "pegawai") { ?>
                                <form role="form" action="<?= base_url('/form-penilaian-tzi23'); ?>" method="post">
                                    <div class="col-12">
                                        <div class="row mb-1 ms-1" style="font-size:1.25em;">
                                            Pertanyaan <?= $nomor_soal; ?>
                                        </div>
                                        <div class="row mb-1 ms-1" style="font-size:1.5em;">
                                            <b class="ms-0 ps-0"><?= $detail_soal['soal']; ?></b>
                                            <textarea id="soal" name="soal" hidden="hidden" class="form-control form-control-lg mt-1" placeholder="" aria-label="Soal" required><?= $detail_soal['soal']; ?></textarea>
                                        </div>
                                        <div class="row mb-3 ms-1" style="font-size:1.1em;">
                                            <b class="ms-0 ps-0"> Jawaban : </b>
                                        </div>
                                        <?php if ($detail_soal['kategori'] == 'wajib') {
                                            if (isset($nilai_asesi_persoal['pokja'])) { ?>
                                                <div class="row mb-3 ms-1 ps-0 col-xl-8">
                                                    <select class="form-select" name="pokja" id="pokja" required>
                                                        <?php if ($nilai_asesi_persoal['pokja'] == 'P1') { ?>
                                                            <option value="P1" selected>Pokja 1 - Manajemen Perubahan</option>
                                                            <option value="P2">Pokja 2 - Penataan Tatalaksana</option>
                                                            <option value="P3">Pokja 3 - Penataan Manajemen SDM</option>
                                                            <option value="P4">Pokja 4 - Penguatan Akuntabilitas Kinerja</option>
                                                            <option value="P5">Pokja 5 - Penguatan Pengawasan</option>
                                                            <option value="P6">Pokja 6 - Peningkatan Kualitas Pelayanan Publik</option>
                                                            <option value="SK">Sekretariat</option>
                                                        <?php } else if ($nilai_asesi_persoal['pokja'] == 'P2') { ?>
                                                            <option value="P1">Pokja 1 - Manajemen Perubahan</option>
                                                            <option value="P2" selected>Pokja 2 - Penataan Tatalaksana</option>
                                                            <option value="P3">Pokja 3 - Penataan Manajemen SDM</option>
                                                            <option value="P4">Pokja 4 - Penguatan Akuntabilitas Kinerja</option>
                                                            <option value="P5">Pokja 5 - Penguatan Pengawasan</option>
                                                            <option value="P6">Pokja 6 - Peningkatan Kualitas Pelayanan Publik</option>
                                                            <option value="SK">Sekretariat</option>
                                                        <?php } else if ($nilai_asesi_persoal['pokja'] == 'P3') { ?>
                                                            <option value="P1">Pokja 1 - Manajemen Perubahan</option>
                                                            <option value="P2">Pokja 2 - Penataan Tatalaksana</option>
                                                            <option value="P3" selected>Pokja 3 - Penataan Manajemen SDM</option>
                                                            <option value="P4">Pokja 4 - Penguatan Akuntabilitas Kinerja</option>
                                                            <option value="P5">Pokja 5 - Penguatan Pengawasan</option>
                                                            <option value="P6">Pokja 6 - Peningkatan Kualitas Pelayanan Publik</option>
                                                            <option value="SK">Sekretariat</option>
                                                        <?php } else if ($nilai_asesi_persoal['pokja'] == 'P4') { ?>
                                                            <option value="P1">Pokja 1 - Manajemen Perubahan</option>
                                                            <option value="P2">Pokja 2 - Penataan Tatalaksana</option>
                                                            <option value="P3">Pokja 3 - Penataan Manajemen SDM</option>
                                                            <option value="P4" selected>Pokja 4 - Penguatan Akuntabilitas Kinerja</option>
                                                            <option value="P5">Pokja 5 - Penguatan Pengawasan</option>
                                                            <option value="P6">Pokja 6 - Peningkatan Kualitas Pelayanan Publik</option>
                                                            <option value="SK">Sekretariat</option>
                                                        <?php } else if ($nilai_asesi_persoal['pokja'] == 'P5') { ?>
                                                            <option value="P1">Pokja 1 - Manajemen Perubahan</option>
                                                            <option value="P2">Pokja 2 - Penataan Tatalaksana</option>
                                                            <option value="P3">Pokja 3 - Penataan Manajemen SDM</option>
                                                            <option value="P4">Pokja 4 - Penguatan Akuntabilitas Kinerja</option>
                                                            <option value="P5" selected>Pokja 5 - Penguatan Pengawasan</option>
                                                            <option value="P6">Pokja 6 - Peningkatan Kualitas Pelayanan Publik</option>
                                                            <option value="SK">Sekretariat</option>
                                                        <?php } else if ($nilai_asesi_persoal['pokja'] == 'P6') { ?>
                                                            <option value="P1">Pokja 1 - Manajemen Perubahan</option>
                                                            <option value="P2">Pokja 2 - Penataan Tatalaksana</option>
                                                            <option value="P3">Pokja 3 - Penataan Manajemen SDM</option>
                                                            <option value="P4">Pokja 4 - Penguatan Akuntabilitas Kinerja</option>
                                                            <option value="P5">Pokja 5 - Penguatan Pengawasan</option>
                                                            <option value="P6" selected>Pokja 6 - Peningkatan Kualitas Pelayanan Publik</option>
                                                            <option value="SK">Sekretariat</option>
                                                        <?php } else if ($nilai_asesi_persoal['pokja'] == 'SK') { ?>
                                                            <option value="P1">Pokja 1 - Manajemen Perubahan</option>
                                                            <option value="P2">Pokja 2 - Penataan Tatalaksana</option>
                                                            <option value="P3">Pokja 3 - Penataan Manajemen SDM</option>
                                                            <option value="P4">Pokja 4 - Penguatan Akuntabilitas Kinerja</option>
                                                            <option value="P5">Pokja 5 - Penguatan Pengawasan</option>
                                                            <option value="P6">Pokja 6 - Peningkatan Kualitas Pelayanan Publik</option>
                                                            <option value="SK" selected>Sekretariat</option>
                                                        <?php } else { ?>
                                                            <option value="" selected disabled></option>
                                                            <option value="P1">Pokja 1 - Manajemen Perubahan</option>
                                                            <option value="P2">Pokja 2 - Penataan Tatalaksana</option>
                                                            <option value="P3">Pokja 3 - Penataan Manajemen SDM</option>
                                                            <option value="P4">Pokja 4 - Penguatan Akuntabilitas Kinerja</option>
                                                            <option value="P5">Pokja 5 - Penguatan Pengawasan</option>
                                                            <option value="P6">Pokja 6 - Peningkatan Kualitas Pelayanan Publik</option>
                                                            <option value="SK">Sekretariat</option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            <?php } else { ?>
                                                <div class="row mb-3 ms-1 ps-0 col-xl-8">
                                                    <select class="form-select" name="pokja" id="pokja" required>
                                                        <option value="" selected disabled></option>
                                                        <option value="P1">Pokja 1 - Manajemen Perubahan</option>
                                                        <option value="P2">Pokja 2 - Penataan Tatalaksana</option>
                                                        <option value="P3">Pokja 3 - Penataan Manajemen SDM</option>
                                                        <option value="P4">Pokja 4 - Penguatan Akuntabilitas Kinerja</option>
                                                        <option value="P5">Pokja 5 - Penguatan Pengawasan</option>
                                                        <option value="P6">Pokja 6 - Peningkatan Kualitas Pelayanan Publik</option>
                                                        <option value="SK">Sekretariat</option>
                                                    </select>
                                                </div>
                                            <?php }
                                        } else if ($detail_soal['kategori'] == 'wajib2') { ?>
                                            <?php if (isset($nilai_asesi_persoal['jawaban_program'])) { ?>
                                                <div class="row mb-3 ms-1 ps-0 col-xl-6">
                                                    <textarea id="jawaban_program" name="jawaban_program" class="form-control form-control-lg mt-1 ms-0 ps-0" placeholder="" aria-label="Jawaban" required><?= $nilai_asesi_persoal['jawaban_program']; ?></textarea>
                                                </div>
                                            <?php } else { ?>
                                                <div class="row mb-3 ms-1 ps-0 col-xl-6">
                                                    <textarea id="jawaban_program" name="jawaban_program" class="form-control form-control-lg mt-1 ms-0 ps-0" placeholder="" aria-label="Jawaban" required></textarea>
                                                </div>
                                            <?php }
                                        } else { ?>
                                            <div class="ps-1 ms-1">
                                                <?php if (isset($nilai_asesi_persoal)) { ?>
                                                    <?php if ($nilai_asesi_persoal['jawaban_dipilih'] == "jawaban_1") { ?>
                                                        <div class="custom-control custom-radio mb-3">
                                                            <input type="radio" id="jawaban_1" name="customRadio" class="custom-control-input" value="jawaban_1" checked>
                                                            <label class="custom-control-label" for="jawaban_1" style="font-size:1em;font-weight:lighter;"><?= $detail_soal['jawaban_1']; ?></label>
                                                        </div>
                                                    <?php } else { ?>
                                                        <div class="custom-control custom-radio mb-3">
                                                            <input type="radio" id="jawaban_1" name="customRadio" class="custom-control-input active" value="jawaban_1">
                                                            <label class="custom-control-label" for="jawaban_1" style="font-size:1em;font-weight:lighter;"><?= $detail_soal['jawaban_1']; ?></label>
                                                        </div>
                                                    <?php }
                                                    if ($nilai_asesi_persoal['jawaban_dipilih'] == "jawaban_2") { ?>
                                                        <div class="custom-control custom-radio mb-3">
                                                            <input type="radio" id="jawaban_2" name="customRadio" class="custom-control-input" value="jawaban_2" checked>
                                                            <label class="custom-control-label" for="jawaban_2" style="font-size:1em;font-weight:lighter;"><?= $detail_soal['jawaban_2']; ?></label>
                                                        </div>
                                                    <?php } else { ?>
                                                        <div class="custom-control custom-radio mb-3">
                                                            <input type="radio" id="jawaban_2" name="customRadio" class="custom-control-input" value="jawaban_2">
                                                            <label class="custom-control-label" for="jawaban_2" style="font-size:1em;font-weight:lighter;"><?= $detail_soal['jawaban_2']; ?></label>
                                                        </div>
                                                    <?php }
                                                    if ($nilai_asesi_persoal['jawaban_dipilih'] == "jawaban_3") { ?>
                                                        <div class="custom-control custom-radio mb-3">
                                                            <input type="radio" id="jawaban_3" name="customRadio" class="custom-control-input" value="jawaban_3" checked>
                                                            <label class="custom-control-label" for="jawaban_3" style="font-size:1em;font-weight:lighter;"><?= $detail_soal['jawaban_3']; ?></label>
                                                        </div>
                                                    <?php } else { ?>
                                                        <div class="custom-control custom-radio mb-3">
                                                            <input type="radio" id="jawaban_3" name="customRadio" class="custom-control-input" value="jawaban_3">
                                                            <label class="custom-control-label" for="jawaban_3" style="font-size:1em;font-weight:lighter;"><?= $detail_soal['jawaban_3']; ?></label>
                                                        </div>
                                                    <?php }
                                                    if ($nilai_asesi_persoal['jawaban_dipilih'] == "jawaban_4") { ?>
                                                        <div class="custom-control custom-radio mb-3">
                                                            <input type="radio" id="jawaban_4" name="customRadio" class="custom-control-input" value="jawaban_4" checked>
                                                            <label class="custom-control-label" for="jawaban_4" style="font-size:1em;font-weight:lighter;"><?= $detail_soal['jawaban_4']; ?></label>
                                                        </div>
                                                    <?php } else { ?>
                                                        <div class="custom-control custom-radio mb-3">
                                                            <input type="radio" id="jawaban_4" name="customRadio" class="custom-control-input" value="jawaban_4">
                                                            <label class="custom-control-label" for="jawaban_4" style="font-size:1em;font-weight:lighter;"><?= $detail_soal['jawaban_4']; ?></label>
                                                        </div>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <div class="custom-control custom-radio mb-3">
                                                        <input type="radio" id="jawaban_1" name="customRadio" class="custom-control-input" value="jawaban_1">
                                                        <label class="custom-control-label" for="jawaban_1" style="font-size:1em;font-weight:lighter;"><?= $detail_soal['jawaban_1']; ?></label>
                                                    </div>
                                                    <div class="custom-control custom-radio mb-3">
                                                        <input type="radio" id="jawaban_2" name="customRadio" class="custom-control-input" value="jawaban_2">
                                                        <label class="custom-control-label" for="jawaban_2" style="font-size:1em;font-weight:lighter;"><?= $detail_soal['jawaban_2']; ?></label>
                                                    </div>
                                                    <div class="custom-control custom-radio mb-3">
                                                        <input type="radio" id="jawaban_3" name="customRadio" class="custom-control-input" value="jawaban_3">
                                                        <label class="custom-control-label" for="jawaban_3" style="font-size:1em;font-weight:lighter;"><?= $detail_soal['jawaban_3']; ?></label>
                                                    </div>
                                                    <div class="custom-control custom-radio mb-3">
                                                        <input type="radio" id="jawaban_4" name="customRadio" class="custom-control-input" value="jawaban_4">
                                                        <label class="custom-control-label" for="jawaban_4" style="font-size:1em;font-weight:lighter;"><?= $detail_soal['jawaban_4']; ?></label>
                                                    </div>
                                            </div>
                                    <?php }
                                            } ?>
                                    <div class="id_soal_selanjutnya">
                                        <input id="id_soal" name="id_soal" type="hidden" class="form-control form-control-sm mt-2" placeholder="" aria-label="" value="<?= $detail_soal['id_soal']; ?>" required>
                                        <input id="id_asesi" name="id_asesi" type="hidden" class="form-control form-control-sm mt-2" placeholder="" aria-label="" value="<?= $id_asesi; ?>" required>
                                        <?php if (isset($id_soal_selanjutnya)) { ?>
                                            <input id="id_soal_selanjutnya" name="id_soal_selanjutnya" type="hidden" class="form-control form-control-sm mt-2" placeholder="" aria-label="" value="<?= $id_soal_selanjutnya; ?>" required>
                                        <?php } ?>
                                    </div>
                                    <div class="row">
                                        <?php if ($soal_ke == 'terakhir') { ?>
                                            <div class="col-xl-3 text-center">
                                                <button type="submit" class="btn btn-lg btn-danger btn-lg w-100 mt-2 mb-0" onclick="return confirm('Anda Yakin?')">
                                                    Submit
                                                </button>
                                            </div>
                                        <?php } else { ?>
                                            <div class="col-xl-3 text-center">
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
                                        <div class="col-xl-3 text-center">
                                            <form role="form" action="<?= base_url('/form-penilaian-sebelum-tzi23'); ?>" method="post">
                                                <div class="id_soal">
                                                    <input id="id_asesi" name="id_asesi" type="hidden" class="form-control form-control-sm mt-2" placeholder="" aria-label="" value="<?= $id_asesi; ?>" required>
                                                    <input id="id_soal_sebelum" name="id_soal_sebelum" type="hidden" class="form-control form-control-sm mt-2" placeholder="" aria-label="" value="<?= $id_soal_sebelumnya; ?>" required>
                                                </div>
                                                <button type="submit" class="btn btn-lg btn-secondary btn-lg w-100 mt-2 mb-0">
                                                    << Sebelumnya </button>
                                            </form>
                                        </div>
                                    <?php } ?>
                                </div>
                        </div>
                    <?php } else { ?>
                        <form role="form" action="<?= base_url('/form-penilaian-tzi23'); ?>" method="post">
                            <div class="col-12">
                                <div class="row mb-1 ms-1" style="font-size:1.25em;">
                                    Pertanyaan <?= $nomor_soal; ?>
                                </div>
                                <div class="row mb-1 ms-1" style="font-size:1.5em;">
                                    <b class="ms-0 ps-0"><?= $detail_soal['soal']; ?></b>
                                    <textarea id="soal" name="soal" hidden="hidden" class="form-control form-control-lg mt-1" placeholder="" aria-label="Soal" required><?= $detail_soal['soal']; ?></textarea>
                                </div>
                                <div class="row mb-3 ms-1" style="font-size:1.1em;">
                                    <b class="ms-0 ps-0"> Jawaban : </b>
                                    <?php if ($detail_soal['kategori'] == 'wajib' || $detail_soal['kategori'] == 'pilgan') { ?>
                                    <?php } else { ?>
                                        <?= $detail_soal['jawaban']; ?>
                                        <textarea id=" jawaban" name="jawaban" hidden="hidden" class="form-control form-control-lg mt-1 ms-0 ps-0" placeholder="" aria-label="Jawaban" required><?= $detail_soal['jawaban']; ?></textarea>
                                    <?php } ?>
                                </div>
                                <?php if ($detail_soal['kategori'] == 'wajib') {
                                    if (isset($nilai_asesi_persoal['pokja'])) { ?>
                                        <div class="row mb-3 ms-1 ps-0 col-xl-8">
                                            <select class="form-select" name="pokja" id="pokja" required>
                                                <?php if ($nilai_asesi_persoal['pokja'] == 'P1') { ?>
                                                    <option value="P1" selected>Pokja 1 - Manajemen Perubahan</option>
                                                    <option value="P2">Pokja 2 - Penataan Tatalaksana</option>
                                                    <option value="P3">Pokja 3 - Penataan Manajemen SDM</option>
                                                    <option value="P4">Pokja 4 - Penguatan Akuntabilitas Kinerja</option>
                                                    <option value="P5">Pokja 5 - Penguatan Pengawasan</option>
                                                    <option value="P6">Pokja 6 - Peningkatan Kualitas Pelayanan Publik</option>
                                                    <option value="SK">Sekretariat</option>
                                                <?php } else if ($nilai_asesi_persoal['pokja'] == 'P2') { ?>
                                                    <option value="P1">Pokja 1 - Manajemen Perubahan</option>
                                                    <option value="P2" selected>Pokja 2 - Penataan Tatalaksana</option>
                                                    <option value="P3">Pokja 3 - Penataan Manajemen SDM</option>
                                                    <option value="P4">Pokja 4 - Penguatan Akuntabilitas Kinerja</option>
                                                    <option value="P5">Pokja 5 - Penguatan Pengawasan</option>
                                                    <option value="P6">Pokja 6 - Peningkatan Kualitas Pelayanan Publik</option>
                                                    <option value="SK">Sekretariat</option>
                                                <?php } else if ($nilai_asesi_persoal['pokja'] == 'P3') { ?>
                                                    <option value="P1">Pokja 1 - Manajemen Perubahan</option>
                                                    <option value="P2">Pokja 2 - Penataan Tatalaksana</option>
                                                    <option value="P3" selected>Pokja 3 - Penataan Manajemen SDM</option>
                                                    <option value="P4">Pokja 4 - Penguatan Akuntabilitas Kinerja</option>
                                                    <option value="P5">Pokja 5 - Penguatan Pengawasan</option>
                                                    <option value="P6">Pokja 6 - Peningkatan Kualitas Pelayanan Publik</option>
                                                    <option value="SK">Sekretariat</option>
                                                <?php } else if ($nilai_asesi_persoal['pokja'] == 'P4') { ?>
                                                    <option value="P1">Pokja 1 - Manajemen Perubahan</option>
                                                    <option value="P2">Pokja 2 - Penataan Tatalaksana</option>
                                                    <option value="P3">Pokja 3 - Penataan Manajemen SDM</option>
                                                    <option value="P4" selected>Pokja 4 - Penguatan Akuntabilitas Kinerja</option>
                                                    <option value="P5">Pokja 5 - Penguatan Pengawasan</option>
                                                    <option value="P6">Pokja 6 - Peningkatan Kualitas Pelayanan Publik</option>
                                                    <option value="SK">Sekretariat</option>
                                                <?php } else if ($nilai_asesi_persoal['pokja'] == 'P5') { ?>
                                                    <option value="P1">Pokja 1 - Manajemen Perubahan</option>
                                                    <option value="P2">Pokja 2 - Penataan Tatalaksana</option>
                                                    <option value="P3">Pokja 3 - Penataan Manajemen SDM</option>
                                                    <option value="P4">Pokja 4 - Penguatan Akuntabilitas Kinerja</option>
                                                    <option value="P5" selected>Pokja 5 - Penguatan Pengawasan</option>
                                                    <option value="P6">Pokja 6 - Peningkatan Kualitas Pelayanan Publik</option>
                                                    <option value="SK">Sekretariat</option>
                                                <?php } else if ($nilai_asesi_persoal['pokja'] == 'P6') { ?>
                                                    <option value="P1">Pokja 1 - Manajemen Perubahan</option>
                                                    <option value="P2">Pokja 2 - Penataan Tatalaksana</option>
                                                    <option value="P3">Pokja 3 - Penataan Manajemen SDM</option>
                                                    <option value="P4">Pokja 4 - Penguatan Akuntabilitas Kinerja</option>
                                                    <option value="P5">Pokja 5 - Penguatan Pengawasan</option>
                                                    <option value="P6" selected>Pokja 6 - Peningkatan Kualitas Pelayanan Publik</option>
                                                    <option value="SK">Sekretariat</option>
                                                <?php } else if ($nilai_asesi_persoal['pokja'] == 'SK') { ?>
                                                    <option value="P1">Pokja 1 - Manajemen Perubahan</option>
                                                    <option value="P2">Pokja 2 - Penataan Tatalaksana</option>
                                                    <option value="P3">Pokja 3 - Penataan Manajemen SDM</option>
                                                    <option value="P4">Pokja 4 - Penguatan Akuntabilitas Kinerja</option>
                                                    <option value="P5">Pokja 5 - Penguatan Pengawasan</option>
                                                    <option value="P6">Pokja 6 - Peningkatan Kualitas Pelayanan Publik</option>
                                                    <option value="SK" selected>Sekretariat</option>
                                                <?php } else { ?>
                                                    <option value="" selected disabled></option>
                                                    <option value="P1">Pokja 1 - Manajemen Perubahan</option>
                                                    <option value="P2">Pokja 2 - Penataan Tatalaksana</option>
                                                    <option value="P3">Pokja 3 - Penataan Manajemen SDM</option>
                                                    <option value="P4">Pokja 4 - Penguatan Akuntabilitas Kinerja</option>
                                                    <option value="P5">Pokja 5 - Penguatan Pengawasan</option>
                                                    <option value="P6">Pokja 6 - Peningkatan Kualitas Pelayanan Publik</option>
                                                    <option value="SK">Sekretariat</option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    <?php } else { ?>
                                        <div class="row mb-3 ms-1 ps-0 col-xl-8">
                                            <select class="form-select" name="pokja" id="pokja" required>
                                                <option value="" selected disabled></option>
                                                <option value="P1">Pokja 1 - Manajemen Perubahan</option>
                                                <option value="P2">Pokja 2 - Penataan Tatalaksana</option>
                                                <option value="P3">Pokja 3 - Penataan Manajemen SDM</option>
                                                <option value="P4">Pokja 4 - Penguatan Akuntabilitas Kinerja</option>
                                                <option value="P5">Pokja 5 - Penguatan Pengawasan</option>
                                                <option value="P6">Pokja 6 - Peningkatan Kualitas Pelayanan Publik</option>
                                                <option value="SK">Sekretariat</option>
                                            </select>
                                        </div>
                                    <?php }
                                } else if ($detail_soal['kategori'] == 'wajib2') { ?>
                                    <?php if (isset($nilai_asesi_persoal['nilai'])) { ?>
                                        <div class="row mb-3 ms-1 ps-0 col-xl-6">
                                            <input id="nilai" name="nilai" type="number" class="form-control form-control-lg" placeholder="Nilai" aria-label="Nilai" min="0" max="100" value="<?= $nilai_asesi_persoal['nilai']; ?>" required>
                                        </div>
                                    <?php } else { ?>
                                        <div class="row mb-3 ms-1 ps-0 col-xl-6">
                                            <input id="nilai" name="nilai" type="number" class="form-control form-control-lg" placeholder="Nilai" aria-label="Nilai" min="0" max="100" value="" required>
                                        </div>
                                    <?php }
                                } else { ?>
                                    <?php if (isset($nilai_asesi_persoal)) { ?>
                                        <div class="row mb-3 ms-1 ps-0 col-xl-3">
                                            <input id="nilai" name="nilai" type="number" class="form-control form-control-lg" placeholder="Nilai" aria-label="Nilai" min="0" max="100" value="<?= $nilai_asesi_persoal['nilai']; ?>" required>
                                        </div>
                                    <?php } else { ?>
                                        <div class="row mb-3 ms-1 ps-0 col-xl-3">
                                            <input id="nilai" name="nilai" type="number" class="form-control form-control-lg" placeholder="Nilai" aria-label="Nilai" min="0" max="100" required>
                                        </div>
                                <?php }
                                } ?>
                                <div class="row mb-3 text-sm ms-1 ps-0" style="font-size:1em;">
                                    <?php if ($detail_soal['kategori'] == 'acak') { ?>
                                        Keterangan: <br>
                                        Evaluatee dapat menjelaskan dan memahami seluruh jawaban dengan sesuai = 91-100 <br>
                                        Evaluatee dapat menjelaskan dan memahami sebagian jawaban dengan sesuai = 76-90 <br>
                                        Evaluatee kurang dapat menjelaskan dan memahami jawaban dengan sesuai = 60-75 <br>
                                        Evaluatee sama sekali tidak dapat menjelaskan jawaban = 0-50 <br>
                                    <?php } else if ($detail_soal['kategori'] == 'wajib2') { ?>
                                        Keterangan: <br>
                                        Program Kerja sangat sesuai dengan tujuan pokja yang dipilih = 91-100 <br>
                                        Program Kerja cukup sesuai dengan tujuan pokja yang dipilih = 76-90 <br>
                                        Program Kerja kurang sesuai dengan tujuan pokja yang dipilih = 60-75 <br>
                                        Program Kerja sangat tidak sesuai dengan tujuan pokja yang dipilih = 0-50 <br>
                                    <?php } ?>
                                </div>
                                <div class="id_soal_selanjutnya">
                                    <input id="id_soal" name="id_soal" type="hidden" class="form-control form-control-sm mt-2" placeholder="" aria-label="" value="<?= $detail_soal['id_soal']; ?>" required>
                                    <input id="id_asesi" name="id_asesi" type="hidden" class="form-control form-control-sm mt-2" placeholder="" aria-label="" value="<?= $id_asesi; ?>" required>
                                    <?php if (isset($id_soal_selanjutnya)) { ?>
                                        <input id="id_soal_selanjutnya" name="id_soal_selanjutnya" type="hidden" class="form-control form-control-sm mt-2" placeholder="" aria-label="" value="<?= $id_soal_selanjutnya; ?>" required>
                                    <?php } ?>
                                </div>
                                <div class="row">
                                    <?php if ($soal_ke == 'terakhir') { ?>
                                        <div class="col-xl-3 text-center">
                                            <button type="submit" class="btn btn-lg btn-danger btn-lg w-100 mt-2 mb-0">
                                                Submit
                                            </button>
                                        </div>
                                    <?php } else { ?>
                                        <div class="col-xl-3 text-center">
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
                                <div class="col-xl-3 text-center">
                                    <form role="form" action="<?= base_url('/form-penilaian-sebelum-tzi23'); ?>" method="post">
                                        <div class="id_soal">
                                            <input id="id_asesi" name="id_asesi" type="hidden" class="form-control form-control-sm mt-2" placeholder="" aria-label="" value="<?= $id_asesi; ?>" required>
                                            <input id="id_soal_sebelum" name="id_soal_sebelum" type="hidden" class="form-control form-control-sm mt-2" placeholder="" aria-label="" value="<?= $id_soal_sebelumnya; ?>" required>
                                        </div>
                                        <button type="submit" class="btn btn-lg btn-secondary btn-lg w-100 mt-2 mb-0">
                                            << Sebelumnya </button>
                                    </form>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>

<?= $this->endSection(); ?>