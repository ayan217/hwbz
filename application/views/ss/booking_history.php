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
					<div class="d-flex">
						<h4 class="card-title">Filter by</h4>
						<div>
							<form action="" method="post">
								<label for="strdt">Start date<input type="date" name="start_date" class="form-control" value="<?= isset($_POST['start_date']) ? $_POST['start_date'] : '' ?>" required></label>
								<label for="enddt">End date<input type="date" name="end_date" class="form-control" value="<?= isset($_POST['end_date']) ? $_POST['end_date'] : '' ?>" required></label>
								<button class="btn btn-primary" type="submit">View</button>
							</form>
							<?php
							if (isset($_POST['start_date']) && isset($_POST['end_date'])) {
							?>
								<a href="<?= base_url('ss/booking-history') ?>">Clear Filter</a>
							<?php
							}
							?>

						</div>
					</div>
					<hr>
					<div class="table-responsive">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Job ID</th>
									<th>Date/Time</th>
									<th>Service(s)</th>
									<th>Location</th>
									<th>HCP Name</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								<?php
								if (!empty($bookings)) {
									foreach ($bookings as $booking) {
										$service_names_array = array();
										$service_ids = explode(',', $booking->service_ids);

										foreach ($service_ids as $service_id) {
											$service_names_array[] = $this->SettingsModel->get_hcp_service($service_id)->name;
										}
										$service_names = implode(', ', $service_names_array);
										if ($booking->cancel == 0) {
											if ($booking->status == 0) {
												$status = '<p>Open</p>';
											} elseif ($booking->status == 1) {
												$status = '<p class="text-success">Completed</p>';
											} elseif ($booking->status == 2) {
												$status = '<p class="text-warning">Pending</p>';
											}
										} else {
											$status = '<p class="text-danger">Cancelled</p>';
										}

								?>
										<tr>
											<td><?= $booking->job_id ?></td>
											<td><?= date('m/d/Y', strtotime($booking->job_date)) ?><br><?= $booking->shift ?></td>
											<td><?= $service_names ?></td>
											<td><?= $booking->city . ', ' . $booking->Code ?></td>
											<td><?= $booking->hcp_id == null ? '- -' : $booking->first_name . ' ' . $booking->last_name ?></td>
											<td><?= $status ?></td>
										</tr>
								<?php
									}
								} else {
									echo '<tr><td align="center" colspan="9">No Jobs Found</td></tr>';
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
