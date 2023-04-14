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
function hcp_form_2() {
	$('[name="hcp_form_1"]').val(1);
	submit_signup_form();
}

function hcp_form_2_trigger() {
	$('#hcp-form-1').hide();
	$('#hcp-form-2').show();
}

function hcp_form_1_back() {
	$('[name="hcp_form_1"]').val(0);
	$('#hcp-form-2').hide();
	$('#hcp-form-1').show();
}

