<script src="<?php echo base_url(); ?>assets/temaalus/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="<?php echo base_url(); ?>assets/temaalus/plugins/jquery-validation/dist/additional-methods.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Laporan Keuangan <small>(Profit & Loss)</small></h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-money"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Omset</span>
                        <span class="info-box-number">$ <?= number_format($grand_omset, 2); ?></span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="fa fa-truck"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Biaya</span>
                        <span class="info-box-number">$ <?= number_format($grand_biaya, 2); ?></span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-bank"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Laba Bersih</span>
                        <span class="info-box-number">$ <?= number_format($grand_profit, 2); ?></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="box box-default">
            <div class="box-header">
                <h3 class="box-title"><i class="fa fa-calendar"></i> Pilih Periode Keuangan</h3>
            </div>
            <div class="box-body text-black">
                <form method="GET" class="form-inline text-center">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label style="color:#333">Bulan: </label>
                                <select name="bulan" class="form-control">
                                    <?php
                                    $bln = [1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'];
                                    foreach ($bln as $k => $v) {
                                        $sel = ($k == $bulan_pilih) ? 'selected' : '';
                                        echo "<option value='$k' $sel>$v</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label style="color:#333"> Tahun: </label>
                                <select name="tahun" class="form-control">
                                    <?php for ($i = 2020; $i <= date('Y') + 1; $i++) {
                                        $sel = ($i == $tahun_pilih) ? 'selected' : '';
                                        echo "<option value='$i' $sel>$i</option>";
                                    } ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-default"><b>Tampilkan</b></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Rincian Transaksi</h3>
                <button id="btn-print" class="btn btn-default pull-right"><i class="fa fa-print"></i> Cetak Laporan</button>
            </div>
            <div class="box-body">
                <table id="tableKeuangan" class="table table-bordered table-striped">
                    <thead style="background-color: #3c8dbc; color: white;">
                        <tr>
                            <th>Tanggal</th>
                            <th>Produk</th>
                            <th>Tujuan</th>
                            <th class="text-right">Pendapatan (Omset)</th>
                            <th class="text-right">Biaya (Cost)</th>
                            <th class="text-right">Keuntungan (Net)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($laporan as $row): ?>
                            <tr>
                                <td><?= date('d/m/y', strtotime($row->created_at)); ?></td>
                                <td><?= $row->nama_produk; ?></td>
                                <td><?= $row->negara_tujuan; ?></td>

                                <td class="text-right text-blue">
                                    $ <?= number_format($row->nilai_omset, 2); ?>
                                </td>

                                <td class="text-right text-red">
                                    ($ <?= number_format($row->biaya_operasional, 2); ?>)
                                </td>

                                <?php
                                $color_class = ($row->nilai_profit >= 0) ? 'text-green' : 'text-red';
                                $icon = ($row->nilai_profit >= 0) ? '+' : '';
                                ?>
                                <td class="text-right <?= $color_class; ?>" style="font-weight:bold;">
                                    <?= $icon ?> $ <?= number_format($row->nilai_profit, 2); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>

                    <tfoot>
                        <tr style="background-color: #f4f4f4; border-top: 3px solid #333;">
                            <td colspan="3" class="text-center"><b>TOTAL BULAN INI</b></td>
                            <td class="text-right"><b>$ <?= number_format($grand_omset, 2); ?></b></td>
                            <td class="text-right text-red"><b>($ <?= number_format($grand_biaya, 2); ?>)</b></td>

                            <?php $grand_color = ($grand_profit >= 0) ? 'background-color:#00a65a; color:white;' : 'background-color:#dd4b39; color:white;'; ?>
                            <td class="text-right" style="<?= $grand_color ?> font-size:16px;">
                                <b>$ <?= number_format($grand_profit, 2); ?></b>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </section>
</div>

<script>
    $(document).ready(function() {
        var table = $('#tableKeuangan').DataTable({
            "paging": false,
            "searching": false,
            "buttons": [{
                extend: 'print',
                title: 'Laporan Laba Rugi Ekspor - <?= $bln[$bulan_pilih] . " " . $tahun_pilih ?>',
                customize: function(win) {
                    $(win.document.body).css('font-family', 'Arial');
                    $(win.document.body).find('h1').css('text-align', 'center');
                    // Pastikan footer (Total) tercetak
                    $(win.document.body).find('tfoot').css('display', 'table-row-group');
                }
            }],
            "dom": 't'
        });
        $('#btn-print').click(function() {
            table.button('.buttons-print').trigger();
        });
    });
    /*FUNCTION MODAL*/

    function btn_modal_add() {
        $.ajax({
            url: base_url + "<?php echo $this->uri->segment(1); ?>/modal_add",
            cache: false,
            indicatorId: '#load_ajax',
            beforeSend: function() {
                $('#load_ajax').fadeIn(100);
            },
            success: function(msg) {
                $('#modal_add').modal('show');
                $('#load_ajax').fadeOut(100);
                $("#mark_addform").html(msg);
            }
        });
    }
</script>