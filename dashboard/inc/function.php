<?php 
function session_check()
{
  if (empty($_SESSION['login'])) {
    echo "die";
    exit();
  }
}

function session_check_end() {
    if (empty($_SESSION['login'])) {
    echo "<script>alert('Sessio Anda Telah Habis'); window.location = '".base_url()."';</script>";
    exit();
  }
}

function session_check_json()
{
 if (empty($_SESSION['login'])) {
    $json_response = array();
    $status['status'] = "die";
    array_push($json_response, $status);
    echo json_encode($json_response);
    exit();
  }
}
//uang
function rupiah($angka){

  $hasil_rupiah = number_format($angka,0,',','.');
  return $hasil_rupiah;
}
function dump($data) {
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}
function tgl_hijriah($tanggal)
{
    $date = substr($tanggal, 0, 10);
  if (validateDate($date)) {
    $array_month = array("Muharram", "Safar", "Rabiul Awwal", "Rabiul Akhir", "Jumadil Awwal","Jumadil Akhir", "Rajab", "Sya'ban", "Ramadhan","Syawwal", "Zulqaidah", "Zulhijjah");
                     
    $date = intval(substr($tanggal,8,2));
    $month = intval(substr($tanggal,5,2));
    $year = intval(substr($tanggal,0,4));
 
    if (($year>1582)||(($year == "1582") && ($month > 10))||(($year == "1582") && ($month=="10")&&($date >14))) {
        $jd = intval((1461*($year+4800+intval(($month-14)/12)))/4)+
        intval((367*($month-2-12*(intval(($month-14)/12))))/12)-
        intval( (3*(intval(($year+4900+intval(($month-14)/12))/100))) /4)+
        $date-32075; 
    } else {
        $jd = 367*$year-intval((7*($year+5001+intval(($month-9)/7)))/4)+
        intval((275*$month)/9)+$date+1729777;
    }
 
    $wd = $jd % 7;
    $l  = $jd - 1948440 + 10632;
    $n  = intval(($l-1) / 10631);
    $l  = $l - 10631 * $n + 354;
    $z  = (intval((10985-$l)/5316))*(intval((50*$l)/17719))+(intval($l/5670))*(intval((43*$l)/15238));
    $l  = $l-(intval((30-$z)/15))*(intval((17719*$z)/50))-(intval($z/16))*(intval((15238*$z)/43))+29;
    $m  = intval((24*$l)/709);
    $d  = $l-intval((709*$m)/24);
    $y  = 30*$n+$z-30;
    $g  = $m-1;
     
    $hijriah = "$d $array_month[$g] $y H";
 
    return $hijriah;
  } else {
    return '';
  }
}

//submit form action json response 
function action_response($error_message,$custom_response=array()) {
    $json_response = array();
    if ($error_message=='') {
        $status['status'] = "good";
        if (!empty($custom_response)) {
       foreach ($custom_response as $key => $value) {
          $status[$key] = $value;
       }

      }

     } else {
        $status['status'] = "error";
        $status['error_message'] = $error_message;
     }
    array_push($json_response, $status);
    echo json_encode($json_response);
    exit();
}
//for admin only
function session_check_adm()
{
  if ($_SESSION['group_level']!='root') {
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
  $protocol = isset($_SERVER["HTTPS"]) ? 'https://' : 'http://';
  $root = $protocol.$_SERVER['HTTP_HOST'];
  //$root .= dirname($_SERVER['SCRIPT_NAME']);
  $root .= "/".DIR_MAIN."/";
  return $root;
}

//base admin is url until admin dir, ex:http://localhost/backend/admina
function base_admin()
{
  $root='';
  $protocol = isset($_SERVER["HTTPS"]) ? 'https://' : 'http://';
  $root = $protocol.$_SERVER['HTTP_HOST'];
  $root .= "/".DIR_ADMIN."/";
  return $root;
}

//base admin is url until index.php, ex:http://localhost/backend/admina/index.php
function base_index()
{
  $root='';
   $protocol = isset($_SERVER["HTTPS"]) ? 'https://' : 'http://';
  $root = $protocol.$_SERVER['HTTP_HOST'];
  //$root .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
   $root .= "/".DIR_ADMIN."/";
  $root .='index.php/';
  return $root;
}

function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
    return $d && $d->format($format) === $date;
}

