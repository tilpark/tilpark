<?php 

  $deneme = '{"sEcho":"2","iColumns":"5","sColumns":",,,,","iDisplayStart":"0","iDisplayLength":"10","mDataProp_0":"0","sSearch_0":"","bRegex_0":"false","bSearchable_0":"true","bSortable_0":"true","mDataProp_1":"1","sSearch_1":"","bRegex_1":"false","bSearchable_1":"true","bSortable_1":"true","mDataProp_2":"2","sSearch_2":"","bRegex_2":"false","bSearchable_2":"true","bSortable_2":"true","mDataProp_3":"3","sSearch_3":"","bRegex_3":"false","bSearchable_3":"true","bSortable_3":"true","mDataProp_4":"4","sSearch_4":"","bRegex_4":"false","bSearchable_4":"true","bSortable_4":"true","sSearch":"","bRegex":"false","iSortCol_0":"0","sSortDir_0":"desc","iSortingCols":"1","_":"1463393999263"}';

  $deneme2 = '{"sEcho":"2","iColumns":"5","sColumns":",,,,","iDisplayStart":"0","iDisplayLength":"10","mDataProp_0":"0","sSearch_0":"","bRegex_0":"false","bSearchable_0":"true","bSortable_0":"true","mDataProp_1":"1","sSearch_1":"","bRegex_1":"false","bSearchable_1":"true","bSortable_1":"true","mDataProp_2":"2","sSearch_2":"","bRegex_2":"false","bSearchable_2":"true","bSortable_2":"true","mDataProp_3":"3","sSearch_3":"","bRegex_3":"false","bSearchable_3":"true","bSortable_3":"true","mDataProp_4":"4","sSearch_4":"","bRegex_4":"false","bSearchable_4":"true","bSortable_4":"true","sSearch":"","bRegex":"false","iSortCol_0":"3","sSortDir_0":"asc","iSortingCols":"1","_":"1463395909093"}';
  $array1 = json_decode($deneme);
  $array2 = json_decode($deneme2);


print_r($array1);

echo '<hr />';
print_r($array2);
?>