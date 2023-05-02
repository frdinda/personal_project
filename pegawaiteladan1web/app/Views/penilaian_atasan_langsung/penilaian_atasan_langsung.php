<?= $this->extend('layout/layout_all'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card z-index-2 h-auto">
                <div class="card-header pb-0 pt-3 bg-transparent">
                    <b>
                        <h3 class="text-capitalize" style="color: #344767;"><?= $nama_sub_page; ?></h3>
                    </b>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-12 col-xxl-12 d-flex" style="color: #344767;">
                        <div class="card flex-fill p-4">
                            <!-- IDENTITIAS PEGAWAINYA -->
                            <div class="card-body p-3">
                                <div class="row gx-4">
                                    <div class="col-1">
                                        <img src="../img/foto_pegawai/irene.jpg" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                                    </div>
                                    <div class="col-6 my-auto">
                                        <div class="h-100">
                                            <h5 class="mb-1">
                                                <?= $detail_pegawai['nama_pegawai']; ?>
                                            </h5>
                                            <p class="mb-0 font-weight-bold text-md">
                                                <?= $detail_pegawai['nip']; ?>
                                            </p>
                                            <p class="mb-0 font-weight-light text-md">
                                                <?= $detail_pegawai['nama_jabatan']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- BENTUKNYA TABEL AJA, TERUS SAMPING KIRINYA PENILAIANNYA -->
                            <?php if (count($nilai_atasan_langsung) > 0) { ?>
                                <form action="<?= base_url('/proses-penilaian-atasan-langsung'); ?>" method="post" class="pilih_atasan_langsung pb-2" id="Penilaian_Atasan">
                                    <?= csrf_field(); ?>
                                    <table class="" id="table-penilaian">
                                        <tbody>
                                            <tr>
                                                <td class="mb-0 text-sm ps-0" scope="row"><b>PROFESIONAL</b></td>
                                                <td class="col-9 mb-0 text-sm" scope="row">
                                                    <input id="save" name="save" type="hidden" class="form-control form-control-sm" placeholder="" aria-label="Save" value="Save" required>
                                                </td>
                                                <td class="col-9 mb-0 text-sm" scope="row">
                                                    <input id="nip_pegawai" name="nip_pegawai" type="hidden" class="form-control form-control-sm" placeholder="" aria-label="NIP Pegawai" value="<?= $nip_pegawai_yang_dinilai; ?>" required>
                                                </td>
                                                <td class="col-9 mb-0 text-sm" scope="row">
                                                    <input id="nip_atasan_langsung" name="nip_atasan_langsung" type="hidden" class="form-control form-control-sm" placeholder="" aria-label="NIP Atasan Langsung" value="<?= $nip_atasan_langsung; ?>" required>
                                                </td>
                                            </tr>
                                            <?php $a = 1; ?>
                                            <?php foreach ($nilai_atasan_langsung as $p) : ?>
                                                <?php if ($p['kategori_pertanyaan'] == 'Profesional') { ?>
                                                    <tr>
                                                        <td class="col-1 mb-0 text-sm ps-0" scope="row"><?= $a; ?></td>
                                                        <td class="col-9 mb-0 text-sm" scope="row">
                                                            <?= $p['jabaran_pertanyaan']; ?>
                                                            <input id="<?= $p['id_penilaian_atasan_langsung']; ?>_id" name="<?= $p['id_penilaian_atasan_langsung']; ?>_id" type="hidden" class="form-control form-control-sm" placeholder="" aria-label="ID Penilaian" value="<?= $p['id_penilaian_atasan_langsung']; ?>" required>
                                                        </td>
                                                        <td class="col-2 mb-0 text-sm" scope="row">
                                                            <input id="<?= $p['id_penilaian_atasan_langsung']; ?>_nilai" name="<?= $p['id_penilaian_atasan_langsung']; ?>_nilai" type="number" class="form-control form-control-sm" placeholder="" aria-label="Nilai" value="<?= $p['nilai']; ?>" required>
                                                        </td>
                                                        <?php $a++; ?>
                                                    </tr>
                                                <?php } ?>
                                            <?php endforeach; ?>
                                            <tr>
                                                <td class="mb-0 text-sm ps-0" scope="row"><b>AKUNTABEL</b></td>
                                            </tr>
                                            <?php $a = 1; ?>
                                            <?php foreach ($nilai_atasan_langsung as $p) : ?>
                                                <?php if ($p['kategori_pertanyaan'] == 'Akuntabel') { ?>
                                                    <tr>
                                                        <td class="col-1 mb-0 text-sm ps-0" scope="row"><?= $a; ?></td>
                                                        <td class="col-9 mb-0 text-sm" scope="row">
                                                            <?= $p['jabaran_pertanyaan']; ?>
                                                            <input id="<?= $p['id_penilaian_atasan_langsung']; ?>_id" name="<?= $p['id_penilaian_atasan_langsung']; ?>_id" type="hidden" class="form-control form-control-sm" placeholder="" aria-label="ID Penilaian" value="<?= $p['id_penilaian_atasan_langsung']; ?>" required>
                                                        </td>
                                                        <td class="col-2 mb-0 text-sm" scope="row">
                                                            <input id="<?= $p['id_penilaian_atasan_langsung']; ?>_nilai" name="<?= $p['id_penilaian_atasan_langsung']; ?>_nilai" type="number" class="form-control form-control-sm" placeholder="" aria-label="Nilai" value="<?= $p['nilai']; ?>" required>
                                                        </td>
                                                        <?php $a++; ?>
                                                    </tr>
                                                <?php } ?>
                                            <?php endforeach; ?>
                                            <tr>
                                                <td class="mb-0 text-sm ps-0" scope="row"><b>SINERGI</b></td>
                                            </tr>
                                            <?php $a = 1; ?>
                                            <?php foreach ($nilai_atasan_langsung as $p) : ?>
                                                <?php if ($p['kategori_pertanyaan'] == 'Sinergi') { ?>
                                                    <tr>
                                                        <td class="col-1 mb-0 text-sm ps-0" scope="row"><?= $a; ?></td>
                                                        <td class="col-9 mb-0 text-sm" scope="row">
                                                            <?= $p['jabaran_pertanyaan']; ?>
                                                            <input id="<?= $p['id_penilaian_atasan_langsung']; ?>_id" name="<?= $p['id_penilaian_atasan_langsung']; ?>_id" type="hidden" class="form-control form-control-sm" placeholder="" aria-label="ID Penilaian" value="<?= $p['id_penilaian_atasan_langsung']; ?>" required>
                                                        </td>
                                                        <td class="col-2 mb-0 text-sm" scope="row">
                                                            <input id="<?= $p['id_penilaian_atasan_langsung']; ?>_nilai" name="<?= $p['id_penilaian_atasan_langsung']; ?>_nilai" type="number" class="form-control form-control-sm" placeholder="" aria-label="Nilai" value="<?= $p['nilai']; ?>" required>
                                                        </td>
                                                        <?php $a++; ?>
                                                    </tr>
                                                <?php } ?>
                                            <?php endforeach; ?>
                                            <tr>
                                                <td class="mb-0 text-sm ps-0" scope="row"><b>TRANSPARAN</b></td>
                                            </tr>
                                            <?php $a = 1; ?>
                                            <?php foreach ($nilai_atasan_langsung as $p) : ?>
                                                <?php if ($p['kategori_pertanyaan'] == 'Transparan') { ?>
                                                    <tr>
                                                        <td class="col-1 mb-0 text-sm ps-0" scope="row"><?= $a; ?></td>
                                                        <td class="col-9 mb-0 text-sm" scope="row">
                                                            <?= $p['jabaran_pertanyaan']; ?>
                                                            <input id="<?= $p['id_penilaian_atasan_langsung']; ?>_id" name="<?= $p['id_penilaian_atasan_langsung']; ?>_id" type="hidden" class="form-control form-control-sm" placeholder="" aria-label="ID Penilaian" value="<?= $p['id_penilaian_atasan_langsung']; ?>" required>
                                                        </td>
                                                        <td class="col-2 mb-0 text-sm" scope="row">
                                                            <input id="<?= $p['id_penilaian_atasan_langsung']; ?>_nilai" name="<?= $p['id_penilaian_atasan_langsung']; ?>_nilai" type="number" class="form-control form-control-sm" placeholder="" aria-label="Nilai" value="<?= $p['nilai']; ?>" required>
                                                        </td>
                                                        <?php $a++; ?>
                                                    </tr>
                                                <?php } ?>
                                            <?php endforeach; ?>
                                            <tr>
                                                <td class="mb-0 text-sm ps-0" scope="row"><b>INOVATIF</b></td>
                                            </tr>
                                            <?php $a = 1; ?>
                                            <?php foreach ($nilai_atasan_langsung as $p) : ?>
                                                <?php if ($p['kategori_pertanyaan'] == 'Inovatif') { ?>
                                                    <tr>
                                                        <td class="col-1 mb-0 text-sm ps-0" scope="row"><?= $a; ?></td>
                                                        <td class="col-9 mb-0 text-sm" scope="row">
                                                            <?= $p['jabaran_pertanyaan']; ?>
                                                            <input id="<?= $p['id_penilaian_atasan_langsung']; ?>_id" name="<?= $p['id_penilaian_atasan_langsung']; ?>_id" type="hidden" class="form-control form-control-sm" placeholder="" aria-label="ID Penilaian" value="<?= $p['id_penilaian_atasan_langsung']; ?>" required>
                                                        </td>
                                                        <td class="col-2 mb-0 text-sm" scope="row">
                                                            <input id="<?= $p['id_penilaian_atasan_langsung']; ?>_nilai" name="<?= $p['id_penilaian_atasan_langsung']; ?>_nilai" type="number" class="form-control form-control-sm" placeholder="" aria-label="Nilai" value="<?= $p['nilai']; ?>" required>
                                                        </td>
                                                        <?php $a++; ?>
                                                    </tr>
                                                <?php } ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <div class="row mt-3">
                                        <div class="col">
                                            <button type="submit" class="btn btn-lg btn-primary mt-2 mb-0" style="font-size:1em;">
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            <?php } else { ?>
                                <form action="<?= base_url('/proses-penilaian-atasan-langsung'); ?>" method="post" class="pilih_atasan_langsung pb-2" id="Penilaian_Atasan">
                                    <?= csrf_field(); ?>
                                    <table class="" id="table-penilaian">
                                        <tbody>
                                            <tr>
                                                <td class="mb-0 text-sm ps-0" scope="row"><b>PROFESIONAL</b></td>
                                                <td class="col-9 mb-0 text-sm" scope="row">
                                                    <input id="save" name="save" type="hidden" class="form-control form-control-sm" placeholder="" aria-label="Tambah" value="Tambah" required>
                                                </td>
                                                <td class="col-9 mb-0 text-sm" scope="row">
                                                    <input id="nip_pegawai" name="nip_pegawai" type="hidden" class="form-control form-control-sm" placeholder="" aria-label="NIP Pegawai" value="<?= $nip_pegawai_yang_dinilai; ?>" required>
                                                </td>
                                                <td class="col-9 mb-0 text-sm" scope="row">
                                                    <input id="nip_atasan_langsung" name="nip_atasan_langsung" type="hidden" class="form-control form-control-sm" placeholder="" aria-label="NIP Atasan Langsung" value="<?= $nip_atasan_langsung; ?>" required>
                                                </td>
                                            </tr>
                                            <?php $a = 1; ?>
                                            <?php foreach ($pertanyaan as $p) : ?>
                                                <?php if ($p['kategori_pertanyaan'] == 'Profesional') { ?>
                                                    <tr>
                                                        <td class="col-1 mb-0 text-sm ps-0" scope="row"><?= $a; ?></td>
                                                        <td class="col-9 mb-0 text-sm" scope="row">
                                                            <?= $p['jabaran_pertanyaan']; ?>
                                                            <input id="<?= $p['id_pertanyaan']; ?>_id" name="<?= $p['id_pertanyaan']; ?>_id" type="hidden" class="form-control form-control-sm" placeholder="" aria-label="ID Penilaian" value="<?= $p['id_pertanyaan']; ?>" required>
                                                        </td>
                                                        <td class="col-2 mb-0 text-sm" scope="row">
                                                            <input id="<?= $p['id_pertanyaan']; ?>_nilai" name="<?= $p['id_pertanyaan']; ?>_nilai" type="number" class="form-control form-control-sm" placeholder="" aria-label="Nilai" value="0" required>
                                                        </td>
                                                        <?php $a++; ?>
                                                    </tr>
                                                <?php } ?>
                                            <?php endforeach; ?>
                                            <tr>
                                                <td class="mb-0 text-sm ps-0" scope="row"><b>AKUNTABEL</b></td>
                                            </tr>
                                            <?php $a = 1; ?>
                                            <?php foreach ($pertanyaan as $p) : ?>
                                                <?php if ($p['kategori_pertanyaan'] == 'Akuntabel') { ?>
                                                    <tr>
                                                        <td class="col-1 mb-0 text-sm ps-0" scope="row"><?= $a; ?></td>
                                                        <td class="col-9 mb-0 text-sm" scope="row">
                                                            <?= $p['jabaran_pertanyaan']; ?>
                                                            <input id="<?= $p['id_pertanyaan']; ?>_id" name="<?= $p['id_pertanyaan']; ?>_id" type="hidden" class="form-control form-control-sm" placeholder="" aria-label="ID Penilaian" value="<?= $p['id_pertanyaan']; ?>" required>
                                                        </td>
                                                        <td class="col-2 mb-0 text-sm" scope="row">
                                                            <input id="<?= $p['id_pertanyaan']; ?>_nilai" name="<?= $p['id_pertanyaan']; ?>_nilai" type="number" class="form-control form-control-sm" placeholder="" aria-label="Nilai" value="0" required>
                                                        </td>
                                                        <?php $a++; ?>
                                                    </tr>
                                                <?php } ?>
                                            <?php endforeach; ?>
                                            <tr>
                                                <td class="mb-0 text-sm ps-0" scope="row"><b>SINERGI</b></td>
                                            </tr>
                                            <?php $a = 1; ?>
                                            <?php foreach ($pertanyaan as $p) : ?>
                                                <?php if ($p['kategori_pertanyaan'] == 'Sinergi') { ?>
                                                    <tr>
                                                        <td class="col-1 mb-0 text-sm ps-0" scope="row"><?= $a; ?></td>
                                                        <td class="col-9 mb-0 text-sm" scope="row">
                                                            <?= $p['jabaran_pertanyaan']; ?>
                                                            <input id="<?= $p['id_pertanyaan']; ?>_id" name="<?= $p['id_pertanyaan']; ?>_id" type="hidden" class="form-control form-control-sm" placeholder="" aria-label="ID Penilaian" value="<?= $p['id_pertanyaan']; ?>" required>
                                                        </td>
                                                        <td class="col-2 mb-0 text-sm" scope="row">
                                                            <input id="<?= $p['id_pertanyaan']; ?>_nilai" name="<?= $p['id_pertanyaan']; ?>_nilai" type="number" class="form-control form-control-sm" placeholder="" aria-label="Nilai" value="0" required>
                                                        </td>
                                                        <?php $a++; ?>
                                                    </tr>
                                                <?php } ?>
                                            <?php endforeach; ?>
                                            <tr>
                                                <td class="mb-0 text-sm ps-0" scope="row"><b>TRANSPARAN</b></td>
                                            </tr>
                                            <?php $a = 1; ?>
                                            <?php foreach ($pertanyaan as $p) : ?>
                                                <?php if ($p['kategori_pertanyaan'] == 'Transparan') { ?>
                                                    <tr>
                                                        <td class="col-1 mb-0 text-sm ps-0" scope="row"><?= $a; ?></td>
                                                        <td class="col-9 mb-0 text-sm" scope="row">
                                                            <?= $p['jabaran_pertanyaan']; ?>
                                                            <input id="<?= $p['id_pertanyaan']; ?>_id" name="<?= $p['id_pertanyaan']; ?>_id" type="hidden" class="form-control form-control-sm" placeholder="" aria-label="ID Penilaian" value="<?= $p['id_pertanyaan']; ?>" required>
                                                        </td>
                                                        <td class="col-2 mb-0 text-sm" scope="row">
                                                            <input id="<?= $p['id_pertanyaan']; ?>_nilai" name="<?= $p['id_pertanyaan']; ?>_nilai" type="number" class="form-control form-control-sm" placeholder="" aria-label="Nilai" value="0" required>
                                                        </td>
                                                        <?php $a++; ?>
                                                    </tr>
                                                <?php } ?>
                                            <?php endforeach; ?>
                                            <tr>
                                                <td class="mb-0 text-sm ps-0" scope="row"><b>INOVATIF</b></td>
                                            </tr>
                                            <?php $a = 1; ?>
                                            <?php foreach ($pertanyaan as $p) : ?>
                                                <?php if ($p['kategori_pertanyaan'] == 'Inovatif') { ?>
                                                    <tr>
                                                        <td class="col-1 mb-0 text-sm ps-0" scope="row"><?= $a; ?></td>
                                                        <td class="col-9 mb-0 text-sm" scope="row">
                                                            <?= $p['jabaran_pertanyaan']; ?>
                                                            <input id="<?= $p['id_pertanyaan']; ?>_id" name="<?= $p['id_pertanyaan']; ?>_id" type="hidden" class="form-control form-control-sm" placeholder="" aria-label="ID Penilaian" value="<?= $p['id_pertanyaan']; ?>" required>
                                                        </td>
                                                        <td class="col-2 mb-0 text-sm" scope="row">
                                                            <input id="<?= $p['id_pertanyaan']; ?>_nilai" name="<?= $p['id_pertanyaan']; ?>_nilai" type="number" class="form-control form-control-sm" placeholder="" aria-label="Nilai" value="0" required>
                                                        </td>
                                                        <?php $a++; ?>
                                                    </tr>
                                                <?php } ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <div class="row mt-3">
                                        <div class="col">
                                            <button type="submit" class="btn btn-lg btn-primary mt-2 mb-0" style="font-size:1em;">
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            <?php } ?>
                            <!-- PALING BAWAH BUTTON -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>