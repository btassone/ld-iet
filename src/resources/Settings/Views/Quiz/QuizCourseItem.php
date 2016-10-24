<div class="ld-quiz-import-course-item">

	<div class="ld-quiz-import-course-title">
		<?php echo $post_title; ?>

		<div class="arrow-wrap-position-right">
			<svg height="48" viewBox="0 0 48 48" width="48" xmlns="http://www.w3.org/2000/svg">
				<path d="M14.83 16.42l9.17 9.17 9.17-9.17 2.83 2.83-12 12-12-12z"/>
				<path d="M0-.75h48v48h-48z" fill="none"/>
			</svg>
		</div>
	</div>
	<div class="ld-quiz-import-course-content">
		<div class="ld-quiz-import-course-content-container">
			<div class="ld-quiz-imported-course-info-pane ld-quiz-content-pane">
				<div class="ld-quiz-imported-course-info-pane-title">
					<h4 class="title">
						Course Import Information
					</h4>
				</div>
				<div class="ld-quiz-imported-course-info-pane-container">
					<div class="ld-quiz-course-item-property-row">
						<label>Course Title:</label>
						<span><?php echo $post_title; ?></span>
					</div>
					<div class="ld-quiz-course-item-property-row">
						<label>Course Price Type:</label>
						<span><?php echo $price_type; ?></span>
					</div>
					<div class="ld-quiz-course-item-property-row">
						<label>Course Price:</label>
						<span><?php echo $price; ?></span>
					</div>
					<div class="ld-quiz-course-item-property-row">
						<label>Course Access List:</label>
						<span><?php echo $access_list; ?></span>
					</div>
					<div class="ld-quiz-course-item-property-row">
						<label>Course Materials:</label>
						<span><?php echo $materials; ?></span>
					</div>
					<div class="ld-quiz-course-item-property-row">
						<label>Course Lesson Order By:</label>
						<span><?php echo $lesson_orderby; ?></span>
					</div>
					<div class="ld-quiz-course-item-property-row">
						<label>Course Lesson Order:</label>
						<span><?php echo $lesson_order; ?></span>
					</div>
					<div class="ld-quiz-course-item-property-row">
						<label>Course Pre-Requisite:</label>
						<span><?php echo $prereq; ?></span>
					</div>
					<div class="ld-quiz-course-item-property-row">
						<label>Custom Button Url:</label>
						<span><?php echo $button_url; ?></span>
					</div>
					<div class="ld-quiz-course-item-property-row">
						<label>Certificate:</label>
						<span><?php echo $certificate; ?></span>
					</div>
					<div class="ld-quiz-course-item-property-row">
					<label>Expire Access Days:</label>
					<span><?php echo $expire_access_days; ?></span>
				</div>
				</div>
			</div>
			<div class="ld-quiz-import-action-pane ld-quiz-content-pane">
				<h4 class="title">
					Quiz Import Actions
				</h4>
				<div class="ld-quiz-actions-container">
					Quiz Import Actions Go Here.
				</div>
			</div>
		</div>
	</div>
</div>