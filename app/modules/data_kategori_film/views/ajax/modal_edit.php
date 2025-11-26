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
        <input type="text" class="form-control" name="name" value="<?php echo $value->name; ?>">
      </div>
      <div class="form-group">
        <label>Deskripsi</label>
        <textarea name="description" class="form-control" rows="10"><?php echo $value->description; ?></textarea>
      </div>
      <div class="form-group">
        <label>Status</label>
        <select name="is_active" class="form-control">
          <option value="1" <?php if ($value->is_active == "1") {
                              echo "selected";
                            } ?>>Aktif</option>
          <option value="0" <?php if ($value->is_active == "0") {
                              echo "selected";
                            } ?>>Tidak Aktif</option>
        </select>
      </div>
      <div class="form-group">
        <div class="callout callout-warning">
          <p>Panduan Ukuran Gambar: L: 414px T: 280px</p>
        </div>
      </div>
      <div class="form-group">
        <label>Gambar</label>
        <div class="col-md-4">
          <?php if ($value->picture != "") { ?>
            <img src="<?php echo base_url('assets/categories/') . $value->picture; ?>" width="100%">
          <?php } ?>
        </div>
        <input type="hidden" name="userfile_lama" value="<?php echo $value->picture; ?>">
        <input type="file" name="userfile">
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