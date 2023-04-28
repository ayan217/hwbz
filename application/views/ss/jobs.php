<style>
	.rating {
		display: flex;
		font-size: 0;
		width: 110px;
		justify-content: space-between;
		/* remove inline-block gap */
	}

	.star {
		display: inline-block;
		width: 20px;
		height: 16px;
		background-color: #ffff;
		border: .1px solid black;
		border-radius: 5px;
		/* default star color */
	}

	.full {
		background-color: #07d358;
		/* yellow color for full stars */
	}

	.half {
		background-image: linear-gradient(to right, #07d358 50%, #ddd 50%);
		/* gradient for half stars */
	}
</style>
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
						<h4 class="card-title">My Jobs</h4>
						<div>
							<label for="all">All<input <?= $type == 'all' ? 'checked' : '' ?> id="all" name="job_type" value="all" type="radio"></label>
							<label for="open">Open<input <?= $type == 'open' ? 'checked' : '' ?> id="open" name="job_type" value="open" type="radio"></label>
							<label for="pending">Pending Approval<input <?= $type == 'pending' ? 'checked' : '' ?> id="pending" name="job_type" value="pending" type="radio"></label>
							<label for="completed">Completed<input <?= $type == 'completed' ? 'checked' : '' ?> id="completed" name="job_type" value="completed" type="radio"></label>
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
									<th>Amount</th>
									<th>HCP</th>
									<th>Time Sheet</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								if (!empty($jobs)) {
									foreach ($jobs as $job) {
										$service_names_array = array();
										$this->load->model('SettingsModel');
										$service_ids = explode(',', $job->service_ids);
										foreach ($service_ids as $service_id) {
											$service_names_array[] = $this->SettingsModel->get_hcp_service($service_id)->name;
										}
										$service_names = implode(', ', $service_names_array);
										if ($job->status == 0) {
											$url = base_url('ss/cancel-job/' . $job->id);
											$status = '<p>Open</p>';
											$action = '<a href="javascript:void(0)" onclick="window.location.href = \'' . $url . '\';" class="text-danger">Cancel</a>';
										} elseif ($job->status == 1) {
											$status = '<p class="text-success">Completed</p>';
											$action = '<p class="text-success">- -</p>';
										} elseif ($job->status == 2) {
											$status = '<button type="button" class="btn btn-outline-success btn-fw">Approve</button>';
											if ($job->rating == null) {
												$status = '<button type="button" class="btn btn-outline-warning btn-fw">Review</button>';
											} else {

												$rating = $job->rating;
												$rating_div = '';
												$rounded_rating = round($rating * 2) / 2;
												$rating_div .= '<div class="rating">';
												for ($i = 1; $i <= 5; $i++) {
													if ($i <= $rounded_rating) {
														$rating_div .= '<span class="star full"></span>';
													} else if ($i == ceil($rounded_rating) && $rounded_rating != floor($rounded_rating)) {
														$rating_div .= '<span class="star half"></span>';
													} else {
														$rating_div .= '<span class="star empty"></span>';
													}
												}
												$rating_div .= '</div>';

												$action = $rating_div;
											}
										}

								?>
										<tr>
											<td><?= $job->job_id ?></td>
											<td><?= date('m/d/Y', strtotime($job->job_date)) ?><br><?= $job->shift ?></td>
											<td><?= $service_names ?></td>
											<td><?= $job->city . ', ' . $job->Code ?></td>
											<td>$<?= $job->amount ?></td>
											<td><?= $job->hcp_id == null ? '- -' : 'HCP_NAME' ?></td>
											<td><?= $job->time_sheet_id == null ? '- -' : 'TIME_SHEET' ?></td>
											<td><?= $status ?></td>
											<td><?= $action ?></td>
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
