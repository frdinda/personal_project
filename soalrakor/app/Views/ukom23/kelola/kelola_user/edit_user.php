<?= $this->extend('layout_ukom23/layout_all'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid py-4">
    <div class="row mt-4">
        <div class="col-lg-12 mb-lg-0 mb-4">
            <div class="card z-index-2 h-auto">
                <div class="card-header pb-0 pt-3 bg-transparent">
                    <b>
                        <h3 class="text-capitalize" style="color: #344767;">Edit User</h3>
                    </b>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-12 col-xxl-12 d-flex" style="color: #344767;">
                        <div class="card flex-fill p-3">
                            <form role="form" action="<?= base_url('/sub-edit-user-ukom23'); ?>" method="post" class="pb-5">
                                <div class="col-8">
                                    <div class="row mb-2 ms-1" style="font-size:1em;">
                                        NIP
                                        <input id="id_user" name="id_user" type="text" class="form-control form-control-sm mt-2" placeholder="" aria-label="ID User" value="<?= $detail_user['id_user']; ?>" required>
                                    </div>
                                    <div class="row mb-2 ms-1" style="font-size:1em;">
                                        Nama
                                        <input id="nama_user" name="nama_user" type="text" class="form-control form-control-sm mt-2" placeholder="" aria-label="Nama User" value="<?= $detail_user['nama_user']; ?>" required>
                                    </div>
                                    <div class="row mb-2 ms-1" style="font-size:1em;">
                                        Jenis Akses
                                        <select class="form-select" name="jenis_akses" id="jenis_akses" required>
                                            <?php if ($detail_user['jenis_akses'] == 'Admin') { ?>
                                                <option value="Admin" selected>Admin</option>
                                                <option value="Penguji">Penguji</option>
                                            <?php } else if ($detail_user['jenis_akses'] == 'Penguji') { ?>
                                                <option value="Admin">Admin</option>
                                                <option value="Penguji" selected>Penguji</option>
                                            <?php } else { ?>
                                                <option value="" selected disabled></option>
                                                <option value="Admin">Admin</option>
                                                <option value="Penguji">Penguji</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="row mb-3 ms-1" style="font-size:1em;">
                                        Jabatan
                                        <input id="jabatan_user" name="jabatan_user" type="text" class="form-control form-control-sm mt-2" placeholder="" aria-label="Jabatan User" value="<?= $detail_user['jabatan']; ?>" required>
                                    </div>
                                    <div class="row mb-3 ms-1" style="font-size:1em;">
                                        Password
                                        <input id="password" name="password" type="password" class="form-control form-control-sm mt-2" placeholder="" aria-label="Password" required>
                                    </div>
                                    <div class="row mb-3 ms-1" style="font-size:1em;">
                                        Konfirmasi Password
                                        <input id="konfirmasi_password" name="konfirmasi_password" type="password" class="form-control form-control-sm mt-2" placeholder="" aria-label="Konfirmasi Password" required>
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