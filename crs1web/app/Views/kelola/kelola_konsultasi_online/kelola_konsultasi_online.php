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
                    <div class="col-12">
                        <table class="table-hover" id="table-konsultasi-online">
                            <thead>
                                <th class="col-md-2 font-weight-normal ps-0" scope="col">
                                    Tanggal Konsultasi
                                </th>
                                <th class="col-md-2 font-weight-normal ps-0" scope="col">
                                    Nama Pengguna Layanan
                                </th>
                                <th class="col-md-2 font-weight-normal ps-0" scope="col">
                                    Nama Konsultan
                                </th>
                                <th class="col-md-1 font-weight-normal ps-0" scope="col">
                                    Room Zoom
                                </th>
                                <th class="col-md-2 font-weight-normal ps-0" scope="col">
                                    Status Konsultasi
                                </th>
                                <th class="col-md-1 font-weight-normal ps-0" scope="col"></th>
                                <?php if ($jenis_akses != 'Pegawai') { ?>
                                    <th class="col-md-1 font-weight-normal ps-0" scope="col"></th>
                                <?php } ?>
                                <?php if ($jenis_akses == 'Admin') { ?>
                                    <th class="col-md-1 font-weight-normal ps-0" scope="col"></th>
                                <?php } ?>
                            </thead>
                            <tbody>
                                <?php foreach ($data_konsultasi as $d) : ?>
                                    <?php if ($jenis_akses == 'Pegawai') { ?>
                                        <?php if ($user_id == $d['NIP']) { ?>
                                            <?php if ($d['tanggal_konsultasi_online'] >= date('Y-m-d')) { ?>
                                                <?php if ($d['tanggal_konsultasi_online'] == date('Y-m-d') && $d['jam_konsultasi_online'] >= date('H:i:s')) { ?>
                                                    <tr>
                                                        <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em; color:black;">
                                                            <?= $d['tanggal_konsultasi_online'] . " " . $d['jam_konsultasi_online']; ?>
                                                        </td>
                                                        <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em; color:black;">
                                                            <?php foreach ($data_pengguna as $p) : ?>
                                                                <?php if ($p['no_telp_pengguna'] == $d['no_telp_pengguna']) { ?>
                                                                    <?= $p['nama_pengguna']; ?>
                                                                <?php } ?>
                                                            <?php endforeach; ?>
                                                        </td>
                                                        <?php foreach ($data_konsultan as $u) : ?>
                                                            <?php if ($u['user_id'] == $d['NIP']) { ?>
                                                                <?php if ($d['NIP'] == '111') { ?>
                                                                    <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em; color:red;">
                                                                        <?= $u['nama_kepala']; ?>
                                                                    </td>
                                                                <?php } else { ?>
                                                                    <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em; color:black;">
                                                                        <?= $u['nama_kepala']; ?>
                                                                    </td>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        <?php endforeach; ?>
                                                        <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em; color:black;">
                                                            <?= $d['room_zoom']; ?>
                                                        </td>
                                                        <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em; color:black;">
                                                            <?php if ($d['status_jalan_konsultasi'] != null) { ?>
                                                                <?= $d['status_jalan_konsultasi']; ?>
                                                            <?php } else { ?>
                                                                Belum Berlangsung
                                                            <?php } ?>
                                                        </td>
                                                        <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em; color:black;">
                                                            <a href="<?= base_url('/detail-entry-pengguna/' . $d['id_entry']); ?>" class="">
                                                                <span class="material-symbols-outlined">
                                                                    open_in_new
                                                                </span>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php } else { ?>
                                                    <tr>
                                                        <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em; color:black;">
                                                            <?= $d['tanggal_konsultasi_online'] . " " . $d['jam_konsultasi_online']; ?>
                                                        </td>
                                                        <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em; color:black;">
                                                            <?php foreach ($data_pengguna as $p) : ?>
                                                                <?php if ($p['no_telp_pengguna'] == $d['no_telp_pengguna']) { ?>
                                                                    <?= $p['nama_pengguna']; ?>
                                                                <?php } ?>
                                                            <?php endforeach; ?>
                                                        </td>
                                                        <?php foreach ($data_konsultan as $u) : ?>
                                                            <?php if ($u['user_id'] == $d['NIP']) { ?>
                                                                <?php if ($d['NIP'] == '111') { ?>
                                                                    <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em; color:red;">
                                                                        <?= $u['nama_kepala']; ?>
                                                                    </td>
                                                                <?php } else { ?>
                                                                    <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em; color:black;">
                                                                        <?= $u['nama_kepala']; ?>
                                                                    </td>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        <?php endforeach; ?>
                                                        <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em; color:black;">
                                                            <?= $d['room_zoom']; ?>
                                                        </td>
                                                        <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em; color:black;">
                                                            <?php if ($d['status_jalan_konsultasi'] != null) { ?>
                                                                <?= $d['status_jalan_konsultasi']; ?>
                                                            <?php } else { ?>
                                                                Belum Berlangsung
                                                            <?php } ?>
                                                        </td>
                                                        <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em; color:black;">
                                                            <a href="<?= base_url('/detail-entry-pengguna/' . $d['id_entry']); ?>" class="">
                                                                <span class="material-symbols-outlined">
                                                                    open_in_new
                                                                </span>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php }
                                            } else { ?>
                                                <tr>
                                                    <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;">
                                                        <?= $d['tanggal_konsultasi_online'] . " " . $d['jam_konsultasi_online']; ?>
                                                    </td>
                                                    <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;">
                                                        <?php foreach ($data_pengguna as $p) : ?>
                                                            <?php if ($p['no_telp_pengguna'] == $d['no_telp_pengguna']) { ?>
                                                                <?= $p['nama_pengguna']; ?>
                                                            <?php } ?>
                                                        <?php endforeach; ?>
                                                    </td>
                                                    <?php foreach ($data_konsultan as $u) : ?>
                                                        <?php if ($u['user_id'] == $d['NIP']) { ?>
                                                            <?php if ($d['NIP'] == '111') { ?>
                                                                <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em; color:red;">
                                                                    <?= $u['nama_kepala']; ?>
                                                                </td>
                                                            <?php } else { ?>
                                                                <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;">
                                                                    <?= $u['nama_kepala']; ?>
                                                                </td>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    <?php endforeach; ?>
                                                    <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;">
                                                        <?= $d['room_zoom']; ?>
                                                    </td>
                                                    <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;">
                                                        <?php if ($d['status_jalan_konsultasi'] != null) { ?>
                                                            <?= $d['status_jalan_konsultasi']; ?>
                                                        <?php } else { ?>
                                                            <?php if ($d['tanggal_konsultasi_online'] <= date('Y-m-d')) { ?>
                                                                Tidak Berlangsung
                                                            <?php } else if ($d['tanggal_konsultasi_online'] == date('Y-m-d') && $d['jam_konsultasi_online'] <= date('H:i:s')) { ?>
                                                                Tidak Berlangsung
                                                            <?php } else { ?>
                                                                Belum Berlangsung
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;">
                                                        <a href="<?= base_url('/detail-entry-pengguna/' . $d['id_entry']); ?>" class="">
                                                            <span class="material-symbols-outlined">
                                                                open_in_new
                                                            </span>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } else if ($jenis_akses == 'Unit Kerja') { ?>
                                        <?php if ($user_id == $d['user_id']) { ?>
                                            <?php if ($d['tanggal_konsultasi_online'] >= date('Y-m-d')) { ?>
                                                <?php if ($d['tanggal_konsultasi_online'] == date('Y-m-d') && $d['jam_konsultasi_online'] >= date('H:i:s')) { ?>
                                                    <tr>
                                                        <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em; color:black;">
                                                            <?= $d['tanggal_konsultasi_online'] . " " . $d['jam_konsultasi_online']; ?>
                                                        </td>
                                                        <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em; color:black;">
                                                            <?php foreach ($data_pengguna as $p) : ?>
                                                                <?php if ($p['no_telp_pengguna'] == $d['no_telp_pengguna']) { ?>
                                                                    <?= $p['nama_pengguna']; ?>
                                                                <?php } ?>
                                                            <?php endforeach; ?>
                                                        </td>
                                                        <?php foreach ($data_konsultan as $u) : ?>
                                                            <?php if ($u['user_id'] == $d['NIP']) { ?>
                                                                <?php if ($d['NIP'] == '111') { ?>
                                                                    <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em; color:red;">
                                                                        <?= $u['nama_kepala']; ?>
                                                                    </td>
                                                                <?php } else { ?>
                                                                    <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em; color:black;">
                                                                        <?= $u['nama_kepala']; ?>
                                                                    </td>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        <?php endforeach; ?>
                                                        <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em; color:black;">
                                                            <?= $d['room_zoom']; ?>
                                                        </td>
                                                        <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em; color:black;">
                                                            <?php if ($d['status_jalan_konsultasi'] != null) { ?>
                                                                <?= $d['status_jalan_konsultasi']; ?>
                                                            <?php } else { ?>
                                                                Belum Berlangsung
                                                            <?php } ?>
                                                        </td>
                                                        <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em; color:black;">
                                                            <a href="<?= base_url('/detail-entry-pengguna/' . $d['id_entry']); ?>" class="">
                                                                <span class="material-symbols-outlined">
                                                                    open_in_new
                                                                </span>
                                                            </a>
                                                        </td>
                                                        <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em; color:black;">
                                                            <a href="<?= base_url('/edit-konsultasi-online/' . $d['id_konsultasi_online']); ?>" class="">
                                                                <span class="material-symbols-outlined">
                                                                    edit
                                                                </span>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php } else { ?>
                                                    <tr>
                                                        <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em; color:black;">
                                                            <?= $d['tanggal_konsultasi_online'] . " " . $d['jam_konsultasi_online']; ?>
                                                        </td>
                                                        <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em; color:black;">
                                                            <?php foreach ($data_pengguna as $p) : ?>
                                                                <?php if ($p['no_telp_pengguna'] == $d['no_telp_pengguna']) { ?>
                                                                    <?= $p['nama_pengguna']; ?>
                                                                <?php } ?>
                                                            <?php endforeach; ?>
                                                        </td>
                                                        <?php foreach ($data_konsultan as $u) : ?>
                                                            <?php if ($u['user_id'] == $d['NIP']) { ?>
                                                                <?php if ($d['NIP'] == '111') { ?>
                                                                    <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em; color:red;">
                                                                        <?= $u['nama_kepala']; ?>
                                                                    </td>
                                                                <?php } else { ?>
                                                                    <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em; color:black;">
                                                                        <?= $u['nama_kepala']; ?>
                                                                    </td>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        <?php endforeach; ?>
                                                        <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em; color:black;">
                                                            <?= $d['room_zoom']; ?>
                                                        </td>
                                                        <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em; color:black;">
                                                            <?php if ($d['status_jalan_konsultasi'] != null) { ?>
                                                                <?= $d['status_jalan_konsultasi']; ?>
                                                            <?php } else { ?>
                                                                Belum Berlangsung
                                                            <?php } ?>
                                                        </td>
                                                        <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em; color:black;">
                                                            <a href="<?= base_url('/detail-entry-pengguna/' . $d['id_entry']); ?>" class="">
                                                                <span class="material-symbols-outlined">
                                                                    open_in_new
                                                                </span>
                                                            </a>
                                                        </td>
                                                        <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em; color:black;">
                                                            <a href="<?= base_url('/edit-konsultasi-online/' . $d['id_konsultasi_online']); ?>" class="">
                                                                <span class="material-symbols-outlined">
                                                                    edit
                                                                </span>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php }
                                            } else { ?>
                                                <tr>
                                                    <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;">
                                                        <?= $d['tanggal_konsultasi_online'] . " " . $d['jam_konsultasi_online']; ?>
                                                    </td>
                                                    <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;">
                                                        <?php foreach ($data_pengguna as $p) : ?>
                                                            <?php if ($p['no_telp_pengguna'] == $d['no_telp_pengguna']) { ?>
                                                                <?= $p['nama_pengguna']; ?>
                                                            <?php } ?>
                                                        <?php endforeach; ?>
                                                    </td>
                                                    <?php foreach ($data_konsultan as $u) : ?>
                                                        <?php if ($u['user_id'] == $d['NIP']) { ?>
                                                            <?php if ($d['NIP'] == '111') { ?>
                                                                <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em; color:red;">
                                                                    <?= $u['nama_kepala']; ?>
                                                                </td>
                                                            <?php } else { ?>
                                                                <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;">
                                                                    <?= $u['nama_kepala']; ?>
                                                                </td>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    <?php endforeach; ?>
                                                    <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;">
                                                        <?= $d['room_zoom']; ?>
                                                    </td>
                                                    <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;">
                                                        <?php if ($d['status_jalan_konsultasi'] != null) { ?>
                                                            <?= $d['status_jalan_konsultasi']; ?>
                                                        <?php } else { ?>
                                                            <?php if ($d['tanggal_konsultasi_online'] <= date('Y-m-d')) { ?>
                                                                Tidak Berlangsung
                                                            <?php } else if ($d['tanggal_konsultasi_online'] == date('Y-m-d') && $d['jam_konsultasi_online'] <= date('H:i:s')) { ?>
                                                                Tidak Berlangsung
                                                            <?php } else { ?>
                                                                Belum Berlangsung
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;">
                                                        <a href="<?= base_url('/detail-entry-pengguna/' . $d['id_entry']); ?>" class="">
                                                            <span class="material-symbols-outlined">
                                                                open_in_new
                                                            </span>
                                                        </a>
                                                    </td>
                                                    <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em; color:#D3D3D3;">
                                                        <span class="material-symbols-outlined">
                                                            edit
                                                        </span>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <?php if ($d['tanggal_konsultasi_online'] >= date('Y-m-d')) { ?>
                                            <?php if ($d['tanggal_konsultasi_online'] == date('Y-m-d') && $d['jam_konsultasi_online'] >= date('H:i:s')) { ?>
                                                <tr>
                                                    <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em; color:black;">
                                                        <?= $d['tanggal_konsultasi_online'] . " " . $d['jam_konsultasi_online']; ?>
                                                    </td>
                                                    <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em; color:black;">
                                                        <?php foreach ($data_pengguna as $p) : ?>
                                                            <?php if ($p['no_telp_pengguna'] == $d['no_telp_pengguna']) { ?>
                                                                <?= $p['nama_pengguna']; ?>
                                                            <?php } ?>
                                                        <?php endforeach; ?>
                                                    </td>
                                                    <?php foreach ($data_konsultan as $u) : ?>
                                                        <?php if ($u['user_id'] == $d['NIP']) { ?>
                                                            <?php if ($d['NIP'] == '111') { ?>
                                                                <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em; color:red;">
                                                                    <?= $u['nama_kepala']; ?>
                                                                </td>
                                                            <?php } else { ?>
                                                                <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;color:black;">
                                                                    <?= $u['nama_kepala']; ?>
                                                                </td>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    <?php endforeach; ?>
                                                    <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em; color:black;">
                                                        <?= $d['room_zoom']; ?>
                                                    </td>
                                                    <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em; color:black;">
                                                        <?php if ($d['status_jalan_konsultasi'] != null) { ?>
                                                            <?= $d['status_jalan_konsultasi']; ?>
                                                        <?php } else { ?>
                                                            Belum Berlangsung
                                                        <?php } ?>
                                                    </td>
                                                    <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em; color:black;">
                                                        <a href="<?= base_url('/detail-entry-pengguna/' . $d['id_entry']); ?>" class="">
                                                            <span class="material-symbols-outlined">
                                                                open_in_new
                                                            </span>
                                                        </a>
                                                    </td>
                                                    <?php if ($jenis_akses != 'Pegawai') { ?>
                                                        <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em; color:black;">
                                                            <a href="<?= base_url('/edit-konsultasi-online/' . $d['id_konsultasi_online']); ?>" class="">
                                                                <span class="material-symbols-outlined">
                                                                    edit
                                                                </span>
                                                            </a>
                                                        </td>
                                                        <?php if ($jenis_akses == 'Admin') { ?>
                                                            <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em; color:black;">
                                                                <form action="<?= base_url('/hapus-konsultasi-online/' . $d['id_konsultasi_online']); ?>" method="post" class="d-inline">
                                                                    <?= csrf_field(); ?>
                                                                    <input type="hidden" name="_method" value="DELETE">
                                                                    <button href="" class="link-tambahan" onclick="return confirm('Anda Yakin?')" style="border: none; outline: none; background:none;">
                                                                        <span class="material-symbols-outlined">
                                                                            delete
                                                                        </span>
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </tr>
                                            <?php } else { ?>
                                                <tr>
                                                    <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em; color:black;">
                                                        <?= $d['tanggal_konsultasi_online'] . " " . $d['jam_konsultasi_online']; ?>
                                                    </td>
                                                    <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em; color:black;">
                                                        <?php foreach ($data_pengguna as $p) : ?>
                                                            <?php if ($p['no_telp_pengguna'] == $d['no_telp_pengguna']) { ?>
                                                                <?= $p['nama_pengguna']; ?>
                                                            <?php } ?>
                                                        <?php endforeach; ?>
                                                    </td>
                                                    <?php foreach ($data_konsultan as $u) : ?>
                                                        <?php if ($u['user_id'] == $d['NIP']) { ?>
                                                            <?php if ($d['NIP'] == '111') { ?>
                                                                <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em; color:red;">
                                                                    <?= $u['nama_kepala']; ?>
                                                                </td>
                                                            <?php } else { ?>
                                                                <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;color:black;">
                                                                    <?= $u['nama_kepala']; ?>
                                                                </td>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    <?php endforeach; ?>
                                                    <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em; color:black;">
                                                        <?= $d['room_zoom']; ?>
                                                    </td>
                                                    <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em; color:black;">
                                                        <?php if ($d['status_jalan_konsultasi'] != null) { ?>
                                                            <?= $d['status_jalan_konsultasi']; ?>
                                                        <?php } else { ?>
                                                            Belum Berlangsung
                                                        <?php } ?>
                                                    </td>
                                                    <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em; color:black;">
                                                        <a href="<?= base_url('/detail-entry-pengguna/' . $d['id_entry']); ?>" class="">
                                                            <span class="material-symbols-outlined">
                                                                open_in_new
                                                            </span>
                                                        </a>
                                                    </td>
                                                    <?php if ($jenis_akses != 'Pegawai') { ?>
                                                        <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em; color:black;">
                                                            <a href="<?= base_url('/edit-konsultasi-online/' . $d['id_konsultasi_online']); ?>" class="">
                                                                <span class="material-symbols-outlined">
                                                                    edit
                                                                </span>
                                                            </a>
                                                        </td>
                                                        <?php if ($jenis_akses == 'Admin') { ?>
                                                            <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em; color:black;">
                                                                <form action="<?= base_url('/hapus-konsultasi-online/' . $d['id_konsultasi_online']); ?>" method="post" class="d-inline">
                                                                    <?= csrf_field(); ?>
                                                                    <input type="hidden" name="_method" value="DELETE">
                                                                    <button href="" class="link-tambahan" onclick="return confirm('Anda Yakin?')" style="border: none; outline: none; background:none;">
                                                                        <span class="material-symbols-outlined">
                                                                            delete
                                                                        </span>
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </tr>
                                            <?php }
                                        } else { ?>
                                            <tr>
                                                <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;">
                                                    <?= $d['tanggal_konsultasi_online'] . " " . $d['jam_konsultasi_online']; ?>
                                                </td>
                                                <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;">
                                                    <?php foreach ($data_pengguna as $p) : ?>
                                                        <?php if ($p['no_telp_pengguna'] == $d['no_telp_pengguna']) { ?>
                                                            <?= $p['nama_pengguna']; ?>
                                                        <?php } ?>
                                                    <?php endforeach; ?>
                                                </td>
                                                <?php foreach ($data_konsultan as $u) : ?>
                                                    <?php if ($u['user_id'] == $d['NIP']) { ?>
                                                        <?php if ($d['NIP'] == '111') { ?>
                                                            <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em; color:red;">
                                                                <?= $u['nama_kepala']; ?>
                                                            </td>
                                                        <?php } else { ?>
                                                            <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;">
                                                                <?= $u['nama_kepala']; ?>
                                                            </td>
                                                        <?php } ?>
                                                    <?php } ?>
                                                <?php endforeach; ?>
                                                <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;">
                                                    <?= $d['room_zoom']; ?>
                                                </td>
                                                <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;">
                                                    <?php if ($d['status_jalan_konsultasi'] != null) { ?>
                                                        <?= $d['status_jalan_konsultasi']; ?>
                                                    <?php } else { ?>
                                                        <?php if ($d['tanggal_konsultasi_online'] <= date('Y-m-d')) { ?>
                                                            Tidak Berlangsung
                                                        <?php } else if ($d['tanggal_konsultasi_online'] == date('Y-m-d') && $d['jam_konsultasi_online'] <= date('H:i:s')) { ?>
                                                            Tidak Berlangsung
                                                        <?php } else { ?>
                                                            Belum Berlangsung
                                                        <?php } ?>
                                                    <?php } ?>
                                                </td>
                                                <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em;">
                                                    <a href="<?= base_url('/detail-entry-pengguna/' . $d['id_entry']); ?>" class="">
                                                        <span class="material-symbols-outlined">
                                                            open_in_new
                                                        </span>
                                                    </a>
                                                </td>
                                                <td class="mb-0 font-weight-normal ps-0" style="font-size:0.9em; color:#D3D3D3;">
                                                    <span class="material-symbols-outlined">
                                                        edit
                                                    </span>
                                                </td>
                                                <form action="" method="post" class="d-inline">
                                                    <?= csrf_field(); ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button href="" class="" onclick="return confirm('Anda Yakin?')" style="border: none; outline: none; background:none; color:#D3D3D3;" disabled>
                                                        <span class="material-symbols-outlined">
                                                            delete
                                                        </span>
                                                    </button>
                                                </form>
                                            </tr>
                                        <?php } ?>
                                    <?php } ?>
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