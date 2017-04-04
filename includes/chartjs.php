<?php



/**
 * chartjs()
 * chartjs icin js kodlarını döndürür
 */
function chartjs($args) {

	// chart type
	if(!isset($args['type'])) { $args['type'] = 'bar'; }
	if(!isset($args['id'])) { $args['id'] = 'tilChart-'.rand(11111111,99999999); }
	if(!isset($args['borderColor'])) { $args['borderColor'] = true; }

	// genislik ve uzunluk
	if(!isset($args['width'])) 	{ $args['width'] = '100%'; }
	if(!isset($args['height'])) { $args['height'] = '100%'; }

	// sirasi ile arka plan renkleri
	$args['backgroundColor'][] = 'rgba(255, 99, 132, 0.2)';
	$args['backgroundColor'][] = 'rgba(54, 162, 235, 0.2)';
	$args['backgroundColor'][] = 'rgba(255, 206, 86, 0.2)';
	$args['backgroundColor'][] = 'rgba(75, 192, 192, 0.2)';
	$args['backgroundColor'][] = 'rgba(153, 102, 255, 0.2)';
	$args['backgroundColor'][] = 'rgba(255, 159, 64, 0.2)';

	// sirasi ile arka plan cerceve renkleri
	if($args['borderColor'] == true) {
		$args['borderColor'] = array();
		$args['borderColor'][] = 'rgba(255,99,132,1)';
		$args['borderColor'][] = 'rgba(54, 162, 235, 1)';
		$args['borderColor'][] = 'rgba(255, 206, 86, 1)';
		$args['borderColor'][] = 'rgba(75, 192, 192, 1)';
		$args['borderColor'][] = 'rgba(153, 102, 255, 1)';
		$args['borderColor'][] = 'rgba(255, 159, 64, 1)';
	}
	

	?>

	<canvas id="<?php echo $args['id']; ?>" width="<?php echo $args['width']; ?>" height="<?php echo $args['height']; ?>"></canvas>
	<script>
	var ctx = document.getElementById("<?php echo $args['id']; ?>");
	var myChart = new Chart(ctx, {
	    type: '<?php echo $args['type']; ?>',
	    data: {
	    	labels: <?php echo json_encode_utf8($args['labels']); ?>,
	        datasets: [
	        	<?php foreach($args['data'] as $key=>$val): ?> {
	        		label: '<?php echo @$val['label']; ?>',
	        		data: <?php echo json_encode_utf8($val['value']); ?>,
	        		<?php if($args['type'] == 'pie'): ?>
	        			backgroundColor: <?php echo json_encode_utf8($args['backgroundColor']); ?>,
		            	<?php if($args['borderColor']): ?>borderColor: <?php echo json_encode_utf8($args['borderColor']); ?>,<?php endif; ?>
	        		<?php else: ?>
	        			backgroundColor: ['<?php echo $args['backgroundColor'][$key]; ?>'],
		           		<?php if($args['borderColor']): ?>borderColor: ['<?php echo $args['borderColor'][$key]; ?>'],<?php endif; ?>
		           	<?php endif; ?>
	        	},<?php endforeach; ?>
	        ]
	    },
	    options: {
	    	<?php if(isset($args['display'])): ?>
		    	tooltips: {
		            enabled: true,
		            mode: 'single',
		            callbacks: {
		                label: function(tooltipItem, data) {
		                    var label = data.labels[tooltipItem.index];
		                    var datasetLabel = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
		                	return ' '+addCommas(datasetLabel) +' TL' ;
		                }
		            }
		        },
		        scaleLabel: function(label){return  '$' + label.value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");},
		        scales: {
		            yAxes: [{
		                ticks: {
		                    beginAtZero: true,
				            callback: function(value, index, values) {
				              if(parseInt(value) > 1000){
				                return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")+' TL';
				              } else {
				                return  value+' TL';
				              }
				            }
		                }
		            }],
		            xAxes: [{
		                display: false
		            }]
		        },
		        legend: {
				    display: true,
				}
	    	<?php else: ?>
		        scales: {
		            yAxes: [{
		                ticks: {
		                    beginAtZero:true
		                }
		            }]
		        },
	
    				maintainAspectRatio: false
	        <?php endif; ?>
	    }
	});
	</script>


	<?php
}

?>