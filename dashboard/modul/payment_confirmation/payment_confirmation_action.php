<?php
session_start();
include "../../inc/config.php";
require_once "../../inc/lib/mail/vendor/autoload.php";
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
  case 'up_status':
    $db->update('tb_data_payment_proof',array('status_payment' => $_POST['status']),'id',$_POST['id']);
    $get_payment_id = $db->query("select payment_id from tb_data_payment_detail where payment_proof_id=?",array('payment_proof_id' => $_POST['id']));
    if ($_POST['status']=='invalid') {
      $status_payment = 'unverified';
    } elseif ($_POST['status']=='verified') {
      $status_payment = 'paid';
    } else {
      $status_payment = 'unverified';
    }


    foreach ($get_payment_id as $pay_id) {
      $db->update('tb_data_payment',array('status_payment' => $status_payment,'date_verified' => date('Y-m-d')),'id',$pay_id->payment_id);
    }

    exit();



$email_user = $_POST['email_user'];

//data mail
$body = '
<p>Dear Participants,</p>

<p>We thank you for paying registration fee of ICONISTECH 2019. We will send you more detail about the conference soon.&nbsp;</p>

<p>Thank you.</p>

<p>Iconistech Comittee</p>
';
           
            $subject = 'A thank you note for your payment proof';

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


    action_response($db->getErrorMessage());
    break;
  case "in":
    
  
  
  
  $data = array(
      "nama_pengirim" => $_POST["nama_pengirim"],
      "asal_bank" => $_POST["asal_bank"],
      "no_rekening_pengirim" => $_POST["no_rekening_pengirim"],
      "file_proof" => $_POST["file_proof"]
  );
  
  
  
   
    $in = $db->insert("tb_data_payment_proof",$data);
    
    
    action_response($db->getErrorMessage());
    break;
  case "delete":
    //update payment 
    $payment_id = $db->query("select * from tb_data_payment_detail where payment_proof_id=?",array('id' => $_GET['id']));
    foreach($payment_id as $pay) {
      $db->update('tb_data_payment',array('status_payment' => 'unpaid'),'id',$pay->payment_id);
    }
    //delete payment proof
   // $db->deleteDirectory("../../../upload/payment_proofs/".$db->fetch_single_row("tb_data_payment_proof","id",$_GET["id"])->file_proof);
    $db->delete("tb_data_payment_proof","id",$_GET["id"]);
    action_response($db->getErrorMessage());
    break;
   case "del_massal":
    $data_ids = $_REQUEST["data_ids"];
    $data_id_array = explode(",", $data_ids);
    if(!empty($data_id_array)) {
        foreach($data_id_array as $id) {
          $db->delete("tb_data_payment_proof","id",$id);
         }
    }
    action_response($db->getErrorMessage());
    break;
  case "confirm":

  
  $id_abstract = $db->fetch_single_row('tb_data_abstract','id_user',$_POST['id_user']);

$id_payment = $db->fetch_single_row('tb_data_payment','id_abstract',$id_abstract->id);
  
  $data = array(
      "id_user" => $_POST['id_user'],
      "jumlah" => $id_payment->jumlah,
      "nama_pengirim" => $_POST["nama_pengirim"],
      "no_rekening_pengirim" => $_POST["no_rekening_pengirim"],
      "asal_bank" => $_POST["asal_bank"],
       "date_payment" => $_POST['date_payment']
  );



  
if (!preg_match("/.(jpg|jpeg|gif|png|bmp)$/i", $_FILES["file_proof"]["name"]) ) {

              action_response($lang["upload_image_error_extention"]); 
              exit();

            } else {
$filename = $_FILES["file_proof"]["name"];
$filename = preg_replace("#[^a-z.0-9]#i", "", $filename); 
$ex = explode(".", $filename); // split filename
$fileExt = end($ex); // ekstensi akhir
$filename = time().rand().".".$fileExt;//rename nama file';

$size = getimagesize ($_FILES["file_proof"]["tmp_name"]);
if ($size[0]>512) {
  $db->compressImage($_FILES["file_proof"]["type"],$_FILES["file_proof"]["tmp_name"], "../../../upload/payment_proofs/",$filename,512);
} else {
  copy($_FILES["file_proof"]["tmp_name"], "../../../upload/payment_proofs/".$filename);
}


//move_uploaded_file($_FILES["file_proof"]["tmp_name"], "../../../upload/payment_proofs/".$filename);
              $file_proof = array("file_proof"=>$filename);
              $data = array_merge($data,$file_proof);
            }
  

   
$in = $db->insert("tb_data_payment_proof",$data);
$last_id = $db->last_insert_id();

$db->update('tb_data_payment',array('status_payment' => 'unverified'),'id',$id_payment->id);

$datas = array(
        'payment_id' => $id_payment->id,
        'payment_proof_id' => $last_id
  );
$db->insert('tb_data_payment_detail',$datas);
    action_response($db->getErrorMessage());
    break;
  case "up":
    
   $data = array(
      "nama_pengirim" => $_POST["nama_pengirim"],
      "asal_bank" => $_POST["asal_bank"],
      "no_rekening_pengirim" => $_POST["no_rekening_pengirim"],
      "file_proof" => $_POST["file_proof"],
      "file_proof" => $_POST["file_proof"],
   );
   
   
   

    
    
    $up = $db->update("tb_data_payment_proof",$data,"id",$_POST["id"]);
    
    action_response($db->getErrorMessage());
    break;
  default:
    # code...
    break;
}

?>