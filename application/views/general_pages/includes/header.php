<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>
		<?= $title ?>
	</title>
	<!-- plugins:css -->
	<link rel="stylesheet" href="<?= ASSET_URL ?>templete/vendors/feather/feather.css">
	<link rel="stylesheet" href="<?= ASSET_URL ?>templete/vendors/mdi/css/materialdesignicons.min.css">
	<link rel="stylesheet" href="<?= ASSET_URL ?>templete/vendors/ti-icons/css/themify-icons.css">
	<link rel="stylesheet" href="<?= ASSET_URL ?>templete/vendors/typicons/typicons.css">
	<link rel="stylesheet" href="<?= ASSET_URL ?>templete/vendors/simple-line-icons/css/simple-line-icons.css">
	<link rel="stylesheet" href="<?= ASSET_URL ?>templete/vendors/css/vendor.bundle.base.css">
	<link rel="stylesheet" href="<?= ASSET_URL ?>templete/css/vertical-layout-light/style.css">
	<link rel="stylesheet" href="<?= ASSET_URL ?>/css/style.css">
	<link rel="stylesheet" href="<?= ASSET_URL ?>fontawesome/css/all.min.css">
	<link rel="stylesheet" href="<?= ASSET_URL ?>/css/responsive.css">
	<!-- endinject -->
	<script src="<?= ASSET_URL . 'js/jquery-3.6.4.min.js' ?>"></script>
</head>

<body>
	<div class="container-scroller">

		<header>

			<nav class="big-screen">
				<div class="d-flex justify-content-between">

					<div class="logo"> <a href="<?= BASE_URL ?>"><img src="<?= ASSET_URL ?>/images/logo.png" alt=""></a>
					</div>
					<div class="navbtns-maindiv d-flex ">
						<div class="navbtns"><a href="<?= BASE_URL ?>about" class="navlinks">About</a></div>
						<div class="navbtns"><a href="<?= BASE_URL ?>faq" class="navlinks">Faq's</a></div>
						<div class="navbtns"><a href="<?= BASE_URL ?>contact-us" class="navlinks">Contact</a></div>
						<div class="navbtns"><a href="login" class="navlinks">Login</a></div>
						<div class="navbtns signup"><a href="signup" class="navlinks primary-btn">Sign Up</a></div>
					</div>

				</div>
			</nav>


			<!-- phone nav bar -->

			<nav class="phone">
				<div class="d-flex justify-content-between">

					<div class="logo"> <a href="<?= BASE_URL ?>"><img src="<?= ASSET_URL ?>/images/logo.png" alt=""></a>
					</div>
					<div class="navbtns signup"><a href="signup" class="navlinks signup primary-btn btn">Sign Up</a></div>
					<div class="nav-togglebtn">
						<div class="cross1"></div>
						<div class="cross2"></div>
						<div class="cross1"></div>
					</div>

				</div>
			</nav>


			<div class="sliderphone toggle-cls">
				<div class="navbtns phonrs"><a href="<?= BASE_URL ?>about" class="navlinks">About</a></div>
				<div class="navbtns phonrs"><a href="#" class="navlinks">Faq's</a></div>
				<div class="navbtns phonrs"><a href="#" class="navlinks">Contact</a></div>
				<div class="navbtns phonrs"><a href="login" class="navlinks">Login</a></div>

			</div>
		</header>
