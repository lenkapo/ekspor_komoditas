<?php defined('BASEPATH') or exit('No direct script access allowed');

class Manajemen_stok extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model', 'Alus_items');
    }

    public function index()
    {
        if ($this->alus_auth->logged_in()) {
            $title_head = "Data Manajemen Stok";
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
    public function simpan()
    {
        $data = array(
            'lot_number' => $this->input->post('lot_number'),
            'komoditas' => $this->input->post('komoditas'),
            'sumber_asal' => $this->input->post('sumber_asal'),
            'stok_tersedia_kg' => $this->input->post('stok_tersedia_kg'),
            'tanggal_masuk' => date('Y-m-d'), // Tanggal hari ini
            'tanggal_kadaluarsa' => $this->input->post('tanggal_kadaluarsa'),
            'status_kualitas' => $this->input->post('status_kualitas')
        );

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
            'tanggal_transaksi' => $this->input->post('tanggal_transaksi'), // BARIS BARU
            'nama_latin'        => $this->input->post('nama_latin'),
            'jenis_olahan'      => $this->input->post('jenis_olahan'),
            'grade'             => $this->input->post('grade'),
            'id_pelabuhan_asal'      => $this->input->post('id_pelabuhan_asal'),
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

    // Fungsi untuk memproses pengurangan stok saat ekspor (harus dipanggil dari Controller Ekspor Anda)
    public function proses_ekspor($lot_number, $qty_ekspor)
    {
        if ($this->Alus_items->update_stok_outbound($lot_number, $qty_ekspor)) {
            // Berhasil mengurangi stok
            return TRUE;
        } else {
            // Gagal (mungkin stok tidak cukup atau lot number salah)
            $this->session->set_flashdata('error', 'Gagal mengurangi stok. Jumlah tidak mencukupi atau Lot Number salah.');
            return FALSE;
        }
    }
}
