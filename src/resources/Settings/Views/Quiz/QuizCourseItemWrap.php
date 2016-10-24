<div class="ld-quiz-import-courses-wrap">
	<?php
		foreach($posts as $post) {
			$course_meta_info = get_post_meta($post->ID, '_sfwd-courses')[0];

			$post_title = $post->post_title;
			$price_type = $course_meta_info['sfwd-courses_course_price_type'];
			$price = $course_meta_info['sfwd-courses_course_price'];
			$access_list = $course_meta_info['sfwd-courses_course_access_list'];
			$materials = $course_meta_info['sfwd-courses_course_materials'];
			$lesson_orderby = $course_meta_info['sfwd-courses_course_lesson_orderby'];
			$lesson_order = $course_meta_info['sfwd-courses_course_lesson_order'];
			$prereq = $course_meta_info['sfwd-courses_course_prerequisite'];
			$button_url = $course_meta_info['sfwd-courses_custom_button_url'];
			$certificate = $course_meta_info['sfwd-courses_certificate'];
			$expire_access_days = $course_meta_info['sfwd-courses_expire_access_days'];

			require(LD_IET_SETTINGS_BASE . "Views/Quiz/QuizCourseItem.php");
		}
	?>
</div>