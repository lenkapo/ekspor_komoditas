<script src="<?php echo base_url(); ?>assets/temaalus/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="<?php echo base_url(); ?>assets/temaalus/plugins/jquery-validation/dist/additional-methods.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

<div class="content-wrapper">
    <section class="content-header">
        <h1><?= $title; ?><small><?= $subtitle; ?></small></h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Data Transaksi Ekspor</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-add-ekspor">
                                <i class="fa fa-plus"></i> Tambah Transaksi Baru
                            </button>
                        </div>
                    </div>
                    <div class="box-body">

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
                                <h4><i class="icon fa fa-warning"></i> Perhatian!</h4>
                                <?= $this->session->flashdata('error'); ?>
                            </div>
                        <?php endif; ?>

                        <table id="dataTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Tgl. Ekspor</th>
                                    <th>Lot Number (FK)</th>
                                    <th>Komoditas</th>
                                    <th>Negara Tujuan</th>
                                    <th>Kuantitas (Kg)</th>
                                    <th>Nilai (USD)</th>
                                    <th>Sumber Asal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($transaksi as $row):
                                ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= date('d-m-Y', strtotime($row->tanggal_ekspor)); ?></td>
                                        <td><strong><?= $row->lot_number_fk; ?></strong></td>
                                        <td><?= $row->komoditas; ?></td>
                                        <td><?= $row->negara_tujuan; ?></td>
                                        <td><?= number_format($row->stok_kg, 2); ?></td>
                                        <td>$ <?= number_format($row->harga_usd, 2); ?></td>
                                        <td><?= $row->sumber_asal; ?></td>
                                        <td>
                                            <button class="btn btn-info btn-xs" title="Detail"><i class="fa fa-eye"></i></button>
                                            <button class="btn btn-danger btn-xs" title="Hapus"><i class="fa fa-trash"></i></button>
                                        </td>
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
<div class="modal fade" id="modal-add-ekspor">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-green">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Tambah Transaksi Ekspor Baru</h4>
            </div>
            <?php
            // Kirim POST ke Controller Ekspor/add
            echo form_open('manajemen_stok_outbound/add');
            ?>
            <div class="modal-body">

                <div class="form-group">
                    <label for="lot_number_fk">Pilih Lot Number Stok:</label>
                    <select class="form-control select2" name="lot_number_fk" required style="width: 100%;">
                        <option value="">-- Pilih Lot Stok yang Akan Diekspor --</option>
                        <?php
                        // Data $available_lots HARUS dikirim dari Controller Ekspor/index() ke view
                        foreach ($available_lots as $lot): ?>
                            <option value="<?= $lot->lot_number; ?>">
                                <?= $lot->lot_number; ?> (<?= $lot->komoditas; ?>) - Tersedia: <?= number_format($lot->stok_tersedia_kg, 2); ?> Kg
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="stok_kg">Kuantitas Ekspor (Kg):</label>
                    <input type="number" step="0.01" min="0.01" class="form-control" name="stok_kg" placeholder="Masukkan kuantitas yang diekspor" required>
                </div>

                <div class="form-group">
                    <label for="tanggal_ekspor">Tanggal Ekspor:</label>
                    <input type="date" class="form-control" name="tanggal_ekspor" value="<?= date('Y-m-d'); ?>" required>
                </div>

                <div class="form-group">
                    <label for="negara_tujuan">Negara Tujuan:</label>
                    <input type="text" class="form-control" name="negara_tujuan" placeholder="Contoh: Jepang" required>
                </div>

                <div class="form-group">
                    <label for="harga_usd">Nilai Transaksi (USD):</label>
                    <input type="number" step="0.01" min="0.01" class="form-control" name="harga_usd" placeholder="Contoh: 15000.50" required>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan Transaksi</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<script>
    $(function() {
        // 1. Inisialisasi DataTables
        $('#dataTable').DataTable({
            'paging': true,
            'lengthChange': true,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': false
        });

        // 2. Inisialisasi Select2 untuk Modal
        // Harus diinisialisasi ulang setiap modal dibuka
        $('#modal-add-ekspor').on('shown.bs.modal', function() {
            $('.select2').select2({
                dropdownParent: $('#modal-add-ekspor') // Penting agar Select2 muncul di atas modal
            });
        });

        // 2. Inisialisasi Select2 untuk Modal
        // Harus diinisialisasi ulang setiap modal dibuka dan setting dropdownParent
        $('#modal-add-ekspor').on('shown.bs.modal', function() {
            $('.select2').select2({
                dropdownParent: $('#modal-add-ekspor') // PENTING untuk fix Select2 di Modal
            });
        });
    });
</script>