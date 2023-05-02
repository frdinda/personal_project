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
                            <form role="form" action="<?= base_url('/sub-tambah-periode-ukom23'); ?>" method="post" class="pb-5">
                                <div class="col-8">
                                    <div class="row mb-4 ms-1" style="font-size:1.25em;">
                                        Nama Periode
                                        <input id="nama_periode" name="nama_periode" type="text" class="form-control form-control-lg" placeholder="" aria-label="Nama Periode" value="" required>
                                    </div>
                                    <div class="row">
                                        <div class="col ms-1">
                                            <button type="submit" class="btn btn-lg btn-primary btn-lg mt-2 mb-0">
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