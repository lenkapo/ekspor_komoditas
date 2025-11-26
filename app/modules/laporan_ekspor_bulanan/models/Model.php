<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model extends CI_Model
{
    // Ambil data berdasarkan Bulan & Tahun dari kolom created_at
    public function get_laporan_bulanan($bulan, $tahun)
    {
        $this->db->select('*');
        $this->db->from('tb_ikan');
        $this->db->where('MONTH(created_at)', $bulan);
        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->order_by('created_at', 'ASC');

        return $this->db->get()->result();
    }

    // // Fungsi untuk generate ID barang otomatis
    // public function generate_id_barang()
    // {
    //     $this->db->select('RIGHT(barang.id_barang, 4) as kode', FALSE);
    //     $this->db->order_by('id_barang', 'DESC');
    //     $this->db->limit(1);
    //     $query = $this->db->get('barang');  // Ganti 'barang' dengan nama tabel Anda

    //     if ($query->num_rows() <> 0) {
    //         //jika kode barang sudah ada
    //         $data = $query->row();
    //         $kode = intval($data->kode) + 1;
    //     } else {
    //         //jika kode barang belum ada
    //         $kode = 1;
    //     }

    //     $kodemax = str_pad($kode, 4, "0", STR_PAD_LEFT); // Angka 4 menunjukkan jumlah digit nol
    //     $kodejadi = "BRG-" . $kodemax;    // BRG-0001
    //     return $kodejadi;
    // }
}
