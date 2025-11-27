<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model extends CI_Model
{
    // 1. Ambil semua data stok
    public function get_all_stok()
    {
        return $this->db->get('tb_stok')->result();
    }

    // 2. Tambah data stok baru (Inbound)
    public function add_stok($data)
    {
        return $this->db->insert('tb_stok', $data);
    }

    /**
     * Mengurangi stok tersedia dan menambah alokasi berdasarkan Lot Number
     * @param string $lot_number
     * @param float $qty_ekspor
     * @return bool TRUE jika berhasil update, FALSE jika stok tidak cukup.
     */
    public function update_stok_outbound($lot_number, $qty_ekspor)
    {
        // Ambil data stok saat ini
        $stok = $this->get_all_stok($lot_number);

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

    /**
     * Mengambil Lot yang Tersedia (Stok Tersedia > 0) untuk dropdown form ekspor
     */
    public function get_available_lots()
    {
        $this->db->where('stok_tersedia_kg >', 0);
        $this->db->where('status_kualitas !=', 'Ditolak');
        $this->db->order_by('tanggal_kadaluarsa', 'ASC'); // FEFO: Utamakan yang mendekati kadaluarsa
        return $this->db->get('tb_stok')->result();
    }
}
