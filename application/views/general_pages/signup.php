<section class="about1st-section">
	<form action="<?= BASE_URL . 'signup' ?>" id="signup_form" method="post" enctype="multipart/form-data">
		<input type="hidden" name="hcp_form_1" value="0">
		<div id="signup-user-type">
			<h1 class="normal-header text-center">I want to signup as a</h1>


			<div class="container p30">
				<div class="container">
					<div class="row justify-content-center">
						<div class="col-lg-3 col-sm-4 form1btn text-center">

							<div class="signup-txt-icon">
								<img src="<?= ASSET_URL ?>/images/signupbg.png" alt="" class="bg-sign">
								<img src="<?= ASSET_URL ?>/images/sign1.png" alt="">
								<p class="text-signup">Individual Patient</p>

							</div>
						</div>
						<div class="col-lg-3  col-sm-4 form1btn text-center">

							<div class="signup-txt-icon">
								<img src="<?= ASSET_URL ?>/images/signupbg.png" alt="" class="bg-sign">
								<img src="<?= ASSET_URL ?>/images/sign2.png" alt="">
								<p class="text-signup">Organization</p>

							</div>
						</div>
						<div class="col-lg-3   col-sm-4 form1btn text-center">

							<div class="signup-txt-icon">
								<img src="<?= ASSET_URL ?>/images/signupbg.png" alt="" class="bg-sign">
								<img src="<?= ASSET_URL ?>/images/sign3.png" alt="">
								<p class="text-signup">Nurse / HCP</p>

							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="text-center p20"><button type="button" onclick="select_user_type();" class="btn primary-btn">Continue <span class="arws"><i class="fa-solid fa-angle-right"></i></span></button></div>
		</div>
		<div>











			<label for="<?= PATIENT ?>" class="d-none"><input class="radiobtn" checked id="<?= PATIENT ?>" type="radio" name="user_type" value="<?= PATIENT ?>">Individual Patient</label>
			<label class="d-none" for="<?= ORG ?>"><input class="radiobtn" id="<?= ORG ?>" type="radio" name="user_type" value="<?= ORG ?>">Organization</label>
			<label class="d-none" for="<?= HCP ?>"><input class="radiobtn" id="<?= HCP ?>" type="radio" name="user_type" value="<?= HCP ?>">Nurse /
				HCP</label>







			<!--  -->






			<div class="hcp-forms" id="hcp-forms" style="display:none">

				<div class="btnd-sc">
					<img src="<?= ASSET_URL ?>/images/nrs.png" alt="">
				</div>
				<h2 class="normal-header text-center"> Signup as a <span class="bg-blues"> nurse / hcp </span></h2>
				<p class="accout top-text login-top text-center"> Already have an account ? <a class="logincls" href="<?= BASE_URL ?>login">Login Now</a></p>
				<div id="hcp-form-1">
					<div class="row forms">
						<div class="col-lg-6 col-sm-6"><input class="inputs-form" id="h_username" type="text" name="h_username" placeholder="User Name"></div>
						<div class="col-lg-6 col-sm-6"><input class="inputs-form" id="h_email" type="email" name="h_email" placeholder="Email"></div>
						<div class="col-lg-6 col-sm-6"><input class="inputs-form" id="h_password" type="password" name="h_password" placeholder="Password"></div>
						<div class="col-lg-6 col-sm-6"><input class="inputs-form" id="h_cpassword" type="password" name="h_cpassword" placeholder="Confirm Password"></div>
						<div class="col-lg-6 col-sm-6"><input class="inputs-form" id="h_fname" type="text" name="h_fname" placeholder="First Name"></div>
						<div class="col-lg-6 col-sm-6"><input class="inputs-form" id="h_lname" type="text" name="h_lname" placeholder="Last Name"></div>
						<div class="col-lg-6 col-sm-6"><select class="inputs-form" name="h_gender" id="h_gender"></div>
						<option value="0" selected>Gender</option>
						<option value="M">Male</option>
						<option value="F">Female</option>
						<option value="O">Other</option>
						</select>
					</div>
					<div class="col-lg-6 col-sm-6"><input class="inputs-form" id="h_ssn" type="text" name="h_ssn" placeholder="SSN"></div>
					<div class="col-lg-12"><input class="inputs-form" id="h_address" type="text" name="h_address" placeholder="Street Address"></div>
					<div class="col-lg-6 col-sm-6"><input class="inputs-form" id="h_city" type="text" name="h_city" placeholder="City"></div>
					<div class="col-lg-6 col-sm-6"><select class="inputs-form" name="h_state" id="h_state">
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
						</select></div>
					<div class="col-lg-6 col-sm-6"><input class="inputs-form" id="h_zip" type="text" name="h_zip" placeholder="ZIP"></div>
					<div class="col-lg-6 col-sm-6"><input class="inputs-form" id="h_phone" type="text" name="h_phone" placeholder="Phone Number"></div>
					<div class="col-lg-6 col-sm-6"><input class="inputs-form" id="h_dob" type="date" name="h_dob" placeholder="DOB"></div>
					<div class="col-lg-6 col-sm-6"><input class="inputs-form" id="h_emergency_info" type="text" name="h_emergency_info" placeholder="Emergency Contact Info"></div>
					<div class="check-box nres"><input class="cb3" type="checkbox" /> <label for="" class="text-keep">Keep me logged in</label> </div>
					<div class="text-right nurse"><button class="btn primary-btn" type="button" onclick="submit_signup_form();">Next <span class="arws"><i class="fa-solid fa-angle-right"></i></span></button></div>
				</div>
			</div>
















			<div id="hcp-form-2" style="display:none">
				<h2 class="up-doc-header  text-center orange-text2">Upload Documents</h2>
				<p class="text-uplds text-center">(Documents in .pdf, .png, .jpg, .doc, .xls formats)</p>

				<div class="row">
					<div class="col-lg-6 col-sm-6">
						<p class="text-drivers">Driver’s License or State ID</p>
						<div class="inputs-form d-flex upload">
							<span class="fliename ">No file choosen</span>
							<span class="icons-upald"><i class="fa-solid fa-upload"></i></span>
						</div>
						<input type="file" class="d-none file-uploader" name="dl" id="">
					</div>
					<div class="col-lg-6 col-sm-6">
						<p class="text-drivers">Active Professional License</p>
						<div class="inputs-form d-flex upload">
							<span class="fliename ">No file choosen</span>
							<span class="icons-upald"><i class="fa-solid fa-upload"></i></span>
						</div>
						<input type="file" class="d-none file-uploader" name="acl" id="">
					</div>
					<div class="col-lg-6 col-sm-6">
						<p class="text-drivers">Active BLS card</p>
						<div class="inputs-form d-flex upload">
							<span class="fliename ">No file choosen</span>
							<span class="icons-upald"><i class="fa-solid fa-upload"></i></span>
						</div>
						<input type="file" class="d-none file-uploader" name="abc" id="">
					</div>
					<div class="col-lg-6 col-sm-6">
						<p class="text-drivers">Covid-19 Vaccine card or exemption letter</p>
						<div class="inputs-form d-flex upload">
							<span class="fliename ">No file choosen</span>
							<span class="icons-upald"><i class="fa-solid fa-upload"></i></span>
						</div>
						<input type="file" class="d-none file-uploader" name="covid" id="">
					</div>
					<div class="col-lg-6 col-sm-6">
						<p class="text-drivers">Physical</p>
						<div class="inputs-form d-flex upload">
							<span class="fliename ">No file choosen</span>
							<span class="icons-upald"><i class="fa-solid fa-upload"></i></span>
						</div>

						<input type="file" class="d-none file-uploader" name="phy" id="">
					</div>
					<div class="col-lg-6 col-sm-6">
						<p class="text-drivers">TB test results or negative chest X-Ray</p>
						<div class="inputs-form d-flex upload">
							<span class="fliename ">No file choosen</span>
							<span class="icons-upald"><i class="fa-solid fa-upload"></i></span>
						</div>
						<input type="file" class="d-none file-uploader" name="tb" id="">
					</div>
					<div class="col-lg-6 col-sm-6">
						<p class="text-drivers">Background check</p>
						<div class="inputs-form d-flex upload">
							<span class="fliename ">No file choosen</span>
							<span class="icons-upald"><i class="fa-solid fa-upload"></i></span>
						</div>
						<input type="file" class="d-none file-uploader" name="bc" id="">
					</div>
					<div class="col-lg-6 col-sm-6">
						<p class="text-drivers">Social Security card</p>
						<div class="inputs-form d-flex upload">
							<span class="fliename ">No file choosen</span>
							<span class="icons-upald"><i class="fa-solid fa-upload"></i></span>
						</div>
						<input type="file" class="d-none file-uploader" name="ssc" id="">
					</div>
					<div class="col-lg-6 col-sm-6">
						<p class="text-drivers">Fire Card</p>
						<div class="inputs-form d-flex upload">
							<span class="fliename ">No file choosen</span>
							<span class="icons-upald"><i class="fa-solid fa-upload"></i></span>
						</div>
						<input type="file" class="d-none file-uploader" name="fc" id="">
					</div>
					<div class="col-lg-6 col-sm-6">
						<p class="text-drivers">Professional Liability Insurance</p>
						<div class="inputs-form d-flex upload">
							<span class="fliename ">No file choosen</span>
							<span class="icons-upald"><i class="fa-solid fa-upload"></i></span>
						</div>
						<input type="file" class="d-none file-uploader" name="pli" id="">
					</div>
				</div>
				<div class="row mainsbtndona">
					<div class="fit-wi"><button class=" btn primary-btn bacvk" type="button" onclick="hcp_form_1_back();"><span class="back-arw"><i class="fa-solid fa-angle-left"></i></span>Back</button></div>
					<div class="fit-wi"><button type="button" class="sign-up btn primary-btn" id="hcp-form1-btn" disabled>Sign Up Now</button></div>

				</div>
			</div>
		</div>









		<div class="width-same-form" id="patient-form" style="display:none">
			<div class="round-img">
				<img src="http://ayan/hwbz/assets//images/pati1.png" alt="">
			</div>
			<h2 class="normal-header text-center"> Sign Up as a <span class="bg-blues">Patient</span></h2>
			<p class="accout top-text login-top text-center"> Already have an account ? <a class="logincls" href="<?= BASE_URL ?>login">Login</a></p>
			<!-- <div class="normal-header text-center">Signup as an Patient<br> Already have an account ? <a href="<?= BASE_URL ?>login">Login</a></div> -->
			<div class="row">
				<div class="col-lg-6 col-sm-6">
					<input class="inputs-form" id="p_username" type="text" name="p_username" placeholder="User Name">
				</div>
				<div class="col-lg-6 col-sm-6">
					<input class="inputs-form" id="p_email" type="email" name="p_email" placeholder="Email">
				</div>
				<div class="col-lg-6 col-sm-6">
					<input class="inputs-form" id="p_password" type="password" name="p_password" placeholder="Password">
				</div>
				<div class="col-lg-6 col-sm-6">
					<input class="inputs-form" id="p_cpassword" type="password" name="p_cpassword" placeholder="Confirm Password">
				</div>
				<div class="col-lg-6 col-sm-6">
					<input class="inputs-form" id="p_fname" type="text" name="p_fname" placeholder="First Name">
				</div>
				<div class="col-lg-6 col-sm-6">
					<input class="inputs-form" id="p_lname" type="text" name="p_lname" placeholder="Last Name">
				</div>
				<div class="col-lg-6 col-sm-6">
					<input class="inputs-form" id="p_ssn" type="text" name="p_ssn" placeholder="SSN">
				</div>
				<div class="col-lg-6 col-sm-6">
					<select class="inputs-form" name="p_gender" id="p_gender">
						<option value="0" selected>Gender</option>
						<option value="M">Male</option>
						<option value="F">Female</option>
						<option value="O">Other</option>
					</select>
				</div>
				<div class="col-lg-12">
					<input class="inputs-form" id="p_address" type="text" name="p_address" placeholder="Street Address">
				</div>
				<div class="col-lg-6 col-sm-6">
					<input  class="inputs-form" id="p_city" type="text" name="p_city" placeholder="City">
				</div>
				<div class="col-lg-6 col-sm-6">
					<select  class="inputs-form" name="p_state" id="">
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
				</div>
				<div class="col-lg-6 col-sm-6">
					<input  class="inputs-form" id="p_zip" type="text" name="p_zip" placeholder="ZIP">
				</div>
				<div class="col-lg-6 col-sm-6">
					<input  class="inputs-form" id="p_phone" type="text" name="p_phone" placeholder="Phone Number">
				</div>
				<div class="col-lg-6 col-sm-6">
					<input  class="inputs-form" id="p_dob" type="date" name="p_dob" placeholder="DOB">
				</div>
				<div class="col-lg-6 col-sm-6">
					<input  class="inputs-form" id="p_emergency_info" type="text" name="p_emergency_info" placeholder="Emergency Contact Info">
				</div>
				<div class="check-box nres"><input class="cb3" id="check-p" type="checkbox"> <label for="check-p" class="text-keep accept-trms">I have accept the <a href="#">terms & conditions</a></label> </div>

				<div class="text-center mt-5"><button type="button" class="sign-up btn primary-btn">Sign Up Now</button></div>
			</div>
		</div>










		<div class="width-same-form" id="org-form" style="display:nonee">
			<div class="round-img">
				<img src="http://ayan/hwbz/assets//images/hos-1.png" alt="">
			</div>
			<h2 class="normal-header text-center"> Sign Up as a <span class="bg-blues">Organization</span></h2>
			<p class="accout top-text login-top text-center"> Already have an account ? <a class="logincls" href="<?= BASE_URL ?>login">Login</a></p>
			<!-- <div> Signup as an Organization <br> Already have an account ? <a href="<?= BASE_URL ?>login">Login</a></div> -->
			<div class="row">
			<div class="col-lg-6 col-sm-6"><input class="inputs-form" id="o_username" type="text" name="o_username" placeholder="User Name"></div>
			<div class="col-lg-6 col-sm-6"><input class="inputs-form" id="o_email" type="email" name="o_email" placeholder="Email"></div>
			<div class="col-lg-6 col-sm-6"><input class="inputs-form" id="o_password" type="password" name="o_password" placeholder="Password"></div>
			<div class="col-lg-6 col-sm-6"><input class="inputs-form" id="o_cpassword" type="password" name="o_cpassword" placeholder="Confirm Password"></div>
			<div class="col-lg-6 col-sm-6"><input class="inputs-form" id="o_fname" type="text" name="o_fname" placeholder="First Name"></div>
			<div class="col-lg-6 col-sm-6"><input class="inputs-form" id="o_lname" type="text" name="o_lname" placeholder="Last Name"></div>
			<div class="col-lg-6 col-sm-6">
				<select class="inputs-form" name="o_org_type" id="o_org_type">
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
			</div>
			<div class="col-lg-6 col-sm-6"><input class="inputs-form" id="o_org_name" type="text" name="o_org_name" placeholder="Organization Name"></div>
			<div class="col-lg-12"><input class="inputs-form" id="o_address" type="text" name="o_address" placeholder="Street Address"></div>
			<div class="col-lg-6 col-sm-6"><input class="inputs-form" id="o_city" type="text" name="o_city" placeholder="City"></div>
			<div class="col-lg-6 col-sm-6">
				<select name="o_state" class="inputs-form" id="o_state">
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
			</div>
			<div class="col-lg-6 col-sm-6"><input class="inputs-form" id="o_zip" type="text" name="o_zip" placeholder="ZIP"></div>
			<div class="col-lg-6 col-sm-6"><input class="inputs-form" id="o_phone" type="text" name="o_phone" placeholder="Phone Number"></div>
			<div class="check-box nres"><input class="cb3" id="check-pl" type="checkbox"> <label for="check-pl" class="text-keep accept-trms">I have accept the <a href="#">terms & conditions</a></label> </div>	
			<div class="text-center mt-5"><button type="button" class="sign-up btn primary-btn">Sign Up Now</button></div>
			</div>
		</div>
		</div>
	</form>
