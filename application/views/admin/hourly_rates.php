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
	<div class="grid-margin stretch-card w-100 mb-2">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">Hourly Rates</h4>
				<div class="d-flex justify-content-center">
					<form class="forms-sample" action="<?= ADMIN_URL ?>hourly-rates" method="post">
						<div class="row">
							<div class="col-md-4">
								<select name="hcp_state" id="" class="form-control">
									<option value="" selected disabled>Select State</option>
									<?php
									if (!empty($all_usa_states)) {
										foreach ($all_usa_states as $state) {
									?>
											<option value="<?= $state->id ?>"><?= $state->Name ?> (<?= $state->Code ?>)</option>
									<?php
										}
									}
									?>
								</select>
							</div>
							<div class="col-md-4">
								<select name="hcp_service" id="" class="form-control">
									<option value="" selected disabled>Select Service</option>
									<?php
									if (!empty($hcp_services)) {
										foreach ($hcp_services as $hcp_service) {
									?>
											<option value="<?= $hcp_service->id ?>"><?= $hcp_service->name ?></option>
									<?php
										}
									}
									?>
								</select>
							</div>
							<div class="col-md-4">
								<input type="text" name="hourly_rate" class="form-control" required>
							</div>
						</div>
						<div class="mt-3 d-flex justify-content-center">
							<button name="add_hourly_rate_btn" type="submit" class="btn btn-warning btn-rounded btn-fw">Add</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="grid-margin stretch-card w-100">
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
					<table class="table" id="example">
						<thead>
							<tr>
								<th>State</th>
								<th>Service</th>
								<th>Hourly Rate</th>
								<th>Edit</th>
								<th>Delete</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if (!empty($hourly_rates)) {
								foreach ($hourly_rates as $hourly_rate) {
							?>

									<tr>
										<td id="hourly_rate_state<?= $hourly_rate->id ?>"><?= $hourly_rate->state_name ?> (<?= $hourly_rate->state_code ?>)</td>
										<td id="hourly_rate_service<?= $hourly_rate->id ?>"><?= $hourly_rate->service_name ?></td>
										<td id="hourly_rate<?= $hourly_rate->id ?>">$<?= $hourly_rate->amount ?></td>
										<td id="hourly_rate_edit_btn<?= $hourly_rate->id ?>" data-state_id="<?= $hourly_rate->state_id ?>" data-service_id="<?= $hourly_rate->service_id ?>" data-rate="<?= $hourly_rate->amount ?>"><a href="javascript:void(0)" type="button" class="btn btn-warning btn-rounded btn-fw" onclick="update_hourly_rate_form(<?= $hourly_rate->id ?>)">Edit</a></td>
										<td><a href="<?= ADMIN_URL ?>Settings/delete_hourly_rate/<?= $hourly_rate->id ?>" type="button" class="btn btn-danger btn-rounded btn-fw">Delete</a></td>
									</tr>
							<?php
								}
							} else {
								echo '<tr><td colspan="3">No HCP Service Found</tr>';
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	function update_hourly_rate(hcp_id) {
		var hcp_name = $('#hcp_edit_btn' + hcp_id).data('hcp_name');
		var hcp_input_field = '<input type="text" id="hcp_service' + hcp_id + '" class="form-control" value="' + hcp_name + '">';
		var hcp_edit_btn = "<button type='button' onclick='update_hcp(" + hcp_id + ")' class='btn btn-warning btn-rounded btn-fw'>Update</button>";
		$('#hcp_name' + hcp_id).html(hcp_input_field);
		$('#hcp_edit_btn' + hcp_id).html(hcp_edit_btn);
	}

	function update_hcp(hcp_id) {
		var url = "<?= ADMIN_URL . 'Settings/update_hcp_service/' ?>" + hcp_id;
		var hcp_service = $('#hcp_service' + hcp_id).val();
		$.ajax({
			type: "post",
			url: url,
			data: {
				"hcp_service": hcp_service
			},
			success: function(response) {
				window.location.reload();
			}
		});
	}
</script>
