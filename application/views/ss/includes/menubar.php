<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
	<div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
		<div class="me-3">
			<button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
				<span class="icon-menu"></span>
			</button>
		</div>
		<div>
			<a class="navbar-brand brand-logo" href="index.html">
				<img src="<?= SHOW_PROFILE_PICTURE . logged_in_ss_row()->profile_image ?>" alt="logo" />
			</a>
			<a class="navbar-brand brand-logo-mini" href="index.html">
				<img src="<?= SHOW_PROFILE_PICTURE . logged_in_ss_row()->profile_image ?>" alt="logo" />
			</a>
			<button type="button" id="edit-icon">Edit Profile Picture</button>
			<input type="file" id="file-upload" style="display:none;">
			<script>
				$(document).ready(function() {
					$('#edit-icon').on('click', function() {
						$('#file-upload').click();
					});

					$('#file-upload').on('change', function() {
						var file_data = $('#file-upload').prop('files')[0];
						var form_data = new FormData();
						form_data.append('file', file_data);
						var url = '<?= base_url('home/upload_profile_photo') ?>';
						$.ajax({
							url: url,
							cache: false,
							contentType: false,
							processData: false,
							data: form_data,
							type: 'post',
							dataType: 'json',
							success: function(res) {
								if (res.status == 1) {
									window.location.reload();
								}
							}
						});
					});
				});
			</script>
		</div>
	</div>
	<div class="navbar-menu-wrapper d-flex align-items-top">
		<ul class="navbar-nav">
			<li class="nav-item font-weight-semibold d-none d-lg-block ms-0">
				<h1 class="welcome-text">Welcome, <span class="text-black fw-bold"><?= $user_data->first_name . ' ' . $user_data->last_name ?></span></h1>
				<h3 class="welcome-sub-text">Your performance summary this week </h3>
			</li>
		</ul>
		<ul class="navbar-nav ms-auto">

			<li class="nav-item dropdown">
				<a class="nav-link count-indicator" id="countDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
					<i class="icon-bell"></i>
					<span class="count"></span>
				</a>
				<div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0" aria-labelledby="countDropdown">
					<a class="dropdown-item py-3">
						<p class="mb-0 font-weight-medium float-left">You have 7 unread mails </p>
						<span class="badge badge-pill badge-primary float-right">View all</span>
					</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item preview-item">
						<div class="preview-thumbnail">
							<img src="images/faces/face10.jpg" alt="image" class="img-sm profile-pic">
						</div>
						<div class="preview-item-content flex-grow py-2">
							<p class="preview-subject ellipsis font-weight-medium text-dark">Marian Garner </p>
							<p class="fw-light small-text mb-0"> The meeting is cancelled </p>
						</div>
					</a>
					<a class="dropdown-item preview-item">
						<div class="preview-thumbnail">
							<img src="images/faces/face12.jpg" alt="image" class="img-sm profile-pic">
						</div>
						<div class="preview-item-content flex-grow py-2">
							<p class="preview-subject ellipsis font-weight-medium text-dark">David Grey </p>
							<p class="fw-light small-text mb-0"> The meeting is cancelled </p>
						</div>
					</a>
					<a class="dropdown-item preview-item">
						<div class="preview-thumbnail">
							<img src="images/faces/face1.jpg" alt="image" class="img-sm profile-pic">
						</div>
						<div class="preview-item-content flex-grow py-2">
							<p class="preview-subject ellipsis font-weight-medium text-dark">Travis Jenkins </p>
							<p class="fw-light small-text mb-0"> The meeting is cancelled </p>
						</div>
					</a>
				</div>
			</li>
			<li class="nav-item dropdown d-none d-lg-block user-dropdown">
				<a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
					<img class="img-xs rounded-circle" src="<?= ASSET_URL ?>templete/images/faces/face8.jpg" alt="Profile image"> </a>
				<div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
					<div class="dropdown-header text-center">
						<img class="img-md rounded-circle" src="<?= ASSET_URL ?>templete/images/faces/face8.jpg" alt="Profile image">
						<p class="mb-1 mt-3 font-weight-semibold">Allen Moreno</p>
						<p class="fw-light text-muted mb-0">allenmoreno@gmail.com</p>
					</div>
					<a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i> My Profile <span class="badge badge-pill badge-danger">1</span></a>
					<a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-message-text-outline text-primary me-2"></i> Messages</a>
					<a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-calendar-check-outline text-primary me-2"></i> Activity</a>
					<a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-help-circle-outline text-primary me-2"></i> FAQ</a>
					<a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>Sign Out</a>
				</div>
			</li>
		</ul>
		<button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
			<span class="mdi mdi-menu"></span>
		</button>
	</div>
</nav>
