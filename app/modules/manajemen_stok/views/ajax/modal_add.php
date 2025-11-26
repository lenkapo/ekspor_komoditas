<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/temaalus/dist/css/bootstrap-datetimepicker.min.css">
<script src="<?php echo base_url(); ?>assets/temaalus/dist/js/bootstrap-datetimepicker.min.js"></script>
<script src="<?php echo base_url(); ?>assets/temaalus/plugin/jQuery/jquery-2.2.3.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/bootstrap/jquery.min.js') ?>"></script>
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Tambah Data Ikan</h4>
    </div>
    <div class="modal-body">
        <!-- FORM -->
        <form id="form_add">
            <!-- KONTEN -->
            <!-- <div class="form-group">
                <div class="callout callout-warning">
                    <p>Panduan Tambah Data Barang: L: 750px T: 250px</p>
                </div>
            </div> -->
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
            <div class="form-group">
                <label>Nama Produk/Ikan</label>
                <input type="text" name="nama_produk" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Asal Wilayah</label>
                <input type="text" name="asal_wilayah" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Nama Latin</label>
                <input type="text" name="nama_latin" class="form-control" required>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Jenis Olahan</label>
                        <select name="jenis_olahan" class="form-control">
                            <option value="">-- Pilih Jenis Olahan --</option>
                            <option value="Fresh">Fresh/Segar</option>
                            <option value="Frozen">Frozen/Beku</option>
                            <option value="Live">Live/Hidup</option>
                            <option value="Fillet">Fillet/Irisan/Potongan</option>
                            <option value="Canned">Canned/Kalengan</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Grade Kualitas</label>
                        <select name="jenis_olahan" class="form-control">
                            <option value="">-- Pilih Grade Kualitas --</option>
                            <option value="A / Sangat Baik / Premium">A / Sangat Baik / Premium</option>
                            <option value=">B / Baik">B / Baik </option>
                            <option value="C / Cukup Baik">C / Cukup Baik</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Stok Produk</label>
                        <input type="number" name="stok_kg" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Satuan</label>
                        <select name="satuan" class="form-control">
                            <option value="">-- Pilih Satuan --</option>
                            <?php
                            $satuan = $this->db->get('satuan')->result();
                            foreach ($satuan as $s) { ?>
                                <option value="<?php echo $s->id; ?>"><?php echo $s->s_satuan; ?> / <?php echo $s->nama_satuan; ?></option>
                            <?php }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Harga(USD) / Kg</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                    <input type="number"
                        name="harga_usd"
                        id="edit_harga"
                        class="form-control"
                        step="0.01"
                        min="0"
                        required>
                </div>
            </div>
            <div class="form-group">
                <label>Gambar</label>
                <input type="file" name="userfile">
            </div>
            <div class="form-group">
                <label>Tanggal Transaksi (Pengiriman/Pencatatan)</label>
                <input type="date" class="form-control" name="tanggal_transaksi" required>
            </div>
            <div class="form-group">
                <label>Biaya Operasional (Shipping/Packing/dll)</label>
                <div class="input-group">
                    <span class="input-group-addon text-red"><b>- $</b></span>
                    <input type="number" name="biaya_operasional" class="form-control" step="0.01" value="0" placeholder="0.00">
                </div>
                <small class="text-muted">Total biaya pengeluaran untuk pengiriman ini.</small>
            </div>

            <!-- <div class="form-group">
                <label>Negara Tujuan Ekspor</label>
                <input type="text" name="negara_tujuan" class="form-control">
            </div> -->
            <!-- END KONTEN -->
        </form>
        <!-- END FORM -->
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" onClick="btn_save_add()" class="btn btn-primary">Save changes</button>
    </div>
</div>