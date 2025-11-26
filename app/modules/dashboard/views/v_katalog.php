<div class="content-wrapper">
    <section class="content-header">
        <h1>Katalog: <?= $kategori_aktif ?></h1>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <button class="btn btn-primary" data-toggle="modal" data-target="#modalTambah">
                    <i class="fas fa-plus"></i> Tambah <?= $kategori_aktif ?>
                </button>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover" id="example1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Nama Produk</th>
                            <th>HS Code</th>
                            <th>Stok</th>
                            <th>Negara Tujuan</th>
                            <th>Nilai Ekspor</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($items as $row): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><img src="<?= base_url('uploads/' . $row->gambar) ?>" width="50"></td>
                                <td><?= $row->nama_produk ?></td>
                                <td><?= $row->hs_code ?></td>
                                <td><?= $row->stok . ' ' . $row->satuan ?></td>
                                <td><?= $row->negara_tujuan ?></td>
                                <td>Rp <?= number_format($row->nilai_ekspor, 0, ',', '.') ?></td>
                                <td>
                                    <a href="#" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                    <a href="#" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="modalTambah">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah <?= $kategori_aktif ?></h4>
            </div>
            <form>
                <div class="modal-body">
                    <input type="hidden" name="kategori" value="<?= $kategori_aktif ?>">
                    <div class="form-group">
                        <label>Nama Produk</label>
                        <input type="text" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>