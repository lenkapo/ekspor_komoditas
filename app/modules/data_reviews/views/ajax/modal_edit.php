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
        <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
        <!-- KONTEN -->
        <div class="form-group">
          <label>Judul Film</label>
          <select name="movie_id" class="form-control">
            <?php 
            $movies = $this->db->get('movies')->result();
            foreach ( $movies as $movie) { ?>
              <option value="<?php echo $movie->id;?>"
                <?php if($value->movie_id == $movie->id) { ?> selected="selected"<?php }?>
              ><?php echo $movie->title;?></option>
            <?php }
            ?>
          </select>
        </div>
        <div class="form-group">
          <label>Nama</label>
          <input type="text" class="form-control" name="name" value="<?php echo $value->name; ?>">
        </div>
        <div class="form-group">
          <label>Judul Review</label>
          <input type="text" class="form-control" name="title" value="<?php echo $value->title; ?>">
        </div>
        <div class="form-group">
          <label>Isi Review</label>
          <textarea name="review" class="form-control" rows="10"><?php echo $value->review;?></textarea>
        </div>
        <hr>
        <div class="form-group">
          <label>Rating</label>
          <input type="number" min="0" max="10" class="form-control" name="rating" value="<?php echo $value->rating; ?>" step="0.5">
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