<form action="<?= BASE_URL . 'signup' ?>" method="post" id="signup_form">
	<div id="signup-user-type">
		<h1>I want to signup as a</h1>
		<label for="<?= PATIENT ?>"><input checked id="<?= PATIENT ?>" type="radio" name="user_type" value="<?= PATIENT ?>">Individual Patient</label>
		<label for="<?= ORG ?>"><input id="<?= ORG ?>" type="radio" name="user_type" value="<?= ORG ?>">Organization</label>
		<label for="<?= HCP ?>"><input id="<?= HCP ?>" type="radio" name="user_type" value="<?= HCP ?>">Nurse / HCP</label>
		<div><button type="button" onclick="select_user_type();">Continue</button></div>
	</div>
	<div>
		<div class="hcp-forms" id="hcp-forms" style="display:none">
			<div> Signup as a hcp / nurse <br> Already have an account ? <a href="<?= BASE_URL ?>login">Login</a></div>
			<div id="hcp-form-1">
				<div>
					<input id="h_username" type="text" name="h_username" placeholder="User Name">
					<input id="h_email" type="email" name="h_email" placeholder="Email">
					<input id="h_password" type="password" name="h_password" placeholder="Password">
					<input id="h_cpassword" type="password" name="h_cpassword" placeholder="Confirm Password">
					<input id="h_fname" type="text" name="h_fname" placeholder="First Name">
					<input id="h_lname" type="text" name="h_lname" placeholder="Last Name">
					<select name="h_gender" id="h_gender">
						<option value="" selected disabled>Gender</option>
						<option value="M">Male</option>
						<option value="F">Female</option>
						<option value="O">Other</option>
					</select>
					<input id="h_ssn" type="text" name="h_ssn" placeholder="SSN">
					<input id="h_address" type="text" name="h_address" placeholder="Street Address">
					<input id="h_city" type="text" name="h_city" placeholder="City">
					<select name="h_state" id="h_state">
						<option value="" selected disabled>State</option>
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
					<input id="h_zip" type="text" name="h_zip" placeholder="ZIP">
					<input id="h_phone" type="text" name="h_phone" placeholder="Phone Number">
					<input id="h_dob" type="date" name="h_dob" placeholder="DOB">
					<input id="h_emergency_info" type="text" name="h_emergency_info" placeholder="Emergency Contact Info">
					<div><button type="button" id="hcp-form1-btn" onclick="hcp_form_2();">Next</button></div>
				</div>
			</div>
			<div id="hcp-form-2" style="display:none">
				<input type="file" name="dl" id="">
				<input type="file" name="acl" id="">
				<input type="file" name="abc" id="">
				<input type="file" name="covid" id="">
				<input type="file" name="phy" id="">
				<input type="file" name="tb" id="">
				<input type="file" name="bc" id="">
				<input type="file" name="ssc" id="">
				<input type="file" name="fc" id="">
				<input type="file" name="pli" id="">
				<div><button type="button" class="sign-up" id="hcp-form1-btn">Sign Up Now</button></div>
				<div><button type="button" id="hcp-form1-btn" onclick="hcp_form_1();">Back</button></div>
			</div>
		</div>
		<div id="patient-form" style="display:none">
			<div> Signup as an Patient <br> Already have an account ? <a href="<?= BASE_URL ?>login">Login</a></div>
			<div>
				<input id="p_username" type="text" name="p_username" placeholder="User Name">
				<input id="p_email" type="email" name="p_email" placeholder="Email">
				<input id="p_password" type="password" name="p_password" placeholder="Password">
				<input id="p_cpassword" type="password" name="p_cpassword" placeholder="Confirm Password">
				<input id="p_fname" type="text" name="p_fname" placeholder="First Name">
				<input id="p_lname" type="text" name="p_lname" placeholder="Last Name">
				<select name="p_gender" id="p_gender">
					<option value="0" selected>Gender</option>
					<option value="M">Male</option>
					<option value="F">Female</option>
					<option value="O">Other</option>
				</select>
				<input id="p_ssn" type="text" name="p_ssn" placeholder="SSN">
				<input id="p_address" type="text" name="p_address" placeholder="Street Address">
				<input id="p_city" type="text" name="p_city" placeholder="City">
				<select name="p_state" id="">
					<option value="0" selected>State</option>
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
				<input id="p_zip" type="text" name="p_zip" placeholder="ZIP">
				<input id="p_phone" type="text" name="p_phone" placeholder="Phone Number">
				<input id="p_dob" type="date" name="p_dob" placeholder="DOB">
				<input id="p_emergency_info" type="text" name="p_emergency_info" placeholder="Emergency Contact Info">
				<div><button type="button" class="sign-up">Sign Up Now</button></div>
			</div>
		</div>
		<div id="org-form" style="display:none">
			<div> Signup as an Organization <br> Already have an account ? <a href="<?= BASE_URL ?>login">Login</a></div>
			<div>
				<input id="o_username" type="text" name="o_username" placeholder="User Name">
				<input id="o_email" type="email" name="o_email" placeholder="Email">
				<input id="o_password" type="password" name="o_password" placeholder="Password">
				<input id="o_cpassword" type="password" name="o_cpassword" placeholder="Confirm Password">
				<input id="o_fname" type="text" name="o_fname" placeholder="First Name">
				<input id="o_lname" type="text" name="o_lname" placeholder="Last Name">
				<select name="o_org_type" id="o_org_type">
					<option value="0" selected>Organization Type</option>
					<?php
					if (!empty($ss_types)) {
						foreach ($ss_types as $ss_type) {
					?>
							<option value="<?= $ss_type->id ?>"><?= $ss_type->name ?></option>
					<?php
						}
					}
					?>
				</select>
				<input id="o_org_name" type="text" name="o_org_name" placeholder="Organization Name">
				<input id="o_address" type="text" name="o_address" placeholder="Street Address">
				<input id="o_city" type="text" name="o_city" placeholder="City">
				<select name="o_state" id="o_state">
					<option value="0" selected>State</option>
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
				<input id="o_zip" type="text" name="o_zip" placeholder="ZIP">
				<input id="o_phone" type="text" name="o_phone" placeholder="Phone Number">
				<div><button type="button" class="sign-up">Sign Up Now</button></div>
			</div>
		</div>
	</div>
</form>
<div style="color: red;" id="error_output"></div>
<script>
	$(".sign-up").click(function() {
		submit_signup_form();
	});

	function submit_signup_form() {
		event.preventDefault();
		var formData = $('#signup_form').serialize();
		var url = '<?= BASE_URL . 'signup' ?>';

		$.ajax({
			type: 'POST',
			url: url,
			data: formData,
			dataType: 'json',
			success: function(res) {
			$('#error_output').html(res.msg);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(textStatus + ': ' + errorThrown);
			}
		});
	};
</script>
