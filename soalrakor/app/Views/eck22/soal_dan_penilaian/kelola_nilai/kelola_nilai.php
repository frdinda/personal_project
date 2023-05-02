<?= $this->extend('layout/layout_all'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid py-4">
    <div class="row mt-4">
        <div class="col-lg-12 mb-lg-0 mb-4">
            <div class="card z-index-2 h-auto">
                <div class="card-header pb-0 pt-3 bg-transparent">
                    <b>
                        <h3 class="text-capitalize" style="color: #344767;">Kelola Nilai</h3>
                    </b>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-12 col-xxl-12 d-flex" style="color: #344767;">
                        <div class="card flex-fill p-3">
                            <div class="tab-content card-body flex-fill p-3 table-responsive" id="myTabContent">
                                <div class="tab-content mt-4 ms-2 me-2" id="myTabContent">
                                    <div class="tab-pane fade show active" id="surat-all" role="tabpanel" aria-labelledby="surat-all-tab">
                                        <table class="table-hover" id="table-ranking">
                                            <thead>
                                                <th class="col-md-1 text-uppercase font-weight-bolder text-sm ps-0" scope="col">Ranking</th>
                                                <th class="col-md-4 text-uppercase font-weight-bolder text-sm ps-0" scope="col">Satuan Kerja</th>
                                                <th class="col-md-4 text-uppercase font-weight-bolder text-sm ps-0" scope="col">Total Penilaian</th>
                                                <th class="col-md-1 text-uppercase font-weight-bolder text-sm ps-0" scope="col"></th>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $ranking = 1;
                                                foreach ($daftar_satker as $s) :
                                                ?>
                                                    <tr>
                                                        <td class="mb-0 text-sm" scope="row"><?= $ranking; ?></td>
                                                        <td class="mb-0 text-sm" scope="row"><?= $s['nama_satker']; ?></td>
                                                        <?php
                                                        $total_keseluruhan = 0;
                                                        $nilai_akhir = 0;
                                                        foreach ($pembagian_soal as $p) :
                                                            $total_persoal = 0;
                                                            if ($s['id_satker'] == $p['id_satker']) {
                                                                foreach ($nilai_dashboard as $n) :
                                                                    if ($p['id_soal'] == $n['id_soal'] && $s['id_satker'] == $n['id_satker']) {
                                                                        $total_persoal = $total_persoal + $n['nilai'];
                                                                    }
                                                                endforeach;
                                                                $total_keseluruhan = $total_keseluruhan + ($total_persoal / 3);
                                                            }
                                                        ?>
                                                        <?php
                                                        endforeach;
                                                        $nilai_akhir = $total_keseluruhan / 3;
                                                        ?>
                                                        <td class="mb-0 text-sm" scope="row"><?= $nilai_akhir; ?></td>
                                                        <td class="mb-0 text-sm" scope="row">
                                                            <a href="<?= base_url('/edit-nilai/' . $s['id_satker']); ?>" class="btn btn-primary table text-sm">Edit</a>
                                                        </td>
                                                    </tr>
                                                <?php
                                                    $ranking++;
                                                endforeach;
                                                ?>
                                            </tbody>
                                        </table>
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