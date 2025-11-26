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
          <label>Judul Film</label>
          <select name="movie_id" class="form-control">
            <?php 
            $movies = $this->db->get('movies')->result();
            foreach ( $movies as $movie) { ?>
              <option value="<?php echo $movie->id;?>"><?php echo $movie->title;?></option>
            <?php }
            ?>
          </select>
        </div>
        <div class="form-group">
          <label>Nama</label>
          <input type="text" class="form-control" name="name">
        </div>
        <div class="form-group">
          <label>Komentar</label>
          <textarea name="comment" class="form-control" rows="10"></textarea>
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