<?php



/**
 * chartjs()
 * chartjs icin js kodlarını döndürür
 */
function chartjs($args) {

	// chart type
	if(!isset($args['id'])) { $args['id'] = 'tilChart-'.rand(11111111,99999999); }
	if(!isset($args['backgroundColor'])) { $args['backgroundColor'] = true; }
	if(!isset($args['borderColor'])) { $args['borderColor'] = true; }

	// genislik ve uzunluk
	if(!isset($args['width'])) 	{ $args['width'] = '100%'; }
	if(!isset($args['height'])) { $args['height'] = '100%'; }

	

	// sirasi ile arka plan renkleri
	if($args['backgroundColor'] == true) {
		$args['backgroundColor'] = array();
		$args['backgroundColor'][] = 'rgba(255, 99, 132, 0.2)';
		$args['backgroundColor'][] = 'rgba(54, 162, 235, 0.2)';
		$args['backgroundColor'][] = 'rgba(255, 206, 86, 0.2)';
		$args['backgroundColor'][] = 'rgba(75, 192, 192, 0.2)';
		$args['backgroundColor'][] = 'rgba(153, 102, 255, 0.2)';
		$args['backgroundColor'][] = 'rgba(255, 159, 64, 0.2)';
		$args['backgroundColor'][] = 'rgba(24, 165, 224, 0.2)';
		$args['backgroundColor'][] = 'rgba(119, 166, 245, 0.2)';
		$args['backgroundColor'][] = 'rgba(239, 224, 255, 0.2)';
		$args['backgroundColor'][] = 'rgba(245, 211, 180, 0.2)';

		;
	}


	// sirasi ile arka plan cerceve renkleri
	if($args['borderColor'] == true) {
		$args['borderColor'] = array();
		$args['borderColor'][] = 'rgba(255,99,132,1)';
		$args['borderColor'][] = 'rgba(54, 162, 235, 1)';
		$args['borderColor'][] = 'rgba(255, 206, 86, 1)';
		$args['borderColor'][] = 'rgba(75, 192, 192, 1)';
		$args['borderColor'][] = 'rgba(153, 102, 255, 1)';
		$args['borderColor'][] = 'rgba(255, 159, 64, 1)';
		$args['borderColor'][] = 'rgba(24, 165, 224, 1)';
		$args['borderColor'][] = 'rgba(119, 166, 245, 1)';
		$args['borderColor'][] = 'rgba(239, 224, 255, 1)';
		$args['borderColor'][] = 'rgba(245, 211, 180, 1)';
	}
	


	// colors
	if(count($args['chart']['data']['datasets']) == 1) {
		$args['chart']['data']['datasets'][0]['backgroundColor'] = $args['backgroundColor'];
		$args['chart']['data']['datasets'][0]['borderColor'] = $args['borderColor'];
			
	} else {
		foreach($args['chart']['data']['datasets'] as $key=>$value) {
			if( !isset($value['backgroundColor']) ) { $args['chart']['data']['datasets'][$key]['backgroundColor'] = $args['backgroundColor'][$key]; }
			if( !isset($value['borderColor']) ) { $args['chart']['data']['datasets'][$key]['borderColor'] = $args['borderColor'][$key]; }
		}
	}
	

	?>

	<canvas id="<?php echo $args['id']; ?>" width="<?php echo $args['width']; ?>" height="<?php echo $args['height']; ?>"></canvas>
	<script>
	var ctx = document.getElementById("<?php echo $args['id']; ?>");
	var myChart = new Chart(ctx, <?php echo str_replace(array('"=TIL= ', ' =TIL="'), '', json_encode_utf8($args['chart'])); ?>);
	</script>


	<?php
}

?>