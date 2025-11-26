<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author 		Maulana Rahman <maulana.code@gmail.com>
 */
class Dashboard_model extends CI_Model
{

	private $table = 'tb_produk';

	// Mengambil total item per kategori untuk Widget
	public function count_by_kategori($kategori)
	{
		$this->db->where('kategori', $kategori);
		return $this->db->count_all_results($this->table);
	}

	// Mengambil total nilai ekspor (Sum)
	public function sum_nilai_ekspor()
	{
		$this->db->select_sum('nilai_ekspor');
		$query = $this->db->get($this->table);
		return $query->row()->nilai_ekspor;
	}

	// Mengambil data untuk Grafik (Chart.js)
	public function get_chart_data()
	{
		// Query: Hitung jumlah item berdasarkan kategori
		$this->db->select('kategori, COUNT(*) as total');
		$this->db->group_by('kategori');
		return $this->db->get('tb_produk')->result();
	}

	// Mengambil list data (Bisa difilter kategori atau semua)
	public function get_all($kategori = null)
	{
		if ($kategori) {
			$this->db->where('kategori', $kategori);
		}
		$this->db->order_by('id_produk', 'DESC');
		return $this->db->get($this->table)->result();
	}

	public function insert($data)
	{
		return $this->db->insert($this->table, $data);
	}

	// Tambahkan fungsi update dan delete sesuai kebutuhan standar

}


/* End of file  */
/* Location: ./application/models/ */