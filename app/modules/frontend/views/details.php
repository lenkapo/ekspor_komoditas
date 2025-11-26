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
	<title> <?php echo $title; ?> </title>

</head>

<body>
	<!-- header (hidden style) -->
	<?php $this->load->view('header'); ?>

	<!-- end header -->

	<!-- details -->
	<?php
	foreach ($movies as $row) {
	?>
		<section class="section section--head section--head-fixed section--gradient section--details-bg">
			<div class="section__bg" data-bg="<?php echo base_url() . 'assets/movies/' . $row->picture; ?>"></div>
			<div class="container">
				<!-- article -->
				<div class="article">
					<div class="row">
						<div class="col-12 col-xl-8">
							<!-- trailer -->
							<a href="<?php echo $row->link_trailer; ?>" class="article__trailer open-video">
								<svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path fill-rule="evenodd" clip-rule="evenodd" d="M11 1C16.5228 1 21 5.47716 21 11C21 16.5228 16.5228 21 11 21C5.47716 21 1 16.5228 1 11C1 5.47716 5.47716 1 11 1Z" stroke-linecap="round" stroke-linejoin="round"></path>
									<path fill-rule="evenodd" clip-rule="evenodd" d="M14.0501 11.4669C13.3211 12.2529 11.3371 13.5829 10.3221 14.0099C10.1601 14.0779 9.74711 14.2219 9.65811 14.2239C9.46911 14.2299 9.28711 14.1239 9.19911 13.9539C9.16511 13.8879 9.06511 13.4569 9.03311 13.2649C8.93811 12.6809 8.88911 11.7739 8.89011 10.8619C8.88911 9.90489 8.94211 8.95489 9.04811 8.37689C9.07611 8.22089 9.15811 7.86189 9.18211 7.80389C9.22711 7.69589 9.30911 7.61089 9.40811 7.55789C9.48411 7.51689 9.57111 7.49489 9.65811 7.49789C9.74711 7.49989 10.1091 7.62689 10.2331 7.67589C11.2111 8.05589 13.2801 9.43389 14.0401 10.2439C14.1081 10.3169 14.2951 10.5129 14.3261 10.5529C14.3971 10.6429 14.4321 10.7519 14.4321 10.8619C14.4321 10.9639 14.4011 11.0679 14.3371 11.1549C14.3041 11.1999 14.1131 11.3999 14.0501 11.4669Z" stroke-linecap="round" stroke-linejoin="round"></path>
								</svg>
								Trailer
							</a>
							<!-- end trailer -->

							<!-- article content -->
							<div class="article__content">
								<h1><?php echo $row->title; ?></h1>
								<ul class="list">
									<li><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
											<path d="M22,9.67A1,1,0,0,0,21.14,9l-5.69-.83L12.9,3a1,1,0,0,0-1.8,0L8.55,8.16,2.86,9a1,1,0,0,0-.81.68,1,1,0,0,0,.25,1l4.13,4-1,5.68A1,1,0,0,0,6.9,21.44L12,18.77l5.1,2.67a.93.93,0,0,0,.46.12,1,1,0,0,0,.59-.19,1,1,0,0,0,.4-1l-1-5.68,4.13-4A1,1,0,0,0,22,9.67Zm-6.15,4a1,1,0,0,0-.29.88l.72,4.2-3.76-2a1.06,1.06,0,0,0-.94,0l-3.76,2,.72-4.2a1,1,0,0,0-.29-.88l-3-3,4.21-.61a1,1,0,0,0,.76-.55L12,5.7l1.88,3.82a1,1,0,0,0,.76.55l4.21.61Z" />
										</svg><?php echo $row->rating; ?></li>
									<?php
									$this->db->where('movie_id', $row->id);
									$this->db->join('categories', 'categories.id = movie_categories.category_id', 'left');
									$cat = $this->db->get('movie_categories')->result();

									foreach ($cat as $val_cat) {
										echo "<li>" . $val_cat->name . "</li>";
									}
									?>
									<li><?php echo $row->year; ?></li>
									<li><?php echo $row->duration; ?></li>
									<li><?php echo $row->age; ?>+</li>
								</ul>

								<p><?php echo $row->description; ?></p>
							</div>
							<!-- end article content -->
						</div>

						<!-- video player -->
						<div class="col-12 col-xl-8">
							<video controls crossorigin playsinline id="player" style="object-fit:fill">
								<!-- Video files -->
								<source src="<?php echo base_url() . 'assets/movies/' . $row->file_movie; ?>" type="video/mp4" size="576">
								<source src="<?php echo $row->file_movie; ?>" type="video/mp4" size="720">
								<source src="<?php echo $row->file_movie; ?>" type="video/mp4" size="1080">

								<!-- Caption files -->
								<track kind="captions" label="English" srclang="en" src="https://cdn.plyr.io/static/demo/View_From_A_Blue_Moon_Trailer-HD.en.vtt" default>
								<track kind="captions" label="Français" srclang="fr" src="https://cdn.plyr.io/static/demo/View_From_A_Blue_Moon_Trailer-HD.fr.vtt">

								<!-- Fallback for browsers that don't support the <video> element -->
								<a href="" download>Download</a>
							</video>

							<div class="article__actions article__actions--details">
								<div class="article__download">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
										<path d="M21,14a1,1,0,0,0-1,1v4a1,1,0,0,1-1,1H5a1,1,0,0,1-1-1V15a1,1,0,0,0-2,0v4a3,3,0,0,0,3,3H19a3,3,0,0,0,3-3V15A1,1,0,0,0,21,14Zm-9.71,1.71a1,1,0,0,0,.33.21.94.94,0,0,0,.76,0,1,1,0,0,0,.33-.21l4-4a1,1,0,0,0-1.42-1.42L13,12.59V3a1,1,0,0,0-2,0v9.59l-2.29-2.3a1,1,0,1,0-1.42,1.42Z" />
									</svg>
									Download:
									<a href="<?php echo $row->file_movie ?>" download="<?php echo $row->file_movie ?>">480p</a>
									<a href="<?php echo $row->file_movie ?>" download="<?php echo $row->file_movie ?>">720p</a>
									<a href="<?php echo $row->file_movie ?>" download="<?php echo $row->file_movie ?>">1080p</a>
									<a href="<?php echo $row->file_movie ?>" download="<?php echo $row->file_movie ?>">4k</a>
								</div>

								<!-- add .active class -->
								<button class="article__favorites" type="button" data-item-id="<?= $item_id; ?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
										<path d="M16,2H8A3,3,0,0,0,5,5V21a1,1,0,0,0,.5.87,1,1,0,0,0,1,0L12,18.69l5.5,3.18A1,1,0,0,0,18,22a1,1,0,0,0,.5-.13A1,1,0,0,0,19,21V5A3,3,0,0,0,16,2Zm1,17.27-4.5-2.6a1,1,0,0,0-1,0L7,19.27V5A1,1,0,0,1,8,4h8a1,1,0,0,1,1,1Z"></path>
									</svg> Add to favorites</button>
							</div>
						</div>
						<!-- end video player -->
						<div class="col-xl-2">
							<div class="partners__img">
								<img src="<?php echo base_url() . 'assets/movies/' . $row->picture; ?>" alt="" style="border-radius: 2%;">
							</div>
						</div>
						<!-- series -->
						<div class="col-12">
							<div class="series-wrap">
								<h3 class="series-wrap__title"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
										<path d="M9,10a1,1,0,0,0-1,1v2a1,1,0,0,0,2,0V11A1,1,0,0,0,9,10Zm12,1a1,1,0,0,0,1-1V6a1,1,0,0,0-1-1H3A1,1,0,0,0,2,6v4a1,1,0,0,0,1,1,1,1,0,0,1,0,2,1,1,0,0,0-1,1v4a1,1,0,0,0,1,1H21a1,1,0,0,0,1-1V14a1,1,0,0,0-1-1,1,1,0,0,1,0-2ZM20,9.18a3,3,0,0,0,0,5.64V17H10a1,1,0,0,0-2,0H4V14.82A3,3,0,0,0,4,9.18V7H8a1,1,0,0,0,2,0H20Z" />
									</svg> 1st season</h3>
								<div class="section__carousel-wrap">
									<div class="section__series owl-carousel" id="series">
										<div class="series">
											<a href="details.html" class="series__cover">
												<img src="img/series/1.jpg" alt="">
												<span>
													<svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
														<path fill-rule="evenodd" clip-rule="evenodd" d="M11 1C16.5228 1 21 5.47716 21 11C21 16.5228 16.5228 21 11 21C5.47716 21 1 16.5228 1 11C1 5.47716 5.47716 1 11 1Z" stroke-linecap="round" stroke-linejoin="round" />
														<path fill-rule="evenodd" clip-rule="evenodd" d="M14.0501 11.4669C13.3211 12.2529 11.3371 13.5829 10.3221 14.0099C10.1601 14.0779 9.74711 14.2219 9.65811 14.2239C9.46911 14.2299 9.28711 14.1239 9.19911 13.9539C9.16511 13.8879 9.06511 13.4569 9.03311 13.2649C8.93811 12.6809 8.88911 11.7739 8.89011 10.8619C8.88911 9.90489 8.94211 8.95489 9.04811 8.37689C9.07611 8.22089 9.15811 7.86189 9.18211 7.80389C9.22711 7.69589 9.30911 7.61089 9.40811 7.55789C9.48411 7.51689 9.57111 7.49489 9.65811 7.49789C9.74711 7.49989 10.1091 7.62689 10.2331 7.67589C11.2111 8.05589 13.2801 9.43389 14.0401 10.2439C14.1081 10.3169 14.2951 10.5129 14.3261 10.5529C14.3971 10.6429 14.4321 10.7519 14.4321 10.8619C14.4321 10.9639 14.4011 11.0679 14.3371 11.1549C14.3041 11.1999 14.1131 11.3999 14.0501 11.4669Z" stroke-linecap="round" stroke-linejoin="round" />
													</svg> 56:36
												</span>
											</a>
											<h3 class="series__title"><a href=""><?php echo $row->title; ?></a></h3>
										</div>

										<div class="series">
											<a href="details.html" class="series__cover">
												<img src="img/series/2.jpg" alt="">
												<span>
													<svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
														<path fill-rule="evenodd" clip-rule="evenodd" d="M11 1C16.5228 1 21 5.47716 21 11C21 16.5228 16.5228 21 11 21C5.47716 21 1 16.5228 1 11C1 5.47716 5.47716 1 11 1Z" stroke-linecap="round" stroke-linejoin="round" />
														<path fill-rule="evenodd" clip-rule="evenodd" d="M14.0501 11.4669C13.3211 12.2529 11.3371 13.5829 10.3221 14.0099C10.1601 14.0779 9.74711 14.2219 9.65811 14.2239C9.46911 14.2299 9.28711 14.1239 9.19911 13.9539C9.16511 13.8879 9.06511 13.4569 9.03311 13.2649C8.93811 12.6809 8.88911 11.7739 8.89011 10.8619C8.88911 9.90489 8.94211 8.95489 9.04811 8.37689C9.07611 8.22089 9.15811 7.86189 9.18211 7.80389C9.22711 7.69589 9.30911 7.61089 9.40811 7.55789C9.48411 7.51689 9.57111 7.49489 9.65811 7.49789C9.74711 7.49989 10.1091 7.62689 10.2331 7.67589C11.2111 8.05589 13.2801 9.43389 14.0401 10.2439C14.1081 10.3169 14.2951 10.5129 14.3261 10.5529C14.3971 10.6429 14.4321 10.7519 14.4321 10.8619C14.4321 10.9639 14.4011 11.0679 14.3371 11.1549C14.3041 11.1999 14.1131 11.3999 14.0501 11.4669Z" stroke-linecap="round" stroke-linejoin="round" />
													</svg> 58:41
												</span>
											</a>
											<h3 class="series__title"><a href="details.html">2nd series</a></h3>
										</div>

										<div class="series">
											<a href="details.html" class="series__cover">
												<img src="img/series/3.jpg" alt="">
												<span>
													<svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
														<path fill-rule="evenodd" clip-rule="evenodd" d="M11 1C16.5228 1 21 5.47716 21 11C21 16.5228 16.5228 21 11 21C5.47716 21 1 16.5228 1 11C1 5.47716 5.47716 1 11 1Z" stroke-linecap="round" stroke-linejoin="round" />
														<path fill-rule="evenodd" clip-rule="evenodd" d="M14.0501 11.4669C13.3211 12.2529 11.3371 13.5829 10.3221 14.0099C10.1601 14.0779 9.74711 14.2219 9.65811 14.2239C9.46911 14.2299 9.28711 14.1239 9.19911 13.9539C9.16511 13.8879 9.06511 13.4569 9.03311 13.2649C8.93811 12.6809 8.88911 11.7739 8.89011 10.8619C8.88911 9.90489 8.94211 8.95489 9.04811 8.37689C9.07611 8.22089 9.15811 7.86189 9.18211 7.80389C9.22711 7.69589 9.30911 7.61089 9.40811 7.55789C9.48411 7.51689 9.57111 7.49489 9.65811 7.49789C9.74711 7.49989 10.1091 7.62689 10.2331 7.67589C11.2111 8.05589 13.2801 9.43389 14.0401 10.2439C14.1081 10.3169 14.2951 10.5129 14.3261 10.5529C14.3971 10.6429 14.4321 10.7519 14.4321 10.8619C14.4321 10.9639 14.4011 11.0679 14.3371 11.1549C14.3041 11.1999 14.1131 11.3999 14.0501 11.4669Z" stroke-linecap="round" stroke-linejoin="round" />
													</svg> 57:19
												</span>
											</a>
											<h3 class="series__title"><a href="details.html">3rd series</a></h3>
										</div>

										<div class="series">
											<a href="details.html" class="series__cover">
												<img src="img/series/4.jpg" alt="">
												<span>
													<svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
														<path fill-rule="evenodd" clip-rule="evenodd" d="M11 1C16.5228 1 21 5.47716 21 11C21 16.5228 16.5228 21 11 21C5.47716 21 1 16.5228 1 11C1 5.47716 5.47716 1 11 1Z" stroke-linecap="round" stroke-linejoin="round" />
														<path fill-rule="evenodd" clip-rule="evenodd" d="M14.0501 11.4669C13.3211 12.2529 11.3371 13.5829 10.3221 14.0099C10.1601 14.0779 9.74711 14.2219 9.65811 14.2239C9.46911 14.2299 9.28711 14.1239 9.19911 13.9539C9.16511 13.8879 9.06511 13.4569 9.03311 13.2649C8.93811 12.6809 8.88911 11.7739 8.89011 10.8619C8.88911 9.90489 8.94211 8.95489 9.04811 8.37689C9.07611 8.22089 9.15811 7.86189 9.18211 7.80389C9.22711 7.69589 9.30911 7.61089 9.40811 7.55789C9.48411 7.51689 9.57111 7.49489 9.65811 7.49789C9.74711 7.49989 10.1091 7.62689 10.2331 7.67589C11.2111 8.05589 13.2801 9.43389 14.0401 10.2439C14.1081 10.3169 14.2951 10.5129 14.3261 10.5529C14.3971 10.6429 14.4321 10.7519 14.4321 10.8619C14.4321 10.9639 14.4011 11.0679 14.3371 11.1549C14.3041 11.1999 14.1131 11.3999 14.0501 11.4669Z" stroke-linecap="round" stroke-linejoin="round" />
													</svg> 54:58
												</span>
											</a>
											<h3 class="series__title"><a href="details.html">4th series</a></h3>
										</div>

										<div class="series">
											<a href="details.html" class="series__cover">
												<img src="img/series/5.jpg" alt="">
												<span>
													<svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
														<path fill-rule="evenodd" clip-rule="evenodd" d="M11 1C16.5228 1 21 5.47716 21 11C21 16.5228 16.5228 21 11 21C5.47716 21 1 16.5228 1 11C1 5.47716 5.47716 1 11 1Z" stroke-linecap="round" stroke-linejoin="round" />
														<path fill-rule="evenodd" clip-rule="evenodd" d="M14.0501 11.4669C13.3211 12.2529 11.3371 13.5829 10.3221 14.0099C10.1601 14.0779 9.74711 14.2219 9.65811 14.2239C9.46911 14.2299 9.28711 14.1239 9.19911 13.9539C9.16511 13.8879 9.06511 13.4569 9.03311 13.2649C8.93811 12.6809 8.88911 11.7739 8.89011 10.8619C8.88911 9.90489 8.94211 8.95489 9.04811 8.37689C9.07611 8.22089 9.15811 7.86189 9.18211 7.80389C9.22711 7.69589 9.30911 7.61089 9.40811 7.55789C9.48411 7.51689 9.57111 7.49489 9.65811 7.49789C9.74711 7.49989 10.1091 7.62689 10.2331 7.67589C11.2111 8.05589 13.2801 9.43389 14.0401 10.2439C14.1081 10.3169 14.2951 10.5129 14.3261 10.5529C14.3971 10.6429 14.4321 10.7519 14.4321 10.8619C14.4321 10.9639 14.4011 11.0679 14.3371 11.1549C14.3041 11.1999 14.1131 11.3999 14.0501 11.4669Z" stroke-linecap="round" stroke-linejoin="round" />
													</svg> 53:52
												</span>
											</a>
											<h3 class="series__title"><a href="details.html">5th series</a></h3>
										</div>

										<div class="series">
											<a href="details.html" class="series__cover">
												<img src="img/series/6.jpg" alt="">
												<span>
													<svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
														<path fill-rule="evenodd" clip-rule="evenodd" d="M11 1C16.5228 1 21 5.47716 21 11C21 16.5228 16.5228 21 11 21C5.47716 21 1 16.5228 1 11C1 5.47716 5.47716 1 11 1Z" stroke-linecap="round" stroke-linejoin="round" />
														<path fill-rule="evenodd" clip-rule="evenodd" d="M14.0501 11.4669C13.3211 12.2529 11.3371 13.5829 10.3221 14.0099C10.1601 14.0779 9.74711 14.2219 9.65811 14.2239C9.46911 14.2299 9.28711 14.1239 9.19911 13.9539C9.16511 13.8879 9.06511 13.4569 9.03311 13.2649C8.93811 12.6809 8.88911 11.7739 8.89011 10.8619C8.88911 9.90489 8.94211 8.95489 9.04811 8.37689C9.07611 8.22089 9.15811 7.86189 9.18211 7.80389C9.22711 7.69589 9.30911 7.61089 9.40811 7.55789C9.48411 7.51689 9.57111 7.49489 9.65811 7.49789C9.74711 7.49989 10.1091 7.62689 10.2331 7.67589C11.2111 8.05589 13.2801 9.43389 14.0401 10.2439C14.1081 10.3169 14.2951 10.5129 14.3261 10.5529C14.3971 10.6429 14.4321 10.7519 14.4321 10.8619C14.4321 10.9639 14.4011 11.0679 14.3371 11.1549C14.3041 11.1999 14.1131 11.3999 14.0501 11.4669Z" stroke-linecap="round" stroke-linejoin="round" />
													</svg> 59:37
												</span>
											</a>
											<h3 class="series__title"><a href="details.html">6th series</a></h3>
										</div>
									</div>

									<button class="section__nav section__nav--series section__nav--prev" data-nav="#series" type="button"><svg width="17" height="15" viewBox="0 0 17 15" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M1.25 7.72559L16.25 7.72559" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
											<path d="M7.2998 1.70124L1.2498 7.72524L7.2998 13.7502" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
										</svg></button>
									<button class="section__nav section__nav--series section__nav--next" data-nav="#series" type="button"><svg width="17" height="15" viewBox="0 0 17 15" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M15.75 7.72559L0.75 7.72559" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
											<path d="M9.7002 1.70124L15.7502 7.72524L9.7002 13.7502" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
										</svg></button>
								</div>
							</div>
						</div>
						<!-- end series -->

						<div class="col-12 col-xl-8">
							<!-- categories -->
							<div class="categories">
								<h3 class="categories__title">Categories</h3>
								<?php
								$this->db->where('movie_id', $row->id);
								$this->db->join('categories', 'categories.id = movie_categories.category_id', 'left');
								$cat = $this->db->get('movie_categories')->result();
								foreach ($cat as $val_cat) {
									echo '<a href="' . base_url() . 'categories/' . $val_cat->id . '" class="categories__item">' . $val_cat->name . '</a>';
								}
								?>
							</div>
							<!-- end categories -->


							<!-- share -->
							<div class="share">
								<h3 class="share__title">Share</h3>
								<a href="#" class="share__link share__link--fb"><svg width="9" height="17" viewBox="0 0 9 17" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M5.56341 16.8197V8.65888H7.81615L8.11468 5.84663H5.56341L5.56724 4.43907C5.56724 3.70559 5.63693 3.31257 6.69042 3.31257H8.09873V0.5H5.84568C3.1394 0.5 2.18686 1.86425 2.18686 4.15848V5.84695H0.499939V8.6592H2.18686V16.8197H5.56341Z" />
									</svg> share</a>
								<a href="#" class="share__link share__link--tw"><svg width="16" height="12" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M7.55075 3.19219L7.58223 3.71122L7.05762 3.64767C5.14804 3.40404 3.47978 2.57782 2.06334 1.1902L1.37085 0.501686L1.19248 1.01013C0.814766 2.14353 1.05609 3.34048 1.843 4.14552C2.26269 4.5904 2.16826 4.65396 1.4443 4.38914C1.19248 4.3044 0.972149 4.24085 0.951164 4.27263C0.877719 4.34677 1.12953 5.31069 1.32888 5.69202C1.60168 6.22165 2.15777 6.74068 2.76631 7.04787L3.28043 7.2915L2.67188 7.30209C2.08432 7.30209 2.06334 7.31268 2.12629 7.53512C2.33613 8.22364 3.16502 8.95452 4.08833 9.2723L4.73884 9.49474L4.17227 9.8337C3.33289 10.321 2.34663 10.5964 1.36036 10.6175C0.888211 10.6281 0.5 10.6705 0.5 10.7023C0.5 10.8082 1.78005 11.4014 2.52499 11.6344C4.75983 12.3229 7.41435 12.0264 9.40787 10.8506C10.8243 10.0138 12.2408 8.35075 12.9018 6.74068C13.2585 5.88269 13.6152 4.315 13.6152 3.56293C13.6152 3.07567 13.6467 3.01212 14.2343 2.42953C14.5805 2.09056 14.9058 1.71983 14.9687 1.6139C15.0737 1.41264 15.0632 1.41264 14.5281 1.59272C13.6362 1.91049 13.5103 1.86812 13.951 1.39146C14.2762 1.0525 14.6645 0.438131 14.6645 0.258058C14.6645 0.22628 14.5071 0.279243 14.3287 0.374576C14.1398 0.480501 13.7202 0.639389 13.4054 0.734722L12.8388 0.914795L12.3247 0.565241C12.0414 0.374576 11.6427 0.162725 11.4329 0.0991699C10.8978 -0.0491255 10.0794 -0.0279404 9.59673 0.14154C8.2852 0.618204 7.45632 1.84694 7.55075 3.19219Z" />
									</svg> tweet</a>
								<a href="#" class="share__link share__link--vk"><svg width="16" height="9" viewBox="0 0 16 9" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M8.78479 8.92255C8.78479 8.92255 9.07355 8.89106 9.22145 8.73512C9.35684 8.59224 9.35214 8.32262 9.35214 8.32262C9.35214 8.32262 9.33414 7.06361 9.92967 6.87771C10.5166 6.69489 11.2702 8.09524 12.07 8.63372C12.6741 9.04085 13.1327 8.95174 13.1327 8.95174L15.2699 8.92255C15.2699 8.92255 16.3874 8.85495 15.8576 7.99231C15.8137 7.92164 15.5485 7.35397 14.269 6.1879C12.9284 4.9673 13.1084 5.16472 14.7221 3.05305C15.705 1.76715 16.0978 0.982093 15.975 0.646407C15.8584 0.325317 15.1353 0.410582 15.1353 0.410582L12.7297 0.425177C12.7297 0.425177 12.5513 0.401365 12.419 0.478949C12.2899 0.554996 12.2061 0.732441 12.2061 0.732441C12.2061 0.732441 11.8258 1.72721 11.3179 2.57372C10.2466 4.35892 9.81855 4.4534 9.64326 4.34279C9.23554 4.08392 9.33727 3.30424 9.33727 2.75039C9.33727 1.01973 9.60491 0.298431 8.81687 0.111769C8.5555 0.0495478 8.36299 0.00883541 7.6939 0.00192196C6.83543 -0.00652779 6.10921 0.00499461 5.69758 0.202411C5.42369 0.333767 5.2124 0.627203 5.34152 0.644103C5.50038 0.664843 5.86036 0.739354 6.0513 0.994383C6.29781 1.32392 6.2892 2.06289 6.2892 2.06289C6.2892 2.06289 6.43084 4.10005 5.95818 4.35277C5.6342 4.52638 5.1897 4.17226 4.2342 2.55221C3.7451 1.7226 3.37573 0.805416 3.37573 0.805416C3.37573 0.805416 3.30451 0.634117 3.17696 0.541938C3.02279 0.430555 2.80759 0.395987 2.80759 0.395987L0.521729 0.410582C0.521729 0.410582 0.178185 0.4198 0.0521924 0.566519C-0.0597138 0.696338 0.0435842 0.965961 0.0435842 0.965961C0.0435842 0.965961 1.8333 5.07638 3.86013 7.1481C5.71871 9.04699 7.8285 8.92255 7.8285 8.92255H8.78479Z" />
									</svg> share</a>
							</div>
							<!-- end share -->
						</div>
					</div>

					<div class="row">
						<div class="col-12 col-xl-12">
							<!-- comments and reviews -->
							<div class="comments">
								<!-- tabs nav -->
								<ul class="nav nav-tabs comments__title comments__title--tabs" id="comments__tabs" role="tablist">
									<li class="nav-item">
										<a class="nav-link active" data-toggle="tab" href="#tab-1" role="tab" aria-controls="tab-1" aria-selected="true">
											<h4>Comments</h4>
											<span>
												<?php
												$this->db->where('movie_id', $row->id);
												$totalComment = $this->db->get('comments')->num_rows();
												echo $totalComment;
												?>
											</span>
										</a>
									</li>

									<li class="nav-item">
										<a class="nav-link" data-toggle="tab" href="#tab-2" role="tab" aria-controls="tab-2" aria-selected="false">
											<h4>Reviews</h4>
											<span><?php
													$this->db->where('movie_id', $row->id);
													$totalReview = $this->db->get('reviews')->num_rows();
													echo $totalReview;
													?></span>
										</a>
									</li>
								</ul>
								<!-- end tabs nav -->

								<!-- tabs -->
								<div class="tab-content">
									<!-- comments -->
									<!-- ask -->
									<div class="tab-pane fade show active" id="tab-1" role="tabpanel">
										<ul class="comments__list">
											<?php
											$this->db->where('movie_id', $row->id);
											$com = $this->db->get('comments')->result();
											foreach ($com as $val_com) { ?>
												<li class="comments__item">
													<div class="comments__autor">
														<img class="comments__avatar" src="<?php echo base_url(); ?>assets/avatar/avatar_default.png" alt="">
														<span class='comments__name'><?php echo $val_com->name; ?></span>
														<span class='comments__time'><?php echo $val_com->created_at; ?></span>

													</div>
													<p class="comments__text"><?php echo $val_com->comment; ?></p>
													<!-- <div class="comments__actions">
												<div class="comments__rate">
													<button type="button"><svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11 7.3273V14.6537" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M14.6667 10.9905H7.33333" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M15.6857 1H6.31429C3.04762 1 1 3.31208 1 6.58516V15.4148C1 18.6879 3.0381 21 6.31429 21H15.6857C18.9619 21 21 18.6879 21 15.4148V6.58516C21 3.31208 18.9619 1 15.6857 1Z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>20</button>
													<button type="button">7 <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.6667 10.9905H7.33333" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M15.6857 1H6.31429C3.04762 1 1 3.31208 1 6.58516V15.4148C1 18.6879 3.0381 21 6.31429 21H15.6857C18.9619 21 21 18.6879 21 15.4148V6.58516C21 3.31208 18.9619 1 15.6857 1Z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg></button>
												</div>			
												<button type="button"><svg xmlns='http://www.w3.org/2000/svg' width='512' height='512' viewBox='0 0 512 512'><polyline points='400 160 464 224 400 288' style='fill:none;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px'/><path d='M448,224H154C95.24,224,48,273.33,48,332v20' style='fill:none;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px'/></svg><span>Reply</span></button>
												<button type="button"><svg xmlns='http://www.w3.org/2000/svg' width='512' height='512' viewBox='0 0 512 512'><polyline points='320 120 368 168 320 216' style='fill:none;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px'/><path d='M352,168H144a80.24,80.24,0,0,0-80,80v16' style='fill:none;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px'/><polyline points='192 392 144 344 192 296' style='fill:none;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px'/><path d='M160,344H368a80.24,80.24,0,0,0,80-80V248' style='fill:none;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px'/></svg><span>Quote</span></button>
											</div> -->
												</li>
											<?php } ?>

										</ul>

										<!-- <div class="catalog__paginator-wrap catalog__paginator-wrap--comments">
										<span class="catalog__pages">5 from 16</span>

										<ul class="catalog__paginator">
											<li>
												<a href="#">
													<svg width="14" height="11" viewBox="0 0 14 11" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0.75 5.36475L13.1992 5.36475" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/><path d="M5.771 10.1271L0.749878 5.36496L5.771 0.602051" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
												</a>
											</li>
											<li class="active"><a href="#">1</a></li>
											<li><a href="#">2</a></li>
											<li><a href="#">3</a></li>
											<li><a href="#">4</a></li>
											<li>
												<a href="#">
													<svg width="14" height="11" viewBox="0 0 14 11" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13.1992 5.3645L0.75 5.3645" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/><path d="M8.17822 0.602051L13.1993 5.36417L8.17822 10.1271" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
												</a>
											</li>
										</ul>
									</div> -->
										<form action="<?php echo base_url('frontend/beranda/savecomment'); ?>" class="comments__form" method="POST">
											<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
											<input type="hidden" name="movie_id" value="<?php echo $row->id; ?>" />
											<div class="sign__group">
												<input type="text" name="name" class="sign__input" value="" placeholder="Your name" required="required" />
											</div>
											<div class="sign__group">
												<textarea id="text" name="comment" class="sign__textarea" placeholder="Add comment" required="required"></textarea>
											</div>
											<button type="submit" class="sign__btn">Send</button>
										</form>
									</div>
									<!-- end comments -->

									<!-- reviews -->
									<div class="tab-pane fade" id="tab-2" role="tabpanel">
										<ul class="reviews__list">
											<?php
											$this->db->where('movie_id', $row->id);
											$com = $this->db->get('reviews')->result();
											foreach ($com as $val_rev) { ?>
												<li class="reviews__item">
													<div class="reviews__autor">
														<img class="reviews__avatar" src="<?php echo base_url(); ?>assets/avatar/avatar_default.png" alt="">
														<span class="reviews__name"><?= $val_rev->title; ?></span>
														<span class="reviews__time"><?php echo date('d-m-Y H:i', strtotime($val_rev->created_at)); ?> by <?php echo $val_rev->name; ?></span>
														<span class="reviews__rating"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
																<path d="M22,9.67A1,1,0,0,0,21.14,9l-5.69-.83L12.9,3a1,1,0,0,0-1.8,0L8.55,8.16,2.86,9a1,1,0,0,0-.81.68,1,1,0,0,0,.25,1l4.13,4-1,5.68A1,1,0,0,0,6.9,21.44L12,18.77l5.1,2.67a.93.93,0,0,0,.46.12,1,1,0,0,0,.59-.19,1,1,0,0,0,.4-1l-1-5.68,4.13-4A1,1,0,0,0,22,9.67Zm-6.15,4a1,1,0,0,0-.29.88l.72,4.2-3.76-2a1.06,1.06,0,0,0-.94,0l-3.76,2,.72-4.2a1,1,0,0,0-.29-.88l-3-3,4.21-.61a1,1,0,0,0,.76-.55L12,5.7l1.88,3.82a1,1,0,0,0,.76.55l4.21.61Z" />
															</svg> <?php echo $val_rev->rating; ?></span>
													</div>
													<p class="reviews__text"><?php echo $val_rev->review; ?></p>
												</li>
											<?php } ?>
										</ul>

										<form action="<?php echo base_url('frontend/beranda/savereview'); ?>" method="POST" class="reviews__form">
											<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
											<input type="hidden" name="movie_id" value="<?php echo $row->id; ?>" />
											<div class="row">
												<div class="col-12 col-md-9 col-lg-10 col-xl-9">
													<div class="sign__group">
														<input type="text" name="name" class="sign__input" placeholder="Your name">
													</div>
													<div class="sign__group">
														<input type="text" name="title" class="sign__input" placeholder="Title">
													</div>
												</div>

												<div class="col-12 col-md-3 col-lg-2 col-xl-3">
													<div class="sign__group">
														<select name="select" id="select" class="sign__select">
															<option value="0">Rating</option>
															<option value="10">10</option>
															<option value="9">9</option>
															<option value="8">8</option>
															<option value="7">7</option>
															<option value="6">6</option>
															<option value="5">5</option>
															<option value="4">4</option>
															<option value="3">3</option>
															<option value="2">2</option>
															<option value="1">1</option>
														</select>
													</div>
												</div>

												<div class="col-12">
													<div class="sign__group">
														<textarea id="text2" name="text2" class="sign__textarea" placeholder="Add review"></textarea>
													</div>
												</div>

												<div class="col-12">
													<button type="submit" class="sign__btn">Send</button>
												</div>
											</div>
										</form>
									</div>
									<!-- end reviews -->
								</div>
								<!-- end tabs -->
							</div>
							<!-- end comments and reviews -->
						</div>

					</div>
				</div>
				<!-- end article -->
			</div>
		</section>
	<?php } ?>
	<!-- end details -->

	<!-- similar -->
	<section class="section">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<h2 class="section__title"><a href="category.html">Similar movies</a></h2>
				</div>

				<div class="col-12">
					<div class="section__carousel-wrap">
						<div class="section__carousel owl-carousel" id="similar">
							<?php foreach ($featured->result() as $movie) { ?>
								<div class="card">
									<a href="<?php echo base_url(); ?>details/<?php echo $movie->id; ?>" class="card__cover">
										<img src="<?php echo base_url() . 'assets/movies/' . $movie->picture; ?>" alt="">
										<svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path fill-rule="evenodd" clip-rule="evenodd" d="M11 1C16.5228 1 21 5.47716 21 11C21 16.5228 16.5228 21 11 21C5.47716 21 1 16.5228 1 11C1 5.47716 5.47716 1 11 1Z" stroke-linecap="round" stroke-linejoin="round" />
											<path fill-rule="evenodd" clip-rule="evenodd" d="M14.0501 11.4669C13.3211 12.2529 11.3371 13.5829 10.3221 14.0099C10.1601 14.0779 9.74711 14.2219 9.65811 14.2239C9.46911 14.2299 9.28711 14.1239 9.19911 13.9539C9.16511 13.8879 9.06511 13.4569 9.03311 13.2649C8.93811 12.6809 8.88911 11.7739 8.89011 10.8619C8.88911 9.90489 8.94211 8.95489 9.04811 8.37689C9.07611 8.22089 9.15811 7.86189 9.18211 7.80389C9.22711 7.69589 9.30911 7.61089 9.40811 7.55789C9.48411 7.51689 9.57111 7.49489 9.65811 7.49789C9.74711 7.49989 10.1091 7.62689 10.2331 7.67589C11.2111 8.05589 13.2801 9.43389 14.0401 10.2439C14.1081 10.3169 14.2951 10.5129 14.3261 10.5529C14.3971 10.6429 14.4321 10.7519 14.4321 10.8619C14.4321 10.9639 14.4011 11.0679 14.3371 11.1549C14.3041 11.1999 14.1131 11.3999 14.0501 11.4669Z" stroke-linecap="round" stroke-linejoin="round" />
										</svg>
									</a>
									<button class="card__add" type="button"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
											<path d="M16,2H8A3,3,0,0,0,5,5V21a1,1,0,0,0,.5.87,1,1,0,0,0,1,0L12,18.69l5.5,3.18A1,1,0,0,0,18,22a1,1,0,0,0,.5-.13A1,1,0,0,0,19,21V5A3,3,0,0,0,16,2Zm1,17.27-4.5-2.6a1,1,0,0,0-1,0L7,19.27V5A1,1,0,0,1,8,4h8a1,1,0,0,1,1,1Z" />
										</svg></button>
									<span class="card__rating"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
											<path d="M22,9.67A1,1,0,0,0,21.14,9l-5.69-.83L12.9,3a1,1,0,0,0-1.8,0L8.55,8.16,2.86,9a1,1,0,0,0-.81.68,1,1,0,0,0,.25,1l4.13,4-1,5.68A1,1,0,0,0,6.9,21.44L12,18.77l5.1,2.67a.93.93,0,0,0,.46.12,1,1,0,0,0,.59-.19,1,1,0,0,0,.4-1l-1-5.68,4.13-4A1,1,0,0,0,22,9.67Zm-6.15,4a1,1,0,0,0-.29.88l.72,4.2-3.76-2a1.06,1.06,0,0,0-.94,0l-3.76,2,.72-4.2a1,1,0,0,0-.29-.88l-3-3,4.21-.61a1,1,0,0,0,.76-.55L12,5.7l1.88,3.82a1,1,0,0,0,.76.55l4.21.61Z" />
										</svg><?php echo $row->rating ?></span>
									<h3 class="card__title"><a href="<?php echo base_url(); ?>/details/<?php echo $movie->id; ?>"><?php echo ucwords($movie->title); ?></a></h3>
									<ul class="card__list">
										<?php
										$this->db->where('movie_id', $movie->id);
										$this->db->join('categories', 'categories.id = movie_categories.category_id', 'left');
										$cat = $this->db->get('movie_categories')->result();
										foreach ($cat as $val_cat) {
											echo "<li>" . $val_cat->name . "</li>";
										}
										?>
										<li><?php echo $movie->year; ?></li>
									</ul>
								</div>
							<?php } ?>
						</div>

						<button class="section__nav section__nav--cards section__nav--prev" data-nav="#similar" type="button"><svg width="17" height="15" viewBox="0 0 17 15" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M1.25 7.72559L16.25 7.72559" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
								<path d="M7.2998 1.70124L1.2498 7.72524L7.2998 13.7502" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
							</svg></button>
						<button class="section__nav section__nav--cards section__nav--next" data-nav="#similar" type="button"><svg width="17" height="15" viewBox="0 0 17 15" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M15.75 7.72559L0.75 7.72559" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
								<path d="M9.7002 1.70124L15.7502 7.72524L9.7002 13.7502" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
							</svg></button>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end similar -->
	<script>
		$('#article__favorites').click(function() {
			var itemId = $(this).data('item-id');
			$.ajax({
				url: 'favorites/add',
				method: 'POST',
				data: {
					item_id: itemId
				},
				success: function(response) {
					alert('Added to favorites!');
				}
			});
		});
	</script>