<div class="content-wrapper">
	<?php
	if ($this->session->flashdata('log_suc')) {
	?>
		<button type="button" class="cpy-alert btn btn-inverse-success btn-fw mb-2 w-100"><?= $this->session->flashdata('log_suc') ?></button>
	<?php
	} elseif ($this->session->flashdata('log_err')) {
	?>
		<button type="button" class="cpy-alert btn btn-inverse-danger btn-fw mb-2 w-100"><?= $this->session->flashdata('log_err') ?></button>
	<?php
	}
	?>
	<div class="row">
		<div class="col-md-12 grid-margin stretch-card">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title">Change Password</h4>
					<hr>
					<form class="forms-sample" method="post" action="<?= base_url('ss/change-password') ?>" id="change_password">
						<div class="form-group">
							<label for="exampleInputEmail1">Old Password</label>
							<input required type="password" name="old_psw" placeholder="Enter Old Password" class="form-control">
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">New Password</label>
							<input required type="password" name="new_psw" placeholder="Enter New Password" class="form-control">
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">Confirm New Password</label>
							<input required type="password" name="confirm_new_psw" placeholder="Confirm New Password" class="form-control">
						</div>
						<button type="submit" class="btn btn-warning btn-rounded btn-fw me-2">Change</button>
						<div class="text-danger" id="error"></div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(e) {
		$("#change_password").on('submit', (function(e) {
			e.preventDefault();
			var url = $(this).attr('action');
			$.ajax({
				url: url,
				mimeType: "multipart/form-data",
				contentType: false,
				cache: false,
				processData: false,
				data: new FormData(this),
				type: 'post',
				dataType: 'json',
				success: function(result) {
					if (result.status == 1) {
						var success_url = '<?= base_url('logout') ?>';
						window.location.replace(success_url);
					} else {
						$('#error').html(result.msg);
					}
				},
				error: function(result) {

				}
			});
		}));
	});
</script>
