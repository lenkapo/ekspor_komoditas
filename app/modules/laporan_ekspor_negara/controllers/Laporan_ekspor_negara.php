<?php defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_ekspor_negara extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model', 'Alus_items');
    }

    public function index()
    {
        if ($this->alus_auth->logged_in()) {
            $title_head = "Laporan Ekspor Negara";
            $head['title'] = $title_head;
            $data['title_head'] = $title_head;

            // --- 1. AMBIL INPUT FILTER ---
            $bulan  = $this->input->get('bulan');
            $tahun  = $this->input->get('tahun');
            $negara = $this->input->get('negara');

            // Default: Bulan/Tahun saat ini, Negara = Semua
            if (empty($bulan)) $bulan = date('m');
            if (empty($tahun)) $tahun = date('Y');
            if (empty($negara)) $negara = 'all';

            // --- 2. PERSIAPAN DATA ---
            $data['title']       = 'Laporan Ekspor per Negara';
            $data['bulan_pilih'] = $bulan;
            $data['tahun_pilih'] = $tahun;
            $data['negara_pilih'] = $negara;

            // Ambil list negara untuk dropdown
            $data['list_negara'] = $this->Alus_items->get_list_negara();

            // Ambil data laporan utama
            $data['laporan'] = $this->Alus_items->get_data_per_negara($bulan, $tahun, $negara);

            // --- 3. HITUNG TOTAL (Grand Total) ---
            $data['grand_qty'] = 0;
            $data['grand_nilai'] = 0;
            foreach ($data['laporan'] as $row) {
                $data['grand_qty']   += $row->stok_kg;
                $data['grand_nilai'] += $row->harga_usd;
            }

            $this->load->view('template/temaalus/header', $head);
            $this->load->view('index', $data);
            $this->load->view('template/temaalus/footer');
        } else {
            redirect('admin/login', 'refresh');
        }
    }
}
