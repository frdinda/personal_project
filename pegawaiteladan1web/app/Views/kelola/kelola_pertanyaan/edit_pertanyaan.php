<?= $this->extend('layout/layout_all'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid py-4">
    <div class="row mt-4">
        <div class="col-lg-12 mb-lg-0 mb-4">
            <div class="card z-index-2 h-auto">
                <div class="card-header pb-0 pt-3 bg-transparent">
                    <b>
                        <h3 class="text-capitalize" style="color: #344767;"><?= $nama_sub_page; ?></h3>
                    </b>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-12 col-xxl-12 d-flex" style="color: #344767;">
                        <div class="card flex-fill p-3">
                            <form role="form" action="<?= base_url('/sub-edit-pertanyaan'); ?>" method="post" class="pb-5">
                                <div class="col-8">
                                    <div class="row mb-2 ms-1" style="font-size:1em;">
                                        ID Pertanyaan
                                        <input id="id_pertanyaan" name="id_pertanyaan" type="hidden" class="form-control form-control-md mt-2" placeholder="" aria-label="ID Pertanyaan" value="<?= $detail_pertanyaan['id_pertanyaan']; ?>" required>
                                        <input id="id_pertanyaan" name="id_pertanyaan" type="text" class="form-control form-control-md mt-2" placeholder="" aria-label="ID Pertanyaan" value="<?= $detail_pertanyaan['id_pertanyaan']; ?>" disabled>
                                    </div>
                                    <div class="row mb-2 ms-1" style="font-size:1em;">
                                        Jabaran Pertanyaan
                                        <input id="jabaran_pertanyaan" name="jabaran_pertanyaan" type="text" class="form-control form-control-md mt-2" placeholder="" aria-label="Jabaran Pertanyaan" value="<?= $detail_pertanyaan['jabaran_pertanyaan']; ?>" required>
                                    </div>
                                    <div class="row mb-2 ms-1" style="font-size:1em;">
                                        Kategori Pertanyaan
                                        <select class="form-select mt-2" name="kategori_pertanyaan" id="kategori_pertanyaan" required>
                                            <?php if ($detail_pertanyaan['kategori_pertanyaan'] == 'Profesional') { ?>
                                                <option value="Profesional" selected>Profesional</option>
                                                <option value="Akuntabel">Akuntabel</option>
                                                <option value="Sinergi">Sinergi</option>
                                                <option value="Transparan">Transparan</option>
                                                <option value="Inovatif">Inovatif</option>
                                            <?php } else if ($detail_pertanyaan['kategori_pertanyaan'] == 'Akuntabel') { ?>
                                                <option value="Profesional">Profesional</option>
                                                <option value="Akuntabel" selected>Akuntabel</option>
                                                <option value="Sinergi">Sinergi</option>
                                                <option value="Transparan">Transparan</option>
                                                <option value="Inovatif">Inovatif</option>
                                            <?php } else if ($detail_pertanyaan['kategori_pertanyaan'] == 'Sinergi') { ?>
                                                <option value="Profesional">Profesional</option>
                                                <option value="Akuntabel">Akuntabel</option>
                                                <option value="Sinergi" selected>Sinergi</option>
                                                <option value="Transparan">Transparan</option>
                                                <option value="Inovatif">Inovatif</option>
                                            <?php } else if ($detail_pertanyaan['kategori_pertanyaan'] == 'Transparan') { ?>
                                                <option value="Profesional">Profesional</option>
                                                <option value="Akuntabel">Akuntabel</option>
                                                <option value="Sinergi">Sinergi</option>
                                                <option value="Transparan" selected>Transparan</option>
                                                <option value="Inovatif">Inovatif</option>
                                            <?php } else if ($detail_pertanyaan['kategori_pertanyaan'] == 'Inovatif') { ?>
                                                <option value="Profesional">Profesional</option>
                                                <option value="Akuntabel">Akuntabel</option>
                                                <option value="Sinergi">Sinergi</option>
                                                <option value="Transparan">Transparan</option>
                                                <option value="Inovatif" selected>Inovatif</option>
                                            <?php } else { ?>
                                                <option value="" selected disabled></option>
                                                <option value="Profesional">Profesional</option>
                                                <option value="Akuntabel">Akuntabel</option>
                                                <option value="Sinergi">Sinergi</option>
                                                <option value="Transparan">Transparan</option>
                                                <option value="Inovatif">Inovatif</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <button type="submit" class="btn btn-lg btn-primary mt-2 mb-0" style="font-size:1em;">
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>