<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/temaalus/dist/css/bootstrap-datetimepicker.min.css">
<script src="<?php echo base_url(); ?>assets/temaalus/dist/js/bootstrap-datetimepicker.min.js"></script>
<script src="<?php echo base_url(); ?>assets/temaalus/plugin/jQuery/jquery-2.2.3.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/bootstrap/jquery.min.js') ?>"></script>
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Tambah Data Barang</h4>
    </div>
    <div class="modal-body">
        <!-- FORM -->
        <form id="form_add">
            <!-- KONTEN -->
            <div class="form-group">
                <div class="callout callout-warning">
                    <p>Panduan Tambah Data Barang: L: 750px T: 250px</p>
                </div>
            </div>
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
            <div class="form-group">
                <label>ID Barang</label>
                <input readonly value="<?= set_value('id_barang', $id_barang); ?>" type="text" class="form-control" name="id_barang">
            </div>
            <div class="form-group">
                <label>Nama Barang</label>
                <input type="text" class="form-control" name="nama_barang" placeholder="Silahkan Masukan nama barang">
            </div>
            <div class="form-group">
                <label>Jenis Barang</label>
                <select name="jenis_id" class="form-control">
                    <option value="">Pilih Jenis Barang</option>
                    <?php
                    $jenis = $this->db->get('jenis')->result();
                    foreach ($jenis as $j) { ?>
                        <option value="<?php echo $j->id; ?>"><?php echo $j->nama_jenis; ?></option>
                    <?php }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label>Stok</label>
                <input type="number" class="form-control" name="stok" placeholder="Silahkan masukan jumlah Stok">
            </div>
            <div class="form-group">
                <label>Satuan Barang</label>
                <select name="satuan_id" class="form-control">
                    <option value="">Pilih Satuan Barang</option>
                    <?php
                    $satuan = $this->db->get('satuan')->result();
                    foreach ($satuan as $s) { ?>
                        <option value="<?php echo $s->id; ?>"><?php echo $s->nama_satuan; ?></option>
                    <?php }
                    ?>
                </select>
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