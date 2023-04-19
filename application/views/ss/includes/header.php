<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title><?= $title ?></title>
	<!-- plugins:css -->
	<link rel="stylesheet" href="<?= ASSET_URL ?>templete/vendors/feather/feather.css">
	<link rel="stylesheet" href="<?= ASSET_URL ?>templete/vendors/mdi/css/materialdesignicons.min.css">
	<link rel="stylesheet" href="<?= ASSET_URL ?>templete/vendors/ti-icons/css/themify-icons.css">
	<link rel="stylesheet" href="<?= ASSET_URL ?>templete/vendors/typicons/typicons.css">
	<link rel="stylesheet" href="<?= ASSET_URL ?>templete/vendors/simple-line-icons/css/simple-line-icons.css">
	<link rel="stylesheet" href="<?= ASSET_URL ?>templete/vendors/css/vendor.bundle.base.css">
	<link rel="stylesheet" href="<?= ASSET_URL ?>templete/css/vertical-layout-light/style.css">
	<!-- endinject -->
	<script src="<?= ASSET_URL . 'js/jquery-3.6.4.min.js' ?>"></script>
</head>

<body>
	<div class="container-scroller">
		<?php if ($template !== 'login') { ?>
			<?php include(APPPATH . 'views/' . $folder . '/includes/menubar.php'); ?>
			<?php include(APPPATH . 'views/' . $folder . '/includes/sidebar.php'); ?>
		<?php } ?>
