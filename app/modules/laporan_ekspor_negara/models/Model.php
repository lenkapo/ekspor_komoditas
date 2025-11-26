<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model extends CI_Model
{
    // 1. Ambil daftar negara unik untuk dropdown filter
    public function get_list_negara()
    {
        $this->db->distinct();
        $this->db->select('negara_tujuan');
        $this->db->from('tb_ikan');
        $this->db->order_by('negara_tujuan', 'ASC');
        return $this->db->get()->result();
    }

    // 2. Ambil Data Laporan (Filter Bulan, Tahun, & Negara)
    public function get_data_per_negara($bulan, $tahun, $negara = 'all')
    {
        $this->db->select('*');
        $this->db->from('tb_ikan');

        // Filter Wajib: Waktu
        $this->db->where('MONTH(created_at)', $bulan);
        $this->db->where('YEAR(created_at)', $tahun);

        // Filter Opsional: Negara
        if ($negara != 'all' && !empty($negara)) {
            $this->db->where('negara_tujuan', $negara);
        }

        // Urutkan berdasarkan Negara dulu, baru Tanggal
        $this->db->order_by('negara_tujuan', 'ASC');
        $this->db->order_by('created_at', 'ASC');

        return $this->db->get()->result();
    }
}
