<div class="csv-upload-information">
	<p class="description">
		Here are the values used for each column in the csv. The column pattern is ordered below.
	</p>

	<div class="csv-upload-information-accordion-wrap">
		<div class="csv-upload-information-accordion-title">
			CSV Column Information

			<div class="arrow-wrap-position-right">
				<svg height="48" viewBox="0 0 48 48" width="48" xmlns="http://www.w3.org/2000/svg">
					<path d="M14.83 16.42l9.17 9.17 9.17-9.17 2.83 2.83-12 12-12-12z"/>
					<path d="M0-.75h48v48h-48z" fill="none"/>
				</svg>
			</div>
		</div>
		<div class="csv-upload-information-accordion-content">
			<div class="csv-upload-information-container">
				<?php foreach($reorganized_column_data as $data_set): ?>
					<div class="csv-upload-information-item">
						<strong><?php echo $data_set->name; ?></strong>
						
						<div class="csv-upload-information-example"><strong>Example: </strong>
							<?php echo $data_set->example; ?></div>
						
						<div class="csv-upload-information-value"><strong>Values: </strong>
							<?php echo $data_set->values; ?></div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>