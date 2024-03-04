<?php
session_start();
include "../../inc/config.php";
session_check_json();
switch ($_GET["act"]) {
  case "in":
    
  
  
  
  $data = array(
      "id_user" => $_POST["id_user"],
      "title_abstract" => $_POST["title_abstract"],
      "all_authors" => $_POST["all_authors"],
      "email_author" => $_POST["email_author"],
      "affiliation" => $_POST["affiliation"],
      "content_abstract" => $_POST["content_abstract"],
      "keywords_abstract" => $_POST["keywords_abstract"],
      "id_scope" => $_POST["id_scope"],
      "presenter_name" => $_POST["presenter_name"],
  );
  
  
  
   
    $in = $db->insert("tb_data_abstract",$data);
    
    
    action_response($db->getErrorMessage());
    break;
  case "delete":
    
    
    
    $db->delete("tb_data_abstract","id",$_GET["id"]);
    action_response($db->getErrorMessage());
    break;
   case "del_massal":
    $data_ids = $_REQUEST["data_ids"];
    $data_id_array = explode(",", $data_ids);
    if(!empty($data_id_array)) {
        foreach($data_id_array as $id) {
          $db->delete("tb_data_abstract","id",$id);
         }
    }
    action_response($db->getErrorMessage());
    break;
  case "up":
    
   $data = array(
      "id_user" => $_POST["id_user"],
      "title_abstract" => $_POST["title_abstract"],
      "all_authors" => $_POST["all_authors"],
      "email_author" => $_POST["email_author"],
      "affiliation" => $_POST["affiliation"],
      "content_abstract" => $_POST["content_abstract"],
      "keywords_abstract" => $_POST["keywords_abstract"],
      "id_scope" => $_POST["id_scope"],
      "presenter_name" => $_POST["presenter_name"],
   );
   
   
   

    
    
    $up = $db->update("tb_data_abstract",$data,"id",$_POST["id"]);
    
    action_response($db->getErrorMessage());
    break;
  default:
    # code...
    break;
}

?>