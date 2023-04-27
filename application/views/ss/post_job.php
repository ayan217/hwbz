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
					<h4 class="card-title">Post A Job</h4>
					<hr>
					<form class="forms-sample" method="post" action="" id="post_job_form">
						<div id="post_job_form_1">
							<div class="form-group">
								<label for="exampleInputUsername1">Date</label>
								<input required type="date" class="form-control" name="date" placeholder="" value="<?= date('Y-m-d') ?>">
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">Time/Shift</label>
								<select name="time_from" class="form-control">
									<option value="0" selected disabled>Select</option>
									<?php
									for ($i = 0; $i < 24; $i++) {
										for ($j = 0; $j < 60; $j += 60) {

											$hour = str_pad($i % 24, 2, '0', STR_PAD_LEFT);
											$minute = str_pad($j, 2, '0', STR_PAD_LEFT);
											$time = $hour . ':' . $minute;
											echo '<option value="' . $time . '">' . $time . '</option>';
										}
									}
									?>
								</select>
								<select name="time_to" class="form-control">
									<option value="0" selected disabled>Select</option>
									<?php
									for ($i = 0; $i < 24; $i++) {
										for ($j = 0; $j < 60; $j += 60) {

											$hour = str_pad($i % 24, 2, '0', STR_PAD_LEFT);
											$minute = str_pad($j, 2, '0', STR_PAD_LEFT);
											$time = $hour . ':' . $minute;
											echo '<option value="' . $time . '">' . $time . '</option>';
										}
									}
									?>
								</select>
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">Service Needed</label>
								<select id="hcp_services" name="service[]" class="form-control select_services" multiple>
									<!-- <option value="0" selected disabled>Select</option> -->
									<?php
									if (!empty($services)) {
										foreach ($services as $service) {
									?>
											<option value="<?= $service->id ?>"><?= $service->name ?></option>
									<?php
										}
									}
									?>
								</select>
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">Service Address</label>
								<input required type="text" name="address" placeholder="Street Address" class="form-control" value="<?= $user_data->address ?>">
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">City</label>
								<input required type="text" name="city" placeholder="City" class="form-control" value="<?= $user_data->city ?>">
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">State</label>
								<select required name="state" class="form-control">
									<option value="0" selected>State</option>
									<?php
									if (!empty($all_usa_states)) {
										foreach ($all_usa_states as $state) {
									?>
											<option <?= $user_data->state_id == $state->id ? 'selected' : '' ?> value="<?= $state->id ?>"><?= $state->Name ?> (<?= $state->Code ?>)</option>
									<?php
										}
									}
									?>
								</select>
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">ZIP</label>
								<input required type="text" name="zip" placeholder="ZIP" class="form-control" value="<?= $user_data->zip ?>">
							</div>
							<button type="button" class="btn btn-warning btn-rounded btn-fw me-2" onclick="show_form_2()">Proceed To Pay</button>
							<div class="text-danger" id="error"></div>
						</div>
						<div id="post_job_form_2" style="display:none">
							<div id="form_details">
								<div id="sdate"></div>
								<div id="stime"></div>
								<div id="sneeded"></div>
								<div id="saddress"></div>
								<div id="scity"></div>
								<div id="sstate"></div>
								<div id="szip"></div>
								<div>
									<h5>Net Payable Amount: <span id="samount"></span></h5>
								</div>
								<div><button type="button" onclick="back()">Edit Details</button></div>
							</div>
							<div id="payment">
								<?php
								if (!empty($cards)) {
									echo '<div id="saved_cards">';
									foreach ($cards as $card) { ?>
										<div>
											<?php echo $card->brand . ' XXXX XXXX XXXX ' . $card->last4; ?>
											<input type="radio" name="card_id" value="<?php echo $card->id; ?>">
										</div>
									<?php
									}
									echo '</div>';
									?>
									<span>Or,<br></span>
									<label for="stripe_form_btn"><input name="stripe_form_btn" value="1" type="checkbox" id="stripe_form_btn">Pay With Another Card</label>
									<div id="stripe_form" style="display: none;">
										<label for="stripe_card_name">
											<input name="card_holder_name" id="stripe_card_name" type="text" placeholder="Enter Your Name">
										</label>
										<label for="stripe_card_no">
											<input name="card_number" id="stripe_card_no" type="number" placeholder="XXXX XXXX XXXX XXXX">
										</label>
										<label for="stripe_card_mn">
											<select name="expiry_month" id="stripe_card_mn">
												<option value="" selected disabled>MM</option>
												<?php
												for ($i = 1; $i <= 12; $i++) {
													$month = str_pad($i, 2, "0", STR_PAD_LEFT); // add leading zero if necessary
													echo "<option value=\"$month\">$month</option>\n";
												}
												?>
											</select>
										</label>
										<label for="stripe_card_year">
											<select name="expiry_year" id="stripe_card_year">
												<option value="" selected disabled>YYYY</option>
												<?php
												$currentYear = date("Y");
												for ($i = 0; $i <= 10; $i++) {
													$year = $currentYear + $i;
													echo "<option value=\"$year\">$year</option>\n";
												}
												?>
											</select>
										</label>
										<label for="stripe_card_cvv">
											<input name="cvc" id="stripe_card_no" type="number" placeholder="123">
										</label>
										<label for="save_stripe_card"><input name="save_stripe_card" type="checkbox" id="save_stripe_card">Save This Card</label>
									</div>
								<?php
								} else {
								?>
									<div>
										<label for="stripe_card_name">
											<input name="card_holder_name" id="stripe_card_name" type="text" placeholder="Enter Your Name">
										</label>
										<label for="stripe_card_no">
											<input name="card_number" id="stripe_card_no" type="number" placeholder="XXXX XXXX XXXX XXXX">
										</label>
										<label for="stripe_card_mn">
											<select name="expiry_month" id="stripe_card_mn">
												<option value="" selected disabled>MM</option>
												<?php
												for ($i = 1; $i <= 12; $i++) {
													$month = str_pad($i, 2, "0", STR_PAD_LEFT); // add leading zero if necessary
													echo "<option value=\"$month\">$month</option>\n";
												}
												?>
											</select>
										</label>
										<label for="stripe_card_year">
											<select name="expiry_year" id="stripe_card_year">
												<option value="" selected disabled>YYYY</option>
												<?php
												$currentYear = date("Y");
												for ($i = 0; $i <= 10; $i++) {
													$year = $currentYear + $i;
													echo "<option value=\"$year\">$year</option>\n";
												}
												?>
											</select>
										</label>
										<label for="stripe_card_cvv">
											<input name="cvc" id="stripe_card_no" type="number" placeholder="123">
										</label>
										<label for="save_stripe_card"><input name="save_stripe_card" type="checkbox" id="save_stripe_card">Save This Card</label>
									</div>
								<?php
								};
								?>

							</div>
							<input type="hidden" name="payment_amount" value="" required>
							<button type="submit" onclick="post_job()">Pay Now & Post Your Job</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	function post_job() {

	}

	$(document).ready(function() {
		$('#stripe_form_btn').change(function() {
			if ($(this).is(':checked')) {
				$('input[name=card_id]').prop('checked', false);
				$('#stripe_form').css('display', 'block');
			} else {
				$('#stripe_form').css('display', 'none');
			}
		});
	});

	$(document).ready(function() {
		$('input[name=card_id]').change(function() {
			$('#stripe_form').css('display', 'none');
			$('input[name=stripe_form_btn]').prop('checked', false);
		});
	});

	function back() {
		$('#post_job_form_1').show();
		$('#post_job_form_2').hide();
	}

	function show_form_2() {

		var url = '<?= BASE_URL . 'ss/Job/post_job/1' ?>';

		var date = $('[name="date"]').val();
		var time_from = $('[name="time_from"]').val();
		var time_to = $('[name="time_to"]').val();

		var services = $('#hcp_services').val();
		var selectedServices = $('#hcp_services option:selected');
		var serviceNames = [];
		selectedServices.each(function() {
			serviceNames.push($(this).html());
		});

		var address = $('[name="address"]').val();
		var city = $('[name="city"]').val();
		var state = $('[name="state"]').val();
		var selectedstate = $('[name="state"] option:selected');
		var statename = selectedstate.html();
		var zip = $('[name="zip"]').val();

		$.ajax({
			type: 'POST',
			url: url,
			data: {
				'date': date,
				'time_from': time_from,
				'time_to': time_to,
				'service': services,
				'address': address,
				'city': city,
				'state': state,
				'zip': zip,
				'state_name': statename,
				'service_name': serviceNames,
			},
			dataType: 'json',
			success: function(res) {
				if (res.status == 0) {
					$('#error').html(res.msg);
				} else if (res.status == 2) {
					$('#sdate').html('Date: ' + date);
					$('#stime').html('Time: ' + time_from + ' - ' + time_to);
					$('#sneeded').html('Service Needed: ' + serviceNames.join(', '));
					$('#saddress').html('Service Address: ' + address);
					$('#scity').html('City: ' + city);
					$('#sstate').html('State: ' + statename);
					$('#szip').html('ZIP: ' + zip);
					$('#samount').html('$' + res.net_amount);
					$('input[name="payment_amount"]').val(res.net_amount);
					$('#post_job_form_1').hide();
					$('#post_job_form_2').show();
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(textStatus + ': ' + errorThrown);
			}
		});
	}

	$(document).ready(function(e) {
		$("#post_job_form").on('submit', (function(e) {
			e.preventDefault();
			var url = '<?= BASE_URL . 'ss/Job/post_job' ?>';
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
						var success_url = '<?= base_url('ss/job/all') ?>';
						window.location.replace(success_url);
					}
				},
				error: function(result) {

				}
			});
		}));
	});
</script>
<script>
	$(document).ready(function() {
		$('.select_services').select2();
	});
</script>
