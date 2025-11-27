<?php
defined('BASEPATH') or exit('No direct script access allowed');

class manajemen_stok_outbound extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Muat Model
        $this->load->library('form_validation');
        $this->load->model('model', 'Alus_items');
        $this->load->model('manajemen_stok_inbound/Models/model', 'Stok');
    }

    /**
     * Menampilkan daftar semua transaksi ekspor
     */
    public function index()
    {
        if ($this->alus_auth->logged_in()) {
            $title_head = "Manajemen Stok Gudang Ekspor";
            $data['subtitle'] = 'Outbond';
            $head['title'] = $title_head;
            $data['title_head'] = $title_head;
            $data['transaksi'] = $this->Alus_items->get_all_transaksi();

            $data['available_lots'] = $this->Alus_items->get_available_lots();


            $this->load->view('template/temaalus/header', $head);
            $this->load->view('index', $data);
            $this->load->view('template/temaalus/footer');
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    /**
     * Menampilkan dan memproses form penambahan transaksi ekspor baru
     */
    public function add()
    {
        // Aturan Validasi
        $this->form_validation->set_rules('lot_number_fk', 'Lot Number Stok', 'required');
        $this->form_validation->set_rules('stok_kg', 'Kuantitas Ekspor', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('negara_tujuan', 'Negara Tujuan', 'required');
        $this->form_validation->set_rules('harga_usd', 'Nilai Transaksi (USD)', 'required|numeric|greater_than[0]');

        $data['title'] = 'Tambah Transaksi Ekspor';
        $data['subtitle'] = 'Input Data Penjualan & Alokasi Stok';

        // Ambil Lot yang tersedia untuk dropdown
        $data['available_lots'] = $this->Alus_items->get_available_lots();

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('template/temaalus/header', $data);
            $this->load->view('index', $data);
            $this->load->view('template/temaalus/footer');
        } else {
            $this->simpan_transaksi_ekspor();
        }
    }

    /**
     * Logika Inti: Memproses POST form, mengurangi stok, dan menyimpan transaksi.
     */
    private function simpan_transaksi_ekspor()
    {
        $lot_number = strtoupper($this->input->post('lot_number_fk'));
        $qty_ekspor = floatval($this->input->post('stok_kg'));

        // LANGKAH 1: Pengurangan Stok (Panggil Model Bisnis)
        $stok_berhasil_kurang = $this->Alus_items->update_stok_outbound($lot_number, $qty_ekspor);

        if (!$stok_berhasil_kurang) {
            // Gagal: Stok tidak cukup atau Lot Number tidak valid.
            $this->session->set_flashdata('error', 'Transaksi gagal disimpan. Stok Lot **' . $lot_number . '** tidak mencukupi atau kode tidak valid.');
            redirect('manajemen_stok_outbound/index');
            return;
        }

        // LANGKAH 2: Pencatatan Transaksi (Panggil Model Data)
        $data_transaksi = array(
            'lot_number_fk'     => $lot_number,
            'tanggal_ekspor'    => date('Y-m-d'),
            'negara_tujuan'     => $this->input->post('negara_tujuan'),
            'stok_kg'           => $qty_ekspor,
            'harga_usd'         => $this->input->post('harga_usd')
        );

        if ($this->Alus_items->add_transaksi($data_transaksi)) {
            $this->session->set_flashdata('success', 'Transaksi ekspor berhasil dicatat dan stok gudang diperbarui.');
        } else {
            // Error jika database tb_ikan gagal, namun stok tb_stok sudah terpotongsa
            $this->session->set_flashdata('error', 'Transaksi gagal dicatat di database ekspor.');
        }

        redirect('manajemen_stok_outbound/index');
    }
}
