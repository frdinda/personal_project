<?= $this->extend('layout_ukom23/layout_all'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid py-4">
    <div class="row mt-4">
        <div class="col-lg-12 mb-lg-0 mb-4">
            <div class="card z-index-2 h-auto">
                <div class="card-header pb-0 pt-3 bg-transparent">
                    <b>
                        <h3 class="text-capitalize" style="color: #344767;"><?= $nama_subpage; ?> Untuk Periode <?= $periode_berjalan_sementara['nama_periode']; ?></h3>
                    </b>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-12 col-xxl-12 d-flex" style="color: #344767;">
                        <div class="card flex-fill p-4">
                            <div class="row mb-5">
                                <div class="col-4">
                                    <form role="form" action="<?= base_url('/pilihan-periode-nilai'); ?>" method="post">
                                        <div class="row">
                                            <div class="col-10">
                                                <div class="input-group input-group-outline is-filled mb-3">
                                                    <select class="form-control form-select form-select-pilihan-periode" name="pilihan_periode" id="pilihan_periode" required>
                                                        <?php foreach ($data_periode as $d) : ?>
                                                            <?php if ($d['id_periode'] == $periode_berjalan_sementara['id_periode']) { ?>
                                                                <option value="<?= $d['id_periode']; ?>" selected><?= $d['nama_periode']; ?></option>
                                                            <?php } else { ?>
                                                                <option value="<?= $d['id_periode']; ?>"><?= $d['nama_periode']; ?></option>
                                                            <?php } ?>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <button type="submit" class="btn btn-primary mt-0 mb-0" style="font-size:1em;">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-12 col-xxl-12">
                                    <table class="table-hover" id="table-nilai">
                                        <thead>
                                            <!-- maunya ranking, tapi gatau caranya buat perankingan berdasarkan nilai yang ada langsung. jadinya, dibuat aja column rankingnya nggak bisa diubah-ubah terus urutannya udah berdasarkan nilai -->
                                            <th class="col-md-2 text-uppercase font-weight-bolder text-sm ps-0" scope="col">NIP Pegawai</th>
                                            <th class="col-md-3 text-uppercase font-weight-bolder text-sm ps-0" scope="col">Nama Pegawai</th>
                                            <th class="col-md-3 text-uppercase font-weight-bolder text-sm ps-0" scope="col">Satuan Kerja</th>
                                            <th class="col-md-3 text-uppercase font-weight-bolder text-sm ps-0" scope="col">Total Nilai</th>
                                            <th class="col-md-1 text-uppercase font-weight-bolder text-sm ps-0" scope="col"></th>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($daftar_peserta as $d) : ?>
                                                <tr>
                                                    <td class="mb-0 ms-0 ps-0 text-sm" scope="row"><?= $d['id_peserta']; ?></td>
                                                    <td class="mb-0 ms-0 ps-0 text-sm" scope="row"><?= $d['nama_peserta']; ?></td>
                                                    <td class="mb-0 ms-0 ps-0 text-sm" scope="row"><?= $d['nama_satker']; ?></td>
                                                    <?php $total_keseluruhan = 0;
                                                    $nilai_akhir = 0;
                                                    foreach ($pembagian_soal as $p) :
                                                        $total_persoal = 0;
                                                        if ($d['id_peserta'] == $p['id_peserta']) {
                                                            foreach ($nilai_dashboard as $n) :
                                                                if ($p['id_soal'] == $n['id_soal'] && $s['id_peserta'] == $n['id_peserta']) {
                                                                    $total_persoal = $total_persoal + $n['nilai'];
                                                                }
                                                            endforeach;
                                                            $total_keseluruhan = $total_keseluruhan + ($total_persoal / 2);
                                                        }
                                                    endforeach;
                                                    $nilai_akhir = $total_keseluruhan / 5; ?>
                                                    <td class="mb-0 ms-0 ps-0 text-sm" scope="row"><?= $nilai_akhir; ?></td>
                                                    <td class="mb-0 ms-0 ps-0 text-sm" scope="row">
                                                        <a href="<?= base_url('/edit-nilai-ukom23/' . $d['id_peserta']); ?>" class="btn btn-primary table text-sm">Edit</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
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

<?= $this->endSection(); ?>