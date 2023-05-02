<?= $this->extend('layout/layout_beranda'); ?>

<?= $this->section('content'); ?>
<div class="row pe-3">
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-header p-3 pt-2">
                <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                    <i class="material-icons opacity-10">person</i>
                </div>
                <div class="text-end pt-1">
                    <p class="text-sm mb-0 text-capitalize">Entry Pengguna Layanan <br> Tanggal <?= date('d M, Y'); ?></p>
                    <h4 class="mb-0 mt-2"><?= $jumlah_entry_perhari; ?></h4>
                </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-header p-3 pt-2">
                <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                    <i class="material-icons opacity-10">person</i>
                </div>
                <div class="text-end pt-1">
                    <p class="text-sm mb-0 text-capitalize">Entry Pengguna Layanan <br> Bulan <?= date('F'); ?></p>
                    <h4 class="mb-0 mt-2"><?= $jumlah_entry_perbulan; ?></h4>
                </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-header p-3 pt-2">
                <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                    <i class="material-icons opacity-10">person</i>
                </div>
                <div class="text-end pt-1">
                    <p class="text-sm mb-0 text-capitalize">Entry Pengguna Layanan <br> Tahun <?= date('Y'); ?></p>
                    <h4 class="mb-0 mt-2"><?= $jumlah_entry_pertahun; ?></h4>
                </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card">
            <div class="card-header p-3 pt-2">
                <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                    <i class="material-icons opacity-10">groups</i>
                </div>
                <div class="text-end pt-1">
                    <p class="text-sm mb-0 text-capitalize">Entry Pengguna Layanan <br> Seluruhnya</p>
                    <h4 class="mb-0 mt-2"><?= $jumlah_entry_total; ?></h4>
                </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
            </div>
        </div>
    </div>
</div>
<div class="row mt-4 pe-3">
    <div class="col-lg-4 col-md-6 mt-4 mb-4">
        <div class="card z-index-2 ">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                    <div class="chart">
                        <canvas id="chart-bars" class="chart-canvas" height="170"></canvas>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <h6 class="mb-0 ">Jumlah Entry Pengguna Layanan</h6>
                <p class="text-sm ">Per Bulan Selama Tahun <?= date('Y'); ?></p>
                <hr class="dark horizontal">
                <div class="d-flex ">

                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 mt-4 mb-4">
        <div class="card z-index-2  ">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                <div class="bg-gradient-success shadow-success border-radius-lg py-3 pe-1">
                    <div class="chart">
                        <canvas id="chart-line" class="chart-canvas" height="170"></canvas>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <h6 class="mb-0 ">Jumlah Broadcast </h6>
                <p class="text-sm ">Per Bulan Selama Tahun <?= date('Y'); ?></p>
                <hr class="dark horizontal">
                <div class="d-flex ">
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 mt-4 mb-4">
        <div class="card z-index-2  ">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                <div class="bg-gradient-info shadow-info border-radius-lg py-3 pe-1">
                    <div class="chart">
                        <canvas id="chart-line-tasks" class="chart-canvas" height="170"></canvas>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <h6 class="mb-0 ">Jumlah Konsultasi Online</h6>
                <p class="text-sm ">Per Bulan Selama Tahun <?= date('Y'); ?></p>
                <hr class="dark horizontal">
                <div class="d-flex ">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mt-4 pe-3">
    <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-header p-3 pt-2">
                <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                    <i class="material-icons opacity-10">weekend</i>
                </div>
                <div class="text-end pt-1">
                    <p class="text-sm mb-0 text-capitalize">Data Broadcast Terkirim</p>
                    <h4 class="mb-0 mt-2"><?= $jumlah_broadcast_terkirim; ?></h4>
                </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-header p-3 pt-2">
                <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                    <i class="material-icons opacity-10">person</i>
                </div>
                <div class="text-end pt-1">
                    <p class="text-sm mb-0 text-capitalize">Data Broadcast Belum Terkirim</p>
                    <h4 class="mb-0 mt-2"><?= $jumlah_broadcast_belum_terkirim; ?></h4>
                </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-header p-3 pt-2">
                <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                    <i class="material-icons opacity-10">person</i>
                </div>
                <div class="text-end pt-1">
                    <p class="text-sm mb-0 text-capitalize">Jumlah Broadcast</p>
                    <h4 class="mb-0 mt-2"><?= $jumlah_broadcast_total; ?></h4>
                </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
            </div>
        </div>
    </div>
</div>
<div class="row mt-4 pe-3">
    <div class="col-lg-12 col-md-12 mt-4 mb-4">
        <div class="card card-chart">
            <div class="card-header card-header-icon card-header-danger">
                <div class="card-icon">
                    <i class="material-icons">pie_chart</i>
                    <h4 class="card-title">Entry Pengguna Per Jenis Layanan</h4>
                </div>
            </div>
            <div class="card-body">
                <canvas id="chart-pie" class="chart-canvas" height="300"></canvas>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-12">
                        <h6 class="card-category">Legend</h6>
                    </div>
                    <div class="col-md-12">
                        <!-- jenis layanannya -->
                        <?php foreach ($data_jenis_layanan as $d) : ?>
                            <i class="fa fa-circle" style="color:<?= $d['warna_jenis_layanan']; ?>;"></i> <?= $d['jenis_layanan']; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<footer class="footer py-4 mt-3 pe-3">
    <div class="container-fluid">
        <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-6 mb-lg-0 mb-4">
                <div class="copyright text-center text-sm text-muted text-lg-start">
                    © <script>
                        document.write(new Date().getFullYear())
                    </script>,
                    made with <i class="fa fa-heart"></i> by
                    <a href="https://sumut.kemenkumham.go.id/" class="font-weight-bold" target="_blank">Kantor Wilayah Kementerian Hukum dan HAM Sumatera Utara</a>
                </div>
            </div>
            <div class="col-lg-6">
                <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                    <li class="nav-item">
                        <a href="https://www.instagram.com/kemenkumhamsumut/" class="nav-link text-muted" target="_blank">Instagram</a>
                    </li>
                    <li class="nav-item">
                        <a href="https://web.facebook.com/kanwilkemenkumham.sumut" class="nav-link text-muted" target="_blank">Facebook</a>
                    </li>
                    <li class="nav-item">
                        <a href="https://twitter.com/Kemenkumham_SUM" class="nav-link text-muted" target="_blank">Twitter</a>
                    </li>
                    <li class="nav-item">
                        <a href="https://sumut.kemenkumham.go.id/" class="nav-link pe-0 text-muted" target="_blank">Website</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>

<?= $this->endSection(); ?>