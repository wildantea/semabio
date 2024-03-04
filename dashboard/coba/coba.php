<?php
include "../inc/config.php";

echo "<pre>";
function sortAndSerialize($arr){
    ksort($arr);
    return serialize($arr);
}

/*function is_connected_brow()
{
  if(!$sock = @fsockopen('wildantea.com', 443))
  {
     return false;
  }
  else
  {
      return true;
  }

}

if (is_connected_brow()) {
	echo "yes";
} else {
	echo "no";
}*/
$array_first = array(
	array(
		'id_perjadin' => 4,
		'tipe_hotel' => 1,
		'harga_hotel' => 4420000
	),
		array(
		'id_perjadin' => 4,
		'tipe_hotel' => 1,
		'harga_hotel' => 3526000
	)

);
print_r($array_first);

$array_new =  array(
	array(
		'id_perjadin' => 4,
		'tipe_hotel' => 1,
		'harga_hotel' => 4960000
	),
		array(
		'id_perjadin' => 4,
		'tipe_hotel' => 1,
		'harga_hotel' => 3526000
	)

);
print_r($array_new);
$differen = array_map('unserialize', array_diff(array_map('sortAndSerialize', $array_new), array_map('sortAndSerialize', $array_first)));
print_r($differen);

exit();
$array_second = array(
	array(
		'id_kegiatan' => 2,
		'id_pegawai' => 1
	),
	array(
		'id_kegiatan' => 2,
		'id_pegawai' => 2
	),
	array(
		'id_kegiatan' => 2,
		'id_pegawai' => 4
	)
);



function diff_array($array_first,$array_second) {
	$data['del'] = array_map('unserialize', array_diff(array_map('sortAndSerialize', $array_first), array_map('sortAndSerialize', $array_second)));

	$data['add'] = array_map('unserialize', array_diff(array_map('sortAndSerialize', $array_second), array_map('sortAndSerialize', $array_first)));
	$data = array_filter($data);
	return $data;

}

print_r(diff_array($array_first,$array_second));

exit();

$array_first = array(
	array(
		'id_kegiatan' => 2,
		'id_pegawai' => 1
	)
);


$array_second = array(
	array(
		'id_kegiatan' => 2,
		'id_pegawai' => 1
	),
	array(
		'id_kegiatan' => 2,
		'id_pegawai' => 2
	)
);


print_r(diff_array($array_first,$array_second));


//$result = array_diff_assoc_recursive($array_first,$array_second);
//$result = array_map('unserialize', array_diff_assoc_recursive(array_map('sortAndSerialize', $array_first), array_map('sortAndSerialize', $array_second)));

//print_r($result);   

exit();
//$data_kat = $db->fetch_all("kategori_ukt");

$check_data = array('username' => 'admin');
$check = $db->check_exist("sys_users",$check_data);

$data = $check->username;
var_dump($check);

print_r($db->check_exist_data("sys_users",$check_data));





?>


<table border="1">
	<thead>
	<tr>
		<th colspan="5">Uang Kuliah Tunggal</th>
	</tr>
	<tr>
		<th>Kategori 1</th>
		<th>Kategori 2</th>
		<th>Kategori 3</th>
		<th>Kategori 4</th>
		<th>Kategori 5</th>
	</tr>
	</thead>
	<tbody>
		<?php
		$data = $db->query("select get_kat(1,66,kode_prodi) as kat1,get_kat(2,66,kode_prodi) as kat2,
get_kat(3,66,kode_prodi) as kat3,get_kat(4,66,kode_prodi) as kat4,get_kat(5,66,kode_prodi) as kat5
from keuangan_kat_detil group by kode_prodi");
		foreach ($data as $dt) {
			echo "<tr>";
			echo "<td>".$dt->kat1."</td>";
			echo "<td>".$dt->kat2."</td>";
			echo "<td>".$dt->kat3."</td>";
			echo "<td>".$dt->kat4."</td>";
			echo "<td>".$dt->kat5."</td>";

			
			echo "</tr>";
		}
		
		?>
	</tbody>
</table>