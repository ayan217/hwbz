<div class="container-fluid page-body-wrapper">
	<nav class="sidebar sidebar-offcanvas" id="sidebar">
		<ul class="nav">
			<li class="nav-item">
				<a class="nav-link" href="<?= BASE_URL ?>ss">
					<i class="mdi mdi-grid-large menu-icon"></i>
					<span class="menu-title">Dashboard</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
					<i class="menu-icon mdi mdi-floor-plan"></i>
					<span class="menu-title">Profile</span>
					<i class="menu-arrow"></i>
				</a>
				<div class="collapse" id="ui-basic">
					<ul class="nav flex-column sub-menu">
						<li class="nav-item"> <a class="nav-link" href="<?= BASE_URL ?>ss/account-settings">Account Settings</a></li>
					</ul>
				</div>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?= BASE_URL ?>ss/job">
					<i class="mdi mdi-grid-large menu-icon"></i>
					<span class="menu-title">Post a Job</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-bs-toggle="collapse" href="#ui-basic-2" aria-expanded="false" aria-controls="ui-basic">
					<i class="menu-icon mdi mdi-floor-plan"></i>
					<span class="menu-title">My Jobs</span>
					<i class="menu-arrow"></i>
				</a>
				<div class="collapse" id="ui-basic-2">
					<ul class="nav flex-column sub-menu">
						<li class="nav-item"> <a class="nav-link" href="<?= BASE_URL ?>ss/job/all">All</a></li>
						<li class="nav-item"> <a class="nav-link" href="<?= BASE_URL ?>ss/job/open">Open</a></li>
						<li class="nav-item"> <a class="nav-link" href="<?= BASE_URL ?>ss/job/pending">Pending</a></li>
						<li class="nav-item"> <a class="nav-link" href="<?= BASE_URL ?>ss/job/completed">Completed</a></li>
					</ul>
				</div>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?= BASE_URL ?>ss/calender">
					<i class="mdi mdi-grid-large menu-icon"></i>
					<span class="menu-title">Calender</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?= BASE_URL ?>ss/message">
					<i class="mdi mdi-grid-large menu-icon"></i>
					<span class="menu-title">Messages</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-bs-toggle="collapse" href="#ui-basic-3" aria-expanded="false" aria-controls="ui-basic">
					<i class="menu-icon mdi mdi-floor-plan"></i>
					<span class="menu-title">Reports</span>
					<i class="menu-arrow"></i>
				</a>
				<div class="collapse" id="ui-basic-3">
					<ul class="nav flex-column sub-menu">
						<li class="nav-item"> <a class="nav-link" href="<?= BASE_URL ?>ss/booking-history">Booking History</a></li>
						<li class="nav-item"> <a class="nav-link" href="<?= BASE_URL ?>ss/payment-history">Payment History</a></li>
					</ul>
				</div>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?=BASE_URL?>ss/change-password">
					<i class="mdi mdi-grid-large menu-icon"></i>
					<span class="menu-title">Change Password</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?= BASE_URL ?>logout">
					<i class="mdi mdi-grid-large menu-icon"></i>
					<span class="menu-title">Logout</span>
				</a>
			</li>
		</ul>
	</nav>
