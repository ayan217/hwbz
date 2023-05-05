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
								<a href="<?= base_url('ss/payment-history') ?>">Clear Filter</a>
							<?php
							}
							?>

						</div>
						<div><a href="<?php echo base_url('ss/Reports/export_csv/'); ?><?= isset($_POST['start_date']) ? $_POST['start_date'] : 0 ?>/<?= isset($_POST['end_date']) ? $_POST['end_date'] : 0 ?>" class="btn btn-primary">Export CSV</a>
						</div>
					</div>
					<hr>
					<div class="table-responsive">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Job ID</th>
									<th>TXN.Date</th>
									<th>TXN.Time</th>
									<th>TXN.ID</th>
									<th>Service(s)</th>
									<th>Amount</th>
									<th>Payment A/c</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								<?php
								if (!empty($payments)) {
									foreach ($payments as $payment) {
										$service_names_array = array();
										$service_ids = explode(',', $payment->service_ids);

										foreach ($service_ids as $service_id) {
											$service_names_array[] = $this->SettingsModel->get_hcp_service($service_id)->name;
										}
										$service_names = implode(', ', $service_names_array);

										$date_time_str = $payment->created_at;
										$date_str = date('m/d/Y', strtotime(substr($date_time_str, 0, 10)));
										$time_str = substr($date_time_str, 11, 5);
										if ($payment->type == 'job_refund') {
											$amount = '<span class="text-danger">-$' . $payment->amount . '</span>';
											$status = '<span class="text-danger">Refunded</span>';
											$ac_no = get_refunded_acc($payment->payment_account);
										} else {
											$amount = '<span class="text-success">$' . $payment->amount . '</span>';
											$status = '<span class="text-success">Success</span>';
											$acpaymenttype = explode('_', $payment->payment_account);
											if ($acpaymenttype[0] == 'card') {
												// $ac_no = '2';
												$ac_no = get_card($payment->stripe_cust_id,	$payment->payment_account);
											} elseif ($acpaymenttype[0] == 'pm') {
												$ac_no = get_payment_card($payment->payment_account);
												// $ac_no = '1';
											} else {
												$ac_no = '3';
											}
										}

								?>
										<tr>
											<td><?= $payment->job_id ?></td>
											<td><?= $date_str ?></td>
											<td><?= $time_str ?></td>
											<td><?= $payment->stripe_payment_id ?></td>
											<td><?= $service_names ?></td>
											<td><?= $amount ?></td>
											<td><?= $ac_no ?></td>
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
