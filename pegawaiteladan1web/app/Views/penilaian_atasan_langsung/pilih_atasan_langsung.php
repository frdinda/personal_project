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
                <div class="row">
                    <div class="col-12 col-lg-12 col-xxl-12 d-flex" style="color: #344767;">
                        <div class="card flex-fill p-4">
                            <div class="col-11 mb-3">
                                <form action="<?= base_url('/dipilih-atasan-langsung'); ?>" method="post" class="pilih_atasan_langsung pb-2" id="Pilih_Atasan_Langsung">
                                    <h5 class="text-capitalize" style="color: #344767;">Pilih Atasan Langsung</h5>
                                    <div class="input-group input-group-outline is-filled">
                                        <select class="form-control form-select form-select-nip-atasan-langsung mt-0" name="nip_atasan_langsung" id="nip_atasan_langsung" style="color:#000000;" required>
                                            <option value="" selected disabled>Pilih Atasan Langsung</option>
                                            <?php foreach ($data_atasan_langsung as $dal) : ?>
                                                <option value="<?= $dal['nip']; ?>"><?= $dal['nama_jabatan'] ?> - <?= $dal['nama_pegawai'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col">
                                            <button type="submit" class="btn btn-lg btn-primary mt-2 mb-0" style="font-size:1em;">
                                                Submit
                                            </button>
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
</div>

<?= $this->endSection(); ?>