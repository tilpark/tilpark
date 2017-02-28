<?php



/**
 * chartjs()
 * chartjs icin js kodlarını döndürür
 */
function chartjs($args) {

	$default_dsets['fill'] = 'true'; // raporlarma cizgilerinin ici nasil gozuksun
	$default_dsets['lineTension'] = '0.1'; // raporlarma cizgilerinin gerginlik orani
	$default_dsets['backgroundColor'] = 'rgba(255, 255, 255, 0.6)'; // raporlama cizgilerinin arka plan rengi
	$default_dsets['borderColor'] = 'rgba(253, 196, 49, 1)'; // raporlama cizgi rengi
	$default_dsets['borderCapStyle'] = 'butt';
	$default_dsets['pointBorderColor'] = 'rgba(75,192,192,1)'; // raporlamada nokta isareti cerceve rengi
	$default_dsets['pointBackgroundColor'] = '#fff'; // raporlamada nokta isareti arka plan rengi
	$default_dsets['pointBorderWidth'] = '1'; // raporlamada nokta isareti cerceve kalinligi
	$default_dsets['pointHoverRadius'] = '3'; // raporlamada nokta isareti ustune gelince cerceve kalingili
	$default_dsets['pointHoverBackgroundColor'] = 'rgba(75,192,192,1)'; // raporlamada nokta isareti ustune gelince arka plan rengi
	$default_dsets['pointHoverBorderColor'] = 'rgba(220,220,220,1)'; // raporlamada nokta isareti ustune gelince cerceve rengi
	$default_dsets['pointHoverBorderWidth'] = '2'; // raporlamada nokta isareti ustune gelince cerceve kalinligi
	$default_dsets['pointRadius'] = '1'; // raporlamada nokta isareti cerceve kalinligi
	$default_dsets['pointHitRadius'] = '1';

	// default chartjs gosterim tipi
	if(!isset($args['type'])) { $args['type'] = 'line'; } 

	// nokta isaretlerinin ustune gelince tooltip
	if(!isset($args['tooltips']['display'])) { $args['tooltips']['display'] = 'true'; }

	// sol taraftaki bilgilendirmeler
	if(!isset($args['yAxes']['display'])) { $args['yAxes']['display'] = 'true'; }

	// alt taraftaki bilgilendirmeler
	if(!isset($args['xAxes']['display'])) { $args['xAxes']['display'] = 'true'; }

	// ust taraftaki bilgilendirmeler
	if(!isset($args['legend']['display'])) { $args['legend']['display'] = 'true'; }

	



	?>

	<?php if(isset($args['canvas']['id'])): ?>
		<?php $getElementById = $args['canvas']['id']; ?>
	<?php else: ?>
		<?php 
			$getElementById = 'til_chartjs_'.rand(11111, 99999); 
			if( !isset($args['canvas']['height']) ) { $args['canvas']['height'] = 'auto'; }
			if( !isset($args['canvas']['width']) ) 	{ $args['canvas']['width'] = 'auto'; }
			?>
		<canvas id="<?php echo $getElementById; ?>" height="<?php echo $args['canvas']['height']; ?>"  width="<?php echo $args['canvas']['width']; ?>"></canvas>
	<?php endif; ?>

	<script>
		var ctx = document.getElementById("<?php echo $getElementById; ?>");
		var myChart = new Chart(ctx, {
			type: "<?php echo $args['type']; ?>",
		    data: {
		        labels: <?php echo json_encode($args['labels']); ?>,
			    datasets: [
			    	<?php foreach($args['chart']['datasets'] as $datasets) : ?>	
						{
				            label: "<?php echo $datasets['label']; ?>",
				            <?php if(isset($datasets['type'])):?>type:"<?php echo $datasets['type']; ?>",<?php endif; ?>
				           	
				           	<?php foreach($default_dsets as $key=>$val): ?>
				           		<?php if(isset($datasets[$key])): ?>
				           			<?php echo $key; ?>: "<?php echo $datasets[$key]; ?>",
				           		<?php else: ?>
				           			<?php echo $key; ?>: "<?php echo $default_dsets[$key]; ?>",
				           		<?php endif; ?>
				           	<?php endforeach; ?>	
				           
				            borderDash: [],
				            borderDashOffset: 0.0,
				            borderJoinStyle: 'miter',
				            data: <?php echo json_encode($datasets['data']); ?>,
				            spanGaps: true,
				        },
				    <?php endforeach; ?>
			    ]
		    },
		    options: {
		    	tooltips: {
		            enabled: <?php echo $args['tooltips']['display']; ?>,
		            mode: 'nearest',
		            callbacks: {
		            	<?php if(isset($args['tooltips']['money'])): ?>
		                label: function(tooltipItem, data) {
		                    var label = data.labels[tooltipItem.index];
		                    var datasetLabel = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
		                	return ' '+cjartjs_addCommas(datasetLabel) +' TL' ;
		                }
		                <?php endif; ?>
		            }
		        },
		        scales: {
		            yAxes: [{
		            	display: <?php echo $args['yAxes']['display']; ?>,
		                ticks: {
		                	<?php if(isset($args['yAxes']['money'])): ?>
		                    beginAtZero: true,
				            callback: function(value, index, values) {
				              if(parseInt(value) > 1000){
				                return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")+' TL';
				              } else {
				                return  value+' TL';
				              }
				            }
				            <?php endif; ?>
		                }
		            }],
		            xAxes: [{
		                display: <?php echo $args['xAxes']['display']; ?>
		            }]
		        },
		        legend: {
				    display: <?php echo $args['legend']['display']; ?>,
				}
		    }
		});
	</script>
	<?php
}

?>