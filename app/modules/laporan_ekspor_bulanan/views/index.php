<script src="<?php echo base_url(); ?>assets/temaalus/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="<?php echo base_url(); ?>assets/temaalus/plugins/jquery-validation/dist/additional-methods.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Laporan Ekspor Bulanan</h1>
    </section>

    <section class="content">

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Filter Periode</h3>
            </div>
            <div class="box-body">
                <form method="GET" action="">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Bulan</label>
                                <select name="bulan" class="form-control">
                                    <option value="">-- Pilih Bulan ingin di filter --</option>
                                    <?php
                                    $bln_array = [
                                        1 => 'Januari',
                                        2 => 'Februari',
                                        3 => 'Maret',
                                        4 => 'April',
                                        5 => 'Mei',
                                        6 => 'Juni',
                                        7 => 'Juli',
                                        8 => 'Agustus',
                                        9 => 'September',
                                        10 => 'Oktober',
                                        11 => 'November',
                                        12 => 'Desember'
                                    ];
                                    foreach ($bln_array as $k => $v) {
                                        $selected = ($k == $bulan_pilih) ? 'selected' : '';
                                        echo "<option value='$k' $selected>$v</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tahun</label>
                                <select name="tahun" class="form-control">
                                    <?php
                                    $thn_skrg = date('Y');
                                    for ($i = 2020; $i <= $thn_skrg + 1; $i++) {
                                        $selected = ($i == $tahun_pilih) ? 'selected' : '';
                                        echo "<option value='$i' $selected>$i</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fa fa-filter"></i> Tampilkan Laporan
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="box box-primary">
            <div class="box-header">
                <button id="btn-print-laporan" class="btn btn-default pull-right">
                    <i class="fa fa-print"></i> Cetak PDF/Print
                </button>
                <h3 class="box-title">Hasil Laporan</h3>
            </div>
            <div class="box-body">
                <table id="tableLaporan" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Input</th>
                            <th>Komoditas (Latin)</th>
                            <th>Tujuan</th>
                            <th>Jenis/Grade</th>
                            <th class="text-right">Volume (Kg)</th>
                            <th class="text-right">Nilai Ekspor (USD)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($laporan as $row): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= date('d/m/Y', strtotime($row->created_at)); ?></td>
                                <td>
                                    <b><?= $row->nama_produk; ?></b><br>
                                    <small class="text-muted"><?= $row->nama_latin; ?></small>
                                </td>
                                <td><?= $row->negara_tujuan; ?></td>
                                <td><?= $row->jenis_olahan; ?> (<?= $row->grade; ?>)</td>
                                <td class="text-right"><?= number_format($row->stok_kg); ?></td>
                                <td class="text-right">$<?= number_format($row->harga_usd, 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr style="background-color: #f0f0f0; font-weight: bold;">
                            <td colspan="5" class="text-center">TOTAL EKSPOR BULAN INI</td>
                            <td class="text-right"><?= number_format($total_qty); ?> Kg</td>
                            <td class="text-right">$<?= number_format($total_nilai, 2); ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </section>
</div>

<script>
    $(document).ready(function() {
        var table = $('#tableLaporan').DataTable({
            "paging": false, // Matikan paging agar semua data ter-print
            "searching": false,
            "info": false,
            "buttons": [{
                extend: 'print',
                text: 'Print',
                title: 'Laporan Ekspor Ikan - Periode: <?= $bln_array[$bulan_pilih] . " " . $tahun_pilih ?>',
                customize: function(win) {
                    $(win.document.body).css('font-family', 'Arial');
                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', '12px');

                    // Style Header
                    $(win.document.body).find('h1')
                        .css('text-align', 'center')
                        .css('font-size', '18px')
                        .css('margin-bottom', '20px');

                    // Style Footer (Total) agar tetap tebal saat diprint
                    $(win.document.body).find('tfoot tr')
                        .css('border-top', '2px solid black')
                        .css('font-weight', 'bold');
                }
            }],
            "dom": 't' // Hanya tampilkan tabel (tanpa search/pagination bawaan)
        });

        $('#btn-print-laporan').on('click', function() {
            table.button('.buttons-print').trigger();
        });
    });
</script>