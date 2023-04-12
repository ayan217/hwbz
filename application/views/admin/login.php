<?php
if ($this->session->flashdata('log_err')) {
?>
	<div class="row justify-content-center mt-5">
		<button type="button" class="col-md-6 btn btn-inverse-danger btn-fw mb-5"><?= $this->session->flashdata('log_err') ?></button>
	</div>
<?php
}
?>
<div class="row justify-content-center">
	<div class="col-md-6 grid-margin stretch-card">
		<div class="card w-100">
			<div class="card-body">
				<h4 class="card-title">Login</h4>
				<form class="forms-sample" action="<?= ADMIN_URL . 'Login/verify_login' ?>" method="post">
					<div class="form-group">
						<label for="exampleInputUsername1">Username</label>
						<input name="username" type="text" class="form-control" id="exampleInputUsername1" placeholder="Username">
					</div>
					<div class="form-group">
						<label for="exampleInputPassword1">Password</label>
						<input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
					</div>
					<div class="form-check form-check-flat form-check-primary">
						<label class="form-check-label">
							<input type="checkbox" class="form-check-input">
							Remember me
						</label>
					</div>
					<button name="login" type="submit" class="btn btn-primary me-2">Login</button>
				</form>
			</div>
		</div>
	</div>
</div>
