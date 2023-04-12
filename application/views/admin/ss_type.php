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
				<h4 class="card-title">Service Seeker Type</h4>
				<form class="forms-sample" action="<?= ADMIN_URL ?>ss-type" method="post">
					<input type="hidden" name="type" value='retail'>
					<div class="form-group d-flex">
						<div class="col-3"><label>Enter Service Seeker Type</label><input name="ss_type" type="text" class="form-control" required></div>
						<div class="col-6" style="margin-left:15px;"><button name="add_ss_type_btn" type="submit" class="btn btn-success btn-rounded btn-fw">Add</button></div>
					</div>
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
								<th>SS Types</th>
								<th>Edit</th>
								<th>Delete</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if (!empty($ss_types)) {
								foreach ($ss_types as $ss_type) {
							?>

									<tr>

										<td id="ss_name<?= $ss_type->id ?>"><?= $ss_type->name ?></td>
										<td id="ss_edit_btn<?= $ss_type->id ?>" data-ss_name="<?= $ss_type->name ?>"><a href="javascript:void(0)" type="button" class="btn btn-warning btn-rounded btn-fw" onclick="update_ss_form(<?= $ss_type->id ?>)">Edit</a></td>
										<td><a href="<?= ADMIN_URL ?>Settings/delete_ss_type/<?= $ss_type->id ?>" type="button" class="btn btn-danger btn-rounded btn-fw">Delete</a></td>
									</tr>

							<?php
								}
							} else {
								echo '<tr><td colspan="3">No SS Type Found</tr>';
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
	function update_ss_form(ss_id) {
		var ss_name = $('#ss_edit_btn' + ss_id).data('ss_name');
		var ss_input_field = '<input type="text" id="ss_type' + ss_id + '" class="form-control" value="' + ss_name + '">';
		var ss_edit_btn = "<button type='button' onclick='update_ss(" + ss_id + ")' class='btn btn-warning btn-rounded btn-fw'>Update</button>";
		$('#ss_name' + ss_id).html(ss_input_field);
		$('#ss_edit_btn' + ss_id).html(ss_edit_btn);
	}

	function update_ss(ss_id) {
		var url = "<?= ADMIN_URL . 'Settings/update_ss_type/' ?>" + ss_id;
		var ss_type = $('#ss_type' + ss_id).val();
		$.ajax({
			type: "post",
			url: url,
			data: {
				"ss_type": ss_type
			},
			success: function(response) {
				window.location.reload();
			}
		});
	}
</script>
