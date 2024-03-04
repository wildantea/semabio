<?php
session_start();
include "../../inc/config.php";
session_check_json();
switch ($_GET["act"]) {
  case "in":
  $data = array(
      "sex" => $_POST["sex"],
      "city" => $_POST["city"],
      "country_id" => $_POST["country_id"],
      "phone" => $_POST["phone"],
      "affiliation" => $_POST["affiliation"],
  );

  $db->update('sys_users',array('full_name' => $_POST['full_name']),'id',$_POST['id_user']);
  
  
  
   
    $in = $db->insert("tb_data_member",$data);
    
    
    action_response($db->getErrorMessage());
    break;
  case "delete":
    
    
    
    $db->delete("tb_data_member","id",$_GET["id"]);
    action_response($db->getErrorMessage());
    break;
   case "del_massal":
    $data_ids = $_REQUEST["data_ids"];
    $data_id_array = explode(",", $data_ids);
    if(!empty($data_id_array)) {
        foreach($data_id_array as $id) {
          $db->delete("tb_data_member","id",$id);
         }
    }
    action_response($db->getErrorMessage());
    break;
  case "up":

           if(isset($_FILES["foto_user"]["name"])) {
                        if (!preg_match("/.(png|jpg|jpeg|gif|bmp)$/i", $_FILES["foto_user"]["name"]) ) {

              action_response("Make your your choose image");
              exit();

            } else {
$filename = $_FILES["foto_user"]["name"];
$filename = preg_replace("#[^a-z.0-9]#i", "", $filename); 
$ex = explode(".", $filename); // split filename
$fileExt = end($ex); // ekstensi akhir
$filename = time().rand().".".$fileExt;//rename nama file';
$filename_thumb = 'thumb_'.$filename;//rename nama file';
$db->compressImage($_FILES["foto_user"]["type"],$_FILES["foto_user"]["tmp_name"],"../../../upload/back_profil_foto/",$filename,200);
$size = getimagesize ($_FILES["foto_user"]["tmp_name"]);
if ($size[0]>512) {
  $db->compressImage($_FILES["foto_user"]["type"],$_FILES["foto_user"]["tmp_name"],"../../../upload/back_profil_foto/",$filename_thumb,512);
} else {
  copy($_FILES["foto_user"]["tmp_name"], "../../../upload/back_profil_foto/".$filename_thumb);
}

/*$check_if_not_default_photo = $db->fetch_single_row('sys_users','id',$_POST['id_user']);
if ($check_if_not_default_photo->foto_user!='default_female.png' or $check_if_not_default_photo->foto_user!='default_male.png') {
  $db->deleteDirectory("../../../upload/back_profil_foto/".$db->fetch_single_row("sys_users","id",$_POST["id_user"])->foto_user);
  $db->deleteDirectory("../../../upload/back_profil_foto/thumb_".$db->fetch_single_row("sys_users","id",$_POST["id_user"])->foto_user);
}*/
             $foto_user = array("foto_user"=>$filename);
             $db->update('sys_users',$foto_user,'id',$_POST['id_user']);
  
            }

                         }

    
  $data = array(
      "sex" => $_POST["sex"],
      "city" => $_POST["city"],
      "country_id" => $_POST["country_id"],
      "phone" => $_POST["phone"],
      "affiliation" => $_POST["affiliation"],
  );

  $db->update('sys_users',array('full_name' => $_POST['full_name'],"email" => $_POST["email"],),'id',$_POST['id_user']);
  
  
  
    
    
    $up = $db->update("tb_data_member",$data,"id",$_POST["id"]);
    
    action_response($db->getErrorMessage());
    break;
  default:
    # code...
    break;
}

?>