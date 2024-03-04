<?php
session_start();
include "../../inc/config.php";
session_check_json();
switch ($_GET["act"]) {
  case "in_massal":


  if (!is_dir("../../../upload/payment_proofs")) {
              mkdir("../../../upload/payment_proofs");
            }

  
  $data = array(
      "jumlah" => $_POST["jumlah"],
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
move_uploaded_file($_FILES["file_proof"]["tmp_name"], "../../../upload/payment_proofs/".$filename);
              $file_proof = array("file_proof"=>$filename);
              $data = array_merge($data,$file_proof);
            }
  

   
$in = $db->insert("tb_data_payment_proof",$data);
$last_id = $db->last_insert_id();

$id_payment = explode(",", $_POST['id_payment']);

foreach ($id_payment as $payment_id) {
  $array_input = array('payment_id' => $payment_id,'payment_proof_id' => $last_id);
  $db->insert('tb_data_payment_detail',$array_input);
  $db->update('tb_data_payment',array('status_payment' => 'unverified'),'id',$payment_id);
}
  

    action_response($db->getErrorMessage());
    break;
  case "in":

  if (!is_dir("../../../upload/payment_proofs")) {
              mkdir("../../../upload/payment_proofs");
            }
  
  
  $data = array(
      "id_user" => $_SESSION['id_user'],
      "jumlah" => $_POST["jumlah"],
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

$db->update('tb_data_payment',array('status_payment' => 'unverified'),'id',$_POST["id_payment"]);

$datas = array(
        'payment_id' => $_POST['id_payment'],
        'payment_proof_id' => $last_id
  );
$db->insert('tb_data_payment_detail',$datas);
    action_response($db->getErrorMessage());
    break;
  case "delete":
    
    
    $db->deleteDirectory("../../../upload/payment_proofs/".$db->fetch_single_row("tb_data_payment","id",$_GET["id"])->file_proof);
    $db->delete("tb_data_payment","id",$_GET["id"]);
    action_response($db->getErrorMessage());
    break;
   case "del_massal":
    $data_ids = $_REQUEST["data_ids"];
    $data_id_array = explode(",", $data_ids);
    if(!empty($data_id_array)) {
        foreach($data_id_array as $id) {
          $db->delete("tb_data_payment","id",$id);
         }
    }
    action_response($db->getErrorMessage());
    break;
  case "up":
    
   $data = array(
      "inv_number" => $_POST["inv_number"],
      "jumlah" => $_POST["jumlah"],
      "nama_pengirim" => $_POST["nama_pengirim"],
      "no_rekening_pengirim" => $_POST["no_rekening_pengirim"],
      "asal_bank" => $_POST["asal_bank"],
   );
   
                         if(isset($_FILES["file_proof"]["name"])) {
                        if (!preg_match("/.(pdf|txt|docx|doc|jpg|jpeg|gif|png|bmp)$/i", $_FILES["file_proof"]["name"]) ) {
              action_response($lang["upload_file_error_extention"]."pdf|txt|docx|doc|jpg|jpeg|gif|png|bmp"); 
              exit();

            } else {
              move_uploaded_file($_FILES["file_proof"]["tmp_name"], "../../../upload/payment_proofs/".$_FILES['file_proof']['name']);
              $db->deleteDirectory("../../../upload/payment_proofs/".$db->fetch_single_row("tb_data_payment","id",$_POST["id"])->file_proof);
              $file_proof = array("file_proof"=>$_FILES["file_proof"]["name"]);
              $data = array_merge($data,$file_proof);
            }

                         }
   
   

    
    
    $up = $db->update("tb_data_payment",$data,"id",$_POST["id"]);
    
    action_response($db->getErrorMessage());
    break;
  default:
    # code...
    break;
}

?>