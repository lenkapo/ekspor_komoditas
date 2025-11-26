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
                <label>Nama</label>
                <input type="text" class="form-control" name="nama" value="<?php echo $value->nama; ?>">
            </div>
            <div class="form-group">
                <label>Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-control">
                    <option value="Pria" <?php if ($value->jenis_kelamin == "Pria") {
                                                echo "selected";
                                            } ?>>Pria</option>
                    <option value="Wanita" <?php if ($value->jenis_kelamin == "Wanita") {
                                                echo "selected";
                                            } ?>>Wanita</option>
                </select>
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <input type="textarea" class="form-control" name="alamat" value="<?php echo $value->alamat; ?>">
            </div>
            <div class="form-group">
                <label>No. Telepon</label>
                <input type="number" class="form-control" name="telepon" value="<?php echo $value->telepon; ?>">
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