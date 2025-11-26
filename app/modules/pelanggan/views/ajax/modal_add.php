<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/temaalus/dist/css/bootstrap-datetimepicker.min.css">
<script src="<?php echo base_url(); ?>assets/temaalus/dist/js/bootstrap-datetimepicker.min.js"></script>
<script src="<?php echo base_url(); ?>assets/temaalus/plugin/jQuery/jquery-2.2.3.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/bootstrap/jquery.min.js') ?>"></script>
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Data Pelanggan</h4>
    </div>
    <div class="modal-body">
        <!-- FORM -->
        <form id="form_add">
            <!-- KONTEN -->
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
            <div class="form-group">
                <label>Nama</label>
                <input type="text" class="form-control" name="nama">
            </div>
            <div class="form-group">
                <label>Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-control">
                    <option value="">----- Silakan Pilih Jenis Kelamin -----</option>
                    <option value="Pria">Pria</option>
                    <option value="Wanita">Wanita</option>
                    <option value="Lainya">Lainya</option>
                </select>
            </div>
            <div class="form-group">
                <label>No. Telephone</label>
                <input type="number" class="form-control" name="telepon">
            </div>
            <!-- <div class='form-group'>
                <label>Provinsi</label>
                <select class='form-control' id='provinsi' name="provinsi">
                    <option value='0'>--pilih--</option>
                    <?php
                    foreach ($provinsi as $prov) {
                        echo "<option value='$prov[id]'>$prov[name]</option>";
                    }
                    ?>
                </select>
            </div>

            <div class='form-group'>
                <label>Kabupaten/kota</label>
                <select class='form-control' id='kabupaten-kota' name="kabupaten">
                    <option value='0'>--pilih--</option>
                </select>
            </div>


            <div class='form-group'>
                <label>Kecamatan</label>
                <select class='form-control' id='kecamatan' name="kecamatan">
                    <option value='0'>--pilih--</option>
                </select>
            </div>


            <div class='form-group'>
                <label>Kelurahan/desa</label>
                <select class='form-control' id='kelurahan-desa' name="kelurahan">
                    <option value='0'>--pilih--</option>
                </select>
            </div> -->
            <div class="form-group">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control" rows="10"></textarea>
            </div>
            <div class="form-group">
                <label>Jenis</label>
                <select name="jenis_id" class="form-control">
                    <?php
                    $jenis = $this->db->get('jenis')->result();
                    foreach ($jenis as $j) { ?>
                        <option value="<?php echo $j->id; ?>"><?php echo $j->s_jenis; ?></option>
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
<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            type: "POST",
            url: "<?php echo base_url('/pelanggan/ambil_data') ?>",
            cache: false,
        });

        $("#provinsi").change(function() {

            var value = $(this).val();
            if (value > 0) {
                $.ajax({
                    data: {
                        modul: 'kabupaten',
                        id: value
                    },
                    success: function(respond) {
                        $("#kabupaten-kota").html(respond);
                    }
                })
            }

        });


        $("#kabupaten-kota").change(function() {
            var value = $(this).val();
            if (value > 0) {
                $.ajax({
                    data: {
                        modul: 'kecamatan',
                        id: value
                    },
                    success: function(respond) {
                        $("#kecamatan").html(respond);
                    }
                })
            }
        })

        $("#kecamatan").change(function() {
            var value = $(this).val();
            if (value > 0) {
                $.ajax({
                    data: {
                        modul: 'kelurahan',
                        id: value
                    },
                    success: function(respond) {
                        $("#kelurahan-desa").html(respond);
                    }
                })
            }
        })

    })
</script>