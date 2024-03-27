<?php
session_start();
include "../../../inc/config.php";
require_once "../../../inc/lib/mail/vendor/autoload.php";
$data_token = $db->fetch_custom_single("select * from tb_token where id='8' order by rand() limit 1");

// Get API Credentials
$authException = false;
$mime = new Mail_mime();
// Setup Google API Client
$client = new Google_Client();
$client->setClientId($data_token->client_id);

$client->setClientSecret($data_token->client_secret);
$client->setRedirectUri($data_token->redirect_url);
$client->addScope('https://mail.google.com/');
$client->setAccessType('offline');
$client->setApprovalPrompt('force');
// Create GMail Service
$service = new Google_Service_Gmail($client);

$access_token = $db->convert_obj_to_array(json_decode($data_token->access_token));

$client->setAccessToken($access_token);

//print_r($access_token);

//if expired update token to record
if ($client->isAccessTokenExpired()) {
  //refresh token
  $client->refreshToken($data_token->refresh_token);
  $newtoken=$client->getAccessToken();

  //get access token
  //update token
 $db->update('tb_token',array('access_token' => json_encode($newtoken)),'id',$data_token->id);

  //set access token
  $client->setAccessToken($newtoken);

}
//for mail google 
function base64url_encode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function base64url_decode($data) {
    return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
}

