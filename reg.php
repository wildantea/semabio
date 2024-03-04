<?php
session_start();
include "dashboard/inc/config.php";

//let's check email first if it's registered
$email = $db->check_exist("sys_users",array("email" => $_POST['email']));
if ($email) {
	action_response('Email ini sudah terdaftar');
}
//let's check username
$email = $db->check_exist("sys_users",array("username" => $_POST['username']));
if ($email) {
	action_response('Username sudah digunakan, silakan pilih yang lain');
}

if ($_POST['is_presenter']=='1') {
	$group_user = 'presenter';
} else {
	$group_user = 'participant';
}


$data_user = array(
	'full_name' => $_POST['full_name'],
	"username"=>$_POST["username"],
	"password"=>md5($_POST["password"]),
	"plain_pass" => $_POST['password'],
	"email"=>$_POST["email"],
	"group_level"=>$group_user,
	"date_created"=>date('Y-m-d')
);
if ($_POST['sex']=='Male') {
	$data_user['foto_user'] = 'default_male.png';
} else {
	$data_user['foto_user'] = 'default_female.png';
}
//check email sent action
$setting_conference = $db->fetch_single_row("tb_ref_setting_conference","id",1);
if ($setting_conference->email_activation=='Y') {
	//do email sent activation
	$insert_user['aktif'] = 'N';
} else {
	$insert_user['aktif'] = 'Y';
}
$insert_user = $db->insert("sys_users",$data_user);
$id_user = $db->last_insert_id();

$data_member = array(
	"id_user" => $id_user,
	"gelar_depan" => $_POST['gelar_depan'],
	"gelar_belakang" => $_POST['gelar_belakang'],
	"sex" => $_POST['sex'],
	"affiliation" => $_POST['affiliation'],
	"city" => $_POST['city'],
	"country_id" => $_POST['country_id'],
	"phone" => $_POST['phone'],
	"is_presenter" => $_POST['is_presenter'],
	"id_kat_member" => $_POST['kategori_daftar']
);

if(isset($_FILES["ktm"]["name"])) {
                        if (!preg_match("/.(png|jpg|jpeg|gif|bmp)$/i", $_FILES["ktm"]["name"]) ) {

              action_response($lang["upload_image_error_extention"]); 
              exit();

            } else {
$filename = $_FILES["ktm"]["name"];
$filename = preg_replace("#[^a-z.0-9]#i", "", $filename); 
$ex = explode(".", $filename); // split filename
$fileExt = end($ex); // ekstensi akhir
$filename = time().rand().".".$fileExt;//rename nama file';
$size = getimagesize ($_FILES["ktm"]["tmp_name"]);
if ($size[0]>512) {
  $db->compressImage($_FILES["ktm"]["type"],$_FILES["ktm"]["tmp_name"],"upload/ktm/",$filename,512);
} else {
  copy($_FILES["ktm"]["tmp_name"], "upload/ktm/".$filename);
}
              $ktm = array("ktm"=>$filename);
              $data_member = array_merge($data_member,$ktm);
            }

                         }

$insert_member = $db->insert("tb_data_member",$data_member);
//$id_user = $db->last_insert_id();

//check if jenis daftar is free
$kat_daftar = $db->fetch_single_row("kategori_daftar","id_kat",$_POST['kategori_daftar']);
if ($kat_daftar->biaya_daftar>0) {
			$invoice_urutan = $db->fetch_custom_single("select * from tb_data_payment order by inv_number desc");
			  if ($invoice_urutan) {
			  	$invoice = $invoice_urutan->inv_number+1;
			  } else {
			  	$invoice = 102;
			  }
			  $data_payment = array(
			  	'inv_number' => $invoice,
			  	'id_user' => $id_user,
			  	'jumlah' => $kat_daftar->biaya_daftar,
			  	'kode_unik' => $invoice,
			  	'due_date' => substr($setting_conference->last_payment,0,10),
			  	'inv_date' => date('Y-m-d'),
			  	'status_payment' => 'unpaid'
			  );
			$db->insert('tb_data_payment',$data_payment);
			echo $db->getErrorMessage();
}

if ($setting_conference->email_activation=='Y') {
	$response = array('email_status' => "Terimakasih sudah melakukan pendaftaran<br> Email udah dikirimkan ke '".$_POST['email']."'. SIlakan cek email anda untuk aktivasi");
 }
 else {
	$response = array('email_status' => 'Terimakasih sudah melakukan pendaftaran<br><a href="'.base_admin().'login.php">Klik disini untuk LOGIN</a>');
}


action_response($db->getErrorMessage(),$response);
