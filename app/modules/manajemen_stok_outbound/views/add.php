<div class="content-wrapper">
    <section class="content-header">
        <h1><?= $title; ?><small><?= $subtitle; ?></small></h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Input Data Transaksi Ekspor Baru</h3>
                    </div>

                    <?php
                    // Form akan dikirim ke Ekspor.php/add (yang memanggil simpan_transaksi_ekspor)
                    echo form_open('ekspor/add');
                    ?>
                    <div class="box-body">

                        <?php if (validation_errors()): ?>
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h4><i class="icon fa fa-ban"></i> Kesalahan Input!</h4>
                                <?php echo validation_errors(); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h4><i class="icon fa fa-warning"></i> Perhatian!</h4>
                                <?= $this->session->flashdata('error'); ?>
                            </div>
                        <?php endif; ?>

                        <div class="form-group">
                            <label for="lot_number_fk">Pilih Lot Number Stok:</label>
                            <select class="form-control select2" name="lot_number_fk" required style="width: 100%;">
                                <option value="">-- Pilih Lot Stok yang Akan Diekspor --</option>
                                <?php
                                // Data $available_lots dikirim dari Ekspor.php (Controller)
                                foreach ($available_lots as $lot): ?>
                                    <option
                                        value="<?= $lot->lot_number; ?>"
                                        <?= set_select('lot_number_fk', $lot->lot_number); ?>>
                                        <?= $lot->lot_number; ?> (<?= $lot->komoditas; ?>) - Tersedia: <?= number_format($lot->stok_tersedia_kg, 2); ?> Kg
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <p class="help-block">Pastikan Lot Number yang dipilih memiliki stok tersedia.</p>
                        </div>

                        <div class="form-group">
                            <label for="stok_kg">Kuantitas Ekspor (Kg):</label>
                            <input type="number" step="0.01" min="0.01" class="form-control" name="stok_kg" placeholder="Masukkan kuantitas yang diekspor" value="<?= set_value('stok_kg'); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="tanggal_ekspor">Tanggal Ekspor:</label>
                            <input type="date" class="form-control" name="tanggal_ekspor" value="<?= set_value('tanggal_ekspor', date('Y-m-d')); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="negara_tujuan">Negara Tujuan:</label>
                            <input type="text" class="form-control" name="negara_tujuan" placeholder="Contoh: Jepang" value="<?= set_value('negara_tujuan'); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="harga_usd">Nilai Transaksi (USD):</label>
                            <input type="number" step="0.01" min="0.01" class="form-control" name="harga_usd" placeholder="Contoh: 15000.50" value="<?= set_value('harga_usd'); ?>" required>
                        </div>

                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-success"><i class="fa fa-send"></i> Simpan & Proses Outbound</button>
                        <a href="<?= site_url('ekspor'); ?>" class="btn btn-default pull-right">Batal</a>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>