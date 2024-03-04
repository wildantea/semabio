<?php
session_start();
include "../../../inc/config.php";
session_check_json();
switch ($_GET["act"]) {
  case 'paper_in':
  $data = array(
      "id_abstract" => $_POST["id_abstract"],
      "id_user" => $_POST['id_user'],
      "message" => $_POST["message"],
      "date_created" => date('Y-m-d H:i:s')
  );

    $id_abstract = $_POST['id_abstract'];
$presenter_name = $db->fetch_single_row("tb_data_abstract","id",$id_abstract);
$presenter_name = $presenter_name->presenter_name;

$dir_name = str_replace(" ", "_", $presenter_name);

if (isset($_FILES['file_name'])) {

    if (!is_dir("../../../../upload/papers/$dir_name/$id_abstract")) {
          mkdir("../../../../upload/papers/$dir_name/$id_abstract");
      }  

   if (!preg_match("/.(docx|doc)$/i", $_FILES["file_name"]["name"]) ) {

      action_response($lang["upload_file_error_extention"]."docx|doc"); 
      exit();

    }
    $check_count = $db->fetch_custom_single("select count(id) as jml from tb_data_papers where id_abstract=? and has_file='Y'",array('id_abstract' => $_POST['id_abstract']));
    $renamer = "paper_revised_0".($check_count->jml+1);
    $temp = explode(".", $_FILES["file_name"]["name"]);
    $newfilename = $renamer . '.' . end($temp);
    $data['has_file']= 'Y';
    $data["file_name"] = $newfilename;

    move_uploaded_file($_FILES["file_name"]["tmp_name"], "../../../../upload/papers/$dir_name/$id_abstract/".$newfilename);

}


$check_has_reviewer = $db->query("select * from tb_data_reviewer where id_abstract=?",array('id_abstract' => $_POST['id_abstract']));
if ($check_has_reviewer->rowCount()>0) {
  $has_reviewer='Reviewed';
} else {
  $has_reviewer = 'Waiting';
}
$data["status_paper"] = $has_reviewer;

$in = $db->insert("tb_data_papers",$data);
    action_response($db->getErrorMessage());

    break;
  case "in":

  $data = array(
      "id_abstract" => $_POST["id_abstract"],
      "id_user" => $_SESSION['id_user'],
      "message" => $_POST["message"],
      "date_created" => date('Y-m-d H:i:s')
  );
 $id_abstract = $_POST['id_abstract'];

$presenter_name = $db->fetch_single_row("tb_data_abstract","id",$id_abstract);
$presenter_name = $presenter_name->presenter_name;

$dir_name = str_replace(" ", "_", $presenter_name);

if (isset($_FILES['file_name'])) {

    if (!is_dir("../../../../upload/papers/$dir_name/$id_abstract")) {
          mkdir("../../../../upload/papers/$dir_name/$id_abstract");
      }  

   if (!preg_match("/.(docx|doc)$/i", $_FILES["file_name"]["name"]) ) {

      action_response($lang["upload_file_error_extention"]."docx|doc"); 
      exit();

    }
    $check_count = $db->fetch_custom_single("select count(id) as jml from tb_data_papers where id_abstract=?",array('id_abstract' => $_POST['id_abstract']));
    //$renamer = "paper_revised_0".($check_count->jml+1);
    $temp = explode(".", $_FILES["file_name"]["name"]);
    $replacer = str_replace(" ", "_", $temp[0]);
    $newfilename = ($check_count->jml+1).$replacer . '.' . end($temp);
    $data['has_file']= 'Y';
    $data["file_name"] = $newfilename;

   

    $presenter_name = $db->fetch_single_row("tb_data_abstract","id",$_POST['id_abstract']);
    $dir_name = str_replace(" ", "_", $presenter_name->presenter_name);
 
    move_uploaded_file($_FILES["file_name"]["tmp_name"], "../../../../upload/papers/$dir_name/$id_abstract/".$newfilename);

}


$check_has_reviewer = $db->query("select * from tb_data_reviewer where id_abstract=?",array('id_abstract' => $_POST['id_abstract']));
if ($check_has_reviewer->rowCount()>0) {
  $has_reviewer='Reviewed';
} else {
  $has_reviewer = 'Waiting';
}
$data["status_paper"] = $has_reviewer;

$in = $db->insert("tb_data_papers",$data);
$id = $db->last_insert_id();
  
    action_response($db->getErrorMessage(),array('id' => $id,'id_abstract' => $id_abstract));
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
  default:
    # code...
    break;
}

?>