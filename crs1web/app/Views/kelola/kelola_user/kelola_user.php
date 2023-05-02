<?= $this->extend('layout/layout_all'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-lg-12 col-md-12 mt-0 mb-4">
        <div class="card">
            <div class="card-header pb-0">
                <div class="col-lg-12 col-12">
                    <h4 class="font-weight-bolder" style="color:#252527;"><?= $nama_page; ?></h4>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-2">
                        <a href="<?= base_url('/tambah-user'); ?>" class="btn bg-gradient-primary p-3 font-weight-normal">
                            Tambah User
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <table class="table-hover" id="table-biasa-2">
                            <thead>
                                <th class="col-md-2 font-weight-normal ps-0" scope="col">
                                    User ID
                                </th>
                                <th class="col-md-4 font-weight-normal ps-0" scope="col">
                                    Nama Unit Kerja
                                </th>
                                <th class="col-md-2 font-weight-normal ps-0" scope="col">
                                    Nama Kepala
                                </th>
                                <th class="col-md-2 font-weight-normal ps-0" scope="col">
                                    NIP Kepala
                                </th>
                                <th class="col-md-1 font-weight-normal ps-0" scope="col">
                                    Jenis Akses
                                </th>
                                <th class="col-md-1 font-weight-normal ps-0" scope="col">
                                    No Telp Representatif
                                </th>
                                <th class="col-md-1 font-weight-normal ps-0" scope="col"></th>
                                <th class="col-md-1 font-weight-normal ps-0" scope="col"></th>
                            </thead>
                            <tbody>
                                <?php foreach ($data_user as $d) : ?>
                                    <tr>
                                        <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;">
                                            <?= $d['user_id']; ?>
                                        </td>
                                        <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;">
                                            <?= $d['nama_unit_kerja']; ?>
                                        </td>
                                        <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;">
                                            <?= $d['nama_kepala']; ?>
                                        </td>
                                        <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;">
                                            <?= $d['nip_kepala']; ?>
                                        </td>
                                        <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;">
                                            <?= $d['jenis_akses']; ?>
                                        </td>
                                        <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;">
                                            <?= $d['no_telp_representatif']; ?>
                                        </td>
                                        <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;">
                                            <a href="<?= base_url('/edit-user/' . $d['user_id']); ?>" class="">
                                                <span class="material-symbols-outlined">
                                                    edit
                                                </span>
                                            </a>
                                        </td>
                                        <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;">
                                            <form action="<?= base_url('/hapus-user/' . $d['user_id']); ?>" method="post" class="d-inline">
                                                <?= csrf_field(); ?>
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button href="" class="link-tambahan" onclick="return confirm('Anda Yakin?')" style="border: none; outline: none; background:none;">
                                                    <span class="material-symbols-outlined">
                                                        delete
                                                    </span>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>