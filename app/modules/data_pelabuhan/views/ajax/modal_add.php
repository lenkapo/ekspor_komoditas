<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/temaalus/dist/css/bootstrap-datetimepicker.min.css">
<script src="<?php echo base_url(); ?>assets/temaalus/dist/js/bootstrap-datetimepicker.min.js"></script>
<script src="<?php echo base_url(); ?>assets/temaalus/plugin/jQuery/jquery-2.2.3.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/bootstrap/jquery.min.js') ?>"></script>
<div class="modal-content-xl">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Tambah Data Satuan</h4>
    </div>
    <div class="modal-body">
        <!-- FORM -->
        <form id="form_add">
            <!-- KONTEN -->
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
            <div class="form-group">
                <label>Nama Pelabuhan</label>
                <input type="text" class="form-control" name="nama_pelabuhan">
            </div>
            <div class="form-group">
                <label>Provinsi Asal</label>
                <select name="provinsi_asal" class="form-control">
                    <option value="">-- Pilih Provinsi Asal --</option>
                    <?php
                    $prov_asal = $this->db->get('wilayah_provinsi')->result();
                    foreach ($prov_asal as $pa) { ?>
                        <option value="<?php echo $pa->id; ?>"><?php echo $pa->nama; ?></option>
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