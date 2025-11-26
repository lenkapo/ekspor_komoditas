<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @author 		Maulana Rahman <maulana.code@gmail.com>
 */
class Dashboard extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!$this->alus_auth->logged_in()) {
			redirect('admin/Login', 'refresh');
		}
		$this->load->model('Dashboard_model', 'model');
	}
	public function index()
	{
		// Data untuk Widget Atas
		$data['total_ikan']     = $this->model->count_by_kategori('Ikan');
		$data['total_hewan']    = $this->model->count_by_kategori('Hewan');
		$data['total_tumbuhan'] = $this->model->count_by_kategori('Tumbuhan');
		$data['total_aset']     = $this->model->sum_nilai_ekspor();
		// Data untuk Grafik
		// 1. Ambil data mentah dari database
		$data['data_komoditas'] = $this->model->get_chart_data();

		// Data Tabel Terbaru (Limit 5 saja untuk dashboard)
		$data['recent_items']   = $this->db->limit(5)->order_by('id_produk', 'DESC')->get('tb_produk')->result();

		$head['title'] = 'Dashboard Ekspor Komoditas';

		// Load View
		$this->load->view('template/temaalus/header', $head);
		$this->load->view('dashboard/index', $data);
		$this->load->view('template/temaalus/footer');
	}

	// Halaman Katalog Detail per Kategori
	public function katalog($kategori)
	{
		$kategori = ucfirst($kategori); // Pastikan huruf depan besar
		$head['title'] = "Katalog Komoditas: $kategori";
		$data['items'] = $this->model->get_all($kategori);
		$data['kategori_aktif'] = $kategori;

		$this->load->view('template/temaalus/header', $head);
		$this->load->view('dashboard/v_katalog', $data);
		$this->load->view('template/temaalus/footer');
	}
	// public function index()
	// {
	// 	$head['title'] = "Beranda";

	// 	$this->load->view('template/temaalus/header', $head);
	// 	$this->load->view('dashboard/index');
	// 	$this->load->view('template/temaalus/footer');
	// }

	function error404()
	{
		if ($this->alus_auth->logged_in()) {
			$head['title'] = "Ups Page Not Found";

			$this->load->view('template/temaalus/header', $head);
			$this->load->view('template/temaalus/404');
			$this->load->view('template/temaalus/footer');
		} else {
			redirect('admin/Login', 'refresh');
		}
	}
}

/* End of file  Home.php */
/* Location: ./application/controllers/ Home.php */