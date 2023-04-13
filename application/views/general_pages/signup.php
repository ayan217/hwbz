<form action="<?= BASE_URL . 'signup' ?>" method="post">
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
					<input id="username" type="text" name="h_username" placeholder="User Name">
					<input id="email" type="email" name="h_email" placeholder="Email">
					<input id="password" type="password" name="h_password" placeholder="Password">
					<input id="cpassword" type="password" name="h_cpassword" placeholder="Confirm Password">
					<input id="fname" type="text" name="h_fname" placeholder="First Name">
					<input id="lname" type="text" name="h_lname" placeholder="Last Name">
					<select name="h_gender" id="gender">
						<option value="" selected disabled>Gender</option>
						<option value="M">Male</option>
						<option value="F">Female</option>
						<option value="O">Other</option>
					</select>
					<input id="ssn" type="text" name="h_ssn" placeholder="SSN">
					<input id="address" type="text" name="h_address" placeholder="Street Address">
					<input id="city" type="text" name="h_city" placeholder="City">
					<select name="h_state" id="">
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
					<input id="zip" type="text" name="h_zip" placeholder="ZIP">
					<input id="phone" type="text" name="h_phone" placeholder="Phone Number">
					<input id="dob" type="date" name="h_dob" placeholder="DOB">
					<input id="emergency_info" type="text" name="h_emergency_info" placeholder="Emergency Contact Info">
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
				<div><button type="submit" id="hcp-form1-btn">Sign Up Now</button></div>
				<div><button type="button" id="hcp-form1-btn" onclick="hcp_form_1();">Back</button></div>
			</div>
		</div>
		<div id="patient-form" style="display:none">
			<div> Signup as an Patient <br> Already have an account ? <a href="<?= BASE_URL ?>login">Login</a></div>
			<div>
				<input id="username" type="text" name="p_username" placeholder="User Name">
				<input id="email" type="email" name="p_email" placeholder="Email">
				<input id="password" type="password" name="p_password" placeholder="Password">
				<input id="cpassword" type="password" name="p_cpassword" placeholder="Confirm Password">
				<input id="fname" type="text" name="p_fname" placeholder="First Name">
				<input id="lname" type="text" name="p_lname" placeholder="Last Name">
				<select name="p_gender" id="gender">
					<option value="" selected disabled>Gender</option>
					<option value="M">Male</option>
					<option value="F">Female</option>
					<option value="O">Other</option>
				</select>
				<input id="ssn" type="text" name="p_ssn" placeholder="SSN">
				<input id="address" type="text" name="p_address" placeholder="Street Address">
				<input id="city" type="text" name="p_city" placeholder="City">
				<select name="p_state" id="">
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
				<input id="zip" type="text" name="p_zip" placeholder="ZIP">
				<input id="phone" type="text" name="p_phone" placeholder="Phone Number">
				<input id="dob" type="date" name="p_dob" placeholder="DOB">
				<input id="emergency_info" type="text" name="p_emergency_info" placeholder="Emergency Contact Info">
				<div><button type="submit">Sign Up Now</button></div>
			</div>
		</div>
		<div id="org-form" style="display:none">
			<div> Signup as an Organization <br> Already have an account ? <a href="<?= BASE_URL ?>login">Login</a></div>
			<div>
				<input id="username" type="text" name="o_username" placeholder="User Name">
				<input id="email" type="email" name="o_email" placeholder="Email">
				<input id="password" type="password" name="o_password" placeholder="Password">
				<input id="cpassword" type="password" name="o_cpassword" placeholder="Confirm Password">
				<input id="fname" type="text" name="o_fname" placeholder="First Name">
				<input id="lname" type="text" name="o_lname" placeholder="Last Name">
				<select name="o_org_type" id="">
					<option value="" selected disabled>Organization Type</option>
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
				<input id="ssn" type="text" name="o_org_name" placeholder="Organization Name">
				<input id="address" type="text" name="o_address" placeholder="Street Address">
				<input id="city" type="text" name="o_city" placeholder="City">
				<select name="o_state" id="">
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
				<input id="zip" type="text" name="o_zip" placeholder="ZIP">
				<input id="phone" type="text" name="o_phone" placeholder="Phone Number">
				<div><button type="submit">Sign Up Now</button></div>
			</div>
		</div>
	</div>
</form>
