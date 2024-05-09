<?php
session_start();
error_reporting(0);
include "../../inc/config.php";
require_once('../../inc/lib/pclzip.lib.php');

$id_scope = $_GET['id'];



$presenter_name = $db->c("select scope_name,presenter_name from tb_data_abstract inner join tb_ref_scope on id_scope=tb_ref_scope.id
where ada=1 and id_scope=? group by presenter_name",array('id_scope' => $id_scope));

$i=1;
foreach ($presenter_name as $presenter) {
	$dir_to_download = $db->get_dir_paper(getcwd()).str_replace(" ", "_", $presenter->presenter_name).DIRECTORY_SEPARATOR;

	//echo $i.$dir_to_download."<br>";
	$db->downloadfolderpaper($dir_to_download,str_replace(" ", "_", $presenter->presenter_name));
	$i++;
}
$db->download_paper(str_replace(" ", "_", $presenter->scope_name));



