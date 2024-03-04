<?php
session_start();
include "dashboard/inc/config.php";
require_once "dashboard/inc/lib/mail/vendor/autoload.php";
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

$data_mail = $db->query("select email from sys_users inner join tb_data_abstract on sys_users.id=tb_data_abstract.id_user
where status_abstract='Accepted'");

//data mail
$body = '
<p>Dear Participants,</p>

<p>We would like to thank you for your interest and enthusiasm in the ICONISTECH 2019 that will be organized this year by Universitas Islam Sunan Gunung Djati Bandung, Universitas Telkom and also the other co-hosts.</p>

<p>Hundreds of participants have registered to this year&rsquo;s conference, including you. This leads an objective selection of the abstracts to be presented on the conference.&nbsp;</p>

<p>In this occasion, we would like to congratulate you since your abstract is&nbsp;<strong>ACCEPTED</strong>&nbsp;to be presented in the parallel/ round table session of the conference. Authors with accepted abstract(s) are requested to immediately proceed to payment through Mandiri Syariah bank:</p>

<p>Please login to Submission system (<a href="https://iconistech.fst.uinsgd.ac.id/submission">https://iconistech.fst.uinsgd.ac.id/submission</a>)&nbsp;&nbsp;with your account, then go to Payment Ticket menu, click on invoice or status to see the detail payment invoice. Once the transfer is sent,&nbsp; click on Blue button with dollar sign to confirm and upload your payment proof.&nbsp;&nbsp;</p>

<p>&nbsp;</p>

<p>No later than 30<strong>&nbsp;June 2019</strong>&nbsp;and upload the payment proof via website&nbsp;<strong>(NOT EMAIL)</strong>&nbsp;to be able to download LoA and invitation letter.&nbsp;</p>

<p>Thank you and see you in Bandung on 11 July 2019.</p>

<p>If you want to ask more about conference, you can send us email to <strong>iconistech@fst.uinsgd.ac.id</strong></p>

<p>&nbsp;</p>

<p>Sincerely,&nbsp;</p>

<p><strong>ICONISTECH Committee</strong></p>

';
            foreach ($data_mail as $email_user) {
              $ke = $email_user->email;
              $mime->addTo($ke);
              $array_to[] = $ke;
           
                }
        
            $subject = 'Notification of ICONISTECH Abstract Acceptance';

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

            print_r($email);