</section>
<div style="color: red;" id="error_output"></div>
<div style="color: red;" id="error_output2"></div>
<script>
	$(".sign-up").click(function() {
		// $('[name="hcp_form_1"]').val(0);
		submit_signup_form();
	});

	function submit_signup_form() {
		event.preventDefault();
		var formData = new FormData($('#signup_form')[0]);
		var url = '<?= BASE_URL . 'signup' ?>';
		var thankyou_url = '<?= BASE_URL . 'thank-you' ?>';

		$.ajax({
			type: 'POST',
			url: url,
			data: formData,
			dataType: 'json',
			processData: false,
			contentType: false,
			success: function(res) {
				if (res.status == 2) {
					$('[name="hcp_form_1"]').val(1);
					hcp_form_2_trigger();
				}
				if (res.status == 1) {
					window.location.replace(thankyou_url);
				}
				$('#error_output').html(res.msg);
				$('#error_output2').html(res.error);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(textStatus + ': ' + errorThrown);
			}
		});
	};

	function select_user_type() {
		var userType = $('input[name=user_type]:checked').val();
		if (userType == 'USER-3') {
			$('#patient-form').show();
			$('#hcp-form-1').hide();
			$('#hcp-form-2').hide();
			$('#org-form').hide();
			$('#signup-user-type').hide();
		} else if (userType == 'USER-4') {
			$('#org-form').show();
			$('#hcp-form-1').hide();
			$('#hcp-form-2').hide();
			$('#patient-form').hide();
			$('#signup-user-type').hide();
		} else if (userType == 'USER-2') {
			$('#hcp-forms').show();
			$('#hcp-form-2').hide();
			$('#patient-form').hide();
			$('#org-form').hide();
			$('#signup-user-type').hide();
		}
	};

	function hcp_form_2_trigger() {
		$('#hcp-form-1').hide();
		$('#hcp-form-2').show();
	}

	function hcp_form_1_back() {
		$('[name="hcp_form_1"]').val(0);
		$('#hcp-form-2').hide();
		$('#hcp-form-1').show();
	}
	$(document).ready(function() {
		$('input[type="file"]').on('change', function() {
			var fileValues = $.map($('input[type="file"]'), function(e) {
				return e.value;
			}).join('');
			if (fileValues !== '') {
				// alert('not disabled');
				$('#hcp-form1-btn').removeAttr('disabled');
			} else {
				// alert('disabled');
				$('#hcp-form1-btn').attr('disabled', 'disabled');
			}
		});
	});





	const radiobtn = document.querySelectorAll(".radiobtn")



	let textsignup = document.querySelectorAll(".text-signup")
	let nodeList = document.querySelectorAll(".signup-txt-icon");
	for (let i = 0; i < nodeList.length; i++) {
		nodeList[0].onclick = function() {
			radiobtn[0].click();

			nodeList[0].classList.add("signup-txt-icon-active");
			nodeList[1].classList.remove("signup-txt-icon-active");
			nodeList[2].classList.remove("signup-txt-icon-active");

			textsignup[0].classList.add("color-wite");
			textsignup[1].classList.remove("color-wite");
			textsignup[2].classList.remove("color-wite");

		}
		nodeList[1].onclick = function() {
			radiobtn[1].click();

			nodeList[1].classList.add("signup-txt-icon-active");
			nodeList[2].classList.remove("signup-txt-icon-active");
			nodeList[0].classList.remove("signup-txt-icon-active");

			textsignup[1].classList.add("color-wite");
			textsignup[2].classList.remove("color-wite");
			textsignup[0].classList.remove("color-wite");
		}
		nodeList[2].onclick = function() {
			radiobtn[2].click();

			nodeList[2].classList.add("signup-txt-icon-active");
			nodeList[0].classList.remove("signup-txt-icon-active");
			nodeList[1].classList.remove("signup-txt-icon-active");

			textsignup[2].classList.add("color-wite");
			textsignup[0].classList.remove("color-wite");
			textsignup[1].classList.remove("color-wite");
		}

	}


	const fileuploader = document.querySelectorAll(".file-uploader");
	const fliename = document.querySelectorAll(".upload");

	const flienaascme = document.querySelectorAll(".fliename");
	for (let i = 0; i < fliename.length; i++) {
		fliename[i].onclick = function() {
			fileuploader[i].click();
		}
	}
</script>
