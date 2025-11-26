<script src="<?php echo base_url(); ?>assets/temaalus/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="<?php echo base_url(); ?>assets/temaalus/plugins/jquery-validation/dist/additional-methods.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

<div class="content-wrapper" style="min-height: 901px;">
    <section class="content-header">
        <h1>
            <?php echo $title_head; ?>
            <small>Barang</small>
        </h1>
    </section>

    <section class="content">
        <div class="box box-primary">
            <div class="box-header" style="background: #3c8dbc; color:white;">
                <div class="col-md-6" style="padding: 1px;">
                    <button id="btn-print-barang" class="btn btn-default">
                        <i class="fa fa-print"></i> Print Table
                    </button>
                </div>
                <div class="button-group pull-right">
                    <a href="javascript:" data-toggle="modal" data-target="#modal_add" onClick="btn_modal_add()" class="btn btn-xs btn-default"><i class="fa fa-plus"></i> Tambah <?php echo $title_head; ?></a>
                    <button class="btn btn-xs btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Refresh</button>
                </div>
            </div>
            <div class="box-body">
                <table id="table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="1%">No</th>
                            <th>ID Barang</th>
                            <th>Nama Barang</th>
                            <th width="100px">Jenis Barang</th>
                            <th width="100px">Stok Barang</th>
                            <th width="100px">Satuan Barang </th>
                            <th class="no-print" width="100px">Tools</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </section>

</div>


<!-- MODAL CSS -->

<div class="modal fade" id="modal_add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div id="mark_addform"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_view" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div id="mark_viewform"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div id="mark_editform"></div>
        </div>
    </div>
</div>

<!-- END MODAL CSS -->


