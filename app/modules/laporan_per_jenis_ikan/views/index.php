<script src="<?php echo base_url(); ?>assets/temaalus/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="<?php echo base_url(); ?>assets/temaalus/plugins/jquery-validation/dist/additional-methods.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Laporan Ekspor <small>Per Jenis Komoditas Ikan</small></h1>
    </section>

    <section class="content">

        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-search"></i> Filter Jenis Ikan</h3>
            </div>
            <div class="box-body">
                <form method="GET" action="">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Bulan</label>
                                <select name="bulan" class="form-control">
                                    <?php
                                    $bln_array = [
                                        1 => 'Jan',
                                        2 => 'Feb',
                                        3 => 'Mar',
                                        4 => 'Apr',
                                        5 => 'Mei',
                                        6 => 'Jun',
                                        7 => 'Jul',
                                        8 => 'Agu',
                                        9 => 'Sep',
                                        10 => 'Okt',
                                        11 => 'Nov',
                                        12 => 'Des'
                                    ];
                                    foreach ($bln_array as $k => $v) {
                                        $sel = ($k == $bulan_pilih) ? 'selected' : '';
                                        echo "<option value='$k' $sel>$v</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Tahun</label>
                                <select name="tahun" class="form-control">
                                    <?php
                                    for ($i = 2020; $i <= date('Y') + 1; $i++) {
                                        $sel = ($i == $tahun_pilih) ? 'selected' : '';
                                        echo "<option value='$i' $sel>$i</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Jenis Ikan</label>
                                <select name="jenis" class="form-control select2">
                                    <option value="all" <?= ($jenis_pilih == 'all') ? 'selected' : '' ?>>-- Semua Jenis --</option>
                                    <?php foreach ($list_jenis as $j): ?>
                                        <option value="<?= $j->nama_produk ?>" <?= ($jenis_pilih == $j->nama_produk) ? 'selected' : '' ?>>
                                            <?= $j->nama_produk ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-warning btn-block"><b>Filter</b></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="box box-solid">
            <div class="box-header">
                <h3 class="box-title">
                    Laporan:
                    <b><?= ($jenis_pilih == 'all') ? 'Semua Komoditas' : $jenis_pilih; ?></b>
                </h3>
                <button id="btn-print" class="btn btn-default pull-right"><i class="fa fa-print"></i> Cetak</button>
            </div>

            <div class="box-body">
                <table id="tableJenis" class="table table-bordered table-striped">
                    <thead class="bg-yellow">
                        <tr>
                            <th>No</th>
                            <th>Jenis Ikan (Produk)</th>
                            <th>Negara Tujuan</th>
                            <th>Tgl Ekspor</th>
                            <th class="text-right">Vol (Kg)</th>
                            <th class="text-right">Harga/Kg</th>
                            <th class="text-right">Total Nilai (USD)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($laporan as $row):
                            // Hitung Total Nilai per Baris
                            $total_nilai = $row->stok_kg * $row->harga_usd;
                        ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td>
                                    <b><?= $row->nama_produk; ?></b><br>
                                    <small class="text-muted"><?= $row->nama_latin; ?></small>
                                </td>
                                <td>
                                    <i class="fa fa-plane"></i> <?= $row->negara_tujuan; ?>
                                </td>
                                <td><?= date('d M Y', strtotime($row->created_at)); ?></td>

                                <td class="text-right"><?= number_format($row->stok_kg); ?></td>
                                <td class="text-right">$ <?= number_format($row->harga_usd, 2); ?></td>

                                <td class="text-right" style="font-weight:bold; color:#3c8dbc; background-color:#f9f9f9;">
                                    $ <?= number_format($total_nilai, 2); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr style="background-color: #333; color: #fff; font-weight:bold;">
                            <td colspan="4" class="text-center">GRAND TOTAL EKSPOR</td>
                            <td class="text-right"><?= number_format($grand_qty); ?> Kg</td>
                            <td></td>
                            <td class="text-right">$ <?= number_format($grand_total_uang, 2); ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </section>
</div>

<script>
    $(document).ready(function() {
        var judul = 'Laporan Ekspor Ikan: <?= ($jenis_pilih == "all") ? "Semua Jenis" : $jenis_pilih ?>';

        var table = $('#tableJenis').DataTable({
            "ordering": false,
            "paging": false,
            "buttons": [{
                extend: 'print',
                title: judul,
                text: '<i class="fa fa-print"></i> Print Report',
                className: 'btn btn-default',
                customize: function(win) {
                    $(win.document.body).css('font-family', 'Arial');
                    $(win.document.body).find('h1').css('text-align', 'center').css('font-size', '18px');
                    $(win.document.body).find('table').addClass('compact').css('font-size', '12px');

                    // Highlight Kolom Terakhir (Total Nilai) saat Print
                    $(win.document.body).find('table tbody td:last-child').css('font-weight', 'bold');
                }
            }],
            "dom": 't'
        });

        $('#btn-print').on('click', function() {
            table.button('.buttons-print').trigger();
        });
    });
</script>