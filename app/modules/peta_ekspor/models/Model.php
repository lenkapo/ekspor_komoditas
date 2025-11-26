<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model extends CI_Model
{

    // Nama tabel di database
    private $table = 'tb_ikan';

    // Primary key tabel
    private $pk = 'id_ikan';

    public function __construct()
    {
        parent::__construct();
        // Memuat database library CodeIgniter
        $this->load->database();
    }

    /**
     * Mengambil semua data dari tabel ikan.
     * Digunakan untuk menampilkan list di halaman utama.
     */
    public function get_all()
    {
        // Mengambil semua baris dari tabel
        $this->db->order_by($this->pk, 'DESC');
        $query = $this->db->get($this->table);
        return $query->result(); // Mengembalikan data sebagai array of objects
    }

    /**
     * Mengambil satu baris data berdasarkan ID.
     * Digunakan untuk fungsi Edit/Detail.
     */
    public function get_by_id($id)
    {
        // Mencari data yang primary key-nya sesuai dengan $id
        $this->db->where($this->pk, $id);
        $query = $this->db->get($this->table);
        return $query->row(); // Mengembalikan satu baris data sebagai object
    }

    /**
     * Menyimpan data baru ke database (Create).
     * Data array harus memiliki key yang sama dengan nama kolom di database.
     */
    public function insert($data)
    {
        // $data adalah array asosiatif dari Controller
        return $this->db->insert($this->table, $data);
    }

    /**
     * Memperbarui data yang sudah ada (Update).
     */
    public function update($id, $data)
    {
        // Menentukan baris mana yang akan diupdate
        $this->db->where($this->pk, $id);
        // Menjalankan proses update dengan data baru
        return $this->db->update($this->table, $data);
    }

    /**
     * Menghapus data dari database (Delete).
     */
    public function delete($id)
    {
        // Menentukan baris mana yang akan dihapus
        $this->db->where($this->pk, $id);
        // Menjalankan proses delete
        return $this->db->delete($this->table);
    }

    // Anda bisa menambahkan fungsi kompleks lain di sini, 
    // seperti get_total_stok(), get_data_for_export(), dll.
    public function get_export_by_product()
    {
        $this->db->select('nama_produk, SUM(stok_kg) AS total_qty');
        $this->db->group_by('nama_produk');
        $this->db->order_by('total_qty', 'DESC');
        return $this->db->get('tb_ikan')->result();
    }

    /**
     * Mengambil total nilai ekspor (USD) per negara tujuan.
     */
    public function get_value_by_country()
    {
        // Hitung total nilai = stok * harga satuan (sesuai logika Laporan Keuangan)
        $this->db->select('negara_tujuan, SUM(stok_kg * harga_usd) AS total_nilai');
        $this->db->group_by('negara_tujuan');
        $this->db->order_by('total_nilai', 'DESC');
        return $this->db->get('tb_ikan')->result();
    }

    /**
     * Mengambil total volume dan nilai ekspor per negara tujuan.
     * Data ini akan dipasangkan dengan koordinat di Controller.
     */
    public function get_export_geographic_data($start_date = null, $end_date = null)
    {
        // Kueri utama untuk mengagregasi data berdasarkan negara dan pelabuhan asal
        $this->db->select('
        t1.negara_tujuan,
        t2.latitude AS dest_lat,
        t2.longitude AS dest_lng,
        t3.latitude AS origin_lat,
        t3.longitude AS origin_lng,
        SUM(t1.stok_kg) AS total_volume_kg,
        SUM(t1.harga_usd) AS total_nilai_usd
    ');

        $this->db->from('tb_ikan t1');
        $this->db->join('tb_koordinat_negara t2', 't1.negara_tujuan = t2.nama_negara', 'left');
        $this->db->join('tb_pelabuhan t3', 't1.id_pelabuhan_asal = t3.id_pelabuhan', 'left');

        // =======================================================
        // BARIS PENTING: Menambahkan Klausa WHERE berdasarkan tanggal
        // =======================================================
        if ($start_date && $end_date) {
            $this->db->where('t1.tanggal_transaksi >=', $start_date);
            $this->db->where('t1.tanggal_transaksi <=', $end_date);
        }
        // =======================================================

        $this->db->group_by('t1.negara_tujuan, t1.id_pelabuhan_asal');
        $this->db->order_by('total_volume_kg', 'DESC');

        // Hanya tampilkan data yang memiliki koordinat negara tujuan
        $this->db->where('t2.latitude IS NOT NULL');

        return $this->db->get()->result_array();
    }

    public function get_all_coordinates_map()
    {
        $this->db->order_by('nama_negara', 'ASC');
        // Menggunakan result_array() agar lebih mudah diproses di Controller
        return $this->db->get('tb_koordinat_negara')->result_array();
    }
}
