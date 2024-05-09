<?php
session_start();
error_reporting(0);
require_once('../../../inc/lib/pclzip.lib.php');
    
   $scope = "";
  $abstract = "";
  $paper = "";
  $verifikasi = "";
  $bayar = "";

   function get_dir_abstract($dir) {
      $modul_dir = explode(DIRECTORY_SEPARATOR, $dir);
     array_pop($modul_dir);
     array_pop($modul_dir);
     array_pop($modul_dir);
      array_pop($modul_dir);

     $modul_dir = implode(DIRECTORY_SEPARATOR, $modul_dir);
     return $modul_dir.DIRECTORY_SEPARATOR."upload/abstracts".DIRECTORY_SEPARATOR;
  }

  if ($_POST['scope']!='all') {
    $scope = ' and id_scope="'.$_POST['scope'].'"';
  }


  if ($_POST['abstract']!='all') {
    $abstract = ' and status_abstract="'.$_POST['abstract'].'"';
  }


  if ($_POST['paper']!='all') {
    $paper = ' and get_status_paper(tb_data_abstract.id)="'.$_POST['paper'].'"';
  } else {
     $paper = ' and get_status_paper(tb_data_abstract.id)!=""';
     $paper = '';
  }

  if ($_POST['verifikasi']!='all') {
    $verifikasi = ' and verifikasi="'.$_POST['verifikasi'].'"';
  }

  if ($_POST['bayar']!='all') {
    $bayar = ' and (select status_payment from tb_data_payment where tb_data_payment.id_abstract=tb_data_abstract.id)="'.$_POST['bayar'].'"';
  }


  $presenter_name = $db->query("select tb_data_abstract.id,presenter_name,(select file_name from tb_data_abstract_chat where id_abstract=tb_data_abstract.id and has_file='Y' order by id desc limit 1) as file_name from tb_data_abstract inner join sys_users on tb_data_abstract.id_user=sys_users.id inner join tb_ref_scope on tb_data_abstract.id_scope=tb_ref_scope.id where tb_data_abstract.status_abstract='Accepted' $scope $abstract $paper $verifikasi $bayar");


//$presenter_name = $db->query("select scope_name,presenter_name from tb_data_abstract inner join tb_ref_scope on id_scope=tb_ref_scope.id where ada=1 and id_scope=? group by presenter_name",array('id_scope' => $id_scope));

$i=1;
foreach ($presenter_name as $presenter) {
  if ($presenter->file_name!="") {
      $nama_directory = str_replace(" ", "_", $presenter->presenter_name);

    //dump($presenter);
    $dir_to_download = get_dir_abstract(getcwd()).$nama_directory.DIRECTORY_SEPARATOR.$presenter->id.DIRECTORY_SEPARATOR.$presenter->file_name;

    $ex = explode(".", $presenter->file_name); // split filename
    $fileExt = end($ex); // ekstensi akhir
    $new_file_name = $nama_directory.$presenter->id.'.'.$fileExt;
   

    //$db->downloadfolderabstract(get_dir_abstract(getcwd()),'abstract');

  /*  dump($dir_to_download);
    exit();*/
    $put_file = $db->put_file_to($dir_to_download,$new_file_name);


    //dump($dir_to_download);

  /*
    //echo $i.$dir_to_download."<br>";
    $db->downloadfolderpaper($dir_to_download,str_replace(" ", "_", $presenter->presenter_name));
    $i++;*/
  }

}
$db->download_paper('data_abstract');



