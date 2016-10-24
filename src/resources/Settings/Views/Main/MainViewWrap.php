<div class="ld-iet-settings-wrap">
	<div class="ld-iet-header-wrap">
		<h1 class="ld-iet-page-title">Learn Dash Import / Export</h1>
		<h5 class="ld-iet-sub-title">
			Temporary page containing basic functionality relevant to the tool. Will be broken up into other sections later<br />
			All controls that need to be saved, are saved automatically.
		</h5>
	</div>
	<div class="ld-main-container no-panel">
		<div class="ld-main-settings-container">
			<form action="options.php" method="post" id="MainViewWrap">

				<?php
					settings_fields('ld_options');
					do_settings_sections('ld-settings-page');
				?>
			</form>
		</div>
		<div class="ld-main-import-preview">
			<div class="ld-main-import-preview-header">
				<h3 class="title">Import Preview</h3>
				<h3 class="course-num">
					Course #<span id="course-num">1</span>
				</h3>
			</div>
			<?php \CorduroyBeach\Utilities\LDUtility::OutputSettingsOption('ld-preview-page', 'ld_preview_section', 'ld_setting_preview_csv'); ?>
		</div>
	</div>
</div>
<div class="saving-notification">
	<div class="in-process">Processing...</div>
	<div class="saved">Saved</div>
</div>