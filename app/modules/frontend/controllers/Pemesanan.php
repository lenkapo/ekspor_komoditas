<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pemesanan extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('pemesanan_model', 'ikan_model'));
		$this->load->library(array('session', 'cart')); // Menggunakan library Cart CI
		$this->load->helper('url');

		// *CATATAN:* Pada sistem nyata, pastikan pelanggan sudah login.
	}

	// Halaman utama (Menampilkan daftar produk yang tersedia untuk dipesan)
	public function index()
	{
		$data['title'] = 'Pilih Komoditas Ekspor';
		$data['produk'] = $this->ikan_model->get_all(); // Ambil semua data ikan

		$this->load->view('layout/header', $data);
		$this->load->view('pemesanan/pilih_produk', $data);
		$this->load->view('layout/footer');
	}

	// Menambah item ke keranjang (Cart)
	public function add_to_cart($id_ikan)
	{
		$ikan = $this->ikan_model->get_by_id($id_ikan);

		if ($ikan) {
			$data = array(
				'id'      => $ikan->id_ikan,
				'qty'     => 1, // Default 1, bisa diubah di halaman cart
				'price'   => $ikan->harga_usd,
				'name'    => $ikan->nama_produk,
				'options' => array('nama_latin' => $ikan->nama_latin)
			);

			$this->cart->insert($data);
			$this->session->set_flashdata('success', $ikan->nama_produk . ' ditambahkan ke Keranjang!');
		}
		redirect('pemesanan');
	}

	// Menampilkan Keranjang Belanja
	public function cart()
	{
		$data['title'] = 'Keranjang Pemesanan';

		$this->load->view('layout/header', $data);
		$this->load->view('pemesanan/view_cart');
		$this->load->view('layout/footer');
	}

	// Update Keranjang (QTY)
	public function update_cart()
	{
		$i = 1;
		foreach ($this->cart->contents() as $item) {
			$data = array(
				'rowid' => $item['rowid'],
				'qty'   => $this->input->post('qty' . $i)
			);
			$this->cart->update($data);
			$i++;
		}
		$this->session->set_flashdata('success', 'Keranjang berhasil diperbarui!');
		redirect('pemesanan/cart');
	}

	// Form Checkout (Input data pelanggan)
	public function checkout()
	{
		if ($this->cart->total_items() == 0) {
			$this->session->set_flashdata('error', 'Keranjang Anda kosong!');
			redirect('pemesanan');
		}

		$data['title'] = 'Checkout Pemesanan';

		$this->load->view('layout/header', $data);
		$this->load->view('pemesanan/view_checkout');
		$this->load->view('layout/footer');
	}

	// Menyelesaikan Pesanan (Simpan ke DB)
	public function proses_pesanan()
	{
		// 1. Siapkan data Header Pesanan
		$kode_pesanan = 'ORD-' . date('Ymd') . rand(100, 999);
		$total_nilai = $this->cart->total();

		$data_header = array(
			'kode_pesanan'     => $kode_pesanan,
			'id_pelanggan'     => 0, // Ganti dengan ID user yang login
			'nama_pelanggan'   => $this->input->post('nama_pelanggan'),
			'negara_tujuan'    => $this->input->post('negara_tujuan'),
			'total_nilai'      => $total_nilai,
			'status_pesanan'   => 'Pending'
		);

		// 2. Siapkan data Detail Pesanan
		$data_detail = array();
		foreach ($this->cart->contents() as $item) {
			$data_detail[] = array(
				'id_ikan'        => $item['id'],
				'nama_produk'    => $item['name'],
				'qty_kg'         => $item['qty'],
				'harga_satuan'   => $item['price'],
				'sub_total'      => $item['subtotal']
			);
		}

		// 3. Simpan ke Database
		$id_pesanan = $this->pemesanan_model->simpan_pesanan($data_header, $data_detail);

		// 4. Hapus Keranjang dan Beri Notifikasi
		$this->cart->destroy();
		$this->session->set_flashdata('success', 'Pesanan Anda (' . $kode_pesanan . ') berhasil dibuat. Kami akan segera memprosesnya!');
		redirect('pemesanan/pesanan_saya/' . $id_pesanan);
	}

	// Halaman riwayat pesanan (Admin view)
	public function riwayat_pesanan()
	{
		$data['title'] = 'Riwayat Pesanan Pelanggan';
		$data['pesanan'] = $this->pemesanan_model->get_all_pesanan();

		$this->load->view('layout/header', $data);
		$this->load->view('pemesanan/riwayat_pesanan', $data);
		$this->load->view('layout/footer');
	}
}
