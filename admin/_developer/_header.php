<script type="text/javascript" src="http://tilpark.org/_themes/js/syntax_color/codemirror.js"></script>
<link rel="stylesheet" href="http://tilpark.org/_themes/css/codemirror.css">
<script type="text/javascript" src="http://tilpark.org/_themes/js/syntax_color/mode/xml.js"></script>
<script type="text/javascript" src="http://tilpark.org/_themes/js/syntax_color/mode/clike.js"></script>
<script type="text/javascript" src="http://tilpark.org/_themes/js/syntax_color/mode/php.js"></script>

<script>


$(document).ready(function() {


	var btn_example = '<a href="#" class="_get_example_btn btn btn-default btn-xs" data-toggle="modal" data-target="#til_code_modal"><i class="fa fa-code"></i> HTML</a>';
	$('._get_example').prepend(btn_example);
	$('._get_example').addClass('relative');
	$('._get_example._get_example_div').css('position', 'relative');

	$('._get_example_btn').click(function() {
		var data_example = $(this).parent().attr('data-example');
		if(data_example == 'parent') {
			var div_html = $(this).parent().parent().html();
		} else {
			var div_html = $(this).parent().html();
		}

		div_html = div_html.replace(btn_example, '');
		div_html = div_html.replace('_get_example ', '');
		div_html = div_html.replace('_get_example', '');
		div_html = div_html.replace('data-example="parent" ', '');
		div_html = div_html.replace('data-example="parent"', '');
		var matchs = div_html.match(/<!--del-->[\s\S]*(.+?)[\s\S]*<!--\/del-->/igm);

		div_html = div_html.replace(/<!--del-->[\s\S]*(.+?)[\s\S]*<!--\/del-->/igm, '');

		//$('#_get_example_textarea').html(div_html.trim());

		$( matchs ).each(function( index ) {
		  console.log( index + ": ");
		});

		
		editor.setValue(''+div_html.trim()+'');

		setTimeout(function() {
        	editor.refresh();
        }, 200);

	});


});
</script>

<style>
.CodeMirror {
	height: auto;
	font-size: 12px;
	padding: 10px;
}
.CodeMirror-scroll {
	height: 100%;
}
._get_example:hover ._get_example_btn, .panel:hover ._get_example_btn  {
	display: block;
}
._get_example_btn {
	top: 5px;
	right: 30px;
	position: absolute;
	z-index: 99;
	display: none;
}
</style>


<!-- Modal -->
<div class="modal fade" id="til_code_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Kod örneği</h4>
      </div>
      <div class="modal-body">
        <textarea id="_get_example_textarea" class="form-control" rows="20"></textarea>
      </div>
    </div>
  </div>
</div>
<script>
var editor = CodeMirror.fromTextArea(document.getElementById("_get_example_textarea"), {
		lineNumbers: false,
		styleActiveLine: true,
		matchBrackets: true,
		theme: 'monokai'
	});
</script>