<script type="text/javascript">
    var save_method; //for save method string
    var table;
    var base_url = '<?php echo base_url(); ?>';
    $(document).ready(function() {

        table = $('#table').DataTable({
            buttons: ['copy', 'csv', 'print', 'excel', 'pdf'],
            dom: '<"row"<"col-sm-6"l><"col-sm-6"f>>rt<"bottom"i>p<"clear">',
            "processing": true,
            "serverSide": true,
            "scrollX": true,

            "ajax": {
                "url": "<?php echo base_url() . $this->uri->segment(1); ?>/ajax_list",
                "type": "POST",
                "error": function(jqXHR, textStatus, errorThrown) {
                    //console.log(textStatus+errorThrown);
                    reload_table();
                },
            },
            "columnDefs": [{
                    "targets": [-1],
                    "orderable": false,
                    "className": "text-center",
                },
                {
                    "targets": [0],
                    "className": "text-center",
                },
            ],
            "lengthMenu": [
                [10, 25, 100, 1000, -1],
                [10, 25, 100, 1000, "All"]
            ],
            "buttons": [{
                extend: 'print',
                text: 'Print',
                autoPrint: true,
                exportOptions: {
                    columns: ':not(:last-child)', // Hanya print kolom yang terlihat
                },
                customize: function(win) {
                    // 1. Atur CSS Dasar untuk Halaman Print
                    $(win.document.body).css('font-family', 'Arial, sans-serif');

                    // 2. Merapikan Judul Laporan (Tengah & Besar)
                    $(win.document.body).find('h1')
                        .css('text-align', 'center')
                        .css('margin-bottom', '20px')
                        .css('font-size', '24px');

                    // 3. Mengambil elemen tabel di halaman print
                    var table = $(win.document.body).find('table');

                    // 4. Styling Tabel (Lebar Penuh & Border Rapi)
                    table
                        .addClass('compact')
                        .css('font-size', '12px')
                        .css('width', '100%')
                        .css('border-collapse', 'collapse'); // Agar garis menyatu

                    // 5. Styling Header Tabel (Background Abu-abu & Tebal)
                    table.find('thead th').css({
                        'background-color': '#f2f2f2', // Warna abu-abu muda
                        'color': '#000',
                        'text-align': 'center',
                        'border': '1px solid #000', // Garis hitam tegas
                        'padding': '8px'
                    });

                    // 6. Styling Isi Tabel (Garis batas tiap sel)
                    table.find('tbody td').css({
                        'border': '1px solid #000',
                        'padding': '6px',
                        'vertical-align': 'middle'
                    });

                    // 7. PERATAAN KOLOM KHUSUS (Meratakan kolom tertentu)
                    // Ingat: nth-child hitungannya mulai dari 1

                    // Kolom 1 (No) -> Tengah
                    table.find('tbody td:nth-child(1)').css('text-align', 'left');

                    // Kolom 2 (ID Barang) -> Tengah
                    table.find('tbody td:nth-child(2)').css('text-align', 'left');

                    // Kolom 5 (Stok) -> Tengah (atau kanan jika mau)
                    table.find('tbody td:nth-child(5)').css('text-align', 'center');

                    // Kolom 6 (Satuan) -> Tengah
                    table.find('tbody td:nth-child(6)').css('text-align', 'center');
                }
            }],
            // Sembunyikan tombol bawaan agar kita bisa pakai tombol custom di atas
        });

        // 3. Hubungkan Tombol HTML Anda dengan fungsi Print DataTables
        $('#btn-print-barang').on('click', function() {
            table.button('.buttons-print').trigger();
        });
    });

    function reload_table() {
        table.ajax.reload(null, false); //reload datatable ajax 
    }

    /*FUNCTION MODAL*/

    function btn_modal_add() {
        $.ajax({
            url: base_url + "<?php echo $this->uri->segment(1); ?>/modal_add",
            cache: false,
            indicatorId: '#load_ajax',
            beforeSend: function() {
                $('#load_ajax').fadeIn(100);
            },
            success: function(msg) {
                $('#modal_add').modal('show');
                $('#load_ajax').fadeOut(100);
                $("#mark_addform").html(msg);
            }
        });
    }


    function btn_modal_edit(id) {
        $.ajax({
            url: base_url + "<?php echo $this->uri->segment(1); ?>/modal_edit/" + id,
            cache: false,
            indicatorId: '#load_ajax',
            beforeSend: function() {
                $('#load_ajax').fadeIn(100);
            },
            success: function(msg) {
                $('#modal_edit').modal('show');
                $('#load_ajax').fadeOut(100);
                $("#mark_editform").html(msg);
            }
        });
    }

    function btn_modal_delete(id) {
        var r = confirm("Anda Yakin Hapus !");

        if (r == true) {
            btn_save_delete(id);
        } else {
            popup("Batal");
        }
    }

    /*FUNCTION ACTION*/

    function btn_save_add() {
        $('#form_add').validate();
        var isvalid = $("#form_add").valid();
        if (isvalid == false) {
            alert(getvalues("form_add"));
            return false;
        };

        //var art_body = CKEDITOR.instances.editor1.getData();
        var formData = new FormData($('#form_add')[0]);
        //formData.append('tup_nama_kegiatan',art_body);
        /*Ajax Model*/
        $.ajax({
            type: "POST",
            url: base_url + "<?php echo $this->uri->segment(1); ?>/save",
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $('#load_ajax').fadeIn(100);
            },
            success: function(data) {
                $('#modal_add').modal('hide');
                $("#load_ajax").fadeOut(100);
                reload_table();
                popup("Data Tersimpan");
            }
        });
    }

    function btn_save_edit() {
        $('#form_edit').validate();
        var isvalid = $("#form_edit").valid();
        if (isvalid == false) {
            //alert(getvalues("form_add"));
            return false;
        };

        /*Nama Form ID*/
        //var art_body = CKEDITOR.instances.editor2.getData();
        var formData = new FormData($('#form_edit')[0]);
        //formData.append('tup_nama_kegiatan',art_body);
        /*Ajax Model*/
        $.ajax({
            type: "POST",
            url: base_url + "<?php echo $this->uri->segment(1); ?>/edit",
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $('#load_ajax').fadeIn(100);
            },
            success: function(data) {
                $('#modal_edit').modal('hide');
                $("#load_ajax").fadeOut(100);
                reload_table();
                popup("Data Edit Tersimpan");
            }
        });
    }

    function btn_save_delete(id) {
        $.ajax({
            url: base_url + "<?php echo $this->uri->segment(1); ?>/delete/" + id,
            cache: false,
            indicatorId: '#load_ajax',
            beforeSend: function() {
                $('#load_ajax').fadeIn(100);
            },
            success: function(msg) {
                $('#load_ajax').fadeOut(100);
                reload_table();
                popup("Data Terhapus");
            }
        });
    }
</script>