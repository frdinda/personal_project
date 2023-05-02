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
                            <form role="form" action="<?= base_url('/sub-edit-periode-berjalan-ukom23'); ?>" method="post" class="pb-5">
                                <div class="col-8">
                                    <div class="row mb-2 ms-0" style="font-size:1em;">
                                        <input id="id_periode_berjalan" name="id_periode_berjalan" type="hidden" class="form-control form-control-lg" placeholder="" aria-label="ID Periode Berjalan" value="<?= $periode_berjalan['id_periode_berjalan']; ?>" required>
                                        <div class="mb-1 ms-0">Pilih Periode</div>
                                        <select class="form-select form-select-peserta mt-1 ms-2 w-100" name="id_periode" id="id_periode" required>
                                            <option value="" selected disabled></option>
                                            <?php foreach ($data_periode as $s) : ?>
                                                <option value="<?= $s['id_periode']; ?>"><?= $s['id_periode']; ?> - <?= $s['nama_periode']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="row">
                                        <div class="col ms-1">
                                            <button type="submit" class="btn btn-primary btn-md mt-2 ms-2 mb-0">
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