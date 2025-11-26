<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model extends CI_Model
{

    // Nama tabel dan primary key
    private $table = 'tb_koordinat_negara';
    private $pk = 'id_koordinat';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Mengambil semua data koordinat negara untuk keperluan peta.
     * Hasil dikembalikan sebagai array asosiatif (array of arrays)
     * agar mudah diproses di Controller Peta.php.
     */
    public function get_all_coordinates_map()
    {
        $this->db->order_by('nama_negara', 'ASC');
        // Menggunakan result_array() agar lebih mudah diproses di Controller
        return $this->db->get($this->table)->result_array();
    }

    /**
     * Mengambil semua data untuk halaman administrasi (CRUD list).
     * Hasil dikembalikan sebagai array of objects (default CI).
     */
    public function get_all()
    {
        $this->db->order_by('nama_negara', 'ASC');
        return $this->db->get($this->table)->result();
    }

    /**
     * Menyimpan data koordinat baru.
     */
    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    /**
     * Mengambil satu baris data berdasarkan ID.
     */
    public function get_by_id($id)
    {
        $this->db->where($this->pk, $id);
        return $this->db->get($this->table)->row();
    }

    /**
     * Memperbarui data koordinat yang sudah ada.
     */
    public function update($id, $data)
    {
        $this->db->where($this->pk, $id);
        return $this->db->update($this->table, $data);
    }

    /**
     * Menghapus data koordinat.
     */
    public function delete($id)
    {
        $this->db->where($this->pk, $id);
        return $this->db->delete($this->table);
    }
}
