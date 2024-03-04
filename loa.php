<?php
session_start();
include "dashboard/inc/config.php";
$setting = $db->fetch_single_row("tb_ref_setting_conference","is_aktif",'Y');
$abstract = $db->fetch_single_row("tb_data_abstract","id",$_GET['id']);
$biaya = $db->fetch_custom_single("select biaya_daftar from tb_data_member inner join kategori_daftar on id_kat=id_kat_member
where id_user=?",array('id_user' => $abstract->id_user));
$full_name= $db->fetch_single_row('sys_users','id',$abstract->id_user);
?>
<html>
<head>
  <title>LOA <?=$setting->conference_name;?></title>
  <link href="https://fonts.googleapis.com/css2?family=EB+Garamond&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Times+New+Roman&display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="<?=base_admin();?>assets/dist/css/cetak/paper.css">
  <link rel="stylesheet" type="text/css" href="table.css">
  <style type="text/css">
body {
      color: #333;
}
@page { size: A4 portrait }

.tabel-info tr td, th {
 font-family: 'Garamond', serif;
 font-size: 11px;
 padding: 2px;
 font-weight: bold;
}
p {
    line-height: 1.5em;
}
ol {
   font-family: 'Garamond', serif;
      margin-bottom: 0;
      margin-top: 0;
      padding-left: 15px;
     
}
li::before {
     font-size: 11pt;
    font-style: inherit;
    font-weight: inherit;
    /* Add other font-related styles here */
}
ul {
      margin-bottom: 0;
}
ol li {
      font-size: inherit;
      padding-left:10px;
}

  </style>
</head>
<?php


//onload="window.print()"
?>
<body class="A4 portrait" >

       <div class="page-break">
        <div class="sheet padding-10mm">
          
       <?php
        $array_value_template = array(
          'nama_pendaftar' => $full_name->full_name,
          'judul_abstract' => $abstract->title_abstract,
          'nama_seminar' => $setting->conference_name,
          'nama_seminar_pendek' => $setting->conference_name_short,
          'tanggal_verifikasi' => tgl_indo($abstract->tgl_verifikasi),
          'tahun' => date('Y'),
          'tgl_lengkap' => tgl_indo(date('Y-m-d')).' M',
          'tgl_lengkap_hijriah' => tgl_hijriah(date('Y-m-d')),
          'jumlah_bayar' => $biaya->biaya_daftar,
        );

        $template = $setting->template_loa;
        preg_match_all('/{{(.*?)}}/', $template, $matches);
        foreach ($matches[1] as $match) {
         // dump($match);
            //$placeholders[] = $match;
            if (in_array($match, array_keys($array_value_template))) {
              $template = str_replace('{{' . $match . '}}', $array_value_template[$match], $template);
            }
          /*  if (in_array($match, array('qr_code'))) {
              $template = str_replace('{{' . $match . '}}', creat_qr($_POST["id_pendaftaran"]), $template);
            }
            //if has nomor surat
            if (in_array($match, array_keys($array_key_surat))) {
              $template = str_replace('{{' . $match . '}}', $increment_surat->urutan_nomor+1, $template);
            }*/
        }

      echo $template;

         //end if last page
        
        //end page-break and sheet
         ?>
        </table>

        </div></div>
    <?php
    //end loop
    




?>

</body>
<script type="text/javascript">
  window.jsPDF = window.jspdf.jsPDF;

// Convert HTML content to PDF
function Convert_HTML_To_PDF() {
    var doc = new jsPDF();
  
    // Source HTMLElement or a string containing HTML.
    var elementHTML = document.querySelector(".sheet");

    doc.html(elementHTML, {
        callback: function(doc) {
            // Save the PDF
            doc.save('surat_pembimbing.pdf');
        },
        margin: [10, 10, 10, 10],
        autoPaging: 'text',
        x: 0,
        y: 0,
        width: 190, //target width in the PDF document
        windowWidth: 675 //window width in CSS pixels
    });
}
</script>
</html>