<?php
session_start();
include "../../../inc/config.php";
session_check_json();
switch ($_GET["act"]) {
  case "in":
$presenter_name = $db->fetch_single_row("tb_data_abstract","id",$_POST["id_abstract"]);
$presenter_name = $presenter_name->presenter_name;

$dir_name = str_replace(" ", "_", $presenter_name);

  $data = array(
      "id_abstract" => $_POST["id_abstract"],
      "id_user" => $_SESSION['id_user'],
      "pesan" => $_POST["message"],
      "date_created" => date('Y-m-d H:i:s'),
      "is_read" => 'N'
  );
  
$id_abstract = $_POST["id_abstract"];
if (isset($_FILES['file_name'])) {

    if (!is_dir("../../../../upload/abstracts/$dir_name")) {
          mkdir("../../../../upload/abstracts/$dir_name");
      }  

    if (!is_dir("../../../../upload/abstracts/$dir_name/$id_abstract")) {
          mkdir("../../../../upload/abstracts/$dir_name/$id_abstract");
      }  
   if (!preg_match("/.(docx|doc)$/i", $_FILES["file_name"]["name"]) ) {

      action_response($lang["upload_file_error_extention"]."docx|doc"); 
      exit();

    }
    $check_count = $db->fetch_custom_single("select count(id) as jml from tb_data_abstract_chat where id_abstract=? and has_file='Y'",array('id_abstract' => $_POST['id_abstract']));
    $renamer = "abstract_0".($check_count->jml+1);
    $temp = explode(".", $_FILES["file_name"]["name"]);
    $newfilename = $renamer . '.' . end($temp);
    $data['has_file']= 'Y';
    $data["file_name"] = $newfilename;

    move_uploaded_file($_FILES["file_name"]["tmp_name"], "../../../../upload/abstracts/$dir_name/$id_abstract/".$newfilename);

}


$in = $db->insert("tb_data_abstract_chat",$data);

  
    action_response($db->getErrorMessage(),array('id_abstract' =>  $_POST["id_abstract"]));
    break;
  default:
    # code...
    break;
}

?>