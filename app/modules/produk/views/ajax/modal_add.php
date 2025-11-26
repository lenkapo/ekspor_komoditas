<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/temaalus/dist/css/bootstrap-datetimepicker.min.css">
<script src="<?php echo base_url(); ?>assets/temaalus/dist/js/bootstrap-datetimepicker.min.js"></script>
<script src="<?php echo base_url(); ?>assets/temaalus/plugin/jQuery/jquery-2.2.3.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/bootstrap/jquery.min.js') ?>"></script>
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Data Produk</h4>
    </div>
    <div class="modal-body">
        <!-- FORM -->
        <form id="form_add">
            <!-- KONTEN -->
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
            <div class="form-group">
                <label>Barcode</label>
                <input type="text" class="form-control" placeholder="Barcode" name="barcode" required>
            </div>
            <div class="form-group">
                <label>Nama Produk</label>
                <input type="text" class="form-control" placeholder="Nama" name="nama_produk" required>
            </div>
            <div class="form-group">
                <label>Kategori Produk</label>
                <select name="kategori_produk" class="form-control">
                    <option value="">-- Pilih Kategori Produk --</option>
                    <?php
                    $kat_prod = $this->db->get('kategori_produk')->result();
                    foreach ($kat_prod as $kp) { ?>
                        <option value="<?php echo $kp->id; ?>"><?php echo $kp->nama_kategori; ?></option>
                    <?php }
                    ?>
                </select>
            </div>



            <div class="form-group">
                <label>Harga</label>
                <input type="text" class="form-control" placeholder="Harga" name="harga">
            </div>
            <div class="form-group">
                <label>Stok</label>
                <input type="text" class="form-control" placeholder="Stok" name="stok" value="0" readonly>
            </div>
            <!-- END KONTEN -->
        </form>
        <!-- END FORM -->
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" onClick="btn_save_add()" class="btn btn-primary">Save changes</button>
    </div>
</div>