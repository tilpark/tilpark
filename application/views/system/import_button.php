"sDom": " <'row'<'col-md-4 hidden-xs hidden-sm'T><'col-md-4 hidden-xs hidden-sm'l><'col-md-4'f>>rt<'row'<'col-md-6 hidden-xs hidden-sm'i><'col-md-6'p>>",
		"bJQueryUI": false,
		"sPaginationType": "full_numbers",
        "oTableTools": {
            "sSwfPath": "<?php echo base_url('theme/js/dataTable/swf/copy_csv_xls_pdf.swf'); ?>",
			"aButtons": [
				{
					"sExtends": "xls",
					"sFileName": exportName + "_excel.csv",
					"sButtonText": "Excel"
				},
				{
					"sExtends": "csv",
					"sFileName":  exportName + ".csv",
					"sButtonText": "CSV"
				},
				{
					"sExtends": "pdf",
					"sFileName": exportName + ".pdf",
					"sButtonText": "PDF"
				},
				{
					"sExtends": "copy",
					"sButtonText": "Kopyala"
				},
				{
					"sExtends": "print",
					"sButtonText": "Yazdır"
				}
			]
        },
		"oLanguage": {
		  "oPaginate": {
			"sFirst": "<?php lang('First page'); ?>",
			"sLast": "<?php lang('Last page'); ?>",
			"sNext": "<?php lang('Next'); ?>",
			"sPrevious": "<?php lang('Previous'); ?>"
		  }
		}