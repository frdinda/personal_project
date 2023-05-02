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
                            <form role="form" action="<?= base_url('/sub-pilih-peserta-periode-ukom23'); ?>" method="post" class="pb-5">
                                <div class="col ms-0 ps-2">
                                    <button type="submit" class="btn btn-primary mt-2 mb-0" style="font-size:1em;">
                                        Submit
                                    </button>
                                </div>
                                <input id="id_periode" name="id_periode" type="hidden" class="form-control form-control-lg" placeholder="" aria-label="ID Periode" value="<?= $id_periode; ?>" required>
                                <table class="table-hover ps-3 pe-3" id="table-peserta-periode">
                                    <thead>
                                        <th class="col-md-1 text-uppercase font-weight-bolder text-sm ps-0" scope="col"></th>
                                        <th class="col-md-2 text-uppercase font-weight-bolder text-sm ps-0" scope="col">NIP Peserta</th>
                                        <th class="col-md-4 text-uppercase font-weight-bolder text-sm ps-0" scope="col">Nama Peserta</th>
                                        <th class="col-md-5 text-uppercase font-weight-bolder text-sm ps-0" scope="col">Nama Satuan Kerja</th>
                                    </thead>
                                    <tbody>
                                        <!-- DIA MASIH BELUM BISA NAMPILIN YANG UDAH DIPILIH, JADI SEMUANYA MULAI LAGI DARI AWAL -->
                                        <?php foreach ($data_peserta as $d) : ?>
                                            <tr>
                                                <td class="mb-0 ms-0 ps-0 text-lg" scope="row">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="id_peserta[]" value="<?= $d['id_peserta']; ?>" id="flexCheckDefault">
                                                    </div>
                                                </td>
                                                <td class="mb-0 ms-0 ps-0 text-sm" scope="row"><?= $d['id_peserta']; ?></td>
                                                <td class="mb-0 ms-0 ps-0 text-sm" scope="row"><?= $d['nama_peserta']; ?></td>
                                                <td class="mb-0 ms-0 ps-0 text-sm" scope="row"><?= $d['nama_satker']; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>