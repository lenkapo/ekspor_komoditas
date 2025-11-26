<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pemesanan_model extends CI_Model
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


    public function simpan_pesanan($data_header, $data_detail)
    {
        // 1. Simpan Header Pesanan
        $this->db->insert('tb_pemesanan', $data_header);
        $id_pemesanan = $this->db->insert_id(); // Ambil ID yang baru dibuat

        // 2. Simpan Detail Pesanan (Loop melalui item)
        foreach ($data_detail as &$item) {
            $item['id_pemesanan'] = $id_pemesanan;
        }
        $this->db->insert_batch('tb_detail_pesanan', $data_detail);

        return $id_pemesanan;
    }

    public function get_all_pesanan()
    {
        $this->db->order_by('tanggal_pesan', 'DESC');
        return $this->db->get('tb_pemesanan')->result();
    }

    // Fungsi untuk mendapatkan data ikan yang masih tersedia (dari Ikan_model)
    // Asumsi: Di Controller nanti kita load Ikan_model untuk ini.
}
