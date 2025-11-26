<?php foreach ($data as $key => $value); ?>
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo $title; ?></h4>
    </div>
    <div class="modal-body">
        <!-- FORM -->
        <form id="form_edit">
            <input type="hidden" name="id" value="<?php echo $value->id; ?>" required>
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
            <!-- KONTEN -->
            <div class="form-group">
                <label>Nama Negara</label>
                <input type="text" class="form-control" name="nama_negara" value="<?php echo $value->nama_negara; ?>">
            </div>
            <div class="form-group">
                <label>Kode Negara</label>
                <input type="text" class="form-control" name="kode_iso" value="<?php echo $value->kode_iso; ?>">
            </div>
            <!-- END KONTEN -->
        </form>
        <!-- END FORM -->
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" onClick="btn_save_edit()" class="btn btn-primary">Save changes</button>
    </div>
</div>