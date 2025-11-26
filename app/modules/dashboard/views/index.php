<!-- Full Width Column -->
<div class="content-wrapper" style="min-height: 901px;">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Dashboard
      <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="box box-primary">
      <section class="content">
        <div class="row">
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
              <div class="inner">
                <h3><?= $total_ikan ?></h3>

                <p>Komoditas Ikan</p>
              </div>
              <div class="icon">
                <i class="ion-ios-compose"></i>
              </div>
              <a href="<?= site_url('data_komoditas_ikan/index') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-o-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
              <div class="inner">
                <h3><?= $total_hewan ?></h3>
                <p>Komoditas Hewan</p>
              </div>
              <div class="icon">
                <i class="ion-ios-paw"></i>
              </div>
              <a href="<?= site_url('dashboard/katalog/tumbuhan') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-o-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-green">
              <div class="inner">
                <h3><?= $total_tumbuhan ?></h3>
                <p>Komoditas Tumbuhan</p>
              </div>
              <div class="icon"><i class="ion-leaf"></i></div>
              <a href="<?= site_url('') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-o-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-red">
              <div class="inner">
                <h3>Rp <?= number_format($total_aset / 1000000, 0) ?> Juta</h3>
                <p>Estimasi Nilai Ekspor</p>
              </div>
              <div class="icon"><i class="fas fa-dollar-sign"></i></div>
              <a href="#" class="small-box-footer">Detail Keuangan <i class="fa fa-arrow-circle-o-right"></i></a>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <!-- DONUT CHART -->
            <!-- DONUT CHART -->
            <div class="box box-danger">
              <div class="box-header with-border">
                <h3 class="box-title">Persentase Komoditas</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
              <div class="box-body">
                <canvas id="pieChart" style="height:250px"></canvas>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
            <!-- /.box -->
          </div>

          <div class="col-md-6">
            <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">Barang Terbaru Ditambahkan</h3>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                      <tr>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Tujuan</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($recent_items as $item): ?>
                        <tr>
                          <td><?= $item->nama_produk ?></td>
                          <td>
                            <span class="badge badge-<?= ($item->kategori == 'Ikan') ? 'info' : (($item->kategori == 'Hewan') ? 'danger' : 'success') ?>">
                              <?= $item->kategori ?>
                            </span>
                          </td>
                          <td><?= number_format($item->stok) ?> <?= $item->satuan ?></td>
                          <td><?= $item->negara_tujuan ?></td>
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
</div>
</section>
</div>
</section>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="<?php echo base_url(); ?>assets/temaalus/plugins/chartjs/chart.js"></script>
<script src="<?php echo base_url(); ?>assets/temaalus/plugins/chartjs/chart.min.js"></script>

<script>
  $(function() {
    // Ambil context canvas
    var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
    var pieChart = new Chart(pieChartCanvas);

    // ============================================================
    // MEMBUAT DATA DINAMIS DARI PHP CODEIGNITER
    // ============================================================
    var PieData = [
      <?php
      foreach ($data_komoditas as $row) :
        // 1. Tentukan Warna Berdasarkan Kategori
        // Kita pakai Switch Case atau If sederhana
        $color = '#d2d6de'; // Warna default (abu-abu)
        $highlight = '#d2d6de';

        if ($row->kategori == 'Ikan') {
          $color = '#00c0ef';     // Biru Muda (Info)
          $highlight = '#00a7d0'; // Biru lebih gelap dikit (saat di-hover)
        } elseif ($row->kategori == 'Hewan') {
          $color = '#f56954';     // Merah (Danger)
          $highlight = '#d35442';
        } elseif ($row->kategori == 'Tumbuhan') {
          $color = '#00a65a';     // Hijau (Success)
          $highlight = '#008d4c';
        }
      ?>

        // 2. Cetak Object JavaScript
        {
          value: <?php echo $row->total; ?>,
          color: "<?php echo $color; ?>",
          highlight: "<?php echo $highlight; ?>",
          label: "<?php echo $row->kategori; ?>"
        },

      <?php endforeach; ?>
    ];
    // ============================================================

    var pieOptions = {
      segmentShowStroke: true,
      segmentStrokeColor: "#fff",
      segmentStrokeWidth: 2,
      percentageInnerCutout: 50, // Ini yang bikin bolong tengahnya (Donut)
      animationSteps: 100,
      animationEasing: "easeOutBounce",
      animateRotate: true,
      animateScale: false,
      responsive: true,
      maintainAspectRatio: true,
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
    };

    // Render Chart
    pieChart.Doughnut(PieData, pieOptions);
  });
</script>