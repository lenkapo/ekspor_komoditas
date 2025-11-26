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
        <label>Judul</label>
        <input type="text" class="form-control" name="title" value="<?php echo $value->title; ?>">
      </div>
      <div class="form-group">
        <label>Deskripsi</label>
        <textarea name="description" class="form-control" rows="10"><?php echo $value->description; ?></textarea>
      </div>
      <div class="form-group">
        <label>Kategori</label>
        <select name="categories[]" class="form-control" multiple>
          <?php
          $categories = $this->db->get('categories')->result();
          foreach ($categories as $category) { ?>
            <option value="<?php echo $category->id; ?>"
              <?php
              $this->db->where('movie_id', $value->id);
              $list = $this->db->get('movie_categories')->result();
              foreach ($list as $key => $valuex) {
                if ($valuex->category_id == $category->id) {
                  echo 'selected="selected"';
                }
              }
              ?>><?php echo $category->name; ?></option>
          <?php }
          ?>
        </select>
      </div>
      <div class="form-group">
        <label>Rating</label>
        <input type="number" class="form-control" name="rating" min="0" max="10" value="<?php echo $value->rating; ?>">
      </div>
      <div class="form-group">
        <label>Featured</label>
        <input type="number" class="form-control" name="featured" min="0" max="4" value="<?php echo $value->is_featured; ?>">
      </div>
      <div class="form-group">
        <label>Tahun Rilis</label>
        <input type="text" class="form-control" name="year" value="<?php echo $value->year; ?>">
      </div>
      <div class="form-group">
        <label>Durasi Film</label>
        <input type="text" class="form-control" name="duration" placeholder="1 Jam 30 Menit" value="<?php echo $value->duration; ?>">
      </div>
      <div class="form-group">
        <label>Panduan Umur</label>
        <input type="text" class="form-control" name="age" placeholder="Contoh : 18+" value="<?php echo $value->age; ?>">
      </div>
      <div class="form-group">
        <label>Link Trailer</label>
        <input type="text" class="form-control" name="link_trailer" value="<?php echo $value->link_trailer; ?>">
      </div>
      <div class="form-group">
        <div class="callout callout-warning">
          <p>Panduan Ukuran Gambar: L: 192px T: 270px</p>
        </div>
      </div>
      <div class="form-group">
        <label>Gambar</label>
        <div class="col-md-4">
          <?php if ($value->picture != "") { ?>
            <img src="<?php echo base_url('assets/movies/') . $value->picture; ?>" width="100%">
          <?php } ?>
        </div>
        <input type="hidden" name="userfile_lama" value="<?php echo $value->picture; ?>">
        <input type="file" name="userfile">
      </div>
      <br>
      <hr>
      <div class="form-group">
        <label>Upload Film</label>
        <input type="hidden" name="movie_lama" value="<?php echo $value->file_movie; ?>">
        <input type="file" name="movie">
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