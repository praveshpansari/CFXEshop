<?php
include 'connection.php';
session_start();

if (isset($_SESSION['loggedin'])) {
	if ($_SESSION['type'] == 'trader')
		header('location:trader.php');
	else if (isset($_GET['add']) && isset($_GET['pid']) && isset($_GET['min'])) {
		$cart = $_SESSION['cartId'];
		$pid = $_GET['pid'];
		$min = $_GET['min'];
		$query = oci_parse($conn, "BEGIN add_to_cart('${cart}', '${pid}', '${min}'); END;");
		oci_execute($query);
	} else {
?>
		<!DOCTYPE html>
		<html lang="en">

		<head>
			<title>Vegefoods - Free Bootstrap 4 Template by Colorlib</title>
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

			<link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap" rel="stylesheet">
			<link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i&display=swap" rel="stylesheet">
			<link href="https://fonts.googleapis.com/css?family=Amatic+SC:400,700&display=swap" rel="stylesheet">

			<link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
			<link rel="stylesheet" href="css/animate.css">

			<link rel="stylesheet" href="css/owl.carousel.min.css">
			<link rel="stylesheet" href="css/owl.theme.default.min.css">
			<link rel="stylesheet" href="css/magnific-popup.css">

			<link rel="stylesheet" href="css/aos.css">

			<link rel="stylesheet" href="css/ionicons.min.css">

			<link rel="stylesheet" href="css/bootstrap-datepicker.css">
			<link rel="stylesheet" href="css/jquery.timepicker.css">


			<link rel="stylesheet" href="css/flaticon.css">
			<link rel="stylesheet" href="css/icomoon.css">
			<link rel="stylesheet" href="css/style.css">
		</head>

		<body class="goto-here">
			<div class="py-1 bg-primary">
				<div class="container">
					<div class="row no-gutters d-flex align-items-start align-items-center px-md-0">
						<div class="col-lg-12 d-block">
							<div class="row d-flex">
								<div class="col-md pr-4 d-flex topper align-items-center">
									<div class="icon mr-2 d-flex justify-content-center align-items-center"><span class="icon-phone2"></span></div>
									<span class="text">+ 1235 2355 98</span>
								</div>
								<div class="col-md pr-4 d-flex topper align-items-center">
									<div class="icon mr-2 d-flex justify-content-center align-items-center"><span class="icon-paper-plane"></span></div>
									<span class="text">eshop@cfx.com</span>
								</div>
								<div class="col-md-5 pr-4 d-flex topper align-items-center text-lg-right">
									<span class="text">3-5 Business days &amp; Free Returns</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
				<div class="container">
					<a class="navbar-brand" href="index.php">Vegefoods</a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
						<span class="oi oi-menu"></span> Menu
					</button>

					<div class="collapse navbar-collapse" id="ftco-nav">
						<ul class="navbar-nav ml-auto">
							<li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
							<li class="nav-item"><a class="nav-link" href="shop.php">Shop</a></li>
							<li class="nav-item"><a href="about.php" class="nav-link">About</a></li>
							<li class="nav-item"><a href="contact.php" class="nav-link">Contact</a></li>
							<li class="nav-item"><a href="dashboard.php" class="nav-link">Profile</a></li>
							<li class="nav-item active cta cta-colored"><a href="cart.php" class="nav-link"><span class="icon-shopping_cart"></span>[0]</a></li>
							<li class="nav-item btn-nav"><a href="logout.php" class="nav-link">LOGOUT</a></li>
						</ul>
					</div>
				</div>
			</nav>
			<!-- END nav -->

			<div class="hero-wrap hero-bread" style="background-image: url('images/bg_1.jpg');">
				<div class="container">
					<div class="row no-gutters slider-text align-items-center justify-content-center">
						<div class="col-md-9 ftco-animate text-center">
							<p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home</a></span> <span>Cart</span></p>
							<h1 class="mb-0 bread">My Cart</h1>
						</div>
					</div>
				</div>
			</div>

			<section class="ftco-section ftco-cart">
				<div class="container">
					<?php
					$cart = $_SESSION['cartId'];
					$query = oci_parse($conn, "BEGIN :count := num_products('${cart}'); END;");
					oci_bind_by_name($query, ":count", $count);
					oci_execute($query);
					if ($count > 0) {
					?>
						<div class="row">
							<div class="col-md-12 ftco-animate">

								<div class="cart-list">

									<table class="table">
										<thead class="thead-primary">
											<tr class="text-center">
												<th>&nbsp;</th>
												<th>&nbsp;</th>
												<th>Product name</th>
												<th>Price</th>
												<th>Quantity</th>
												<th>Total</th>
											</tr>
										</thead>
										<tbody>
											<?php

											$query = oci_parse($conn, "SELECT * FROM PRODUCTS_IN_CART WHERE CART_ID = '${cart}'");
											oci_execute($query);
											while ($result = oci_fetch_assoc($query)) {
											?>
												<tr class="text-center">
													<td class="product-remove"><a class="remove-icon" id="<?= $result['PRODUCT_ID'] ?>" style="cursor: pointer;font-size:1.5rem"><span class="ion-ios-close"></span></a></td>

													<td class="image-prod">
														<div class="img" style="background-image:url(<?= $result['PRODUCT_IMAGE'] ?>);"></div>
													</td>

													<td class="product-name">
														<h3><?= $result['PRODUCT_NAME'] ?></h3>
														<p><?= $result['DESCRIPTION'] ?></p>
													</td>

													<td class="price">$<?= number_format($result['PRICE'], 2); ?></td>

													<td class="quantity">
														<div class="input-group mb-3">
															<input type="number" id="<?= $result['PRODUCT_ID'] ?>" name="quantity" class="quantity form-control input-number" value="<?= $result['ITEM_QUANTITY'] ?>" min="<?= $result['MIN_ORDER'] ?>" max="<?= $result['MAX_ORDER'] ?>">
														</div>
													</td>

													<td class="total">
														<div class="upP" id="<?= $result['PRODUCT_ID'] ?>">$<?= number_format($result['TOTAL'], 2) ?></div>
													</td>

												</tr>
											<?php } ?>
										</tbody>
									</table>

								</div>
							</div>
						</div>
						<div class="row justify-content-end">
							<div class="col-lg-6 mt-5 cart-wrap ftco-animate">
								<div class="cart-total mb-3">
									<h3>Cart Totals</h3>
									<div id="amount">
										<?php
										$query = oci_parse($conn, "SELECT * FROM CART WHERE CART_ID = '${cart}'");
										oci_execute($query);
										$result = oci_fetch_assoc($query);
										$discount = $result['AMOUNT'] * $result['DISCOUNT'] / 100;
										?>
										<p class="d-flex">
											<span>Subtotal</span>
											<span>$<?= number_format($result['AMOUNT'], 2); ?></span>
										</p>
										<p class="d-flex">
											<span>Discount</span>
											<span>$<?= number_format($discount, 2) ?></span>
										</p>
										<hr>
										<p class="d-flex total-price">
											<span>Total</span>
											<span>$<?= number_format($result['NET_AMOUNT'], 2) ?></span>
										</p>
									</div>
								</div>
								<p><a href="checkout.php" class="btn btn-primary py-3 px-4">Proceed to Checkout</a></p>
							</div>
						</div>
					<?php } else {
						echo "NO PRODUCTS IN CART";
					} ?>
				</div>
			</section>

			<section class="ftco-section ftco-no-pt ftco-no-pb py-5 bg-light">
				<div class="container py-4">
					<div class="row d-flex justify-content-center py-5">
						<div class="col-md-6">
							<h2 style="font-size: 22px;" class="mb-0">Subcribe to our Newsletter</h2>
							<span>Get e-mail updates about our latest shops and special offers</span>
						</div>
						<div class="col-md-6 d-flex align-items-center">
							<form action="#" class="subscribe-form">
								<div class="form-group d-flex">
									<input type="text" class="form-control" placeholder="Enter email address">
									<input type="submit" value="Subscribe" class="submit px-3">
								</div>
							</form>
						</div>
					</div>
				</div>
			</section>
			<footer class="ftco-footer ftco-section">
				<div class="container">
					<div class="row">
						<div class="mouse">
							<a href="#" class="mouse-icon">
								<div class="mouse-wheel"><span class="ion-ios-arrow-up"></span></div>
							</a>
						</div>
					</div>
					<div class="row mb-5">
						<div class="col-md">
							<div class="ftco-footer-widget mb-4">
								<h2 class="ftco-heading-2">CFX eShop</h2>
								<p>We aim to provide the best quality and fresh products from all the local traders of the Cleckhuddersfax
									area to you at your convenience and feasible rates.</p>
								<ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-5">
									<li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
									<li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
									<li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
								</ul>
							</div>
						</div>
						<div class="col-md">
							<div class="ftco-footer-widget mb-4 ml-md-5">
								<h2 class="ftco-heading-2">Menu</h2>
								<ul class="list-unstyled">
									<li><a href="#" class="py-2 d-block">Shop</a></li>
									<li><a href="#" class="py-2 d-block">About</a></li>
									<li><a href="#" class="py-2 d-block">Journal</a></li>
									<li><a href="#" class="py-2 d-block">Contact Us</a></li>
								</ul>
							</div>
						</div>
						<div class="col-md-4">
							<div class="ftco-footer-widget mb-4">
								<h2 class="ftco-heading-2">Help</h2>
								<div class="d-flex">
									<ul class="list-unstyled mr-l-5 pr-l-3 mr-4">
										<li><a href="#" class="py-2 d-block">Shipping Information</a></li>
										<li><a href="#" class="py-2 d-block">Returns &amp; Exchange</a></li>
										<li><a href="#" class="py-2 d-block">Terms &amp; Conditions</a></li>
										<li><a href="#" class="py-2 d-block">Privacy Policy</a></li>
									</ul>
									<ul class="list-unstyled">
										<li><a href="#" class="py-2 d-block">FAQs</a></li>
										<li><a href="#" class="py-2 d-block">Contact</a></li>
									</ul>
								</div>
							</div>
						</div>
						<div class="col-md">
							<div class="ftco-footer-widget mb-4">
								<h2 class="ftco-heading-2">Have a Questions?</h2>
								<div class="block-23 mb-3">
									<ul>
										<li><span class="icon icon-map-marker"></span><span class="text">11 Avenue Street,
												Cleckshudderfax, UK</span></li>
										<li><a href="#"><span class="icon icon-phone"></span><span class="text">+2 392 3929
													210</span></a></li>
										<li><a href="#"><span class="icon icon-envelope"></span><span class="text">info@cfx.com</span></a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 text-center">

							<p> Copyright &copy;2020 All rights reserved
							</p>
						</div>
					</div>
				</div>
			</footer>



			<!-- loader -->
			<div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
					<circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
					<circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00" /></svg></div>


			</script>
			<script src="js/jquery.min.js"></script>
			<script src="js/jquery-migrate-3.0.1.min.js"></script>
			<script src="js/popper.min.js"></script>
			<script src="js/bootstrap.min.js"></script>
			<script src="js/jquery.easing.1.3.js"></script>
			<script src="js/jquery.waypoints.min.js"></script>
			<script src="js/jquery.stellar.min.js"></script>
			<script src="js/owl.carousel.min.js"></script>
			<script src="js/jquery.magnific-popup.min.js"></script>
			<script src="js/aos.js"></script>
			<script src="js/jquery.animateNumber.min.js"></script>
			<script src="js/bootstrap-datepicker.js"></script>
			<script src="js/scrollax.min.js"></script>
			<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
			<script src="js/google-map.js"></script>
			<script src="js/main.js"></script>



		</body>

		</html>
<?php }
} else {
	echo "Page not found";
} ?>