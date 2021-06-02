<?php
$singlePage = new \App\Services\Product\Single();
$data = $singlePage->execute();

$data['custom_data']["checkout_url"] = "/wp-admin/admin-ajax.php?action=add_to_cart";

/* All datetime are expired, hide the particular training type */
foreach ($data['custom_data']['training_types'] as $index => $training_type) {

	$dates 		= $training_type['execution_of_training']['live_course_dates'];
	$dateNow 	= date_create('now')->format('d-m-Y h:i a');

	if ($dates && $training_type['execution_of_training']['has_live_course'] == true) {

		foreach ($dates as $key => $date) {
			$dateCustom  	= str_replace('/', '-', $date['date']);
			$date 			= date('d-m-Y h:i a',strtotime($dateCustom));

			if (strtotime($date) < strtotime($dateNow)) {
				unset($data['custom_data']['training_types'][$index]['execution_of_training']['live_course_dates'][$key]);
			}
		}
	}
}

foreach ($data['custom_data']['training_types'] as $index => $training_type) {

	if (isset($data['custom_data']['training_types'][$index]['format']->ID)) {
		$data['custom_data']['training_types'][$index]['format'] = $data['custom_data']['training_types'][$index]['format']->post_title;
	}
	$data['custom_data']['training_types'][$index]['execution_of_training_select'] = array();

	if ($training_type['execution_of_training']['has_live_course'] == true) {
		//$data['custom_data']['training_types'][$index]['time'] = array();
		$cost = $training_type['execution_of_training']["live_course_cost"];
		$url = $training_type['execution_of_training']["live_course_url"];
		
		$data['custom_data']['training_types'][$index]['execution_of_training_select'][] = array(
			"value" => "live_video",
			"label" => "Live Course",
			"cost" => is_array($cost) ? '' : $cost,
			"url" => is_array($url) ? '' : $url,
		);
		if (!empty($training_type['execution_of_training']['live_course_dates'] )) {
			foreach ($training_type['execution_of_training']['live_course_dates'] as $index2 => $live_course_date) {
				$data['custom_data']['training_types'][$index]['time_select'][] = array(
					"label" => $live_course_date['date'],
					"value" => $live_course_date['date']
				);
			}
		} else {
			$data['custom_data']['training_types'][$index]['no_time'] = array(
				"label" => __('No date provided yet', LEC2_DOMAIN)
			);
		}
		
	}

	if ($training_type['execution_of_training']['has_recorded_video'] == true) {
		if (!is_array($data['custom_data']['training_types'][$index]['execution_of_training_select']))
			$data['custom_data']['training_types'][$index]['execution_of_training_select'] = array();

		$cost = $training_type['execution_of_training']["recorded_video_cost"];
		$url = $training_type['execution_of_training']["recorded_video_url"];

		$data['custom_data']['training_types'][$index]['execution_of_training_select'][] = array(
			"value" => "recorded_video",
			"label" => "Recorded Video",
			"cost" => is_array($cost) ? '' : $cost,
			"url" => is_array($url) ? '' : $url,
		);
	}
		
}

if ($_GET['debug'] == 1)
 	debug($data['custom_data'], true);

return [
    'view' => 'pages/trainings-overview-listing-detail/trainings-overview-listing-detail.twig',
    'data' => $data
];

?>

