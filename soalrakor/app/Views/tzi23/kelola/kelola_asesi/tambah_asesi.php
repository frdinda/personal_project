<?= $this->extend('layout_tzi23/layout_all'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid py-4">
    <div class="row mt-4">
        <div class="col-lg-12 mb-lg-0 mb-4">
            <div class="card z-index-2 h-auto">
                <div class="card-header pb-0 pt-3 bg-transparent">
                    <b>
                        <h3 class="text-capitalize" style="color: #344767;">Tambah Asesi</h3>
                    </b>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-12 col-xxl-12 d-flex" style="color: #344767;">
                        <div class="card flex-fill p-3">
                            <form role="form" action="<?= base_url('/sub-tambah-asesi-tzi23'); ?>" method="post" class="pb-5">
                                <div class="col-8">
                                    <div class="row mb-2 ms-1" style="font-size:1em;">
                                        ID Asesi
                                        <input id="id_asesi" name="id_asesi" type="text" class="form-control form-control-sm mt-2" placeholder="" aria-label="ID Asesi" required>
                                    </div>
                                    <div class="row mb-2 ms-1" style="font-size:1em;">
                                        Nama Asesi
                                        <input id="nama_asesi" name="nama_asesi" type="text" class="form-control form-control-sm mt-2" placeholder="" aria-label="Nama Asesi" required>
                                    </div>
                                    <div class="row mb-2 ms-1" style="font-size:1em;">
                                        Jenis Jabatan
                                        <select class="form-select" name="jenis_jabatan" id="jenis_jabatan" required>
                                            <option value="" selected disabled></option>
                                            <option value="kabag">Kepala Bagian</option>
                                            <option value="kasub">Kepala Subbagian</option>
                                            <option value="kadiv">Kepala Divisi</option>
                                            <option value="pegawai">Pegawai JFT/JFU</option>
                                        </select>
                                    </div>
                                    <div class="row mb-2 ms-1" style="font-size:1em;">
                                        Nama Jabatan
                                        <input id="nama_jabatan" name="nama_jabatan" type="text" class="form-control form-control-sm mt-2" placeholder="" aria-label="Nama Jabatan" required>
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