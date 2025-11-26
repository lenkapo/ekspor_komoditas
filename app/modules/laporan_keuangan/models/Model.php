<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model extends CI_Model
{
    public function get_keuangan_bulanan($bulan, $tahun)
    {
        $this->db->select('*');
        $this->db->from('tb_ikan');
        $this->db->where('MONTH(created_at)', $bulan);
        $this->db->where('YEAR(created_at)', $tahun);
        $this->db->order_by('created_at', 'ASC');
        return $this->db->get()->result();
    }
}
