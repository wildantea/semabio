<?php
session_start();
include "../../inc/config.php";
session_check_json();
switch ($_GET["act"]) {
  case "in":
    
  
  
  
  $data = array(
      "kat_informasi" => $_POST["kat_informasi"],
      "isi_informasi" => $_POST["isi_informasi"],
  );
  
  
  
   
          if(isset($_POST["is_aktif"])=="on")
          {
            $is_aktif = array("is_aktif"=>"Y");
            $data=array_merge($data,$is_aktif);
          } else {
            $is_aktif = array("is_aktif"=>"N");
            $data=array_merge($data,$is_aktif);
          }
    $in = $db->insert("tb_informasi",$data);
    
    
    action_response($db->getErrorMessage());
    break;
  case "delete":
    
    
    
    $db->delete("tb_informasi","id",$_GET["id"]);
    action_response($db->getErrorMessage());
    break;
   case "del_massal":
    $data_ids = $_REQUEST["data_ids"];
    $data_id_array = explode(",", $data_ids);
    if(!empty($data_id_array)) {
        foreach($data_id_array as $id) {
          $db->delete("tb_informasi","id",$id);
         }
    }
    action_response($db->getErrorMessage());
    break;
  case "up":
    
   $data = array(
      "kat_informasi" => $_POST["kat_informasi"],
      "isi_informasi" => $_POST["isi_informasi"],
   );
   
   
   

    
          if(isset($_POST["is_aktif"])=="on")
          {
            $is_aktif = array("is_aktif"=>"Y");
            $data=array_merge($data,$is_aktif);
          } else {
            $is_aktif = array("is_aktif"=>"N");
            $data=array_merge($data,$is_aktif);
          }
    
    $up = $db->update("tb_informasi",$data,"id",$_POST["id"]);
    
    action_response($db->getErrorMessage());
    break;
  default:
    # code...
    break;
}

?>