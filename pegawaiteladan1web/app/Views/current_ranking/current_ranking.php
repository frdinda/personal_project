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
                <!-- DISINI BUTTON TENTUKAN PEGAWAI -->

                <div class="row">
                    <div class="col-12 col-lg-12 col-xxl-12 d-flex" style="color: #344767;">
                        <div class="card flex-fill p-4">
                            <div class="col-3 ps-0 ms-0 mb-4">
                                <a href="<?= base_url('/tentukan-pegawai-teladan'); ?>" class="btn btn-primary table text-lg">Tentukan Pegawai Teladan</a>
                            </div>
                            <table class="" id="table-current-ranking">
                                <thead>
                                    <th class="col-md-2 text-uppercase font-weight-bolder text-sm ps-0" scope="col">NIP</th>
                                    <th class="col-md-2 text-uppercase font-weight-bolder text-sm ps-0" scope="col">Nama Pegawai</th>
                                    <th class="col-md-3 text-uppercase font-weight-bolder text-sm ps-0" scope="col">Jabatan</th>
                                    <th class="col-md-3 text-uppercase font-weight-bolder text-sm ps-0" scope="col">Nilai Atasan Langsung</th>
                                    <th class="col-md-3 text-uppercase font-weight-bolder text-sm ps-0" scope="col">Nilai Polling</th>
                                    <th class="col-md-3 text-uppercase font-weight-bolder text-sm ps-0" scope="col">Nilai Total</th>
                                </thead>
                                <tbody>
                                    <?php foreach ($data_pegawai as $d) : ?>
                                        <?php foreach ($pegawai_yang_diusulkan as $p) : ?>
                                            <?php if ($d['nip'] == $p['nip_pegawai']) { ?>
                                                <tr>
                                                    <td class="mb-0 text-sm ps-0" scope="row"><?= $d['nip']; ?></td>
                                                    <td class="mb-0 text-sm ps-0" scope="row"><?= $d['nama_pegawai']; ?></td>
                                                    <td class="mb-0 text-sm ps-0" scope="row"><?= $d['nama_jabatan']; ?></td>
                                                    <td class="mb-0 text-sm ps-0" scope="row"><?= $p['nilai_atasan_langsung']; ?></td>
                                                    <td class="mb-0 text-sm ps-0" scope="row"><?= $p['nilai_vote']; ?></td>
                                                    <td class="mb-0 text-sm ps-0" scope="row"><?= $p['nilai_total']; ?></td>
                                                </tr>
                                            <?php } ?>
                                        <?php endforeach; ?>
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

<?= $this->endSection(); ?>