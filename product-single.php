<?php
include 'connection.php';

if (!isset($_GET['product'])) {
	die(header('location:shop.php'));
}
session_start();
$id = $_GET['product'];
$query = oci_parse($conn, "SELECT * FROM PRODUCT NATURAL JOIN SHOP_PRODUCT WHERE PRODUCT_ID = '${id}'");
oci_execute($query);
$result = oci_fetch_assoc($query);
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

	<div id="myModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content modal-dialog">
				<div class="modal-header">
					<h5 class="modal-title">
						<div class="nav nav-tabs" id="nav-tab" role="tablist">
							<a class="nav-item nav-link active" id="nav-login-tab" data-toggle="tab" href="#nav-login" role="tab" aria-controls="nav-login" aria-selected="true">Login</a>

							<a class="nav-item nav-link" id="nav-register-tab" data-toggle="tab" href="#nav-register" role="tab" aria-controls="nav-register" aria-selected="false">Register</a>

						</div>
					</h5><button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="tab-content" id="nav-tabContent">
						<div class="tab-pane fade show active" id="nav-login" role="tabpanel" aria-labelledby="nav-login-tab">
							<form class="bg-white p-3 login-form" id="loginForm">
								<div class="form-group">
									<label for="emailId">Email address</label>
									<input id="emailId" name="emailId" type="text" class="form-control validate" placeholder="Enter email" required>
								</div>
								<div class="form-group">
									<label for="password">Password</label>
									<input id="password" name="password" type="password" class="form-control validate" placeholder="Password" required>
								</div>
								<div class="form-group">
									<input type="submit" id="loginBtn" value="Login" class="btn btn-primary py-2 px-5">
									<label class="offset-2"><a href="#">Forgot password?</a></label>
								</div>

							</form>
						</div>

						<div class="tab-pane fade" id="nav-register" role="tabpanel" aria-labelledby="nav-register-tab">
							<form class="bg-white p-3 register-form" id="registerForm" action="" method="post">
								<div class="form-row mb-3">
									<div class="col-md-6 col-sm-12">
										<label for="first_name">First Name</label>
										<input id="first_name" type="text" class="form-control validate" maxlength="25" name="first_name" required>
									</div>
									<div class="col-md-6 col-sm-12">
										<label for="last_name">Last Name</label>
										<input id="last_name" type="text" class="form-control validate" maxlength="25" name="last_name" required>
									</div>
								</div>
								<div class="form-row mb-3">
									<div class="col-12">
										<label for="registerEmail">Email</label>
										<input id="registerEmail" type="text" class="form-control validate" maxlength="40" name="registerEmail" required>
									</div>
								</div>
								<div class="form-row mb-3">
									<div class="col-6">
										<label for="username">Username</label>
										<input id="username" type="text" class="form-control validate" maxlength="25" minlength="6" name="username" required>
									</div>
									<div class="col-6">
										<label for="registerPassword">Password</label>
										<input id="registerPassword" type="password" class="form-control validate" maxlength="20" minlength="6" name="registerPassword" required>
									</div>
								</div>
								<div class="form-row mb-3">
									<div class="col-6">
										<label for="phone">Phone Number</label>
										<input id="phone" maxlength="12" type="tel" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" placeholder="123-456-7890" class="form-control validate" data-length="20" name="phone" required>
									</div>
									<div class="col-6">
										<label for="age" class="ml-2">Age</label>
										<input type="range" class="custom-range col-10 ml-2" value="20" name="age" id="age" min="16" max="100" onchange="updateAge(this.value)" />
										<span id="ageValue" class="offset-10">20</span>
									</div>
								</div>
								<div class="form-row mb-3">
									<div class="col-12 custom-control custom-checkbox">
										<input type="checkbox" class="form-control custom-control-input" id="conditions" required name="terms" />
										<label class="custom-control-label" for="conditions">I agree to the terms and
											conditions.</label>
									</div>
								</div>
								<div class="form-row mb-3">
									<button class="btn btn-primary col s12 z-depth-0" id="registerBtn" type="submit">Register
									</button>
								</div>
							</form>
						</div>
					</div>
					<div id="registering">

					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

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
					<li class="nav-item active"><a class="nav-link" href="shop.php">Shop</a></li>
					<li class="nav-item"><a href="about.php" class="nav-link">About</a></li>
					<li class="nav-item"><a href="contact.php" class="nav-link">Contact</a></li>
					<?php
					if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
						echo '<li class="nav-item"><a href="dashboard.php" class="nav-link">Profile</a></li><li class="nav-item cta cta-colored"><a href="cart.php" class="nav-link">
						<span class="icon-shopping_cart" id="products-cart"></span>[0]</a></li>
						<li class="nav-item btn-nav"><a class="nav-link" href="logout.php">LOGOUT</a></li>';
					} else {
						echo '<li class="nav-item btn-nav"><a class="nav-link" data-toggle="modal" data-target="#myModal">LOGIN</a></li>';
					} ?>

				</ul>
			</div>
		</div>
	</nav>
	<!-- END nav -->

	<div class="hero-wrap hero-bread" style="background-image: url('images/bg_1.jpg');">
		<div class="container">
			<div class="row no-gutters slider-text align-items-center justify-content-center">
				<div class="col-md-9 ftco-animate text-center">
					<p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home</a></span> <span class="mr-2"><a href="shop.php">Product</a></span> <span><?= $result['PRODUCT_NAME'] ?></span></p>
					<h1 class="mb-0 bread"><?= $result['PRODUCT_NAME'] ?></h1>
				</div>
			</div>
		</div>
	</div>

	<section class="ftco-section">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 mb-5 ftco-animate">
					<a href="<?= $result['PRODUCT_IMAGE'] ?>" class="image-popup"><img src="<?= $result['PRODUCT_IMAGE'] ?>" class="img-fluid" style="width:100%"></a>
				</div>
				<div class="col-lg-6 product-details pl-md-5 ftco-animate">
					<input type="hidden" id="pid" value=<?= $id ?>>
					<h3><?= $result['PRODUCT_NAME'] ?></h3>
					<div class="rating d-flex" id="given2">
						<p class="text-left mr-4">
							<?php
							$rate = oci_parse($conn, "SELECT avg(stars) stars FROM PRODUCT_REVIEW WHERE PRODUCT_ID = '${id}'");
							oci_execute($rate);
							$rating = oci_fetch_assoc($rate);
							?>
							<a href="#" class="stars mr-2"><?= number_format($rating['STARS'], 1) ?></a>
							<?php
							$stars = round($rating['STARS']);
							for ($x = 0; $x < 5; $x++) {
								if ($stars == 0)
									echo '<a class="stars" style="font-size:1.15rem" href=""><span class="ion-ios-star-outline"> </span></a>';
								else {
									echo '<a class="stars" style="font-size:1.15rem" href=""><span class="ion-ios-star"> </span></a>';
									$stars--;
								}
							}
							?>
						</p>
						<p class="text-left mr-4">
							<?php
							$query1 = oci_parse($conn, "SELECT count(*) NUM FROM PRODUCT_REVIEW WHERE PRODUCT_ID = '${id}'");
							oci_execute($query1);
							$result1 = oci_fetch_assoc($query1);
							?>
							<a href="#" class="stars mr-2" style="color: #000;"><?= $result1['NUM'] ?> <span style="color: #bbb;">Ratings</span></a>
						</p>
					</div>
					<p class="price"><span>$<?= $result['PRICE'] ?></span></p>
					<p><?= $result['DESCRIPTION'] ?>
					</p>
					<div class="row mt-4">
						<div class="w-100"></div>

						<?php
						$cid = $_SESSION['cartId'];
						$incart = oci_parse($conn, "BEGIN :count := check_cart('${cid}', '${id}'); END;");
						oci_bind_by_name($incart, ":count", $num);
						oci_execute($incart);
						if ($num == 0) {
						?>
							<div id="quanta" style="display: block;" class="col-md-12 no-gutters">
							<?php } else { ?>
								<div id="quanta" style="display: none;" class="col-md-12 no-gutters">
								<?php } ?>
								<div class="input-group col-md-6 d-flex mb-3">
									<span class="input-group-btn mr-2">
										<button type="button" class="quantity-left-minus btn btn-number" data-type="minus" data-field="quantity">
											<i class="ion-ios-remove"></i>
										</button>
									</span>
									<input type="text" id="quantity" name="quantity" class="form-control input-number" value="<?= $result['MIN_ORDER'] ?>" min="<?= $result['MIN_ORDER'] ?>" max="<?= $result['MAX_ORDER'] ?>">
									<span class="input-group-btn ml-2">
										<button type="button" class="quantity-right-plus btn btn-number" data-type="plus" data-field="quantity">
											<i class="ion-ios-add"></i>
										</button>
									</span>
								</div>
								</div>
								<div class="w-100"></div>

								<div class="col-md-12">
									<h6>Quantity per Item: <?= $result['QUANTITY'] ?></h6>
									<p style="color: #000;">
										<?php
										$stock =  (int) filter_var($result['QUANTITY'], FILTER_SANITIZE_NUMBER_INT) * $result['STOCK_AMOUNT'];
										$unit = explode(' ', $result['QUANTITY']);

										if (strpos($unit[1], 'grams') !== false)
											echo (($stock < 1000) ? $stock : $stock / 1000) . " kilo" . $unit[1];
										else if (strpos($unit[1], 'ml') !== false)
											echo (($stock < 1000) ? $stock : $stock / 1000) . " litres";
										else if (strpos($unit[1], 'slices') !== false || strpos($unit[1], 'pieces') !== false)
											echo $stock . " " . $unit[1];
										else
											echo $stock . " " . $unit[1] . "s";
										?> available</p>
								</div>

							</div>
							<p>
								<div class="row">
									<div class="col-md-6">
										<div id="cart-btn">
											<?php
											$cid = $_SESSION['cartId'];
											$incart = oci_parse($conn, "BEGIN :count := check_cart('${cid}', '${id}'); END;");
											oci_bind_by_name($incart, ":count", $num);
											oci_execute($incart);
											echo (($num == 0) ? '<a id="add-cart" class="btn btn-black col-md-12 py-3"><span>Add to Cart</span></a>' : '<a id="rem-cart" class="btn btn-black col-md-12 py-3"><span>Remove from Cart</span></a>');
											?>
										</div>
									</div>

									<?php if (isset($_SESSION['loggedin'])) {
										$cid = $_SESSION['id'];
										$x = oci_parse($conn, "SELECT count(*) num FROM PRODUCT_REVIEW WHERE PRODUCT_ID = '${id}' AND CUSTOMER_ID = '${cid}'");
										oci_execute($x);
										$given = oci_fetch_assoc($x);
										$count = $given['NUM'];
										if ($count != 0) {
											$x = oci_parse($conn, "SELECT STARS FROM PRODUCT_REVIEW WHERE PRODUCT_ID = '${id}' AND CUSTOMER_ID = '${cid}'");
											oci_execute($x);
											$given = oci_fetch_assoc($x);
											$rated = $given['STARS'];
										} else {
											$rated = 0;
										}
										echo '<div class="col-md-5 offset-md-1"><div id="given">';
										for ($i = 1; $i < 6; $i++) {
											if ($rated == 0)
												echo '<a class="stars give" id="' . $i . '" style="font-size:1.85rem" href=""><span class="ion-ios-star-outline">&nbsp; </span></a>';
											else {
												echo '<a class="stars give" id="' . $i . '" style="font-size:1.85rem" href=""><span class="ion-ios-star">&nbsp; </span></a>';
												$rated--;
											}
										}
									?>
									<?php echo '</div></div>';
									} ?>
								</div>
							</p>
					</div>
				</div>
			</div>
	</section>

	<!-- <section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center mb-3 pb-3">
				<div class="col-md-12 heading-section text-center ftco-animate">
					<span class="subheading">Products</span>
					<h2 class="mb-4">Related Products</h2>
					<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia</p>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-lg-3 ftco-animate">
					<div class="product">
						<a href="#" class="img-prod"><img class="img-fluid" src="images/product-4.jpg" alt="Colorlib Template">
							<div class="overlay"></div>
						</a>
						<div class="text py-3 pb-4 px-3 text-center">
							<h3><a href="#">Purple Cabbage</a></h3>
							<div class="d-flex">
								<div class="pricing">
									<p class="price"><span>$120.00</span></p>
								</div>
							</div>
							<div class="bottom-area d-flex px-3">
								<div class="m-auto d-flex">
									<a href="#" class="add-to-cart d-flex justify-content-center align-items-center text-center">
										<span><i class="ion-ios-menu"></i></span>
									</a>
									<a href="#" class="buy-now d-flex justify-content-center align-items-center mx-1">
										<span><i class="ion-ios-cart"></i></span>
									</a>
									<a href="#" class="heart d-flex justify-content-center align-items-center ">
										<span><i class="ion-ios-heart"></i></span>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section> -->

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
						<h2 class="ftco-heading-2">Vegefoods</h2>
						<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia.</p>
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
								<li><span class="icon icon-map-marker"></span><span class="text">11 Avenue Street, Cleckshudderfax, UK</span></li>
								<li><a href="#"><span class="icon icon-phone"></span><span class="text">+2 392 3929 210</span></a></li>
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
	<script>
		$(document).on('click', '#add-cart', function(e) {
			e.preventDefault();
			var pid = $('#pid').val();
			if (parseInt($('#quantity').val())) min = parseInt($('#quantity').val());
			else var min = 0;

			$.ajax({
				url: "cart.php",
				method: "get",
				data: {
					add: 1,
					pid: pid,
					min: min
				},
				success: function(data) {
					if (data != "Page not found") {
						$('#cart-btn').load(window.location.href + " #cart-btn");
						if ($('#quanta').css('display') == 'block')
							$('#quanta').css("display", "none");
					} else {
						$("#myModal").modal("show");
					}
				},
			});
		});

		$(document).on('click', '#rem-cart', function(e) {

			e.preventDefault();
			var pid = $('#pid').val();
			$.ajax({
				url: "update-cart.php",
				method: "get",
				data: {
					pid: pid,
					rem: 1
				},
				success: function(data) {
					if (data == "done") {
						$('#cart-btn').load(window.location.href + " #cart-btn");
						$('#quanta').css('display', 'block');
					}
				},
			});
		});
	</script>

</body>

</html>