<?= $this->extend('layout/layout_all'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid py-4">
    <div class="row mt-4">
        <div class="col-lg-12 mb-lg-0 mb-4">
            <div class="card z-index-2 h-auto">
                <div class="card-header pb-0 pt-3 bg-transparent">
                    <b>
                        <h3 class="text-capitalize" style="color: #344767;">Tambah Satuan Kerja</h3>
                    </b>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-12 col-xxl-12 d-flex" style="color: #344767;">
                        <div class="card flex-fill p-3">
                            <form role="form" action="<?= base_url('/sub-tambah-satker'); ?>" method="post" class="pb-5">
                                <div class="col-8">
                                    <div class="row mb-2 ms-1" style="font-size:1em;">
                                        ID Satker
                                        <input id="id_satker" name="id_satker" type="text" class="form-control form-control-sm mt-2" placeholder="" aria-label="ID User" required>
                                    </div>
                                    <div class="row mb-2 ms-1" style="font-size:1em;">
                                        Nama Satker
                                        <input id="nama_satker" name="nama_satker" type="text" class="form-control form-control-sm mt-2" placeholder="" aria-label="Nama Satker" required>
                                    </div>
                                    <div class="row mb-2 ms-1" style="font-size:1em;">
                                        Nama Kasatker
                                        <input id="nama_kasatker" name="nama_kasatker" type="text" class="form-control form-control-sm mt-2" placeholder="" aria-label="Nama Kasatker" required>
                                    </div>
                                    <div class="row mb-2 ms-1" style="font-size:1em;">
                                        Jenis Satker
                                        <select class="form-select" name="jenis_satker" id="jenis_satker" required>
                                            <option value="" selected disabled></option>
                                            <option value="lapas">lapas</option>
                                            <option value="rutan">rutan</option>
                                            <option value="laper">laper</option>
                                            <option value="ruper">ruper</option>
                                            <option value="lpka">lpka</option>
                                            <option value="lpn">lpn</option>
                                            <option value="bapas">bapas</option>
                                            <option value="lpp">lpp</option>
                                            <option value="rupbasan">rupbasan</option>
                                            <option value="kanim">kanim</option>
                                            <option value="rudenim">rudenim</option>
                                            <option value="bhp">bhp</option>
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