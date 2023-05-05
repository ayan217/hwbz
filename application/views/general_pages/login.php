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
		<h1 class="normal-header">
			Login To Your Account
		</h1>
		<p class="top-text login-top">
			Don’t have an account? <a href="#" class="jobbtn">Sign Up Now</a>
		</p>
		<form action="<?= BASE_URL . 'login' ?>" method="post">
			<input type="text" class="inputs-pags" name="username" placeholder="Username" required>
			<input type="password" class="inputs-pags paw" name="password" placeholder="Password" required>

			<div class="forgetpass">
				<div class="check-box"><input class="cb3" type="checkbox"  /> <label for="" class="text-keep">Keep me logged in</label> </div>
				<div class="forget-text"><a href="#" class="forgetanchor">Forgot password?</a> </div>
				
			</div>
			<button type="submit" class="btn primary-btn">Login</button>
		</form>
	</div>
</section>