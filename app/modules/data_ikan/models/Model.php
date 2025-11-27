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

    public function get_all_pelabuhan()
    {
        // Mengambil semua data pelabuhan untuk dropdown
        $this->db->order_by('nama_pelabuhan', 'ASC');
        return $this->db->get('tb_pelabuhan')->result();
    }
}
