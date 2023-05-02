<script src='<?= ASSET_URL ?>js/index.global.min.js'></script>
<script>
	document.addEventListener('DOMContentLoaded', function() {
		var calendarEl = document.getElementById('calendar');
		var calendar = new FullCalendar.Calendar(calendarEl, {
			initialView: 'dayGridMonth',
			events: '<?php echo base_url('ss/calender/get_calendar_data') ?>',
			contentHeight: 'auto',
			aspectRatio: 2,
			eventMouseEnter: function(info) {
				var tooltip = document.createElement('div');
				tooltip.classList.add('fc-tooltip');
				tooltip.innerHTML = 'Time: ' + info.event.title + '<br>' +
					'Location: ' + info.event.extendedProps.location;
				document.body.appendChild(tooltip);
				var rect = info.el.getBoundingClientRect();
				tooltip.style.position = 'absolute';
				tooltip.style.zIndex = 9999;
				tooltip.style.left = rect.left + window.pageXOffset + 'px';
				tooltip.style.top = rect.bottom + window.pageYOffset + 'px';

				var calendarWrapperEl = document.querySelector('.fc');
				var calendarWrapperRect = calendarWrapperEl.getBoundingClientRect();
				if (rect.bottom + tooltip.offsetHeight > calendarWrapperRect.bottom) {
					tooltip.style.top = rect.top - tooltip.offsetHeight + window.pageYOffset + 'px';
				}

				tooltip.style.display = 'block';
			},
			eventMouseLeave: function(info) {
				var tooltips = document.querySelectorAll('.fc-tooltip');
				tooltips.forEach(function(tooltip) {
					tooltip.parentNode.removeChild(tooltip);
				});
			}

		});
		calendar.render();
		var yearFilter = document.getElementById('year-filter');
		yearFilter.addEventListener('change', function() {
			var year = yearFilter.value;
			calendar.gotoDate(year);
		});
	});
</script>
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
			<div id='calendar'></div>
		</div>
	</div>
</div>
