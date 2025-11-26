<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/temaalus/dist/css/bootstrap-datetimepicker.min.css" >
<script src="<?php echo base_url();?>assets/temaalus/dist/js/bootstrap-datetimepicker.min.js"></script>
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">Kategori Film</h4>
  </div>
  <div class="modal-body">
    <!-- FORM -->
    <form id="form_add">
    	<!-- KONTEN -->
        <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
        <div class="form-group">
          <label>Nama</label>
          <input type="text" class="form-control" name="name">
        </div>
        <div class="form-group">
          <label>Deskripsi</label>
          <textarea name="description" class="form-control" rows="10"></textarea>
        </div>
        <div class="form-group">
          <div class="callout callout-warning">
            <p>Panduan Ukuran Gambar: L: 750px T: 250px</p>
          </div>
        </div>
        <div class="form-group">
          <label>Gambar</label>
          <input type="file" name="userfile">
        </div>
        <div class="form-group">
          <label>Status</label>
          <select name="is_active" class="form-control">
            <option value="1">Aktif</option>
            <option value="0">Tidak Aktif</option>
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