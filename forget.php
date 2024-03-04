<?php
session_start();
include "dashboard/inc/config.php";
//let's check email first if it's registered
$email = $db->check_exist("sys_users",array("email" => $_POST['email']));
if ($email==false) {
	action_response('We could not find an account with that email address');
} else {
require_once "dashboard/inc/lib/mail/vendor/autoload.php";
$data_token = $db->fetch_custom_single("select * from tb_token where aktif='Y' order by rand() limit 1");

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

$data_mail = $db->fetch_single_row("sys_users","email",$_POST['email']);

//generate token and expire
$data_tokens = array(
	'id_user' => $data_mail->id,
	'token' => sha1($data_mail->email),
	'exp_time' => strtotime('+1 hour',strtotime(date('Y-m-d H:i:s'))),
	'active' => 'Y'
);
$db->delete('tb_reset_pass','id_user',$data_mail->id);
$db->insert('tb_reset_pass',$data_tokens);
//data mail
$body = '
Hi,<br>
You have requested a password change for the username "'.$data_mail->username.'"
<p>
Please click on the link below [or copy/paste it in your browser\'s address bar] to change your password
<p>
<a href="'.base_url().'reset.php?token='.sha1($data_mail->email).'" target="_blank">
'.base_url().'reset.php?token='.sha1($data_mail->email).'</a>
<p>
Use this link to reset your password. The link is only valid for 1 hours.
<p>
-Iconistech Team
<p>
P.S.
This email was sent because you requested for a password change link using the form <a href="'.base_url().'forgot_password.php" target="_blank">'.base_url().'forgot_password.php</a>
<p>
If you did not make the request, please ignore this email.
';

            $to = $data_mail->email;
        
            $subject = '[Iconistech] Your password change request';

            //email tujuan
            $mime->addTo($to);
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

action_response('',array('success' => 'An email has been sent to '.$data_mail->email.' with further instructions'));
}

