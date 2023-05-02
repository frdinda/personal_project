<?= $this->extend('layout_tzi23/layout_all_beranda'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid py-4">
    <div class="row mt-4">
        <div class="col-lg-12 mb-lg-0 mb-4">
            <div class="card z-index-2 h-auto">
                <div class="card-header pb-0 pt-3 bg-transparent">
                    <b>
                        <h3 class="text-capitalize" style="color: #344767;">Dashboard Penilaian</h3>
                    </b>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-12 col-xxl-12 d-flex" style="color: #344767;">
                        <div class="card flex-fill p-3">
                            <?php if ($akses == 'admin' || $akses == 'evaluator') { ?>
                                <div class="tab-content card-body flex-fill p-3 table-responsive" id="myTabContent">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="data-asesi-struktural" data-bs-toggle="tab" data-bs-target="#tab-data-asesi-struktural" type="button" role="tab" aria-controls="tab-data-asesi-struktural" aria-selected="true">Data Pejabat Struktural</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="data-asesi-pegawai" data-bs-toggle="tab" data-bs-target="#tab-data-asesi-pegawai" type="button" role="tab" aria-controls="tab-data-asesi-pegawai" aria-selected="true">Data JFT JFU</button>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-content ps-4 pe-4 pb-4" id="myTabContent">
                                    <div class="tab-pane fade show active" id="tab-data-asesi-struktural" role="tabpanel" aria-labelledby="data-asesi-struktural">
                                        <div class="tab-content card-body flex-fill p-3 table-responsive" id="myTabContent">
                                            <div class="tab-content mt-4 ms-2 me-2" id="myTabContent">
                                                <div class="tab-pane fade show active" id="surat-all" role="tabpanel" aria-labelledby="surat-all-tab">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="card mb-5">
                                                                <div class="card-header">Nilai Asesi</div>
                                                                <div class="card-body" style="height: auto;">
                                                                    <div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                                                                        <div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                                                            <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                                                                        </div>
                                                                        <div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                                                            <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                                                                        </div>
                                                                    </div> <canvas id="chart-line" width="199" height="100" class="chartjs-render-monitor" style="display: block; width: 199px; height: 100px;"></canvas>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="card mb-5">
                                                                <div class="card-header">Pemilihan Pokja</div>
                                                                <div class="card-body" style="height: auto;">
                                                                    <div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                                                                        <div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                                                            <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                                                                        </div>
                                                                        <div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                                                            <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                                                                        </div>
                                                                    </div> <canvas id="chart-line-2" width="199" height="100" class="chartjs-render-monitor" style="display: block; width: 199px; height: 100px;"></canvas>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <table class="table-hover" id="table-surat-all">
                                                        <thead>
                                                            <th class="col-md-2 text-uppercase font-weight-bolder text-sm ps-0" scope="col">NIP</th>
                                                            <th class="col-md-3 text-uppercase font-weight-bolder text-sm ps-0" scope="col">Nama Asesi</th>
                                                            <th class="col-md-3 text-uppercase font-weight-bolder text-sm ps-0" scope="col">Total Nilai</th>
                                                            <th class="col-md-3 text-uppercase font-weight-bolder text-sm ps-0" scope="col">Pokja Diinginkan</th>
                                                            <th class="col-md-1 text-uppercase font-weight-bolder text-sm ps-0" scope="col">Detail <br> Nilai</th>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            foreach ($daftar_asesi as $s) : if ($s['jenis_jabatan'] != 'pegawai') {
                                                            ?>
                                                                    <tr>
                                                                        <td class="mb-0 text-sm" scope="row"><?= $s['id_asesi']; ?></td>
                                                                        <td class="mb-0 text-sm" scope="row"><?= $s['nama_asesi']; ?></td>
                                                                        <?php
                                                                        $total_keseluruhan = 0;
                                                                        $nilai_akhir = 0;
                                                                        $pokja = '-';
                                                                        foreach ($pembagian_soal as $p) :
                                                                            $total_persoal = 0;
                                                                            $nilai_soal_acak = 0;
                                                                            if ($s['id_asesi'] == $p['id_asesi']) {
                                                                                foreach ($nilai_dashboard as $n) :
                                                                                    if ($p['id_soal'] == $n['id_soal'] && $s['id_asesi'] == $n['id_asesi']) {
                                                                                        if ($n['kategori'] == 'wajib') {
                                                                                            $pokja = $n['pokja'];
                                                                                        } else {
                                                                                            $total_persoal = $total_persoal + $n['nilai'];
                                                                                        }
                                                                                    }
                                                                                endforeach;
                                                                                $total_keseluruhan = $total_keseluruhan + $total_persoal;
                                                                            }
                                                                        ?>
                                                                        <?php
                                                                        endforeach;
                                                                        $nilai_akhir = ($total_keseluruhan / 4);
                                                                        ?>
                                                                        <td class="mb-0 text-sm" scope="row"><?= $nilai_akhir; ?></td>
                                                                        <td class="mb-0 text-sm" scope="row">
                                                                            <?php if ($pokja == 'P1') {
                                                                                echo 'Pokja 1 - Manajemen Perubahan';
                                                                            } else if ($pokja == 'P2') {
                                                                                echo 'Pokja 2 - Penataan Tatalaksana';
                                                                            } else if ($pokja == 'P3') {
                                                                                echo 'Pokja 3 - Penataan Manajemen SDM';
                                                                            } else if ($pokja == 'P4') {
                                                                                echo 'Pokja 4 - Penguatan Akuntabilitas Kinerja';
                                                                            } else if ($pokja == 'P5') {
                                                                                echo 'Pokja 5 - Penguatan Pengawasan';
                                                                            } else if ($pokja == 'P6') {
                                                                                echo 'Pokja 6 - Peningkatan Kualitas Pelayanan Publik';
                                                                            } else if ($pokja == 'SK') {
                                                                                echo 'Sekretariat';
                                                                            } else {
                                                                                echo '-';
                                                                            } ?>
                                                                        </td>
                                                                        <td class="mb-0 text-sm" scope="row">
                                                                            <a href="<?= base_url('/detail-nilai-tzi23/' . $s['id_asesi']); ?>" class="btn btn-primary table text-sm">Detail</a>
                                                                        </td>
                                                                    </tr>
                                                            <?php }
                                                            endforeach;
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tab-data-asesi-pegawai" role="tabpanel">
                                        <div class="tab-content card-body flex-fill p-3 table-responsive" id="myTabContent">
                                            <div class="tab-content mt-4 ms-2 me-2" id="myTabContent">
                                                <div class="tab-pane fade show active" id="surat-all" role="tabpanel" aria-labelledby="surat-all-tab">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="card mb-5">
                                                                <div class="card-header">Nilai Pegawai</div>
                                                                <div class="card-body" style="height: auto;">
                                                                    <div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                                                                        <div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                                                            <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                                                                        </div>
                                                                        <div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                                                            <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                                                                        </div>
                                                                    </div> <canvas id="chart-line-3" width="199" height="100" class="chartjs-render-monitor" style="display: block; width: 199px; height: 100px;"></canvas>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="card mb-5">
                                                                <div class="card-header">Pemilihan Pokja</div>
                                                                <div class="card-body" style="height: auto;">
                                                                    <div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                                                                        <div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                                                            <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                                                                        </div>
                                                                        <div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                                                            <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                                                                        </div>
                                                                    </div> <canvas id="chart-line-4" width="199" height="100" class="chartjs-render-monitor" style="display: block; width: 199px; height: 100px;"></canvas>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <table class="table-hover" id="table-surat-all-2">
                                                        <thead>
                                                            <th class="col-md-2 text-uppercase font-weight-bolder text-sm ps-0" scope="col">NIP</th>
                                                            <th class="col-md-3 text-uppercase font-weight-bolder text-sm ps-0" scope="col">Nama Asesi</th>
                                                            <th class="col-md-3 text-uppercase font-weight-bolder text-sm ps-0" scope="col">Total Nilai</th>
                                                            <th class="col-md-3 text-uppercase font-weight-bolder text-sm ps-0" scope="col">Pokja Diinginkan</th>
                                                            <th class="col-md-1 text-uppercase font-weight-bolder text-sm ps-0" scope="col">Detail <br> Nilai</th>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            foreach ($daftar_asesi as $s) : if ($s['jenis_jabatan'] == 'pegawai') {
                                                            ?>
                                                                    <tr>
                                                                        <td class="mb-0 text-sm" scope="row"><?= $s['id_asesi']; ?></td>
                                                                        <td class="mb-0 text-sm" scope="row"><?= $s['nama_asesi']; ?></td>
                                                                        <?php
                                                                        $total_keseluruhan = 0;
                                                                        $nilai_akhir = 0;
                                                                        $pokja = '-';
                                                                        foreach ($pembagian_soal as $p) :
                                                                            $total_persoal = 0;
                                                                            $nilai_soal_acak = 0;
                                                                            if ($s['id_asesi'] == $p['id_asesi']) {
                                                                                foreach ($nilai_dashboard as $n) :
                                                                                    if ($p['id_soal'] == $n['id_soal'] && $s['id_asesi'] == $n['id_asesi']) {
                                                                                        if ($n['kategori'] == 'wajib') {
                                                                                            $pokja = $n['pokja'];
                                                                                        } else {
                                                                                            $total_persoal = $total_persoal + $n['nilai'];
                                                                                        }
                                                                                    }
                                                                                endforeach;
                                                                                $total_keseluruhan = $total_keseluruhan + $total_persoal;
                                                                            }
                                                                        ?>
                                                                        <?php
                                                                        endforeach;
                                                                        $nilai_akhir = ($total_keseluruhan * 4) / 10;
                                                                        ?>
                                                                        <td class="mb-0 text-sm" scope="row"><?= $nilai_akhir; ?></td>
                                                                        <td class="mb-0 text-sm" scope="row">
                                                                            <?php if ($pokja == 'P1') {
                                                                                echo 'Pokja 1 - Manajemen Perubahan';
                                                                            } else if ($pokja == 'P2') {
                                                                                echo 'Pokja 2 - Penataan Tatalaksana';
                                                                            } else if ($pokja == 'P3') {
                                                                                echo 'Pokja 3 - Penataan Manajemen SDM';
                                                                            } else if ($pokja == 'P4') {
                                                                                echo 'Pokja 4 - Penguatan Akuntabilitas Kinerja';
                                                                            } else if ($pokja == 'P5') {
                                                                                echo 'Pokja 5 - Penguatan Pengawasan';
                                                                            } else if ($pokja == 'P6') {
                                                                                echo 'Pokja 6 - Peningkatan Kualitas Pelayanan Publik';
                                                                            } else if ($pokja == 'SK') {
                                                                                echo 'Sekretariat';
                                                                            } else {
                                                                                echo '-';
                                                                            } ?>
                                                                        </td>
                                                                        <td class="mb-0 text-sm" scope="row" style="text-align:center;">
                                                                            <a href=" <?= base_url('/detail-nilai-tzi23/' . $s['id_asesi']); ?>" class="btn btn-primary text-sm" style="text-align:center;">
                                                                                Detail
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                            <?php }
                                                            endforeach;
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="tab-pane ps-4 pt-5 pe-3 pb-5" id="tab-data-asesi-pegawai" role="tabpanel">
                                    <table class="table-hover" id="table-surat-all-3">
                                        <thead>
                                            <th class="col-md-2 text-uppercase font-weight-bolder text-sm ps-0" scope="col">NIP</th>
                                            <th class="col-md-3 text-uppercase font-weight-bolder text-sm ps-0" scope="col">Nama Asesi</th>
                                            <th class="col-md-3 text-uppercase font-weight-bolder text-sm ps-0" scope="col">Total Nilai</th>
                                            <th class="col-md-3 text-uppercase font-weight-bolder text-sm ps-0" scope="col">Pokja Diinginkan</th>
                                            <th class="col-md-1 text-uppercase font-weight-bolder text-sm ps-0" scope="col">Detail <br> Nilai</th>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($daftar_asesi as $s) : if ($s['id_asesi'] == $id_user) {
                                            ?>
                                                    <tr>
                                                        <td class="mb-0 text-sm" scope="row"><?= $s['id_asesi']; ?></td>
                                                        <td class="mb-0 text-sm" scope="row"><?= $s['nama_asesi']; ?></td>
                                                        <?php
                                                        $total_keseluruhan = 0;
                                                        $nilai_akhir = 0;
                                                        $pokja = '-';
                                                        foreach ($pembagian_soal as $p) :
                                                            $total_persoal = 0;
                                                            $nilai_soal_acak = 0;
                                                            if ($s['id_asesi'] == $p['id_asesi']) {
                                                                foreach ($nilai_dashboard as $n) :
                                                                    if ($p['id_soal'] == $n['id_soal'] && $s['id_asesi'] == $n['id_asesi']) {
                                                                        if ($n['kategori'] == 'wajib') {
                                                                            $pokja = $n['pokja'];
                                                                        } else {
                                                                            $total_persoal = $total_persoal + $n['nilai'];
                                                                        }
                                                                    }
                                                                endforeach;
                                                                $total_keseluruhan = $total_keseluruhan + $total_persoal;
                                                            }
                                                        ?>
                                                        <?php
                                                        endforeach;
                                                        $nilai_akhir = ($total_keseluruhan * 4) / 10;
                                                        ?>
                                                        <td class="mb-0 text-sm" scope="row"><?= $nilai_akhir; ?></td>
                                                        <td class="mb-0 text-sm" scope="row">
                                                            <?php if ($pokja == 'P1') {
                                                                echo 'Pokja 1 - Manajemen Perubahan';
                                                            } else if ($pokja == 'P2') {
                                                                echo 'Pokja 2 - Penataan Tatalaksana';
                                                            } else if ($pokja == 'P3') {
                                                                echo 'Pokja 3 - Penataan Manajemen SDM';
                                                            } else if ($pokja == 'P4') {
                                                                echo 'Pokja 4 - Penguatan Akuntabilitas Kinerja';
                                                            } else if ($pokja == 'P5') {
                                                                echo 'Pokja 5 - Penguatan Pengawasan';
                                                            } else if ($pokja == 'P6') {
                                                                echo 'Pokja 6 - Peningkatan Kualitas Pelayanan Publik';
                                                            } else if ($pokja == 'SK') {
                                                                echo 'Sekretariat';
                                                            } else {
                                                                echo '-';
                                                            } ?>
                                                        </td>
                                                        <td class="mb-0 text-sm" scope="row">
                                                            <a href="<?= base_url('/detail-nilai-tzi23/' . $s['id_asesi']); ?>" class="btn btn-primary table text-sm">Detail</a>
                                                        </td>
                                                    </tr>
                                            <?php }
                                            endforeach;
                                            ?>
                                        </tbody>
                                    </table>
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

<?= $this->endSection(); ?>