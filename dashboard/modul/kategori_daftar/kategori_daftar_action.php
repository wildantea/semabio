<?php
session_start();
include "../../inc/config.php";
session_check_json();
switch ($_GET["act"]) {
  case "in":
  
  $data = array(
      "nama_kategori" => $_POST["nama_kategori"],
      "id_jenis_partisipasi" => $_POST["id_jenis_partisipasi"],
      "biaya_daftar" => str_replace(".", "", $_POST["biaya_daftar"]),
      "tanggal_open" => $_POST["tanggal_open"].' '.$_POST["jam_mulai"],
      "tanggal_close" => $_POST["tanggal_close"].' '.$_POST["jam_selesai"].':59',
  );
  
                if(isset($_POST["is_mahasiswa"])=="on")
          {
            $aktif = array("is_mahasiswa"=>"Y");
            $data=array_merge($data,$aktif);
          } else {
            $aktif = array("is_mahasiswa"=>"N");
            $data=array_merge($data,$aktif);
          }
  

  
   
    $in = $db->insert("kategori_daftar",$data);
    
    
    action_response($db->getErrorMessage());
    break;
  case "delete":
    
    
    
    $db->delete("kategori_daftar","id_kat",$_GET["id"]);
    action_response($db->getErrorMessage());
    break;
   case "del_massal":
    $data_ids = $_REQUEST["data_ids"];
    $data_id_array = explode(",", $data_ids);
    if(!empty($data_id_array)) {
        foreach($data_id_array as $id) {
          $db->delete("kategori_daftar","id_kat",$id);
         }
    }
    action_response($db->getErrorMessage());
    break;
  case "up":

   $data = array(
      "nama_kategori" => $_POST["nama_kategori"],
      "id_jenis_partisipasi" => $_POST["id_jenis_partisipasi"],
      "biaya_daftar" => str_replace(".", "", $_POST["biaya_daftar"]),
      "tanggal_open" => $_POST["tanggal_open"].' '.$_POST["jam_mulai"].':00',
      "tanggal_close" => $_POST["tanggal_close"].' '.$_POST["jam_selesai"].':59',
   );
   
   
                 if(isset($_POST["is_mahasiswa"])=="on")
          {
            $aktif = array("is_mahasiswa"=>"Y");
            $data=array_merge($data,$aktif);
          } else {
            $aktif = array("is_mahasiswa"=>"N");
            $data=array_merge($data,$aktif);
          }

    
    
    $up = $db->update("kategori_daftar",$data,"id_kat",$_POST["id"]);
    
    action_response($db->getErrorMessage());
    break;
  default:
    # code...
    break;
}

?>