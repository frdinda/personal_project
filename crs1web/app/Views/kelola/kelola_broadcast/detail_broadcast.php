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
                <div class="col-12">
                    <div class="col-12 pb-4">
                        <table class="table-hover" id="">
                            <thead>
                                <th class=" col-md-3 font-weight-normal ps-1" scope="col">
                                </th>
                                <th class="col-md-1 font-weight-normal ps-1" scope="col"></th>
                                <th class="col-md-8 font-weight-normal ps-1" scope="col"></th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                        Platform Broadcast
                                    </td>
                                    <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                        :
                                    </td>
                                    <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                        <?= $detail_broadcast['platform_broadcast']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                        Tanggal Broadcast
                                    </td>
                                    <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                        :
                                    </td>
                                    <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                        <?= $detail_broadcast['tanggal_broadcast']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                        Unit Kerja
                                    </td>
                                    <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                        :
                                    </td>
                                    <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                        <?= $detail_broadcast['nama_unit_kerja']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                        Judul Broadcast
                                    </td>
                                    <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                        :
                                    </td>
                                    <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                        <?= $detail_broadcast['judul_broadcast']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                        Tujuan Broadcast
                                    </td>
                                    <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                        :
                                    </td>
                                    <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                        <?= $detail_broadcast['tujuan_broadcast']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                        Status Terkirim
                                    </td>
                                    <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                        :
                                    </td>
                                    <td class="mb-0 font-weight-normal ps-1 pb-2" style="font-size:0.9em;">
                                        <?= $detail_broadcast['status_terkirim']; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-12 pb-3 mb-3">
                        <h5 class="font-weight-normal mb-2" style="color:#252527;">Text Broadcast</h5>
                        <div class="row">
                            <div class="col-3">
                                <span></span>
                            </div>
                            <div class="col-6">
                                <?php if ($detail_broadcast['thumbnail_broadcast'] != null) { ?>
                                    <div class="row mb-3 justify-content-center">
                                        <img src="<?= $detail_broadcast['thumbnail_broadcast']; ?>" alt="" style="height:auto; width:1080px;">
                                    </div>
                                <?php } else {
                                } ?>
                                <div class="row justify-content-center">
                                    <?= $text_broadcast; ?>
                                </div>
                            </div>
                            <div class="col-3">
                                <span></span>
                            </div>
                        </div>
                    </div>
                    <?php if ($detail_broadcast['status_terkirim'] == 'Belum') { ?>
                        <div class="col-9 mb-3 ps-1">
                            <a href="<?= base_url('/kirim-broadcast/' . $detail_broadcast['id_broadcast']); ?>" class="btn bg-gradient-danger font-weight-bolder me-3" onclick="return confirm('Anda Yakin?')">
                                Kirim
                            </a>
                            <a href="<?= base_url('/edit-broadcast/' . $detail_broadcast['id_broadcast']); ?>" class="btn bg-gradient-primary font-weight-bolder me-3">
                                Edit
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>