<div class="content-wrapper">
	<div class="row">
		<div class="col-md-6 grid-margin stretch-card">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title">Account Information</h4>
					<hr>
					<form class="forms-sample" method="post" action="<?= BASE_URL ?>ss/Profile/update_account">
						<div class="form-group">
							<label for="exampleInputUsername1">Email</label>
							<input readonly required type="email" class="form-control" id="exampleInputUsername1" placeholder="Email" value="<?= $user_data->email ?>">
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">First Name</label>
							<input required type="text" class="form-control" id="exampleInputEmail1" name="first_name" placeholder="First Name" value="<?= $user_data->first_name ?>">
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">Last Name</label>
							<input required type="text" class="form-control" id="exampleInputEmail1" name="last_name" placeholder="Last Name" value="<?= $user_data->last_name ?>">
						</div>
						<?php
						if ('USER-' . $user_data->acc_type == ORG) {
						?>
							<div class="form-group">
								<label for="exampleInputEmail1">Organization Type</label>
								<select required name="ss_type_id" id="o_org_type" class="form-control">
									<?php
									if (!empty($ss_types)) {
										foreach ($ss_types as $ss_type) {
									?>
											<option <?= $user_data->ss_type_id == $ss_type->id ? 'selected' : '' ?> value="<?= $ss_type->id ?>"><?= $ss_type->name ?></option>
									<?php
										}
									}
									?>
								</select>
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">Organization Name</label>
								<input required id="org_name" type="text" name="org_name" placeholder="Organization Name" class="form-control" value='<?= $user_data->org_name ?>'>
							</div>
						<?php
						}
						?>
						<div class="form-group">
							<label for="exampleInputEmail1">Street Address</label>
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
						<div class="form-group">
							<label for="exampleInputEmail1">Phone Number</label>
							<input required type="text" name="phone" placeholder="Phone Number" class="form-control" value="<?= $user_data->phone ?>">
						</div>
						<button type="submit" class="btn btn-warning btn-rounded btn-fw me-2">Update</button>
					</form>
				</div>
			</div>
		</div>
		<div class="col-md-6 grid-margin stretch-card">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title">Saved Cards</h4>
					<hr>
					<ul>
						<?php
						if (!empty($cards)) {
							foreach ($cards as $card) { ?>
								<li>
									<?php echo $card->brand . ' XXXX XXXX XXXX ' . $card->last4; ?>
									<form method="post" action="<?= BASE_URL ?>ss/Profile/delete_card">
										<input type="hidden" name="card_id" value="<?php echo $card->id; ?>">
										<input type="hidden" name="cust_id" value="<?php echo $user_data->stripe_cust_id; ?>">
										<button type="submit" name="delete_card">Delete</button>
									</form>
								</li>
						<?php
							}
						} else {
							echo 'No saved are cards found.';
						};
						?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
