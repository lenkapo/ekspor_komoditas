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
	<title><?php echo $title; ?> - PulensFilm</title>

</head>

<body>
	<!-- Navbar -->
	<?php $this->load->view('header'); ?>
	<!-- end header -->

	<div class="content-wrapper">
		<section class="content-header">
			<h1>Keranjang Pemesanan</h1>
		</section>

		<section class="content">
			<div class="box box-solid">
				<div class="box-body">
					<?php if ($this->session->flashdata('success')): ?>
						<div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
					<?php endif; ?>

					<?php if ($this->cart->total_items() > 0): ?>
						<form action="<?= base_url('pemesanan/update_cart'); ?>" method="post">
							<table class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>Produk</th>
										<th style="width: 150px;">QTY (Kg)</th>
										<th class="text-right">Harga Satuan</th>
										<th class="text-right">Sub Total</th>
										<th style="width: 50px;">Hapus</th>
									</tr>
								</thead>
								<tbody>
									<?php $i = 1; ?>
									<?php foreach ($this->cart->contents() as $item): ?>
										<tr>
											<td>
												<?= $item['name']; ?><br>
												<small class="text-muted"><?= $item['options']['nama_latin']; ?></small>
											</td>
											<td>
												<input type="number" name="qty<?= $i; ?>" value="<?= $item['qty']; ?>" min="1" class="form-control text-center">
											</td>
											<td class="text-right">$ <?= number_format($item['price'], 2); ?></td>
											<td class="text-right"><b>$ <?= number_format($item['subtotal'], 2); ?></b></td>
											<td>
												<a href="<?= base_url('pemesanan/remove_item/' . $item['rowid']); ?>" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></a>
											</td>
										</tr>
										<?php $i++; ?>
									<?php endforeach; ?>
								</tbody>
								<tfoot>
									<tr>
										<td colspan="3" class="text-right"><b>TOTAL PESANAN:</b></td>
										<td class="text-right"><b>$ <?= number_format($this->cart->total(), 2); ?></b></td>
										<td></td>
									</tr>
								</tfoot>
							</table>

							<div class="pull-right">
								<button type="submit" class="btn btn-primary"><i class="fa fa-refresh"></i> Update QTY</button>
								<a href="<?= base_url('pemesanan/checkout'); ?>" class="btn btn-success"><i class="fa fa-check"></i> Lanjut Checkout</a>
							</div>
						</form>
					<?php else: ?>
						<div class="alert alert-warning text-center">Keranjang pemesanan Anda kosong.</div>
						<a href="<?= base_url('pemesanan'); ?>" class="btn btn-info"><i class="fa fa-arrow-left"></i> Kembali ke Pemilihan Produk</a>
					<?php endif; ?>
				</div>
			</div>
		</section>
	</div>