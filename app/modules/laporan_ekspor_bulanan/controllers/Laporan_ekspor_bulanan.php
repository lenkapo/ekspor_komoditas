<?php defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_ekspor_bulanan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model', 'Alus_items');
    }

    public function index()
    {
        if ($this->alus_auth->logged_in()) {
            $title_head = "Laporan Ekspor Bulanan";
            $head['title'] = $title_head;
            $data['title_head'] = $title_head;

            // 1. Ambil input dari user (GET method)
            $bulan = $this->input->get('bulan');
            $tahun = $this->input->get('tahun');

            // 2. Jika kosong, set default ke bulan/tahun saat ini
            if (empty($bulan) || empty($tahun)) {
                $bulan = date('m');
                $tahun = date('Y');
            }

            $data['title'] = "Laporan Ekspor Periode $bulan-$tahun";
            $data['bulan_pilih'] = $bulan;
            $data['tahun_pilih'] = $tahun;

            // 3. Ambil Data dari Model
            $data['laporan'] = $this->Alus_items->get_laporan_bulanan($bulan, $tahun);

            // 4. Hitung Total untuk Footer Laporan
            $data['total_qty'] = 0;
            $data['total_nilai'] = 0;
            foreach ($data['laporan'] as $row) {
                $data['total_qty'] += $row->stok_kg; // Asumsi kolom stok adalah yg diekspor
                $data['total_nilai'] += $row->harga_usd;
            }

            $this->load->view('template/temaalus/header', $head);
            $this->load->view('index', $data);
            $this->load->view('template/temaalus/footer');
        } else {
            redirect('admin/login', 'refresh');
        }
    }
}
