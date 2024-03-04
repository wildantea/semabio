<?php
/**
 * @ PHP 5.6
 * @ Decoder version : 1.0.0.4
 * @ Release on : 24.03.2018
 * @ Website    : http://EasyToYou.eu
 *
 * @ Zend guard decoder PHP 5.6
 **/

function xDecrypt($str, $key)
{
    $decrypted = trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, base64_decode($str), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
    return $decrypted;
}


$active_group = 'default';
$active_record = true;

$username1 = 'WGxEMvQ/GwDTBt+rLCokCQ==NiO0483FWg7HlKYtWp8Fkw==';
$password1 = 'igLCvA+EST2MSn9EujqAEA==kW/dxkE0hhY1hi01Gn1Xqg==';
$db1 = 'pddikti';
$username2 = 'Bnl4oiFkSrl9r4vN+FKmsA==vOvCwf3jfPLKRNsOUQfLkw==';
$password2 = 'YhVdj0ngto1xPV2faBPrCg==bRSvlX8NyUTwvtWXKZen8w==';
$db2 = 'pddikti_sandbox';
$portdb = 54321;
$hostdb = 'localhost';
$passwordarr = array('WHNYuFxWIztqp/6BTxK0vg==Pn3mYjHHDApH4/re/b6Q9Q==');
$db['default']['hostname'] = $hostdb;
$db['default']['username'] = $username1;
$db['default']['password'] = $password1;
$db['default']['database'] = $db1;
$db['default']['dbdriver'] = 'postgre';
$db['default']['dbprefix'] = '';
$db['default']['port'] = $portdb;
$db['default']['pconnect'] = false;
$db['default']['db_debug'] = false;
$db['default']['cache_on'] = false;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = true;
$db['default']['stricton'] = false;
$db['sandbox']['hostname'] = $hostdb;
$db['sandbox']['username'] = $username2;
$db['sandbox']['password'] = $password2;
$db['sandbox']['database'] = $db2;
$db['sandbox']['dbdriver'] = 'postgre';
$db['sandbox']['dbprefix'] = '';
$db['sandbox']['port'] = $portdb;
$db['sandbox']['asdu'] = 'b1sm1ll4h';
$db['sandbox']['asdp'] = 'l4nc3r';
$db['sandbox']['pconnect'] = false;
$db['sandbox']['db_debug'] = false;
$db['sandbox']['cache_on'] = false;
$db['sandbox']['cachedir'] = '';
$db['sandbox']['char_set'] = 'utf8';
$db['sandbox']['dbcollat'] = 'utf8_general_ci';
$db['sandbox']['swap_pre'] = '';
$db['sandbox']['autoinit'] = true;
$db['sandbox']['stricton'] = false;




$params = $db['default'];

$dns = @parse_url($params);

print_r($dns);

$params = array('dbdriver' => $dns['scheme'], 'hostname' => isset($dns['host']) ? rawurldecode($dns['host']) : '', 'username' => isset($dns['user']) ? rawurldecode($dns['user']) : '', 'password' => isset($dns['pass']) ? rawurldecode($dns['pass']) : '', 'database' => isset($dns['path']) ? rawurldecode(substr($dns['path'], 1)) : '');

print_r($params);


$key = "ae8a7a587a5a3e5738025b3b43392ab6";
$str = "WGxEMvQ/GwDTBt+rLCokCQ==NiO0483FWg7HlKYtWp8Fkw==";

$time_libcptjs="1476501361";

echo "- last updated: " . date('F d Y h:i A', $time_libcptjs);

echo "<p>";

$time = "1546253102";

echo "- last updated: " . date('F d Y h:i A', $time);


$filename = 'pg_hba.conf';
if (file_exists($filename)) {
    echo "$filename was last modified: " . date ("F d Y H:i:s.", filemtime($filename));
}

echo "<p>";
echo $time;
echo "<br>";
echo filemtime($filename);


echo "<pre>";
$sql = "select test_cat.test,nama_kelas,kuota,status_kelas_tes,
count(kelas_tes_peserta.id) as jml,
(select count(kelas_tes_pengawas.id) from kelas_tes_pengawas
  kelas.id=kelas_tes_pengawas.id_kelas) jml_pengawas
,(select where count(id) where),kelas.id ,seri_soal.nama_soal
 from kelas inner join test_cat on kelas.id_test_cat=test_cat.id
 left join kelas_tes_peserta on kelas.id=kelas_tes_peserta.id_kelas
   kelas.id=?";


$after_remove = preg_replace('#\((([^()]+|(?R))*)\)#', "", $sql);

if (strpos(strtolower($after_remove), "where")) {
	$condition = "and";
} else {
	$condition = "where";
}

echo $condition;

/*$regex =  '/where/i';

preg_match_all($regex, $sql, $matches);
print_r($matches);

*/


exit();
/*    if (!preg_match("/where/i", $sql) AND !preg_match('/\((.*where.*?)\)/', $sql) AND !preg_match('/\((.*WHERE.*?)\)/', $sql)) {) {
        $condition = "where";
    }*/
/*    if (preg_match("/where/i", $sql)) {
    	# code...
    }*/
    if(preg_match('/\((.*where.*?)\)/', $sql) AND preg_match('/\((.*WHERE.*?)\)/', $sql)) {
        $condition = "where";
    } else {
        $condition = "and";
    }

echo $condition;


