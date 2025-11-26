<?php defined('BASEPATH') or exit('No direct script access allowed');

class Manajemen_stok_inbound extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model', 'Alus_items');
    }

    public function index()
    {
        if ($this->alus_auth->logged_in()) {
            $title_head = "Manajemen Stok Gudang Ekspor";
            $data['subtitle'] = 'Daftar Semua Lot Produk Perikanan';
            $head['title'] = $title_head;
            $data['title_head'] = $title_head;
            $data['stok'] = $this->Alus_items->get_all_stok();

            $this->load->view('template/temaalus/header', $head);
            $this->load->view('index', $data);
            $this->load->view('template/temaalus/footer');
        } else {
            redirect('admin/login', 'refresh');
        }
    }
    // Fungsi untuk memproses penyimpanan data baru
    public function add()
    {
        // 1. Aturan Validasi
        $this->form_validation->set_rules(
            'lot_number',
            'Lot Number',
            'required|is_unique[tb_stok.lot_number]',
            array('is_unique' => 'Lot Number ini sudah terdaftar. Harap gunakan kode unik lain.')
        );
        $this->form_validation->set_rules('komoditas', 'Komoditas', 'required');
        $this->form_validation->set_rules('stok_tersedia_kg', 'Kuantitas', 'required|numeric|greater_than[0]');

        $data['title'] = 'Tambah Stok Baru';
        $data['subtitle'] = 'Input Data Produk Masuk';

        if ($this->form_validation->run() == FALSE) {
            // Tampilkan form jika validasi gagal (atau pertama kali dibuka)
            $this->load->view('template/temaalus/header', $data);
            $this->load->view('stok/add');
            $this->load->view('template/temaalus/footer');
        } else {
            // Proses data jika validasi berhasil
            $data_stok = array(
                'lot_number'            => strtoupper($this->input->post('lot_number')),
                'komoditas'             => $this->input->post('komoditas'),
                'sumber_asal'           => $this->input->post('sumber_asal'),
                'stok_tersedia_kg'      => $this->input->post('stok_tersedia_kg'),
                'stok_dialokasikan_kg'  => 0.00, // Selalu 0 saat stok baru masuk
                'tanggal_masuk'         => date('Y-m-d'),
                'tanggal_kadaluarsa'    => $this->input->post('tanggal_kadaluarsa'),
                'status_kualitas'       => $this->input->post('status_kualitas')
            );

            if ($this->Alus_items->add_stok($data_stok)) {
                $this->session->set_flashdata('success', 'Stok dengan **Lot Number ' . $data_stok['lot_number'] . '** berhasil ditambahkan.');
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan stok ke database.');
            }
            redirect('index');
        }
    }

    /**
     * Fungsi Pembantu untuk Pengurangan Stok (Outbound)
     * FUNGSI INI HARUS DIPANGGIL OLEH CONTROLLER EKSPOR (misalnya, Transaksi.php)
     * Setelah transaksi ekspor ke tb_ikan berhasil.
     */
    public function proses_ekspor($lot_number, $qty_ekspor)
    {
        // Pastikan Lot Number dan Kuantitas di-sanitize jika dipanggil melalui URL/API
        $lot_number = $this->security->xss_clean($lot_number);
        $qty_ekspor = floatval($qty_ekspor);

        if ($qty_ekspor <= 0) {
            $this->session->set_flashdata('error', 'Kuantitas ekspor harus lebih dari nol.');
            return FALSE;
        }

        if ($this->Stok_model->update_stok_outbound($lot_number, $qty_ekspor)) {
            // Berhasil mengurangi stok dan memperbarui alokasi
            return TRUE;
        } else {
            // Gagal (kemungkinan stok tidak cukup atau lot number salah)
            $this->session->set_flashdata('error', 'Gagal mengurangi stok. Jumlah tidak mencukupi atau Lot Number tidak valid.');
            return FALSE;
        }
    }
}
