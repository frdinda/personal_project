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
                            <div class="tab-content card-body flex-fill p-3 table-responsive" id="myTabContent">
                                <div class="tab-content mt-4 ms-2 me-2" id="myTabContent">
                                    <div class="tab-pane fade show active" id="surat-all" role="tabpanel" aria-labelledby="surat-all-tab">
                                        <input id="id_peserta" name="id_peserta" type="hidden" class="form-control form-control-lg" placeholder="" aria-label="ID Peserta" disabled>
                                        <div class="row mb-4 ms-0" style="font-size:1.25em;">
                                            Nama Peserta:
                                            <?= $detail_peserta['nama_peserta']; ?>
                                        </div>
                                        <table class="table-hover ms-0" id="table-detail-nilai">
                                            <thead>
                                                <th class="col-md-1 text-uppercase font-weight-bolder text-sm ps-0" scope="col">No.</th>
                                                <th class="col-md-8 text-uppercase font-weight-bolder text-sm ps-0" scope="col">Soal</th>
                                                <th class="col-md-3 text-uppercase font-weight-bolder text-sm ps-0" scope="col">Nilai</th>
                                            </thead>
                                            <tbody>
                                                <?php $nilai_total = 0;
                                                $nomor = 1;
                                                $nilai_akhir = 0;
                                                foreach ($pembagian_soal_peserta as $p) : ?>
                                                    <tr>
                                                        <td class="mb-0 text-sm" scope="row">
                                                            <?= $nomor; ?>
                                                        </td>
                                                        <td class="mb-0 text-sm" scope="row">
                                                            <?= $p['soal']; ?>
                                                        </td>
                                                        <?php
                                                        $total_1 = 0;
                                                        foreach ($nilai_peserta as $n) :
                                                            if ($n['id_soal'] == $p['id_soal']) {
                                                                $total_1 = $total_1 + $n['nilai'];
                                                            }
                                                        endforeach;
                                                        $nilai_persoal = $total_1 / 2;
                                                        $nomor++;
                                                        $nilai_akhir = $nilai_akhir + $nilai_persoal;
                                                        ?>
                                                        <td class="mb-0 text-sm" scope="row">
                                                            <?= $nilai_persoal; ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                        <?php $nilai_akhir = $nilai_akhir / 5; ?>
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