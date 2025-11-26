<?php defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_per_jenis_ikan extends CI_Controller
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
            $jenis  = $this->input->get('jenis'); // Nama produk

            // Default: Bulan/Tahun saat ini, Jenis = Semua
            if (empty($bulan)) $bulan = date('m');
            if (empty($tahun)) $tahun = date('Y');
            if (empty($jenis)) $jenis = 'all';

            // --- 2. PERSIAPAN DATA ---
            $data['title']       = 'Laporan per Jenis Ikan';
            $data['bulan_pilih'] = $bulan;
            $data['tahun_pilih'] = $tahun;
            $data['jenis_pilih'] = $jenis;

            // Ambil list jenis ikan untuk dropdown
            $data['list_jenis'] = $this->Alus_items->get_list_jenis();

            // Ambil data laporan utama
            $data['laporan'] = $this->Alus_items->get_data_per_jenis($bulan, $tahun, $jenis);

            // --- 3. HITUNG GRAND TOTAL ---
            $data['grand_qty'] = 0;
            $data['grand_total_uang'] = 0;

            foreach ($data['laporan'] as $row) {
                $data['grand_qty'] += $row->stok_kg;

                // Rumus: Total Uang = Berat(Kg) * Harga Satuan(USD)
                $total_per_baris = $row->stok_kg * $row->harga_usd;
                $data['grand_total_uang'] += $total_per_baris;
            }

            $this->load->view('template/temaalus/header', $head);
            $this->load->view('index', $data);
            $this->load->view('template/temaalus/footer');
        } else {
            redirect('admin/login', 'refresh');
        }
    }
}
