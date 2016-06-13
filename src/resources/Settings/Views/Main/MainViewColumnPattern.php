<?php

// TODO: Separate this out into it's own testable function
$options = get_option('ld_options');
$csv_ops = $options['ld_settings_course_csv_pattern'];

$csv_pattern = [];

if(!$csv_ops || $csv_ops == "") {
	$csv_pattern = array(
		'course_title',
		'status',
		'visibility',
		'featured_img',
		'categories',
		'tags',
		'restrictions',
		'course_materials',
		'course_price_type',
		'course_price',
		'course_access_list',
		'sort_lesson_by',
		'sort_lesson_direction',
		'course_prerequisites',
		'disable_lesson_progression',
		'expire_access',
		'hide_course_content_table',
		'associated_certificate'
	);

	$csv_pattern = json_encode($csv_pattern);
} else {
	$csv_pattern = $options['ld_settings_course_csv_pattern'];
}

echo "<input type='hidden' id='ld_settings_course_csv_pattern' name='ld_options[ld_settings_course_csv_pattern]' value='$csv_pattern' />";
?>
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