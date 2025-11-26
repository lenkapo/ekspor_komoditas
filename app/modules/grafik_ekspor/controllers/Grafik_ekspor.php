<?php defined('BASEPATH') or exit('No direct script access allowed');

class Grafik_ekspor extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model', 'Alus_items');
        // Memuat helper untuk URL dan Form
        $this->load->helper(array('url', 'form'));
        $this->load->library('session');

        // *Asumsi:* Anda memiliki library upload
        $this->load->library('upload');
    }

    public function index()
    {
        if ($this->alus_auth->logged_in()) {
            $title_head = "Grafik Analisis Ekspor Komoditas";
            $head['title'] = $title_head;
            $data['title_head'] = $title_head;

            // --- 1. DATA UNTUK GRAFIK BAR (Volume Ekspor per Komoditas) ---
            $data_komoditas = $this->Alus_items->get_export_by_product();
            $labels_komoditas = [];
            $data_qty = [];

            foreach ($data_komoditas as $row) {
                $labels_komoditas[] = $row->nama_produk;
                $data_qty[] = (float)$row->total_qty;
            }

            $data['labels_komoditas'] = json_encode($labels_komoditas);
            $data['data_qty'] = json_encode($data_qty);

            // --- 2. DATA UNTUK GRAFIK DOUGHNUT (Nilai Ekspor per Negara) ---
            $data_negara = $this->Alus_items->get_value_by_country();
            $labels_negara = [];
            $data_nilai = [];

            foreach ($data_negara as $row) {
                $labels_negara[] = $row->negara_tujuan;
                $data_nilai[] = (float)$row->total_nilai;
            }

            $data['labels_negara'] = json_encode($labels_negara);
            $data['data_nilai'] = json_encode($data_nilai);

            $this->load->view('template/temaalus/header', $head);
            $this->load->view('index', $data);
            $this->load->view('template/temaalus/footer');
        } else {
            redirect('admin/login', 'refresh');
        }
    }
    // Fungsi untuk memproses penyimpanan data baru
    public function simpan()
    {
        $gambar = 'default.png'; // Nilai default jika tidak ada gambar

        // Konfigurasi Upload Gambar
        $config['upload_path']   = './assets/uploads/ikan/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size']      = 2048; // 2MB
        $config['file_name']     = 'ikan_' . time();

        $this->upload->initialize($config);

        if ($this->upload->do_upload('gambar')) {
            $upload_data = $this->upload->data();
            $gambar = $upload_data['file_name'];
        }

        // Siapkan data untuk disimpan (Termasuk kolom baru: biaya_operasional)
        $data = [
            'nama_produk'       => $this->input->post('nama_produk'),
            'nama_latin'        => $this->input->post('nama_latin'),
            'jenis_olahan'      => $this->input->post('jenis_olahan'),
            'grade'             => $this->input->post('grade'),
            'asal_wilayah'      => $this->input->post('asal_wilayah'),
            'negara_tujuan'     => $this->input->post('negara_tujuan'),
            'stok_kg'           => $this->input->post('stok_kg'),
            'harga_usd'         => $this->input->post('harga_usd'),
            'biaya_operasional' => $this->input->post('biaya_operasional'), // Kolom Keuangan
            'gambar'            => $gambar,
            'created_by'        => $this->session->userdata('username') // Asumsi Anda menyimpan username di session
        ];

        $this->Alus_items->insert($data);
        $this->session->set_flashdata('success', 'Data Komoditas Berhasil Ditambahkan!');
        redirect('data_ikan/index');
    }

    // Fungsi untuk memproses pembaruan data
    public function update()
    {
        $id = $this->input->post('id_ikan');
        $gambar_lama = $this->input->post('gambar_lama');
        $gambar = $gambar_lama; // Tetapkan gambar lama sebagai default

        // Konfigurasi Upload Gambar (Sama seperti simpan)
        $config['upload_path']   = './assets/uploads/ikan/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size']      = 2048; // 2MB
        $config['file_name']     = 'ikan_' . time();

        $this->upload->initialize($config);

        // Cek apakah ada file baru yang diupload
        if ($this->upload->do_upload('gambar')) {
            // Hapus gambar lama jika bukan 'default.png'
            if ($gambar_lama != 'default.png') {
                @unlink('./assets/uploads/ikan/' . $gambar_lama);
            }
            $upload_data = $this->upload->data();
            $gambar = $upload_data['file_name'];
        }

        // Siapkan data untuk diupdate
        $data = [
            'nama_produk'       => $this->input->post('nama_produk'),
            'nama_latin'        => $this->input->post('nama_latin'),
            'jenis_olahan'      => $this->input->post('jenis_olahan'),
            'grade'             => $this->input->post('grade'),
            'asal_wilayah'      => $this->input->post('asal_wilayah'),
            'negara_tujuan'     => $this->input->post('negara_tujuan'),
            'stok_kg'           => $this->input->post('stok_kg'),
            'harga_usd'         => $this->input->post('harga_usd'),
            'biaya_operasional' => $this->input->post('biaya_operasional'), // Kolom Keuangan
            'gambar'            => $gambar
        ];

        $this->Alus_items->update($id, $data);
        $this->session->set_flashdata('success', 'Data Komoditas Berhasil Diperbarui!');
        redirect('index');
    }

    // Fungsi untuk menghapus data
    public function delete($id = null)
    {
        if ($id === null) {
            show_404();
        }

        // Ambil nama file gambar
        $row = $this->ikan_model->get_by_id($id);
        if ($row) {
            $gambar = $row->gambar;
            // Hapus file gambar fisik jika bukan 'default.png'
            if ($gambar != 'default.png') {
                @unlink('./assets/uploads/ikan/' . $gambar);
            }
        }

        $this->ikan_model->delete($id);
        $this->session->set_flashdata('success', 'Data Komoditas Berhasil Dihapus!');
        redirect('ikan');
    }

    // Fungsi helper untuk mendapatkan warna acak (Opsional)
    private function generate_random_color()
    {
        $r = rand(0, 255);
        $g = rand(0, 255);
        $b = rand(0, 255);
        return "rgb($r, $g, $b)";
    }
}
