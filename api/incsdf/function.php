<?php 
function session_check()
{
  if (empty($_SESSION['login'])) {
    echo "die";
    exit();
  }
}
//for admin only
function session_check_adm()
{
  if ($_SESSION['group_level']!='admin') {
  exit();
  }
}
//redirection 
function redirect($var)
{
  header("location:".$var);
}


//root directory web
function base_url()
{
  $root='';
  $root = "http://".$_SERVER['HTTP_HOST'];
  //$root .= dirname($_SERVER['SCRIPT_NAME']);
  $root .= "/".DIR_MAIN."/";
  return $root;
}

//base admin is url until admin dir, ex:http://localhost/backend/admina
function base_admin()
{
  $root='';
  $root = "http://".$_SERVER['HTTP_HOST'];
  $root .= "/".DIR_ADMIN."/";
  return $root;
}
//base admin is url until index.php, ex:http://localhost/backend/admina/index.php
function base_index()
{
  $root='';
  $root = "http://".$_SERVER['HTTP_HOST'];
  $root .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
  $root .='index.php/';
  return $root;
}


function tgl_indo($date) { // fungsi atau method untuk mengubah tanggal ke format indonesia
   // variabel BulanIndo merupakan variabel array yang menyimpan nama-nama bulan
    $BulanIndo = array("Januari", "Februari", "Maret",
               "April", "Mei", "Juni",
               "Juli", "Agustus", "September",
               "Oktober", "November", "Desember");
  
    $tahun = substr($date, 0, 4); // memisahkan format tahun menggunakan substring
    $bulan = substr($date, 5, 2); // memisahkan format bulan menggunakan substring
    $tgl   = substr($date, 8, 2); // memisahkan format tanggal menggunakan substring
    
    $result = $tgl . " " . $BulanIndo[(int)$bulan-1] . " ". $tahun;
    return($result);
}


?>