switch ($_GET["act"]) {
	case 'up_reviewer':
	$check_paper = $db->fetch_custom_single("select get_status_paper('".$_POST['id_abstract']."') as status_paper");
	if ($check_paper->status_paper=='Waiting') {
		$db->update('tb_data_papers',array('status_paper' => 'Reviewed'),'id_abstract',$_POST['id_abstract']);
	}
	$check_abstract = $db->fetch_custom_single("select status_abstract from tb_data_abstract where id=?",array('id' => $_POST['id_abstract']));
	if ($check_abstract->status_abstract=='Waiting') {
		$db->update('tb_data_abstract',array('status_abstract' => 'Reviewed'),'id',$_POST['id_abstract']);
	}
	//$db->update('tb_data_abstract',array('id_reviewer' => $_POST['id_user']),'id',$_POST['id_abstract']);

	if (count($_POST['id_user'])>0) {
		$db->query("delete from tb_data_reviewer where id_abstract=?",array('id_abstract' => $_POST['id_abstract']));
		$i=1;
		foreach ($_POST['id_user'] as $user) {
			$db->insert('tb_data_reviewer',
				array(
					'id_abstract' => $_POST['id_abstract'],
					'id_reviewer' => $user,
					'urutan' => $i
				)
			);
			$check_exist = $db->check_exist("tb_data_note_abstract",array('id_abstract' => $_POST['id_abstract'],'id_reviewer' => $user));
			if ($check_exist==false) {
				$db->insert('tb_data_note_abstract',array('id_abstract' => $_POST['id_abstract'],'id_reviewer' => $user));
			}
		$i++;
		}
	}
	
	action_response($db->getErrorMessage());
		break;
  case "up_abstract":
	//check approved both paper and abstract
$check_paper = $db->fetch_custom_single("select get_status_paper('".$_POST['id']."') as status_paper");
if ($_POST['status']=='Accepted') {
 	$db->query("delete from tb_data_payment where id_abstract=?",array('id_abstract' => $_POST['id']));
/*	  $get_due_date = $db->fetch_single_row("tb_ref_setting_conference","id",1);
	  $invoice_urutan = $db->fetch_custom_single("select * from tb_data_payment order by inv_number desc");
	  if ($invoice_urutan) {
	  	$invoice = $invoice_urutan->inv_number+1;
	  } else {
	  	$invoice = 102;
	  }
	  //member
	  $check_kat_member = $db->fetch_single_row('tb_data_member','id_user',$_POST['id_user']);
	$biaya = $db->fetch_single_row('kategori_daftar','id_kat',$check_kat_member->id_kat_member);

	  $data_payment = array(
	  	'id_abstract' => $_POST['id'],
	  	'inv_number' => $invoice,
	  	'jumlah' => $biaya->biaya_daftar,

	  	'kode_unik' => $invoice,
	  	'due_date' => $get_due_date->due_date,
	  	'inv_date' => $get_due_date->inv_date,
	  	'status_payment' => 'unpaid'
	  );

	$db->insert('tb_data_payment',$data_payment);*/

//check if jenis daftar is free
$abstract = $db->fetch_single_row("tb_data_abstract","id",$_POST['id']);
$member = $db->fetch_single_row("tb_data_member","id_user",$abstract->id_user);
$kat_daftar = $db->fetch_single_row("kategori_daftar","id_kat",$member->id_kat_member);
$setting_conference = $db->fetch_single_row("tb_ref_setting_conference","id",1);
if ($kat_daftar->biaya_daftar>0) {
			$invoice_urutan = $db->fetch_custom_single("select * from tb_data_payment order by inv_number desc");
			  if ($invoice_urutan) {
			  	$invoice = $invoice_urutan->inv_number+1;
			  } else {
			  	$invoice = 102;
			  }
			  $data_payment = array(
			  	'inv_number' => $invoice,
			  	'id_user' => $member->id_user,
			  	'jumlah' => $kat_daftar->biaya_daftar,
			  	'kode_unik' => $invoice,
			  	'due_date' => substr($setting_conference->last_payment,0,10),
			  	'inv_date' => date('Y-m-d'),
			  	'status_payment' => 'unpaid'
			  );
			$db->insert('tb_data_payment',$data_payment);
}

$db->update('tb_data_abstract',array('status_abstract' => $_POST['status'],'approved_by' => $_SESSION['id_user']),'id',$_POST['id']);
} else {
 	$db->update('tb_data_abstract',array('status_abstract' => $_POST['status'],'approved_by' => $_SESSION['id_user']),'id',$_POST['id']);
 	$db->query("delete from tb_data_payment where id_abstract=?",array('id_abstract' => $_POST['id']));
}


if ($_POST['status']=='Accepteds') {

$user_data = $db->fetch_single_row("sys_users","id",$_POST['id_user']);
$email_user = $user_data->email;

//data mail
$body = '
<p>Dear '.$user_data->full_name.',</p>

<p>We would like to thank you for your interest and enthusiasm in the Seminar Nasional Pertanian 2021 that will be organized this year by Jurusan Agroteknologi Universitas Islam Sunan Gunung Djati Bandung.</p>

<p>In this occasion, we would like to congratulate you since your abstract is&nbsp;<strong>ACCEPTED</strong>&nbsp;</p>

<p>Please login to Submission system (<a href="https://agrotekconference.uinsgd.ac.id/submission">https://agrotekconference.uinsgd.ac.id/submission</a>)&nbsp;&nbsp;with your account, then go to Payment Ticket menu, click on invoice or status to see the detail payment invoice. Once the transfer is sent,&nbsp; click on Blue button with dollar sign to confirm and upload your payment proof.&nbsp;&nbsp;</p>

<p>&nbsp;</p>

<p>No later than 22<strong>&nbsp;October 2021</strong>&nbsp;and upload the payment proof via website&nbsp;<strong>(NOT EMAIL)</strong>&nbsp;to be able to download LoA and invitation letter.&nbsp;</p>

<p>Thank you</p>
<p>&nbsp;</p>

<p>Sincerely,&nbsp;</p>

<p><strong>Seminar Nasional Pertanian 2021 Committee</strong></p>
';
           
            $subject = 'Notification of Seminar Nasional Pertanian 2021 Abstract Acceptance';

            //email tujuan
            $mime->addTo($email_user);
            $mime->setTXTBody($body);
            $mime->setHTMLBody($body);
            $mime->setSubject($subject);
            $message_body = $mime->getMessage();

            $encoded_message = base64url_encode($message_body);

            // Gmail Message Body
            $message = new Google_Service_Gmail_Message();
            $message->setRaw($encoded_message);

         

            // Send the Email
            $email = $service->users_messages->send('me',$message);

            //print_r($email);
}

 action_response($db->getErrorMessage());
  break;
 case "up_paper":
	//check approved both paper and abstract
$check_paper = $db->fetch_custom_single("select status_abstract from tb_data_abstract where id=?",array('id' => $_POST['id']));

if ($_POST['status']=='Accepted') {

/* 	$db->query("delete from tb_data_payment where id_abstract=?",array('id_abstract' => $_POST['id']));
	  $get_due_date = $db->fetch_single_row("tb_ref_setting_conference","id",1);
	  $invoice_urutan = $db->fetch_custom_single("select * from tb_data_payment order by inv_number desc");
	  if ($invoice_urutan) {
	  	$invoice = $invoice_urutan->inv_number+1;
	  } else {
	  	$invoice = 102;
	  }
	  $check_kat_pendaftar = $db->fetch_custom_single("select case country_id
	when 104 then 'local'
	else 'int' end as kat,group_level from view_member
	where id_user=?",array('id_user' => $_POST['id_user']));
	$get_price = $db->fetch_custom_single("select biaya from tb_ref_payment where payment_for=? and reg_as=?",array('payment_for' => $check_kat_pendaftar->kat,'reg_as' => $check_kat_pendaftar->group_level));
	  $data_payment = array(
	  	'id_abstract' => $_POST['id'],
	  	'inv_number' => $invoice,
	  	'jumlah' => $get_price->biaya,
	  	'kode_unik' => $invoice,
	  	'due_date' => $get_due_date->due_date,
	  	'inv_date' => date('Y-m-d'),
	  	'status_payment' => 'unverified'
	  );
	$db->insert('tb_data_payment',$data_payment);*/
  $db->update('tb_data_papers',array('status_paper' => $_POST['status'],'approved_by' => $_SESSION['id_user']),'id_abstract',$_POST['id']);
	echo $db->getErrorMessage();
} else {

   $db->update('tb_data_papers',array('status_paper' => $_POST['status'],'approved_by' => $_SESSION['id_user']),'id_abstract',$_POST['id']);
 	$db->query("delete from tb_data_payment where id_abstract=?",array('id_abstract' => $_POST['id']));
}


 action_response($db->getErrorMessage());
  break;
}