<?= $this->extend('layout_tzi23/layout_all'); ?>

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
                                        <table class="table-hover" id="table-kelola-nilai">
                                            <thead>
                                                <th class="col-md-1 text-uppercase font-weight-bolder text-sm ps-0" scope="col">Ranking</th>
                                                <th class="col-md-4 text-uppercase font-weight-bolder text-sm ps-0" scope="col">Asesi</th>
                                                <th class="col-md-4 text-uppercase font-weight-bolder text-sm ps-0" scope="col">Total Penilaian</th>
                                                <th class="col-md-3 text-uppercase font-weight-bolder text-sm ps-0" scope="col">Pokja Diinginkan</th>
                                                <th class="col-md-1 text-uppercase font-weight-bolder text-sm ps-0" scope="col"></th>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $ranking = 1;
                                                foreach ($daftar_asesi as $s) :
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
                                                                if ($s['jenis_jabatan'] == 'pegawai') {
                                                                    $total_keseluruhan = $total_keseluruhan + $total_persoal;
                                                                } else {
                                                                    $total_keseluruhan = $total_keseluruhan + $total_persoal;
                                                                }
                                                            }
                                                        ?>
                                                        <?php
                                                        endforeach;
                                                        if ($s['jenis_jabatan'] == 'pegawai') {
                                                            $nilai_akhir = ($total_keseluruhan * 4) / 10;
                                                        } else {
                                                            $nilai_akhir = $total_keseluruhan / 4;
                                                        }
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
                                                            <a href="<?= base_url('/edit-nilai-tzi23/' . $s['id_asesi']); ?>" class="btn btn-primary table text-sm">Edit</a>
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