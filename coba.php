<?php
include "admina/inc/config.php";


echo hash('sha512','12345');
echo "<pre>";


$image_size = getimagesize('tes.jpg');

if ($image_size[0]>=1200) {
	echo "yes";
} else {
	echo "no";
}
print_r($image_size);

exit();
$data = array();

	$dt1 =array(
			"gambar_name" => array(
              "type" => "notEmpty",
              "value" => "gambarName",
              "allownull" => "no",
			)
		);
	$dt2 =array(
			"gambar_names" => array(
              "type" => "notEmpty",
              "value" => "gambarName",
              "allownull" => "no",
			)
		);


$data = array_merge($data,$dt1);

$data = array_merge($data,$dt2);

print_r($data);

exit();

$data = $db->query("select * from sys_group_users");


foreach ($data as $isi) {
	$dt=$db->convert_obj_to_array($isi);

	print_r($dt);
}

$data = array(
	array(
		'level' => 'admin',
		'level_name' => 'admin',
		'deskripsi' => 'Super Administrator'
		),
		array(
		'level' => 'users',
		'level_name' => 'users',
		'deskripsi' => 'Common User'
		),
		array(
		'level' => 'operator',
		'level_name' => 'operator',
		'deskripsi' => 'operator prodi'
		),
	);

//check group exist
foreach ($data as $dt) {
	$check = $db->check_exist('sys_group_users',array('level' => $dt['level']));
	if ($check==false) {
		$data = array(
			'level' => $dt['level'],
			'level_name' => $dt['level_name'],
			'deskripsi' => $dt['deskripsi']
			);
		$db->insert('sys_group_users',$data);
	}
}

//insert menu 
$db->query("insert into sys_menu (nav_act,page_name,url,main_table,icon,urutan_menu,parent,dt_table,tampil,type_menu) values('kabupaten','kabupaten','kabupaten','kabupaten','','1','0','Y','Y','page')");

echo $db->last_insert_id();

//insert menu role
