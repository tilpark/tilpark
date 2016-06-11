<?php
function tilTable($array)
{
	// required
	# button kontrollerini yapalim
	if(!isset($array['btn_print']))	{ 	$array['btn_print'] = true; }
	if(!isset($array['btn_excel']))	{ 	$array['btn_excel'] = true; }
	if(!isset($array['btn_pdf']))	{ 	$array['btn_pdf'] 	= true; }
		# eger tum butonlar kapatilmis ise hepsini kapatalim
		if(!isset($array['btn']))	{ 	$array['btn'] = true; }
		elseif($array['btn'] == false)
		{
			$array['btn_print'] = false;
			$array['btn_excel'] = true;
			$array['btn_pdf'] 	= true;
		}

	# limit
	if(!isset($array['limit'])){ $array['limit'] = 20; }

	


	// css stilleri icin DIV eklemelerini yapalim. Tabloyu bu divler arasina alalim.
	$before = '<div class="div_tilTable in_panel">';
	$before .= '<div class="table_search_box text-right">';
	
	if($array['btn'] == true)
	{
		if($array['btn_print'] == true){ $before .= '<button class="btn btn-default btn-import"><i class="fa fa-print"></i></button>'; }
		if($array['btn_excel'] == true){ $before .= '<button class="btn btn-default btn-import btn-exx"><i class="fa fa-file-excel-o text-success"></i></button>'; }
		if($array['btn_pdf'] == true){ $before .= '<button class="btn btn-default btn-import"><i class="fa fa-file-pdf-o text-danger"></i></button>'; }
	}
	
	$before .= '<input type="text" id="table_search" name="table_search" class="table_search form-control input-sm"><button class="btn btn-default btn-search"><i class="fa fa-search"></i> </button</div>';
	$after = '';
	$after .= '</div>';

	?>

	<script>

		$(document).ready(function() {
			$('.tilTable').before('<?php echo $before; ?>');
			$('.tilTable').after('<?php echo $after; ?>');
			$('.tilTable').appendTo('.div_tilTable');

		});

		$(document).ready(function() {

			<?php if($array['btn'] == true): ?>

				<?php if($array['btn_excel'] == true): ?>
					$('.btn-exx').click(function() {
						tableToExcel('testTable', 'W3C Example Table');
					});
				<?php endif; ?>

			<?php endif; ?>

		});

	</script>


	<script type="text/javascript">
	var tableToExcel = (function() {
	  var uri = 'data:application/vnd.ms-excel;base64;charset=utf-8,'
	    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
	    , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
	    , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
	  return function(table, name) {
	    if (!table.nodeType) table = document.getElementById(table)
	    var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
	    window.location.href = uri + base64(format(template, ctx))
	  }
	})()
	</script>


<?php
}
?>






