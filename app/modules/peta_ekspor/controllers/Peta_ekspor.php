<?php defined('BASEPATH') or exit('No direct script access allowed');

class Peta_ekspor extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model', 'Alus_items');
    }

    public function index()
    {
        if ($this->alus_auth->logged_in()) {
            $title_head = "Peta Sebaran Ekspor Komoditas";
            $head['title'] = $title_head;
            $data['title_head'] = $title_head;

            // BARIS PENTING: Mengambil input filter tanggal
            // =======================================================
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');
            // =======================================================

            // Panggil Model dengan parameter tanggal yang baru
            $export_data = $this->Alus_items->get_export_geographic_data($start_date, $end_date);

            $map_data = [];
            $origin_coords = [];

            foreach ($export_data as $row) {
                // ... (Logika yang sama untuk memformat data)
                // Pastikan Anda memformat data yang dikembalikan Model

                $map_data[] = [
                    'negara_tujuan' => $row['negara_tujuan'],
                    'volume' => (int)$row['total_volume_kg'],
                    'nilai' => (float)$row['total_nilai_usd'],
                    'lat' => (float)$row['dest_lat'],
                    'lng' => (float)$row['dest_lng'],
                    'origin' => [
                        'lat' => (float)$row['origin_lat'],
                        'lng' => (float)$row['origin_lng']
                    ]
                ];
            }

            // Ambil data koordinat dari database
            $db_coords = $db_coords = $this->Alus_items->get_all_coordinates_map();
            $coordinates = [];

            // Format data menjadi array asosiatif [Nama Negara => [lat, lng]]
            foreach ($db_coords as $coord) {
                $coordinates[$coord['nama_negara']] = [
                    'lat' => (float)$coord['latitude'],
                    'lng' => (float)$coord['longitude']
                ];
            }
            $data['map_data'] = json_encode($map_data);

            $data['start_date'] = $start_date; // Kirim kembali tanggal untuk mempertahankan nilai di form
            $data['end_date'] = $end_date;     // Kirim kembali tanggal untuk mempertahankan nilai di form

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
