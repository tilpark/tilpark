
<canvas id="myChart" height="40"></canvas>
<?php
$how_days = 15;
$date = array();
$charts = array();
for($i=0; $i<=$how_days; $i++) {
	$charts['date'][] = date('Y-m-d',strtotime("-".($how_days-$i)." days"));
	$date[0][date('Y-m-d',strtotime("-".($how_days-$i)." days"))] = 0;
	$date[1][date('Y-m-d',strtotime("-".($how_days-$i)." days"))] = 0;
}
$start_date 	= date('Y-m-d',strtotime("-".($how_days)." days"));
$end_date 		= date('Y-m-d',strtotime("-".($how_days-$how_days)." days"));




$data = array();
$in_out = 0;
$query = db()->query("SELECT * FROM ".dbname('forms')." WHERE date >= '".$start_date."' AND date <= '".$end_date." 99:99:99' AND status='1' AND in_out='".$in_out."' ");
while($list = $query->fetch_object()) {
	if( isset($date[$in_out][substr($list->date,0,10)]) ) {
		$date[$in_out][substr($list->date,0,10)] = $list->total;
	} else {
		$date[$in_out][substr($list->date,0,10)] = 0;
	}
}

$in_out = 1;
$query = db()->query("SELECT * FROM ".dbname('forms')." WHERE date >= '".$start_date."' AND date <= '".$end_date." 99:99:99' AND status='1' AND in_out='".$in_out."' ");
while($list = $query->fetch_object()) {
	if( isset($date[$in_out][substr($list->date,0,10)]) ) {
		$date[$in_out][substr($list->date,0,10)] = $list->total;
	} else {
		$date[$in_out][substr($list->date,0,10)] = 0;
	}
}



foreach($date[0] as $key=>$val) {
	$charts[0]['values'][] = number_format($val,2, '.', '');
}
foreach($date[1] as $key=>$val) {
	$charts[1]['values'][] = number_format($val,2, '.', '');
}




?>

<script>
function addCommas(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}



var ctx = document.getElementById("myChart");
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($charts['date']); ?>,
	    datasets: [
	    	{
	            label: "Çıkışlar",
	            fill: true,
	            lineTension: 0.1,
	            backgroundColor: "rgba(253, 196, 49, 0.4)",
	            borderColor: "rgba(253, 196, 49, 1)",
	            borderCapStyle: 'butt',
	            borderDash: [],
	            borderDashOffset: 0.0,
	            borderJoinStyle: 'miter',
	            pointBorderColor: "rgba(75,192,192,1)",
	            pointBackgroundColor: "#fff",
	            pointBorderWidth: 1,
	            pointHoverRadius: 5,
	            pointHoverBackgroundColor: "rgba(75,192,192,1)",
	            pointHoverBorderColor: "rgba(220,220,220,1)",
	            pointHoverBorderWidth: 2,
	            pointRadius: 1,
	            pointHitRadius: 10,
	            data: <?php echo json_encode($charts[1]['values']); ?>,
	            spanGaps: false,
	        },
	        {
	            label: "Girişler",
	            type:"line",
	            fill: true,
	            lineTension: 0.1,
	            backgroundColor: "rgba(126, 190, 239, 0.4)",
	            borderColor: "rgba(126, 190, 239, 1)",
	            borderCapStyle: 'butt',
	            borderDash: [],
	            borderDashOffset: 0.0,
	            borderJoinStyle: 'miter',
	            pointBorderColor: "rgba(75,192,192,1)",
	            pointBackgroundColor: "#fff",
	            pointBorderWidth: 1,
	            pointHoverRadius: 5,
	            pointHoverBackgroundColor: "rgba(75,192,192,1)",
	            pointHoverBorderColor: "rgba(220,220,220,1)",
	            pointHoverBorderWidth: 2,
	            pointRadius: 3,
	            pointHitRadius: 20,
	            data: <?php echo json_encode($charts[0]['values']); ?>,
	            spanGaps: false,
	            
	        },
	    ]
    },
    options: {

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
    }
});
</script>
