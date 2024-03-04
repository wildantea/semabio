<?php
session_start();
include "../../inc/config.php";
session_check_json();
switch ($_GET["act"]) {
  case "in":
    
  
  
  
  $data = array(
      "no_rekening_pengirim" => $_POST["no_rekening_pengirim"],
      "file_proof" => $_POST["file_proof"],
      "status_payment" => $_POST["status_payment"],
  );
  
  
  
   
    $in = $db->insert("tb_data_payment_proof",$data);
    
    
    action_response($db->getErrorMessage());
    break;
  case "delete":
    
    
    
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
  case "up":
    
   $data = array(
      "no_rekening_pengirim" => $_POST["no_rekening_pengirim"],
      "file_proof" => $_POST["file_proof"],
      "status_payment" => $_POST["status_payment"],
   );
   
   
   

    
    
    $up = $db->update("tb_data_payment_proof",$data,"id",$_POST["id"]);
    
    action_response($db->getErrorMessage());
    break;
  default:
    # code...
    break;
}

?>