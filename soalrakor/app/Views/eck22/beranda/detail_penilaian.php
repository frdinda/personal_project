<?= $this->extend('layout/layout_all'); ?>

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
                                        <input id="id_satker" name="id_satker" type="hidden" class="form-control form-control-lg" placeholder="" aria-label="ID Satuan Kerja" disabled>
                                        <div class="row mb-4 ms-0" style="font-size:1.25em;">
                                            Satuan Kerja:
                                            <?= $detail_satker['nama_satker']; ?>
                                        </div>
                                        <table class="table-hover ms-0" id="table-detail-nilai">
                                            <thead>
                                                <th class="col-md-1 text-uppercase font-weight-bolder text-sm ps-0" scope="col">No.</th>
                                                <th class="col-md-8 text-uppercase font-weight-bolder text-sm ps-0" scope="col">Soal</th>
                                                <th class="col-md-3 text-uppercase font-weight-bolder text-sm ps-0" scope="col">Nilai</th>
                                            </thead>
                                            <tbody>
                                                <?php $nilai_total_lain = 0;
                                                $nilai_total_ppt = 0;
                                                $nilai_video = 0;
                                                $nomor = 1;
                                                foreach ($pembagian_soal_satker as $p) :
                                                    if ($p['kategori'] != 'simpulan') { ?>
                                                        <tr>
                                                            <td class="mb-0 text-sm" scope="row">
                                                                <?= $nomor; ?>
                                                            </td>
                                                            <td class="mb-0 text-sm" scope="row">
                                                                <?= $p['soal']; ?>
                                                            </td>
                                                            <?php
                                                            $total_1 = 0;
                                                            foreach ($nilai_satker as $n) :
                                                                if ($n['id_soal'] == $p['id_soal']) {
                                                                    $total_1 = $total_1 + $n['nilai'];
                                                                }
                                                            endforeach;
                                                            $nilai_persoal = $total_1 / 3;
                                                            ?>
                                                            <td class="mb-0 text-sm" scope="row">
                                                                <?= $nilai_persoal; ?>
                                                            </td>
                                                        </tr>
                                                <?php
                                                        $nomor++;
                                                        if ($p['kategori'] == "ppt") {
                                                            $nilai_total_ppt = $nilai_persoal + $nilai_total_ppt;
                                                        } else if ($p['kategori'] == 'video') {
                                                            $nilai_video = $nilai_persoal + $nilai_video;
                                                        } else {
                                                            $nilai_total_lain = $nilai_persoal + $nilai_total_lain;
                                                        }
                                                    }
                                                endforeach;
                                                $nilai_akhir = ($nilai_total_ppt / 2) * (30 / 100) + ($nilai_video) * (20 / 100) + ($nilai_total_lain / 2) * (50 / 100);
                                                ?>
                                            </tbody>
                                        </table>
                                        <div class="row ms-0 ps-0 mt-5">
                                            <?php
                                            $nomor_evaluatee = 0;
                                            foreach ($pembagian_soal_satker as $p) :
                                                if ($p['kategori'] == 'simpulan') {
                                                    foreach ($nilai_satker as $n) :
                                                        if ($n['id_soal'] == $p['id_soal']) {
                                                            $nomor_evaluatee++; ?>
                                                            <div class="ms-0 ps-0 mb-1">
                                                                <b class="ms-0 ps-0">Evaluator <?= $nomor_evaluatee; ?> </b>: <?= $n['simpulan']; ?>
                                                            </div>
                                                    <?php }
                                                    endforeach; ?>
                                            <?php }
                                            endforeach; ?>
                                        </div>
                                        <div class="row mb-4 mt-5 ms-0" style="font-size:1.25em;">
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