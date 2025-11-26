<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model extends CI_Model
{
    // 1. Ambil daftar nama produk unik untuk dropdown filter
    public function get_list_jenis()
    {
        $this->db->distinct();
        $this->db->select('nama_produk'); // Mengambil nama dagang (bukan latin)
        $this->db->from('tb_ikan');
        $this->db->order_by('nama_produk', 'ASC');
        return $this->db->get()->result();
    }

    // 2. Ambil Data Laporan (Filter Bulan, Tahun, & Jenis)
    public function get_data_per_jenis($bulan, $tahun, $jenis = 'all')
    {
        $this->db->select('*');
        $this->db->from('tb_ikan');

        // Filter Wajib: Waktu
        $this->db->where('MONTH(created_at)', $bulan);
        $this->db->where('YEAR(created_at)', $tahun);

        // Filter Opsional: Jenis Ikan
        if ($jenis != 'all' && !empty($jenis)) {
            // Gunakan LIKE agar pencarian lebih fleksibel jika ada variasi nama
            $this->db->like('nama_produk', $jenis);
        }

        // Urutkan berdasarkan Nama Produk, lalu Negara
        $this->db->order_by('nama_produk', 'ASC');
        $this->db->order_by('negara_tujuan', 'ASC');

        return $this->db->get()->result();
    }
}
