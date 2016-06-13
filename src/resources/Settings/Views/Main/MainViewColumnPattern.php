<input type='hidden' id='ld_settings_course_csv_pattern' name='ld_options[ld_settings_course_csv_pattern]' value='<?php echo $csv_pattern; ?>' />
<div class="column-pattern">
	<?php
		if(count($csv_pattern) > 0) {
			foreach ( json_decode($csv_pattern) as $item ):
				$sItem = str_replace("_", " ", $item);
				$uc = ucwords($sItem);
				?>
				<div class="ui-state-default" data-name="<?php echo $item; ?>">
					<?php echo $uc; ?>
				</div>
				<?php
			endforeach;
		}
	?>
</div>