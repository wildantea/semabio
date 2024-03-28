<?php
session_start();
include "../../inc/config.php";
session_check_json();
switch ($_GET["act"]) {
  case "in":
    
  
  
  if (!is_dir("../../../upload/pengaturan_umum")) {
              mkdir("../../../upload/pengaturan_umum");
            }
  $data = array(
      "conference_name" => $_POST["conference_name"],
      "conference_name_short" => $_POST["conference_name_short"],
      "conference_date" => $_POST["conference_date"],
      "conference_place" => $_POST["conference_place"],
      "conference_desc" => $_POST["conference_desc"],
      "conference_site" => $_POST["conference_site"],
      "conference_email" => $_POST["conference_email"],
      "conference_city" => $_POST["conference_city"],
      "conference_chairman" => $_POST["conference_chairman"],
      "loa_date" => $_POST["loa_date"],
      "last_payment" => $_POST["last_payment"],
  );
  
  
  
                    if (!preg_match("/.(png|jpg|jpeg|gif|bmp)$/i", $_FILES["conference_logo"]["name"]) ) {
              action_response($lang["upload_image_error_extention"]); 
              exit();

            } else {
      move_uploaded_file($_FILES["conference_logo"]["tmp_name"], "../../../upload/pengaturan_umum/".$_FILES['conference_logo']['name']);

            $conference_logo = array("conference_logo"=>$_FILES["conference_logo"]["name"]);
              $data = array_merge($data,$conference_logo);
            }
   
          if(isset($_POST["email_activation"])=="on")
          {
            $email_activation = array("email_activation"=>"Y");
            $data=array_merge($data,$email_activation);
          } else {
            $email_activation = array("email_activation"=>"N");
            $data=array_merge($data,$email_activation);
          }

    $in = $db->insert("tb_ref_setting_conference",$data);
    
    
    action_response($db->getErrorMessage());
    break;
  case "delete":
    
    $db->deleteDirectory("../../../upload/pengaturan_umum/".$db->fetch_single_row("tb_ref_setting_conference","id",$_GET["id"])->conference_logo);
    
    
    $db->delete("tb_ref_setting_conference","id",$_GET["id"]);
    action_response($db->getErrorMessage());
    break;
   case "del_massal":
    $data_ids = $_REQUEST["data_ids"];
    $data_id_array = explode(",", $data_ids);
    if(!empty($data_id_array)) {
        foreach($data_id_array as $id) {
          $db->delete("tb_ref_setting_conference","id",$id);
         }
    }
    action_response($db->getErrorMessage());
    break;
  case 'up_template_loa':
    $data = array(
      'template_loa' => base64_encode($_POST['isi_template_surat'])
    );
    $up = $db->query("update tb_ref_setting_conference set template_loa='".$_POST['isi_template_surat']."' where id='".$_POST["id"]."'");
    action_response($db->getErrorMessage());
    break;
  case 'up_template_rejection':
    $data = array(
      'template_loa' => base64_encode($_POST['isi_template_surat'])
    );
    $up = $db->query("update tb_ref_setting_conference set template_rejection='".$_POST['isi_template_surat']."' where id='".$_POST["id"]."'");
    action_response($db->getErrorMessage());
    break;
  case "up":
    
   $data = array(
      "conference_name" => $_POST["conference_name"],
      "conference_name_short" => $_POST["conference_name_short"],
      "conference_date" => $_POST["conference_date"],
      "conference_place" => $_POST["conference_place"],
      "conference_desc" => $_POST["conference_desc"],
      "conference_site" => $_POST["conference_site"],
      "conference_email" => $_POST["conference_email"],
      "conference_city" => $_POST["conference_city"],
      "conference_chairman" => $_POST["conference_chairman"],
      "loa_date" => $_POST["loa_date"],
       "conference_secretary" => $_POST["conference_secretary"],
      "last_payment" => $_POST["last_payment"].' '.$_POST['jam_selesai'],
   );
   

    if (isset($_FILES['conference_logo'])) {
          if (!preg_match("/.(png|jpg|jpeg|gif|bmp)$/i", $_FILES["conference_logo"]["name"]) ) {
              action_response($lang["upload_image_error_extention"]); 
              exit();

            } else {
      move_uploaded_file($_FILES["conference_logo"]["tmp_name"], "../../../upload/logo/".$_FILES['conference_logo']['name']);

            $conference_logo = array("conference_logo"=>$_FILES["conference_logo"]["name"]);
              $data = array_merge($data,$conference_logo);
            }
    }
    


/*
    if($_POST["isi_gambar"]!="")
    {

     $gambar = $_POST["isi_gambar"];

     $image_array_1 = explode(";", $gambar);

     $image_array_2 = explode(",", $image_array_1[1]);

     $gambar = base64_decode($image_array_2[1]);

     //$imageName = time() . '.png';
     $imageName = uniqueName('gambar.png');

     file_put_contents("../../../upload/logo/".$imageName, $gambar);
     $data['conference_logo'] = $imageName;
    }*/

          if(isset($_POST["email_activation"])=="on")
          {
            $email_activation = array("email_activation"=>"Y");
            $data=array_merge($data,$email_activation);
          } else {
            $email_activation = array("email_activation"=>"N");
            $data=array_merge($data,$email_activation);
          }

    
    $up = $db->update("tb_ref_setting_conference",$data,"id",$_POST["id"]);
    
    action_response($db->getErrorMessage());
    break;
  default:
    # code...
    break;
}

?>