function validateDateTime($date, $format = 'Y-m-d H:i:s')
{
    $d = DateTime::createFromFormat($format, $date);
    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
    return $d && $d->format($format) === $date;
}
/**
 * return indonesian date format 
 * @param  text $date date text 2019-07-02
 * @return text       indonesian format 2 januari 2019
 */
function tgl_indo($date) { // fungsi atau method untuk mengubah tanggal ke format indonesia
  if (validateDate($date)) {
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
  } else {
    return '';
  }

}

function tgl_indo_english($date) { // fungsi atau method untuk mengubah tanggal ke format indonesia
  if (validateDate($date)) {
       // variabel BulanIndo merupakan variabel array yang menyimpan nama-nama bulan
      $BulanIndo = array("January", "February", "March",
                 "April", "May", "June",
                 "July", "August", "September",
                 "October", "November", "December");
    
      $tahun = substr($date, 0, 4); // memisahkan format tahun menggunakan substring
      $bulan = substr($date, 5, 2); // memisahkan format bulan menggunakan substring
      $tgl   = substr($date, 8, 2); // memisahkan format tanggal menggunakan substring
      
      $result = $tgl . " " . $BulanIndo[(int)$bulan-1] . " ". $tahun;
      return($result);
  } else {
    return '';
  }

}
function getHariFromDate($date) {
  $date = substr($date, 0, 10);
  if (validateDate($date)) {
    $day = date('D', strtotime($date));
    $dayList = array(
        'Sun' => 'Minggu',
        'Mon' => 'Senin',
        'Tue' => 'Selasa',
        'Wed' => 'Rabu',
        'Thu' => 'Kamis',
        'Fri' => 'Jumat',
        'Sat' => 'Sabtu'
    );
    $nama_hari = $dayList[$day];
  } else {
    $nama_hari = "";
  }

  return  $nama_hari;
}

function tgl_time($date) { // fungsi atau method untuk mengubah tanggal ke format indonesia
  if (validateDateTime($date)) {
       // variabel BulanIndo merupakan variabel array yang menyimpan nama-nama bulan
      $BulanIndo = array("Januari", "Februari", "Maret",
                 "April", "Mei", "Juni",
                 "Juli", "Agustus", "September",
                 "Oktober", "November", "Desember");
    
      $tahun = substr($date, 0, 4); // memisahkan format tahun menggunakan substring
      $bulan = substr($date, 5, 2); // memisahkan format bulan menggunakan substring
      $tgl   = substr($date, 8, 2); // memisahkan format tanggal menggunakan substring
      $time = substr($date, -8);
      
      $result = $tgl . " " . $BulanIndo[(int)$bulan-1] . " ". $tahun.' '.$time;
      return($result);
  } else {
    return '';
  }

}
function convert_ascii($string) 
{ 
  //build an array we can re-use across several operations
  $badchar=array(
      // control characters
      chr(0), chr(1), chr(2), chr(3), chr(4), chr(5), chr(6), chr(7), chr(8), chr(9), chr(10),
      chr(11), chr(12), chr(13), chr(14), chr(15), chr(16), chr(17), chr(18), chr(19), chr(20),
      chr(21), chr(22), chr(23), chr(24), chr(25), chr(26), chr(27), chr(28), chr(29), chr(30),
      chr(31),
      // non-printing characters
      chr(127)
  );
  
  return str_replace($badchar, '', $string);; 
}
/*function diff_array($array_first,$array_second) {
  if (count($array_first)>count($array_second)) {
  //delete 
  $data = array_map('unserialize', array_diff(array_map('sortAndSerialize', $array_first), array_map('sortAndSerialize', $array_second)));
  return  array('status' => 'del','data' => $data);
  } else {
  $data = array_map('unserialize', array_diff(array_map('sortAndSerialize', $array_second), array_map('sortAndSerialize', $array_first)));
  return  array('status' => 'add','data' => $data);
  }

}*/
    /**
     * get uniqure name from filename
     *
     * @param  string $file_name filename
     * @return string            new unique filename
     */
    function uniqueName($file_name)
    {
        $filename = $file_name;
        $filename = preg_replace("#[^a-z.0-9]#i", "", $filename);
        $ex       = explode(".", $filename); // split filename
        $fileExt  = end($ex); // ekstensi akhir
        $filename = time() . rand() . "." . $fileExt; //rename nama file';
        return $filename;
    }
?>