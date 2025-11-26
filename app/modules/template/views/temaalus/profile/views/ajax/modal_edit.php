<?php foreach ($data as $key => $value); ?>
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel"><?php echo $title; ?></h4>
  </div>
  <div class="modal-body">
    <!-- FORM -->
    <form id="form_edit">
        <input type="hidden" name="id" value="<?php echo $value->id; ?>">
        <!-- KONTEN -->
        <div class="form-group">
          <label>provinsi</label>
          <input type="text" class="form-control" name="provinsi" value="<?php echo $value->provinsi; ?>">
        </div>
<div class="form-group">
          <label>provinsi_id</label>
          <input type="text" class="form-control" name="provinsi_id" value="<?php echo $value->provinsi_id; ?>">
        </div>
<div class="form-group">
          <label>kabkota</label>
          <input type="text" class="form-control" name="kabkota" value="<?php echo $value->kabkota; ?>">
        </div>
<div class="form-group">
          <label>kota_id</label>
          <input type="text" class="form-control" name="kota_id" value="<?php echo $value->kota_id; ?>">
        </div>
<div class="form-group">
          <label>nama</label>
          <input type="text" class="form-control" name="nama" value="<?php echo $value->nama; ?>">
        </div>
<div class="form-group">
          <label>noizin</label>
          <input type="text" class="form-control" name="noizin" value="<?php echo $value->noizin; ?>">
        </div>
<div class="form-group">
          <label>tglnoizin</label>
          <input type="text" class="form-control" name="tglnoizin" value="<?php echo $value->tglnoizin; ?>">
        </div>
<div class="form-group">
          <label>klproduk</label>
          <input type="text" class="form-control" name="klproduk" value="<?php echo $value->klproduk; ?>">
        </div>
<div class="form-group">
          <label>alamat</label>
          <input type="text" class="form-control" name="alamat" value="<?php echo $value->alamat; ?>">
        </div>
<div class="form-group">
          <label>telp</label>
          <input type="text" class="form-control" name="telp" value="<?php echo $value->telp; ?>">
        </div>
<div class="form-group">
          <label>namapimpinan</label>
          <input type="text" class="form-control" name="namapimpinan" value="<?php echo $value->namapimpinan; ?>">
        </div>
<div class="form-group">
          <label>pjawab</label>
          <input type="text" class="form-control" name="pjawab" value="<?php echo $value->pjawab; ?>">
        </div>
<div class="form-group">
          <label>jk</label>
          <input type="text" class="form-control" name="jk" value="<?php echo $value->jk; ?>">
        </div>
<div class="form-group">
          <label>pend_pjawab</label>
          <input type="text" class="form-control" name="pend_pjawab" value="<?php echo $value->pend_pjawab; ?>">
        </div>
<div class="form-group">
          <label>sert_pjawab</label>
          <input type="text" class="form-control" name="sert_pjawab" value="<?php echo $value->sert_pjawab; ?>">
        </div>
<div class="form-group">
          <label>tutup</label>
          <input type="text" class="form-control" name="tutup" value="<?php echo $value->tutup; ?>">
        </div>
<div class="form-group">
          <label>tahun</label>
          <input type="text" class="form-control" name="tahun" value="<?php echo $value->tahun; ?>">
        </div>
<div class="form-group">
          <label>image1</label>
          <input type="text" class="form-control" name="image1" value="<?php echo $value->image1; ?>">
        </div>
<div class="form-group">
          <label>image2</label>
          <input type="text" class="form-control" name="image2" value="<?php echo $value->image2; ?>">
        </div>
<div class="form-group">
          <label>image3</label>
          <input type="text" class="form-control" name="image3" value="<?php echo $value->image3; ?>">
        </div>
<div class="form-group">
          <label>image4</label>
          <input type="text" class="form-control" name="image4" value="<?php echo $value->image4; ?>">
        </div>
<div class="form-group">
          <label>root_id</label>
          <input type="text" class="form-control" name="root_id" value="<?php echo $value->root_id; ?>">
        </div>
<div class="form-group">
          <label>audit_status</label>
          <input type="text" class="form-control" name="audit_status" value="<?php echo $value->audit_status; ?>">
        </div>
<div class="form-group">
          <label>audit_user</label>
          <input type="text" class="form-control" name="audit_user" value="<?php echo $value->audit_user; ?>">
        </div>
<div class="form-group">
          <label>audit_time</label>
          <input type="text" class="form-control" name="audit_time" value="<?php echo $value->audit_time; ?>">
        </div>
<div class="form-group">
          <label>audit_approve</label>
          <input type="text" class="form-control" name="audit_approve" value="<?php echo $value->audit_approve; ?>">
        </div>
<div class="form-group">
          <label>audit_approve_user</label>
          <input type="text" class="form-control" name="audit_approve_user" value="<?php echo $value->audit_approve_user; ?>">
        </div>
<div class="form-group">
          <label>audit_approve_kota</label>
          <input type="text" class="form-control" name="audit_approve_kota" value="<?php echo $value->audit_approve_kota; ?>">
        </div>
<div class="form-group">
          <label>audit_approve_kota_user</label>
          <input type="text" class="form-control" name="audit_approve_kota_user" value="<?php echo $value->audit_approve_kota_user; ?>">
        </div>
<div class="form-group">
          <label>audit_approve_provinsi</label>
          <input type="text" class="form-control" name="audit_approve_provinsi" value="<?php echo $value->audit_approve_provinsi; ?>">
        </div>
<div class="form-group">
          <label>audit_approve_provinsi_user</label>
          <input type="text" class="form-control" name="audit_approve_provinsi_user" value="<?php echo $value->audit_approve_provinsi_user; ?>">
        </div>
<div class="form-group">
          <label>nik_penanggung_jawab</label>
          <input type="text" class="form-control" name="nik_penanggung_jawab" value="<?php echo $value->nik_penanggung_jawab; ?>">
        </div>
<div class="form-group">
          <label>npwp</label>
          <input type="text" class="form-control" name="npwp" value="<?php echo $value->npwp; ?>">
        </div>
<div class="form-group">
          <label>kode_pos_kantor</label>
          <input type="text" class="form-control" name="kode_pos_kantor" value="<?php echo $value->kode_pos_kantor; ?>">
        </div>
<div class="form-group">
          <label>kode_provinsi</label>
          <input type="text" class="form-control" name="kode_provinsi" value="<?php echo $value->kode_provinsi; ?>">
        </div>
<div class="form-group">
          <label>kode_kabkota</label>
          <input type="text" class="form-control" name="kode_kabkota" value="<?php echo $value->kode_kabkota; ?>">
        </div>
<div class="form-group">
          <label>tag_alamat_cabangpak</label>
          <input type="text" class="form-control" name="tag_alamat_cabangpak" value="<?php echo $value->tag_alamat_cabangpak; ?>">
        </div>
<div class="form-group">
          <label>latitude</label>
          <input type="text" class="form-control" name="latitude" value="<?php echo $value->latitude; ?>">
        </div>
<div class="form-group">
          <label>longitude</label>
          <input type="text" class="form-control" name="longitude" value="<?php echo $value->longitude; ?>">
        </div>
<div class="form-group">
          <label>kode_kecamatan</label>
          <input type="text" class="form-control" name="kode_kecamatan" value="<?php echo $value->kode_kecamatan; ?>">
        </div>
<div class="form-group">
          <label>kode_kelurahan</label>
          <input type="text" class="form-control" name="kode_kelurahan" value="<?php echo $value->kode_kelurahan; ?>">
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