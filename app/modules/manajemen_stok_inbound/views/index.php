<script src="<?php echo base_url(); ?>assets/temaalus/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="<?php echo base_url(); ?>assets/temaalus/plugins/jquery-validation/dist/additional-methods.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?= $title; ?>
            <small><?= $subtitle; ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Stok</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Berhasil!</h4>
                        <?= $this->session->flashdata('success'); ?>
                    </div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-ban"></i> Error!</h4>
                        <?= $this->session->flashdata('error'); ?>
                    </div>
                <?php endif; ?>

                <div class="box">
                    <div class="box-header" style="background: #3c8dbc; color:white;">
                        <div class="col-md-6" style="padding: 1px;">
                            <button id="btn-print-barang" class="btn btn-default">
                                <i class="fa fa-print"></i> Print Table
                            </button>
                        </div>
                        <button type="button" class="btn-btn-xs btn-default pull-right" data-toggle="modal" data-target="#modalTambah">
                            <i class="fa fa-plus"></i> Tambah Komoditas Ikan Baru
                        </button>
                    </div>
                    <div class="box-body">
                        <table id="stokTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Lot Number</th>
                                    <th>Komoditas</th>
                                    <th>Tgl Masuk</th>
                                    <th>Tgl Kadaluarsa</th>
                                    <th>Tersedia (Kg)</th>
                                    <th>Dialokasikan (Kg)</th>
                                    <th>Kualitas</th>
                                    <th>Peringatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($stok as $item):
                                    $row_class = '';
                                    $alert_text = '';
                                    $today = new DateTime();
                                    $expiry_date = new DateTime($item->tanggal_kadaluarsa);
                                    $interval = $today->diff($expiry_date);

                                    // Peringatan Kadaluarsa (Kurang dari 30 hari)
                                    if ($item->tanggal_kadaluarsa && $interval->days < 30 && $interval->invert === 0) {
                                        $row_class = 'warning';
                                        $alert_text = '<span class="label label-warning">Segera EXP</span>';
                                    }
                                    // Peringatan Stok Rendah (di bawah 1000 kg)
                                    if ($item->stok_tersedia_kg < 1000) {
                                        $row_class = $row_class == 'warning' ? 'danger' : 'danger';
                                        $alert_text = $alert_text ? $alert_text . ' <span class="label label-danger">Stok Rendah</span>' : '<span class="label label-danger">Stok Rendah</span>';
                                    }
                                ?>
                                    <tr class="<?= $row_class; ?>">
                                        <td><?= $item->lot_number; ?></td>
                                        <td><strong><?= $item->komoditas; ?></strong></td>
                                        <td><?= $item->tanggal_masuk; ?></td>
                                        <td><?= $item->tanggal_kadaluarsa; ?></td>
                                        <td><?= number_format($item->stok_tersedia_kg, 2); ?></td>
                                        <td><?= number_format($item->stok_dialokasikan_kg, 2); ?></td>
                                        <td><span class="label label-<?= $item->status_kualitas == 'Lolos Uji' ? 'success' : 'info'; ?>"><?= $item->status_kualitas; ?></span></td>
                                        <td><?= $alert_text; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Modal Add Data Produk Masuk Inbound -->
<div class="modal fade" id="modalTambah">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Data Produk Masuk (Inbound)</h4>
            </div>
            <?php echo form_open('manajemen_stok/add'); ?>
            <div class="box-body">

                <?php if (validation_errors()): ?>
                    <div class="alert alert-danger"><?php echo validation_errors(); ?></div>
                <?php endif; ?>

                <div class="form-group">
                    <label for="lot_number">Lot Number Unik:</label>
                    <input type="text" class="form-control" name="lot_number" value="<?= set_value('lot_number'); ?>" required>
                </div>

                <div class="form-group">
                    <label for="komoditas">Komoditas (Cth: Tuna Loin / Udang Vaname):</label>
                    <input type="text" class="form-control" name="komoditas" value="<?= set_value('komoditas'); ?>" required>
                </div>

                <div class="form-group">
                    <label for="stok_tersedia_kg">Kuantitas (Kg):</label>
                    <input type="number" step="0.01" class="form-control" name="stok_tersedia_kg" value="<?= set_value('stok_tersedia_kg'); ?>" required>
                </div>

                <div class="form-group">
                    <label for="sumber_asal">Sumber (Cth: Kapal KM Bahari / Tambak Blok C):</label>
                    <input type="text" class="form-control" name="sumber_asal" value="<?= set_value('sumber_asal'); ?>">
                </div>

                <div class="form-group">
                    <label for="tanggal_kadaluarsa">Tanggal Kadaluarsa:</label>
                    <input type="date" class="form-control" name="tanggal_kadaluarsa" value="<?= set_value('tanggal_kadaluarsa'); ?>">
                </div>

                <div class="form-group">
                    <label for="status_kualitas">Status Kualitas:</label>
                    <select class="form-control" name="status_kualitas">
                        <option value="Lolos Uji" <?= set_select('status_kualitas', 'Lolos Uji'); ?>>Lolos Uji (Siap Ekspor)</option>
                        <option value="Karantina" <?= set_select('status_kualitas', 'Karantina'); ?>>Karantina (Menunggu Hasil Tes)</option>
                        <option value="Ditolak" <?= set_select('status_kualitas', 'Ditolak'); ?>>Ditolak (Musnahkan/Alihkan Domestik)</option>
                    </select>
                </div>

            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">Simpan Stok</button>
                <a href="<?= site_url('stok'); ?>" class="btn btn-default pull-right">Batal</a>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<script>
    $(function() {
        $('#stokTable').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });
    });
</script>