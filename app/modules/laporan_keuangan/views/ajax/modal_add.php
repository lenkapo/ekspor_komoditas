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