<?= $this->extend('layout_tzi23/layout_all'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid py-4">
    <div class="row mt-4">
        <div class="col-lg-12 mb-lg-0 mb-4">
            <div class="card z-index-2 h-auto">
                <div class="card-header pb-0 pt-3 bg-transparent">
                    <b>
                        <h3 class="text-capitalize" style="color: #344767;">Edit Nilai</h3>
                    </b>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-12 col-xxl-12 d-flex" style="color: #344767;">
                        <div class="card flex-fill p-3">
                            <div class="tab-content card-body flex-fill p-3 table-responsive" id="myTabContent">
                                <div class="tab-content mt-4 ms-2 me-2" id="myTabContent">
                                    <div class="tab-pane fade show active" id="surat-all" role="tabpanel" aria-labelledby="surat-all-tab">
                                        <input id="id_asesi" name="id_asesi" type="hidden" class="form-control form-control-lg" placeholder="" aria-label="ID Asesi" disabled>
                                        <div class="row mb-4 ms-1" style="font-size:1.25em;">
                                            Asesi:
                                            <?= $detail_asesi['nama_asesi']; ?>
                                        </div>
                                        <form role="form" action="<?= base_url('/sub-edit-nilai-tzi23/' . $id_asesi); ?>" method="post" class="pb-5 mb-5">
                                            <table class="table-hover" id="table-edit-penilaian">
                                                <thead>
                                                    <th class="col-md-1 text-uppercase font-weight-bolder text-sm ps-0" scope="col">ID Penilaian</th>
                                                    <th class="col-md-5 text-uppercase font-weight-bolder text-sm ps-0" scope="col">Soal</th>
                                                    <th class="col-md-3 text-uppercase font-weight-bolder text-sm ps-0" scope="col">Evaluator</th>
                                                    <th class="col-md-4 text-uppercase font-weight-bolder text-sm ps-0" scope="col">Nilai</th>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($nilai_asesi as $n) : ?>
                                                        <tr>
                                                            <td class="mb-0 text-sm" scope="row">
                                                                <?= $n['id_penilaian']; ?>
                                                                <input id="<?= $n['id_penilaian'] . '_id'; ?>" name="<?= $n['id_penilaian'] . '_id'; ?>" type="hidden" class="form-control form-control-lg" placeholder="" aria-label="ID Penilaian" value="<?= $n['id_penilaian']; ?>" required>
                                                            </td>
                                                            <td class="mb-0 text-sm" scope="row">
                                                                <?= $n['soal']; ?>
                                                                <input id="<?= $n['id_penilaian'] . '_soal'; ?>" name="<?= $n['id_penilaian'] . '_soal'; ?>" type="hidden" class="form-control form-control-lg" placeholder="" aria-label="ID Soal" value="<?= $n['id_soal']; ?>" disabled>
                                                            </td>
                                                            <td class="mb-0 text-sm" scope="row">
                                                                <?= $n['nama_user']; ?>
                                                                <input id="<?= $n['id_penilaian'] . '_user'; ?>" name="<?= $n['id_penilaian'] . '_user'; ?>" type="hidden" class="form-control form-control-lg" placeholder="" aria-label="ID User" value="<?= $n['id_user']; ?>" disabled>
                                                            </td>
                                                            <td class="mb-0 text-sm" scope="row">
                                                                <?php if ($detail_asesi['jenis_jabatan'] == 'pegawai') { ?>
                                                                    <?php if ($n['kategori'] == 'acak') { ?>
                                                                        <input id="<?= $n['id_penilaian'] . '_nilai'; ?>" name="<?= $n['id_penilaian'] . '_nilai'; ?>" type="number" class="form-control form-control-sm" placeholder="Nilai" aria-label="Nilai" value="<?= $n['nilai']; ?>" required>
                                                                    <?php } else if ($n['kategori'] == 'wajib') { ?>
                                                                        <input id="<?= $n['id_penilaian'] . '_pokja'; ?>" name="<?= $n['id_penilaian'] . '_pokja'; ?>" type="text" class="form-control form-control-sm" placeholder="pokja" aria-label="pokja" value="<?= $n['pokja']; ?>" required>
                                                                    <?php } else if ($n['kategori'] == 'pilgan') { ?>
                                                                        <input id="<?= $n['id_penilaian'] . '_nilai'; ?>" name="<?= $n['id_penilaian'] . '_nilai'; ?>" type="number" class="form-control form-control-sm" placeholder="Nilai" aria-label="Nilai" value="<?= $n['nilai']; ?>" min="0" max="10" required>
                                                                    <?php } else if ($n['kategori'] == 'wajib2') { ?>
                                                                        <input id="<?= $n['id_penilaian'] . '_jawaban_program'; ?>" name="<?= $n['id_penilaian'] . '_jawaban_program'; ?>" type="text" class="form-control form-control-sm" placeholder="jawaban_program" aria-label="jawaban_program" value="<?= $n['jawaban_program']; ?>" required>
                                                                    <?php } ?>
                                                                <?php } else { ?>
                                                                    <?php if ($n['kategori'] == 'acak' || $n['kategori'] == 'wajib2') { ?>
                                                                        <input id="<?= $n['id_penilaian'] . '_nilai'; ?>" name="<?= $n['id_penilaian'] . '_nilai'; ?>" type="number" class="form-control form-control-sm" placeholder="Nilai" aria-label="Nilai" value="<?= $n['nilai']; ?>" required>
                                                                    <?php } else if ($n['kategori'] == 'wajib') { ?>
                                                                        <input id="<?= $n['id_penilaian'] . '_pokja'; ?>" name="<?= $n['id_penilaian'] . '_pokja'; ?>" type="text" class="form-control form-control-sm" placeholder="pokja" aria-label="pokja" value="<?= $n['pokja']; ?>" required>
                                                                    <?php } else if ($n['kategori'] == 'pilgan') { ?>
                                                                        <input id="<?= $n['id_penilaian'] . '_nilai'; ?>" name="<?= $n['id_penilaian'] . '_nilai'; ?>" type="number" class="form-control form-control-sm" placeholder="Nilai" aria-label="Nilai" value="<?= $n['nilai']; ?>" min="0" max="10" required>
                                                                    <?php } else if ($n['kategori'] == '') { ?>
                                                                        <input id="<?= $n['id_penilaian'] . '_jawaban_program'; ?>" name="<?= $n['id_penilaian'] . '_jawaban_program'; ?>" type="text" class="form-control form-control-sm" placeholder="jawaban_program" aria-label="jawaban_program" value="<?= $n['jawaban_program']; ?>" required>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                            <div class="col ms-0 ps-0">
                                                <button type="submit" class="btn btn-primary mt-2 mb-0" style="font-size:1em;">
                                                    Submit
                                                </button>
                                            </div>
                                        </form>
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