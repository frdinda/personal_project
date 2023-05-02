<?= $this->extend('layout_tzi23/layout_all'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid py-4">
    <div class="row mt-4">
        <div class="col-lg-12 mb-lg-0 mb-4">
            <div class="card z-index-2 h-auto">
                <div class="card-header pb-0 pt-3 bg-transparent">
                    <b>
                        <h3 class="text-capitalize" style="color: #344767;">Detail Nilai</h3>
                    </b>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-12 col-xxl-12 d-flex" style="color: #344767;">
                        <div class="card flex-fill p-3">
                            <div class="tab-content card-body flex-fill p-3 table-responsive" id="myTabContent">
                                <div class="tab-content mt-4 ms-2 me-2" id="myTabContent">
                                    <div class="tab-pane fade show active" id="surat-all" role="tabpanel" aria-labelledby="surat-all-tab">
                                        <input id="id_asesi" name="id_asesi" type="hidden" class="form-control form-control-lg" placeholder="" aria-label="ID Asesi" disabled>
                                        <div class="row mb-4 ms-0" style="font-size:1.25em;">
                                            Nama Asesi:
                                            <?= $detail_asesi['nama_asesi']; ?>
                                        </div>
                                        <table class="table-hover ms-0" id="table-detail-nilai">
                                            <thead>
                                                <th class="col-md-1 text-uppercase font-weight-bolder text-sm ps-0" scope="col">No.</th>
                                                <th class="col-md-8 text-uppercase font-weight-bolder text-sm ps-0" scope="col">Soal</th>
                                                <th class="col-md-3 text-uppercase font-weight-bolder text-sm ps-0" scope="col">Nilai</th>
                                            </thead>
                                            <tbody>
                                                <?php $nilai_total_lain = 0;
                                                $nomor = 1;
                                                $nilai_akhir = 0;
                                                foreach ($pembagian_soal_asesi as $p) :
                                                    if ($p['kategori'] != 'wajib' && $p['kategori'] != 'wajib2') { ?>
                                                        <tr>
                                                            <td class="mb-0 text-sm" scope="row">
                                                                <?= $nomor; ?>
                                                            </td>
                                                            <td class="mb-0 text-sm" scope="row">
                                                                <?= $p['soal']; ?>
                                                            </td>
                                                            <?php
                                                            $total_1 = 0;
                                                            foreach ($nilai_asesi as $n) :
                                                                if ($n['id_soal'] == $p['id_soal']) {
                                                                    $total_1 = $total_1 + $n['nilai'];
                                                                }
                                                            endforeach;
                                                            if ($detail_asesi['jenis_jabatan'] == 'pegawai') {
                                                                $nilai_persoal = $total_1;
                                                            } else {
                                                                $nilai_persoal = $total_1 / 3;
                                                            }
                                                            ?>
                                                            <td class="mb-0 text-sm" scope="row">
                                                                <?= $nilai_persoal; ?>
                                                            </td>
                                                        </tr>
                                                <?php
                                                        $nomor++;
                                                        $nilai_akhir = $nilai_akhir + $nilai_persoal;
                                                    }
                                                endforeach;
                                                if ($detail_asesi['jenis_jabatan'] == 'pegawai') {
                                                    $nilai_akhir = ($nilai_akhir * 4) / 10;
                                                } else {
                                                    $nilai_akhir = ($nilai_akhir / 3);
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                        <div class="row ms-0 ps-0 mt-5">
                                            <?php
                                            $nomor_evaluatee = 0;
                                            foreach ($pembagian_soal_asesi as $p) :
                                                if ($p['kategori'] == 'wajib') {
                                                    foreach ($nilai_asesi as $n) :
                                                        if ($n['id_soal'] == $p['id_soal']) {
                                                            $nomor_evaluatee++; ?>
                                                            <div class="ms-0 ps-0 mb-1">
                                                                <b class="ms-0 ps-0"><?php if ($detail_asesi['jenis_jabatan'] == 'pegawai') { ?>Pokja yang Diinginkan : <?php } else { ?>Evaluator <?= $nomor_evaluatee; ?> </b>: <?php }
                                                                                                                                                                                                                                if ($n['pokja'] == 'P1') {
                                                                                                                                                                                                                                    echo 'Pokja 1 - Manajemen Perubahan';
                                                                                                                                                                                                                                } else if ($n['pokja'] == 'P2') {
                                                                                                                                                                                                                                    echo 'Pokja 2 - Penataan Tatalaksana';
                                                                                                                                                                                                                                } else if ($n['pokja'] == 'P3') {
                                                                                                                                                                                                                                    echo 'Pokja 3 - Penataan Manajemen SDM';
                                                                                                                                                                                                                                } else if ($n['pokja'] == 'P4') {
                                                                                                                                                                                                                                    echo 'Pokja 4 - Penguatan Akuntabilitas Kinerja';
                                                                                                                                                                                                                                } else if ($n['pokja'] == 'P5') {
                                                                                                                                                                                                                                    echo 'Pokja 5 - Penguatan Pengawasan';
                                                                                                                                                                                                                                } else if ($n['pokja'] == 'P6') {
                                                                                                                                                                                                                                    echo 'Pokja 6 - Peningkatan Kualitas Pelayanan Publik';
                                                                                                                                                                                                                                } else if ($n['pokja'] == 'SK') {
                                                                                                                                                                                                                                    echo 'Sekretariat';
                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                    echo '-';
                                                                                                                                                                                                                                } ?>
                                                            </div>
                                                    <?php }
                                                    endforeach; ?>
                                            <?php }
                                            endforeach; ?>
                                        </div>
                                        <div class="row ms-0 ps-0 mt-3">
                                            <?php
                                            $nomor_evaluatee = 0;
                                            foreach ($pembagian_soal_asesi as $p) :
                                                if ($p['kategori'] == 'wajib2') {
                                                    foreach ($nilai_asesi as $n) :
                                                        if ($n['id_soal'] == $p['id_soal']) {
                                                            $nomor_evaluatee++; ?>
                                                            <div class="ms-0 ps-0 mb-1">
                                                                <b class="ms-0 ps-0"><?php if ($detail_asesi['jenis_jabatan'] == 'pegawai') { ?>Program yang Akan Dikembangkan : <?php } else { ?>Evaluator <?= $nomor_evaluatee; ?> </b>: <?php }
                                                                                                                                                                                                                                        echo $n['jawaban_program']; ?>
                                                            </div>
                                                    <?php }
                                                    endforeach; ?>
                                            <?php }
                                            endforeach; ?>
                                        </div>
                                        <div class="row mb-4 mt-4 ms-0" style="font-size:1.25em;">
                                            <b class="ms-0 ps-0">
                                                Nilai Akhir:
                                                <?= $nilai_akhir; ?>
                                            </b>
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
</div>

<?= $this->endSection(); ?>