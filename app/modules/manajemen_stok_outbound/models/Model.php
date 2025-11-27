<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model extends CI_Model
{

    // Mengambil semua data transaksi ekspor (JOIN dengan tb_stok untuk detail produk)
    public function get_all_transaksi()
    {
        // i: tb_ikan (Transaksi), s: tb_stok, m: tb_ikan (Master Komoditas)

        $this->db->select('i.*, s.komoditas, s.sumber_asal, m.nama_latin AS produk_latin');
        $this->db->from('tb_ikan i');

        // JOIN 1: Transaksi ke Stok (Kunci: Lot Number)
        $this->db->join('tb_stok s', 's.lot_number = i.lot_number_fk', 'left');

        // JOIN 2: Stok ke Tabel Master Komoditas (Kunci: Komoditas)
        $this->db->join('tb_ikan m', 'm.nama_produk = s.komoditas', 'left');

        $this->db->order_by('i.tanggal_ekspor', 'DESC');
        return $this->db->get()->result();
    }

    // Menyimpan data transaksi ekspor baru ke tb_ikan
    public function add_transaksi($data)
    {
        return $this->db->insert('tb_ikan', $data);
    }

    public function get_available_lots()
    {
        $this->db->where('stok_tersedia_kg >', 0);
        $this->db->where('status_kualitas !=', 'Ditolak');
        $this->db->order_by('tanggal_kadaluarsa', 'ASC'); // FEFO: Utamakan yang mendekati kadaluarsa
        return $this->db->get('tb_stok')->result();
    }

    public function update_stok_outbound($lot_number, $qty_ekspor)
    {
        // Ambil data stok saat ini
        $stok = $this->get_stok_by_lot($lot_number);

        // Validasi 1: Cek apakah Lot ada
        if (!$stok) {
            return FALSE;
        }

        // Validasi 2: Cek ketersediaan stok
        if ($stok->stok_tersedia_kg < $qty_ekspor) {
            return FALSE; // Stok tidak cukup
        }

        // Lakukan UPDATE: Kurangi stok tersedia dan tambah stok dialokasikan
        $this->db->set('stok_tersedia_kg', 'stok_tersedia_kg - ' . $qty_ekspor, FALSE);
        $this->db->set('stok_dialokasikan_kg', 'stok_dialokasikan_kg + ' . $qty_ekspor, FALSE);
        $this->db->where('lot_number', $lot_number);
        return $this->db->update('tb_stok');
    }
    public function get_stok_by_lot($lot_number)
    {
        // Menggunakan get_where untuk mengambil satu baris berdasarkan Lot Number
        return $this->db->get_where('tb_stok', ['lot_number' => $lot_number])->row();
    }
}
