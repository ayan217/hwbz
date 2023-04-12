<div id="signup-user-type">
	<h1>I want to signup as a</h1>
	<label for="<?= PATIENT ?>"><input id="<?= PATIENT ?>" type="radio" name="user_type" value="<?= PATIENT ?>">Individual Patient</label>
	<label for="<?= ORG ?>"><input id="<?= ORG ?>" type="radio" name="user_type" value="<?= ORG ?>">Organization</label>
	<label for="<?= HCP ?>"><input id="<?= HCP ?>" type="radio" name="user_type" value="<?= HCP ?>">Nurse / HCP</label>
	<div><button type="button" id="user-type-select-btn">Continue</button></div>
</div>
<div id="hcp-form-1" style="display:none">
	Signup as a hcp / nurse <br> Already have an account ? <a href="<?= BASE_URL ?>login">Login</a>
	<div>
		<form action="" method="post">
			<input type="text" name="username" placeholder="User Name">
			<input type="email" name="email" placeholder="Email">
			<input type="password" name="password" placeholder="Password">
			<input type="password" name="cpassword" placeholder="Confirm Password">
			<input type="text" name="fname" placeholder="First Name">
			<input type="text" name="lname" placeholder="Last Name">
			<select name="gender" id="">
				<option value="" selected disabled>Gender</option>
				<option value="M">Male</option>
				<option value="F">Female</option>
				<option value="O">Other</option>
			</select>
			<input type="text" name="ssn" placeholder="SSN">
			<input type="text" name="address" placeholder="Street Address">
			<input type="text" name="city" placeholder="City">
			<input type="text" name="state" placeholder="State">
			<input type="text" name="zip" placeholder="ZIP">
			<input type="text" name="phone" placeholder="Phone Number">
			<input type="date" name="dob" placeholder="DOB">
			<input type="text" name="emergency_info" placeholder="Emergency Contact Info">
		</form>
		<div><button type="button" id="hcp-form1-btn">Next</button></div>
	</div>
</div>
<div id="hcp-form-2" style="display:none">hcp2</div>
<div id="patient-form" style="display:none">p</div>
<div id="org-form" style="display:none">o</div>
