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
		<div class="col-md-6 grid-margin stretch-card">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title">Post A Job</h4>
					<hr>
					<form class="forms-sample" method="post" action="">
						<div class="form-group">
							<label for="exampleInputUsername1">Date</label>
							<input required type="date" class="form-control" id="exampleInputUsername1" placeholder="">
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">Time/Shift</label>
							<select name="time-from" class="form-control">
								<?php
								for ($i = 0; $i < 24; $i++) {
									for ($j = 0; $j < 60; $j += 30) {
										
										$hour = str_pad($i % 24, 2, '0', STR_PAD_LEFT);
										$minute = str_pad($j, 2, '0', STR_PAD_LEFT);
										$time = $hour . ':' . $minute;
										echo '<option value="' . $time . '">' . $time . '</option>';
									}
								}
								?>
							</select>
							<select name="time-to" class="form-control">
								<?php
								for ($i = 0; $i < 24; $i++) {
									for ($j = 0; $j < 60; $j += 30) {
									
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
							<select name="service" class="form-control">
								<option value="" selected disabled>Select</option>
								<?php 
								if(!empty($services)){
									foreach($services as $service){
										?>
										<option value="<?=$service->id?>"><?=$service->name?></option>
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
							<select required name="state_id" class="form-control">
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
						<button type="submit" class="btn btn-warning btn-rounded btn-fw me-2">Update</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
