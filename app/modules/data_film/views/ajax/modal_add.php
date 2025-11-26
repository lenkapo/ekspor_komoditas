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
          <label>Judul</label>
          <input type="text" class="form-control" name="title">
        </div>
        <div class="form-group">
          <label>Deskripsi</label>
          <textarea name="description" class="form-control" rows="10"></textarea>
        </div>
        <div class="form-group">
          <label>Kategori</label>
          <select name="categories[]" class="form-control" multiple>
            <?php 
            $categories = $this->db->get('categories')->result();
            foreach ( $categories as $category) { ?>
              <option value="<?php echo $category->id;?>"><?php echo $category->name;?></option>
            <?php }
            ?>
          </select>
        </div>
        <div class="form-group">
          <label>Rating</label>
          <input type="number" class="form-control" name="rating" min="0" max="10">
        </div>
        <div class="form-group">
          <label>Featured</label>
          <input type="number" class="form-control" name="featured" min="0" max="4">
        </div>
        <div class="form-group">
          <label>Tahun Rilis</label>
          <input type="text" class="form-control" name="year">
        </div>
        <div class="form-group">
          <label>Durasi Film</label>
          <input type="text" class="form-control" name="duration" placeholder="1 Jam 30 Menit">
        </div>
        <div class="form-group">
          <label>Panduan Umur</label>
          <input type="text" class="form-control" name="age" placeholder="Contoh : 18+">
        </div>
        <div class="form-group">
          <label>Link Trailer</label>
          <input type="text" class="form-control" name="link_trailer">
        </div>
        <div class="form-group">
          <div class="callout callout-warning">
            <p>Panduan Ukuran Gambar: L: 192px T: 270px</p>
          </div>
        </div>
        <div class="form-group">
          <label>Gambar</label>
          <input type="file" name="userfile">
        </div>
        <hr>
        <div class="form-group">
          <label>Upload Film</label>
          <input type="file" name="movie">
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
