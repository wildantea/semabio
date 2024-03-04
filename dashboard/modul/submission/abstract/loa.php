<?php
session_start();
include "../../../inc/config.php";
$setting = $db->fetch_single_row("tb_ref_setting_conference","id",1);
$abstract = $db->fetch_single_row("tb_data_abstract","id",$_GET['id']);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title><?=$setting->conference_name;?> - Letter of Acceptance</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
  @media print {
  #print_page {
    display: none;
  }
}
</style>
</head>

<body>
<button id="print_page" onclick="myFunction()">Print this page</button>

<script>
function myFunction() {
    window.print();
}
</script>
<br><br><br>
<table border="1" style="border-collapse: collapse" bordercolor="#000000" cellpadding="10">
<tr>
    <td height="800" width="700" valign="top">
	
<table border="0">
<tr>
 <td valign="middle"><img width="150" src="<?=base_url().'upload/logo/'.$setting->conference_logo;?>"><br><br></td> 
<td valign="top" width="20"></td>
          <td valign="top">
<font size="+3" face="Verdana, Arial, Helvetica, sans-serif"><b><?=$setting->conference_name;?></b></font>
<br>
            <strong><!-- <?=$setting->conference_desc;?> <br>-->
<!-- <?=$setting->conference_place;?>,  --><?=tgl_indo_english($setting->conference_date);?></strong><br>
            <strong>Website: <?=$setting->conference_site;?> <br> Email: <?=$setting->conference_email;?></strong> 
          </td>
</tr>
</table>	

<hr size="1" color="#000000">	
<p>Date: <?=tgl_indo_english($setting->loa_date);?></p>
<br>      <p align="center"><font size="+2"><u>Letter of Acceptance</u></font></p>
<br><br>
      <p>Dear Authors: <?=$abstract->all_authors;?></p>
	  <p>We are pleased to inform you that your abstract, 
	  entitled:</p>
      <p align="center"><strong>&quot;<?=$abstract->title_abstract ;?>&quot;</strong></p>
      <p>has been reviewed and accepted to be presented at <?=$setting->conference_name;?> conference 
        to be held on <?=tgl_indo_english($setting->conference_date);?> in <?=$setting->conference_city;?>, Indonesia.</p>
      <p>Please submit your full paper and make the payment for registration fee before the deadlines, visit our website for more information.</p>
      <p>Thank You.</p>
      <p>&nbsp;</p>
      <p>Best regards,</p>
      <p><img src="new_signature.png" height="75"></p>
      <p><?=$setting->conference_chairman;?><br><?=$setting->conference_name;?> Chairperson</p></td>
</tr>
</table>

</body>
</html>
