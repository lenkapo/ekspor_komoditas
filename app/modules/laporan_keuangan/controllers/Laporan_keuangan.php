<?php defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_keuangan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model', 'Alus_items');
    }

    public function index()
    {
        if ($this->alus_auth->logged_in()) {
            $title_head = "Laporan Keuangan";
            $head['title'] = $title_head;
            $data['title_head'] = $title_head;

            // 1. Filter Input
            $bulan = $this->input->get('bulan') ? $this->input->get('bulan') : date('m');
            $tahun = $this->input->get('tahun') ? $this->input->get('tahun') : date('Y');

            $data['title']       = 'Laporan Pendapatan & Laba Rugi';
            $data['bulan_pilih'] = $bulan;
            $data['tahun_pilih'] = $tahun;

            // 2. Ambil Data
            $transaksi = $this->Alus_items->get_keuangan_bulanan($bulan, $tahun);

            // 3. Kalkulasi Grand Total (Untuk Footer Laporan)
            $grand_omset  = 0;
            $grand_biaya  = 0;
            $grand_profit = 0;

            foreach ($transaksi as $key => $row) {
                // Hitung Omset per Baris
                $omset_baris = $row->stok_kg * $row->harga_usd;

                // Masukkan data hasil hitungan ke object array agar bisa dibaca di View
                $transaksi[$key]->nilai_omset = $omset_baris;
                $transaksi[$key]->nilai_profit = $omset_baris - $row->biaya_operasional;

                // Akumulasi ke Grand Total
                $grand_omset  += $omset_baris;
                $grand_biaya  += $row->biaya_operasional;
                $grand_profit += ($omset_baris - $row->biaya_operasional);
            }

            $data['laporan']      = $transaksi;
            $data['grand_omset']  = $grand_omset;
            $data['grand_biaya']  = $grand_biaya;
            $data['grand_profit'] = $grand_profit;

            $this->load->view('template/temaalus/header', $head);
            $this->load->view('index', $data);
            $this->load->view('template/temaalus/footer');
        } else {
            redirect('admin/login', 'refresh');
        }
    }
}
