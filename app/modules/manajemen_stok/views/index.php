<script src="<?php echo base_url(); ?>assets/temaalus/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="<?php echo base_url(); ?>assets/temaalus/plugins/jquery-validation/dist/additional-methods.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Manajemen Stok
            <small></small>
        </h1>
    </section>


</div>
<div class="modal fade" id="modalTambah">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Tambah Komoditas Baru</h4>
            </div>
            <form action="<?= base_url('data_ikan/simpan'); ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">

                    <div class="form-group">
                        <label>Nama Produk (Contoh: Tuna Loin)</label>
                        <input type="text" name="nama_produk" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Tanggal Transaksi (Pengiriman/Pencatatan)</label>
                        <input type="date" class="form-control" name="tanggal_transaksi" required>
                    </div>

                    <div class="form-group">
                        <label>Nama Latin (Contoh: Thunnus albacares)</label>
                        <input type="text" name="nama_latin" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Jenis Olahan</label>
                        <select name="jenis_olahan" class="form-control" required>
                            <option value="Frozen">Frozen</option>
                            <option value="Fresh">Fresh</option>
                            <option value="Live">Live</option>
                            <option value="Fillet">Fillet</option>
                            <option value="Canned">Canned</option>
                            <option value="Dried">Dried</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Grade / Kualitas</label>
                        <input type="text" name="grade" class="form-control" placeholder="Contoh: AAA / Sashimi Grade">
                    </div>

                    <div class="form-group">
                        <label>Negara Tujuan</label>
                        <input type="text" name="negara_tujuan" class="form-control" placeholder="Contoh: Japan, USA" required>
                    </div>
                    <div class="form-group">
                        <label>Pelabuhan Asal Ekspor</label>
                        <select name="id_pelabuhan_asal" class="form-control" required>
                            <option value="">-- Pilih Pelabuhan Asal --</option>
                            <?php foreach ($pelabuhan as $port): ?>
                                <option value="<?= $port->id_pelabuhan; ?>">
                                    <?= $port->nama_pelabuhan; ?> (<?= $port->kode_pelabuhan; ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Stok / Volume (Kg)</label>
                        <input type="number" name="stok_kg" class="form-control" min="1" required>
                    </div>

                    <hr>
                    <h4><i class="fa fa-dollar"></i> Data Keuangan</h4>

                    <div class="form-group">
                        <label>Harga Jual (USD) / Kg</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                            <input type="number" name="harga_usd" class="form-control" step="0.01" placeholder="0.00" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="text-red">Biaya Operasional (Total Cost)</label>
                        <div class="input-group">
                            <span class="input-group-addon" style="background-color: #f2dede; color: #a94442;">
                                <b>- $</b>
                            </span>
                            <input type="number" name="biaya_operasional" class="form-control" step="0.01" value="0" placeholder="0.00">
                        </div>
                        <small class="text-muted">Total biaya pengiriman, handling, dll. untuk batch ini.</small>
                    </div>

                    <div class="form-group">
                        <label>Foto Produk (Gambar)</label>
                        <input type="file" name="gambar" class="form-control">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modalEdit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-yellow">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Komoditas</h4>
            </div>
            <form action="<?= base_url('data_ikan/update'); ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="id_ikan" id="edit_id">
                    <input type="hidden" name="gambar_lama" id="edit_gambar_lama">

                    <div class="form-group">
                        <label>Nama Produk</label>
                        <input type="text" name="nama_produk" id="edit_nama" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Tanggal Transaksi (Pengiriman/Pencatatan)</label>
                        <input type="date" class="form-control" name="tanggal_transaksi" id="edit_tanggal" required>
                    </div>

                    <div class="form-group">
                        <label>Nama Latin</label>
                        <input type="text" name="nama_latin" id="edit_latin" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Jenis Olahan</label>
                        <select name="jenis_olahan" id="edit_olahan" class="form-control" required>
                            <option value="Frozen">Frozen</option>
                            <option value="Fresh">Fresh</option>
                            <option value="Live">Live</option>
                            <option value="Fillet">Fillet</option>
                            <option value="Canned">Canned</option>
                            <option value="Dried">Dried</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Grade / Kualitas</label>
                        <input type="text" name="grade" id="edit_grade" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Negara Tujuan</label>
                        <input type="text" name="negara_tujuan" id="edit_tujuan" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Pelabuhan Asal Ekspor</label>
                        <select name="id_pelabuhan_asal" id="edit_pelabuhan" class="form-control" required>
                            <option value="">-- Pilih Pelabuhan Asal --</option>
                            <?php foreach ($pelabuhan as $port): ?>
                                <option value="<?= $port->id_pelabuhan; ?>">
                                    <?= $port->nama_pelabuhan; ?> (<?= $port->kode_pelabuhan; ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Stok / Volume (Kg)</label>
                        <input type="number" name="stok_kg" id="edit_stok" class="form-control" min="1" required>
                    </div>

                    <hr>
                    <h4><i class="fa fa-dollar"></i> Update Data Keuangan</h4>

                    <div class="form-group">
                        <label>Harga Jual (USD) / Kg</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                            <input type="number" name="harga_usd" id="edit_harga" class="form-control" step="0.01" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="text-red">Biaya Operasional (Total Cost)</label>
                        <div class="input-group">
                            <span class="input-group-addon" style="background-color: #f2dede; color: #a94442;">
                                <b>- $</b>
                            </span>
                            <input type="number" name="biaya_operasional" id="edit_biaya" class="form-control" step="0.01" value="0">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Foto Produk (Ganti Gambar)</label>
                        <input type="file" name="gambar" class="form-control">
                        <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar.</small>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        // Inisialisasi DataTables
        $('#dataTableIkan').DataTable({
            "order": [
                [0, "desc"]
            ] // Urutkan berdasarkan kolom pertama (ID) secara descending
        });

        // Skrip untuk mengisi data ke Modal Edit saat tombol Edit diklik
        $('.btn-edit').on('click', function() {
            // Ambil data dari atribut data-* tombol
            const id = $(this).data('id');
            const nama = $(this).data('nama');
            const latin = $(this).data('latin');
            const olahan = $(this).data('olahan');
            const grade = $(this).data('grade');
            const asal = $(this).data('asal');
            const tujuan = $(this).data('tujuan');
            const stok = $(this).data('stok');
            const harga = $(this).data('harga');
            const biaya = $(this).data('biaya'); // DATA BARU: BIAYA OPERASIONAL
            const gambar = $(this).data('gambar');
            const tanggal = $(this).data('tanggal'); // Ambil nilai tanggal
            const pelabuhanId = $(this).data('pelabuhan'); // AMBIL ID BARU

            // Isi data ke Form Edit
            $('#edit_id').val(id);
            $('#edit_nama').val(nama);
            $('#edit_latin').val(latin);
            $('#edit_grade').val(grade);
            $('#edit_stok').val(stok);
            $('#edit_tujuan').val(tujuan);
            $('#edit_gambar_lama').val(gambar);

            // Isi Data Keuangan
            $('#edit_harga').val(harga);
            $('#edit_biaya').val(biaya); // ISI DATA BARU

            // Isi data select box Jenis Olahan
            $('#edit_olahan').val(olahan).change();

            // ISI FIELD TANGGAL
            $('#edit_tanggal').val(tanggal);

            // ISI DROPDOWN PELABUHAN DENGAN ID YANG SESUAI
            $('#edit_pelabuhan').val(pelabuhanId).change();

            // Tampilkan Modal Edit
            $('#modalEdit').modal('show');
        });
    });
</script>