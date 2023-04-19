<?php
if ($this->session->flashdata('log_err')) {
?>
	<div class="row justify-content-center mt-5">
		<button type="button" class="col-md-6 btn btn-inverse-danger btn-fw mb-5"><?= $this->session->flashdata('log_err') ?></button>
	</div>
<?php
}
?>
<form action="<?= BASE_URL . 'login' ?>" method="post">
	<input type="text" name="username" placeholder="Username" required>
	<input type="password" name="password" placeholder="Password" required>
	<button type="submit">Login</button>
</form>
