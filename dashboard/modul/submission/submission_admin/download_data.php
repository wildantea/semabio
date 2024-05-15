<?php
session_start();
require_once '../../../inc/lib/Writer.php';
$writer = new XLSXWriter();
$style =
        array (
            array(
              'border' => array(
                'style' => 'thin',
                'color' => '000000'
                ),
            'allfilleddata' => true
            ),
            
            array(
                'fill' => array(
                    'color' => 'ff0000'
                    ),
                'cells' => array(
                   'A1','B1','C1','D1','E1','F1','G1','H1','I1','J1','K1'
                    ),
                'border' => array(
                    'style' => 'thin',
                    'color' => '000000'
                    ),
                'verticalAlign' => 'center',
                'horizontalAlign' => 'center',
            ),
            
            );
//column width
$col_width = array(
1 => 14,
2 => 25,
3 => 40,
4 => 30,
5 => 13,
6 => 30,
7 => 50,
8 => 50,
9 => 30,
10 => 50,
11 => 70,
12 => 100,
13 => 30,
14 => 30,
15 => 30,
16 => 30,
  );
$writer->setColWidth($col_width);

$header = array(
"Account Name" => "string",
"Account Email" => "string",
"All Authors" => "string",
"Presenter" => "string",
"Email Author" => "string",
"Reviewer 1" => 'string',
"Abstract Note Reviewer 1" => 'string',
"Paper Note Reviewer 1" => 'string',
"Reviewer 2" => 'string',
"Abstract Note Reviewer 2" => 'string',
"Paper Note Reviewer 2" => 'string',
"Affiliation" => "string",
"Title Abstract" => "string",
"Abstract" => "string",
"Keywords" => "string",
"Scope" => "string"
);

  //set group by column
  $id_user = $_SESSION['id_user'];
  $where_reviewer = "";
  $where = "";
  if ($_SESSION['group_level']=='reviewer') {
    $where = "where tb_data_reviewer.id_reviewer='".$id_user."'";
    $where_reviewer = "and tb_data_abstract.id in(select tb_data_reviewer.id_abstract from tb_data_reviewer $where)";
  } 

  $btn_reviewer = "";

  $scope = "";
  $abstract = "";
  $paper = "";
  $verifikasi = "";
  $bayar = "";
 if (isset($_POST['scope'])) {
    
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
}



$data_rec = array();
    
        $temp_rec = $db->query("select all_authors,keywords_abstract,full_name,scope_name,tb_data_abstract.status_abstract,
tb_data_abstract.title_abstract,tb_data_abstract.presenter_name,sys_users.email,tb_data_abstract.id,
fungsi_nama_reviewer_single(tb_data_abstract.id,0) as reviewer_1,fungsi_nama_reviewer_single(tb_data_abstract.id,1) as reviewer_2,
fungsi_get_notes_abstract(tb_data_abstract.id,0) as abs_note_1,fungsi_get_notes_abstract(tb_data_abstract.id,1) as abs_note_2,
fungsi_get_notes_paper(tb_data_abstract.id,0) as paper_note_1,fungsi_get_notes_paper(tb_data_abstract.id,1) as paper_note_2,
affiliation from tb_data_abstract inner join sys_users on tb_data_abstract.id_user=sys_users.id 
inner join tb_ref_scope on tb_data_abstract.id_scope=tb_ref_scope.id $where_reviewer $scope $abstract $paper $verifikasi $bayar");
                    foreach ($temp_rec as $key) {

    if ($key->reviewer=="") {
      $reviewer ='';
    } else {  
        $reviewer = array_map('trim', explode('#', $value->reviewer));
        $reviewer = trim(implode("\n- ", $reviewer));
        $reviewer = '- '.$reviewer;
    }

$data_rec[] = array(
            $key->full_name,
            $key->email,
            $key->all_authors,
            $key->presenter_name,
            $key->email_author,
            $key->reviewer_1,
            $key->abs_note_1,
            $key->paper_note_1,
            $key->reviewer_2,
            $key->abs_note_2,
            $key->paper_note_2,
            $key->affiliation,
            $key->title_abstract,
            strip_tags($key->content_abstract),
            $key->keywords_abstract,
            $key->scope_name
);
$reviewer ='';
            }


$filename = 'Download_Submission.xlsx';
header('Content-disposition: attachment; filename="'.XLSXWriter::sanitize_filename($filename).'"');
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header('Content-Transfer-Encoding: binary');
header('Cache-Control: must-revalidate');
header('Pragma: public');
$writer->writeSheet($data_rec,'Submission', $header, $style);
$writer->writeToStdOut();
exit(0);
?>