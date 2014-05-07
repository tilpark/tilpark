<?php
	/*
Script Name: Read excel file in php with example
Script URI: http://allitstuff.com/?p=1303
Website URI: http://allitstuff.com/
*/
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<a href="http://allitstuff.com/">AllItStuff.com</a>
<?php
/** Include path **/
set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');

/** PHPExcel_IOFactory */
include 'PHPExcel/IOFactory.php';


$inputFileName = './test.xls';  // File to read
//echo 'Loading file ',pathinfo($inputFileName,PATHINFO_BASENAME),' using IOFactory to identify the format<br />';
try {
	$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
} catch(Exception $e) {
	die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
}


echo '<hr />';
echo "<pre>";
$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
print_r($sheetData);

/* foreach($sheetData as $rec)
{
	print_r($rec);
}
 */

?>
<body>
</html>