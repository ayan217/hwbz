<?php
if ($this->session->flashdata('log_err')) {
	?>
	<div class="row justify-content-center mt-5">
		<button type="button" class="col-md-6 btn btn-inverse-danger btn-fw mb-5">
			<?= $this->session->flashdata('log_err') ?>
		</button>
	</div>
	<?php
}
?>




<section class="about1st-section loginpage">

	<div class="container text-center">
	<h1 class="mainheader">
	Login To Your Account
            </h1>
			<p class="top-text">
			Don’t have an account? <a href="#" class="jobbtn">Sign Up Now</a>
            </p>
		<form action="<?= BASE_URL . 'login' ?>" method="post">
			<input type="text" class="inputs-pags" name="username" placeholder="Username" required>
			<input type="password" class="inputs-pags" name="password" placeholder="Password" required>
			<button type="submit" class="btn primary-btn">Login</button>
		</form>
	</div>
</section>