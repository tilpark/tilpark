<?php
require('class/BCGFontFile.php');
require('class/BCGColor.php');
require('class/BCGDrawing.php');
require('class/BCGcode128.barcode.php');
 
$font = new BCGFontFile('font/Arial.ttf', 18);
$color_black = new BCGColor(0, 0, 0);
$color_white = new BCGColor(255, 255, 255);



function replace_text_for_utf8($text) {
	$text = trim($text);
	$search = array('Ç','ç','Ğ','ğ','ı','İ','Ö','ö','Ş','ş','Ü','ü',' ');
	$replace = array('c','c','g','g','i','i','o','o','s','s','u','u','-');
	$new_text = str_replace($search,$replace,$text);
	return $new_text;
}

if(isset($_GET['text']))
{
	$text = $_GET['text'];	
}
else
{
	$text = 'no-text';	
}

$text = replace_text_for_utf8(strtolower($text));
 
// Barcode Part
$code = new BCGcode128();
$code->setScale(2);
$code->setThickness(30);
$code->setForegroundColor($color_black);
$code->setBackgroundColor($color_white);
$code->setFont($font);
$code->setStart(NULL);
$code->setTilde(true);
$code->parse($text);
 
// Drawing Part
$drawing = new BCGDrawing('', $color_white);
$drawing->setBarcode($code);
$drawing->draw();
 
header('Content-Type: image/png');
 
$drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
?>



<?php if(isset($_GET['print'])): ?>
<script>
window.print();
</script>
<?php endif; ?>