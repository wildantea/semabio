<?php
session_start();
include "../../inc/config.php";
session_check_json();
switch ($_GET["act"]) {
  case "in":
    
  
  
  
  $data = array(
      "nama_bank" => $_POST["nama_bank"],
      "nama_pemilik" => $_POST["nama_pemilik"],
      "no_rekening" => $_POST["no_rekening"],
      "cabang" => $_POST["cabang"],
  );
  
  
  
   
    $in = $db->insert("tb_ref_rekening",$data);
    
    
    action_response($db->getErrorMessage());
    break;
  case "delete":
    
    
    
    $db->delete("tb_ref_rekening","id",$_GET["id"]);
    action_response($db->getErrorMessage());
    break;
   case "del_massal":
    $data_ids = $_REQUEST["data_ids"];
    $data_id_array = explode(",", $data_ids);
    if(!empty($data_id_array)) {
        foreach($data_id_array as $id) {
          $db->delete("tb_ref_rekening","id",$id);
         }
    }
    action_response($db->getErrorMessage());
    break;
  case "up":
    
   $data = array(
      "nama_bank" => $_POST["nama_bank"],
      "nama_pemilik" => $_POST["nama_pemilik"],
      "no_rekening" => $_POST["no_rekening"],
      "cabang" => $_POST["cabang"],
   );
   
   
   

    
    
    $up = $db->update("tb_ref_rekening",$data,"id",$_POST["id"]);
    
    action_response($db->getErrorMessage());
    break;
  default:
    # code...
    break;
}

?>