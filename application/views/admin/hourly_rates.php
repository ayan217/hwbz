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
				<form class="forms-sample" action="<?= ADMIN_URL ?>hcp-services" method="post">
					<select name="" id="" class="form-control">
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
				</form>
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
								<th>Service</th>
								<th>Edit</th>
								<th>Delete</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if (!empty($hcp_services)) {
								foreach ($hcp_services as $hcp_service) {
							?>

									<tr>
										<td id="hcp_name<?= $hcp_service->id ?>"><?= $hcp_service->name ?></td>
										<td id="hcp_edit_btn<?= $hcp_service->id ?>" data-hcp_name="<?= $hcp_service->name ?>"><a href="javascript:void(0)" type="button" class="btn btn-warning btn-rounded btn-fw" onclick="update_hcp_form(<?= $hcp_service->id ?>)">Edit</a></td>
										<td><a href="<?= ADMIN_URL ?>Settings/delete_hcp_service/<?= $hcp_service->id ?>" type="button" class="btn btn-danger btn-rounded btn-fw">Delete</a></td>
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
	function update_hcp_form(hcp_id) {
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
