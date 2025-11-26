<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- CSS -->
	<link rel="stylesheet" href="<?= base_url('assets/css/bootstrap-reboot.min.css') ?>">
	<link rel="stylesheet" href="<?= base_url('assets/css/bootstrap-grid.min.css') ?>">
	<link rel="stylesheet" href="<?= base_url('assets/css/owl.carousel.min.css') ?>">
	<link rel="stylesheet" href="<?= base_url('assets/css/slider-radio.css') ?>">
	<link rel="stylesheet" href="<?= base_url('assets/css/select2.min.css') ?>">
	<link rel="stylesheet" href="<?= base_url('assets/css/magnific-popup.css') ?>">
	<link rel="stylesheet" href="<?= base_url('assets/css/plyr.css') ?>">
	<link rel="stylesheet" href="<?= base_url('assets/css/main.css') ?>">

	<!-- Favicons -->
	<link rel="icon" type="image/png" href="<?= base_url('assets/icon/favicon-32x32.png') ?>" s>
	<link rel="apple-touch-icon" href="<?= base_url('assets/icon/favicon-32x32.png') ?>">

	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="Luqman Aly RazakS">
	<title>PusatLensaFilm - Movies Streaming </title>

</head>

<body>
	<!-- Navbar -->
	<?php $this->load->view('header'); ?>
	<!-- end header -->

	<!-- Beranda -->
	<div class="content-wrapper">
		<section class="content-header">
			<h1>
				Pemesanan Komoditas
				<small>Pilih Ikan yang Tersedia</small>
			</h1>
		</section>

		<section class="content">
			<?php if ($this->session->flashdata('success')): ?>
				<div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
			<?php endif; ?>

			<a href="<?= base_url('beranda/cart'); ?>" class="btn btn-warning pull-right">
				<i class="fa fa-shopping-cart"></i> Lihat Keranjang (<?= $this->cart->total_items(); ?> Item)
			</a>
			<br><br>

			<div class="row">
				<?php foreach ($produk as $ikan): ?>
					<div class="col-md-3">
						<div class="box box-widget widget-user-2">
							<div class="widget-user-header bg-navy">
								<div class="widget-user-image">
									<img class="img-circle" src="<?= base_url('assets/uploads/ikan/' . $ikan->gambar); ?>" alt="Product Image">
								</div>
								<h3 class="widget-user-username"><?= $ikan->nama_produk; ?></h3>
								<h5 class="widget-user-desc"><?= $ikan->nama_latin; ?></h5>
							</div>
							<div class="box-footer no-padding">
								<ul class="nav nav-stacked">
									<li><a href="#">Grade <span class="pull-right badge bg-green"><?= $ikan->grade; ?></span></a></li>
									<li><a href="#">Stok Tersedia <span class="pull-right badge bg-aqua"><?= number_format($ikan->stok_kg); ?> Kg</span></a></li>
									<li><a href="#">Harga FOB <span class="pull-right badge bg-red">$ <?= number_format($ikan->harga_usd, 2); ?>/Kg</span></a></li>
									<li style="text-align: center;">
										<a href="<?= base_url('beranda/add_to_cart/' . $ikan->id_ikan); ?>" class="btn btn-block btn-success btn-flat">
											<i class="fa fa-cart-plus"></i> Tambah ke Pesanan
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</section>
	</div>