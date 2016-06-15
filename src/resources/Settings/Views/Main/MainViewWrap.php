<div class="ld-iet-settings-wrap">
	<div class="ld-iet-header-wrap">
		<h1 class="ld-iet-page-title">Learn Dash Import / Export</h1>
		<h5 class="ld-iet-sub-title">
			Temporary page containing basic functionality relevant to the tool. Will be broken up into other sections later<br />
			All controls that need to be saved, are saved automatically.
		</h5>
	</div>
	<div>
		<form action="options.php" method="post" id="MainViewWrap">
			<?php
				settings_fields('ld_options');
				do_settings_sections('ld-settings-page');
				submit_button();
			?>
		</form>
	</div>
</div>
<div class="saving-notification">
	<div class="in-process">Processing...</div>
	<div class="saved">Saved</div>
</div>