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

    // 3. Ambil detail satu stok
    public function get_stok_by_lot($lot_number)
    {
        return $this->db->get_where('tb_stok', array('lot_number' => $lot_number))->row();
    }

    // 4. Proses Alokasi/Pengurangan Stok (Outbound)
    public function update_stok_outbound($lot_number, $qty_ekspor)
    {
        $stok = $this->get_stok_by_lot($lot_number);

        if (!$stok) {
            return FALSE; // Lot Number tidak ditemukan
        }

        $sisa_tersedia = $stok->stok_tersedia_kg - $qty_ekspor;
        $dialokasikan_baru = $stok->stok_dialokasikan_kg + $qty_ekspor;

        // Pastikan stok mencukupi
        if ($sisa_tersedia < 0) {
            // Ini harus ditangani di Controller (validasi)
            return FALSE;
        }

        $data_update = array(
            'stok_tersedia_kg' => $sisa_tersedia,
            'stok_dialokasikan_kg' => $dialokasikan_baru
        );

        $this->db->where('lot_number', $lot_number);
        return $this->db->update('tb_stok', $data_update);
    }

    // 5. Ambil Stok yang Tersedia Saja (untuk form ekspor)
    public function get_available_lots()
    {
        $this->db->where('stok_tersedia_kg >', 0);
        $this->db->order_by('tanggal_masuk', 'ASC'); // Prioritas FIFO
        return $this->db->get('tb_stok')->result();
    }
}
