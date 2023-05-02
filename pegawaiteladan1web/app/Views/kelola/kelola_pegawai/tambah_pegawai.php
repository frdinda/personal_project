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
                            <form role="form" action="<?= base_url('/sub-tambah-pegawai'); ?>" enctype="multipart/form-data" method="post" class="pb-5">
                                <div class="col-8">
                                    <div class="row mb-2 ms-1" style="font-size:1em;">
                                        NIP
                                        <input id="nip" name="nip" type="number" class="form-control form-control-md mt-2" placeholder="" aria-label="NIP" required>
                                    </div>
                                    <div class="row mb-2 ms-1" style="font-size:1em;">
                                        Nama
                                        <input id="nama_pegawai" name="nama_pegawai" type="text" class="form-control form-control-md mt-2" placeholder="" aria-label="Nama Pegawai" required>
                                    </div>
                                    <div class="row mb-2 ms-1" style="font-size:1em;">
                                        Nama Jabatan
                                        <input id="nama_jabatan" name="nama_jabatan" type="text" class="form-control form-control-md mt-2" placeholder="" aria-label="Nama Jabatan" required>
                                    </div>
                                    <div class="row mb-2 ms-1" style="font-size:1em;">
                                        Jenis User
                                        <select class="form-select mt-2" name="jenis_user" id="jenis_user" required>
                                            <option value="" selected disabled></option>
                                            <option value="Admin">Admin</option>
                                            <option value="Pegawai">Pegawai</option>
                                            <option value="Kepala Subbagian">Kepala Subbagian</option>
                                            <option value="Kepala Bagian">Kepala Bagian</option>
                                            <option value="Kepala Divisi">Kepala Divisi</option>
                                            <option value="Kepala Kantor Wilayah">Kepala Kantor Wilayah</option>
                                        </select>
                                    </div>
                                    <div class="row mb-3 ms-1" style="font-size:1em;">
                                        Struktural
                                        <select class="form-select mt-2" name="struktural" id="struktural" required>
                                            <option value="" selected disabled></option>
                                            <option value="Y">Ya</option>
                                            <option value="T">Tidak</option>
                                        </select>
                                    </div>
                                    <div class="row mb-3 ms-1" style="font-size:1em;">
                                        NIP Atasan Langsung
                                        <input id="nip_atasan_langsung" name="nip_atasan_langsung" type="number" class="form-control form-control-md mt-2" placeholder="" aria-label="NIP Atasan Langsung" required>
                                    </div>
                                    <div class="row mb-3 ms-1" style="font-size:1em;">
                                        Foto Profil (Ukuran 1080px x 1080px atau perbandingan 1:1)
                                        <input id="foto_profil" name="foto_profil" type="file" accept="image/png, image/jpg, image/jpeg" class="form-control form-control-md mt-2" placeholder="" aria-label="Foto Profil" required>
                                    </div>
                                    <div class="row mb-3 ms-1" style="font-size:1em;">
                                        Password
                                        <input id="password" name="password" type="password" class="form-control form-control-md mt-2" placeholder="" aria-label="Password" required>
                                    </div>
                                    <div class="row mb-3 ms-1" style="font-size:1em;">
                                        Konfirmasi Password
                                        <input id="konfirmasi_password" name="konfirmasi_password" type="password" class="form-control form-control-md mt-2" placeholder="" aria-label="Konfirmasi Password" required>
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