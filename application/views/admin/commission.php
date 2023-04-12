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
	<div class="grid-margin stretch-card w-100">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">Commission Percentage (%)</h4>
				<form action="<?= ADMIN_URL ?>commission" method="post">
					<div>
						<h3>Site Commission Percentage</h3>
					</div>
					<div>
						<input required type="text" name="commission" class="form-control" value="<?= $commission_percentage ?>" pattern="\d+(\.\d{1,2})?"><span>%</span>
					</div>
					<div>
						<button name="update_commission_btn" type="submit" class="btn btn-success btn-rounded btn-fw mt-3">Update</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
