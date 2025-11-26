<script src="<?php echo base_url(); ?>assets/temaalus/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="<?php echo base_url(); ?>assets/temaalus/plugins/jquery-validation/dist/additional-methods.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Laporan Ekspor <small>Berdasarkan Negara Tujuan</small></h1>
    </section>

    <section class="content">

        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-filter"></i> Filter Data</h3>
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
                                <label>Negara Tujuan</label>
                                <select name="negara" class="form-control">
                                    <option value="all" <?= ($negara_pilih == 'all') ? 'selected' : '' ?>>-- Semua Negara --</option>
                                    <?php foreach ($list_negara as $n): ?>
                                        <option value="<?= $n->negara_tujuan ?>" <?= ($negara_pilih == $n->negara_tujuan) ? 'selected' : '' ?>>
                                            <?= $n->negara_tujuan ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-success btn-block">Tampilkan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">
                    Data Ekspor:
                    <b><?= ($negara_pilih == 'all') ? 'Semua Negara' : $negara_pilih; ?></b>
                    (<?= $bln_array[$bulan_pilih] . ' ' . $tahun_pilih ?>)
                </h3>
                <button id="btn-print" class="btn btn-default pull-right"><i class="fa fa-print"></i> Cetak</button>
            </div>

            <div class="box-body">
                <table id="tableNegara" class="table table-bordered table-striped">
                    <thead class="bg-gray">
                        <tr>
                            <th>No</th>
                            <th>Negara Tujuan</th>
                            <th>Tanggal</th>
                            <th>Produk (Latin)</th>
                            <th>Jenis/Grade</th>
                            <th class="text-right">Vol (Kg)</th>
                            <th class="text-right">Nilai (USD)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($laporan as $row):
                        ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td style="font-weight:bold; color:#00a65a;"><?= $row->negara_tujuan; ?></td>
                                <td><?= date('d/m/Y', strtotime($row->created_at)); ?></td>
                                <td>
                                    <?= $row->nama_produk; ?><br>
                                    <i class="text-muted"><?= $row->nama_latin; ?></i>
                                </td>
                                <td><?= $row->jenis_olahan; ?> (<?= $row->grade; ?>)</td>
                                <td class="text-right"><?= number_format($row->stok_kg); ?></td>
                                <td class="text-right text-blue">$ <?= number_format($row->harga_usd, 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr style="background-color: #eee; font-weight:bold; border-top: 2px solid #333;">
                            <td colspan="5" class="text-center">GRAND TOTAL</td>
                            <td class="text-right"><?= number_format($grand_qty); ?> Kg</td>
                            <td class="text-right">$ <?= number_format($grand_nilai, 2); ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </section>
</div>

<script>
    $(document).ready(function() {
        var titleLaporan = 'Laporan Ekspor ke <?= ($negara_pilih == "all") ? "Semua Negara" : $negara_pilih ?> - Periode <?= $bln_array[$bulan_pilih] . " " . $tahun_pilih ?>';

        var table = $('#tableNegara').DataTable({
            "ordering": false, // Matikan sorting otomatis agar urutan negara sesuai model
            "paging": false, // Tampilkan semua data (biar ke-print semua)
            "buttons": [{
                extend: 'print',
                title: titleLaporan,
                text: 'Print',
                customize: function(win) {
                    // Custom CSS saat Print
                    $(win.document.body).css('font-family', 'Arial');
                    $(win.document.body).find('h1').css('text-align', 'center').css('font-size', '20px');
                    $(win.document.body).find('table').addClass('compact').css('font-size', '12px');

                    // Highlight baris total di print
                    $(win.document.body).find('tfoot').css('display', 'table-row-group');
                }
            }],
            "dom": 't' // Hanya tampilkan tabel
        });

        $('#btn-print').on('click', function() {
            table.button('.buttons-print').trigger();
        });
    });
</script>