<?php
session_start();
include "../../../inc/config.php";
$columns = array(
    'tb_data_abstract.title_abstract',
    'tb_data_abstract.presenter_name',
    'verifikasi',
    'tb_data_abstract.status_abstract',
    'tb_data_abstract.id',
  );

  //if you want to exclude column for searching, put columns name in array
  $datatable2->setDisableSearchColumn(
    'tb_data_abstract.id',
  );

  //if you want to exclude column for searching, put columns name in array
  //$new_table->disable_search = array('function_get_reviewer_name(tb_data_reviewer.id_reviewer)','tb_data_abstract.id');
  
  //set numbering is true
    $datatable2->setNumberingStatus(1);

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

$datatable2->setDebug(1);
$id_user = $_SESSION['id_user'];
  $datatable2->setFromQuery("tb_data_abstract inner join sys_users on tb_data_abstract.id_user=sys_users.id
    where sys_users.id='$id_user'");
  $query = $datatable2->execQuery("select tb_data_abstract.status_abstract,tb_data_abstract.title_abstract,tb_data_abstract.presenter_name,sys_users.email,tb_data_abstract.id,verifikasi,alasan_ditolak,fungsi_check_message_reviewer(tb_data_abstract.id) as msg_for_author,fungsi_check_message_abstract(tb_data_abstract.id,'reviewer') as chat_abstract,
(select status_payment from tb_data_payment where tb_data_payment.id_abstract=tb_data_abstract.id) as payment,
    get_status_paper(tb_data_abstract.id) as status_paper from tb_data_abstract inner join sys_users on tb_data_abstract.id_user=sys_users.id
    where sys_users.id='$id_user'",$columns);

  //buat inisialisasi array data
  $data = array();

  $i=1;
  $msg_for_author = '';
  $array_login = array('root','administrator');
  $chat_abstract = "";
  $login_as = '';
  foreach ($query as $value) {
    $msg_for_author = '';
    $alasan_ditolak = '';
    if ($value->msg_for_author>0) {
      $msg_for_author = '<span class="btn btn-xs btn-success paper" data-toggle="tooltip" title="You have unread message from reviewer" data-id='.$value->id.'><i class="fa fa-envelope"></i></span>';
    }
    if ($value->chat_abstract>0) {
      $chat_abstract = '<span class="btn btn-xs btn-success abstract-view" data-toggle="tooltip" title="You have unread message from reviewer" data-id='.$value->id.'><i class="fa fa-envelope"></i></span>';
    }
    if ($value->verifikasi=='Ditolak') {
      $alasan_ditolak = $value->alasan_ditolak;
    }

    //array data
    $ResultData = array();
    $ResultData[] = $datatable->number($i);
  
    $ResultData[] = $value->title_abstract;
    $ResultData[] = $value->presenter_name;
    if ($value->verifikasi=='Menunggu') {
      $ResultData[] = '<span class="btn btn-xs btn-warning" data-toggle="tooltip" title="Sedang Menunggu Verifikasi" data-id='.$value->id.'>Menunggu</span>';
    } elseif ($value->verifikasi=='Ditolak') {
       $ResultData[] = '<span class="btn btn-xs btn-danger" data-id='.$value->id.'><i class="fa fa-times"></i> Ditolak</span> <a href="'.base_url().'loj.php?id='.$value->id.'" target="_blank" class="btn btn-xs btn-primary" data-toggle="tooltip" data-title="Lihat Surat Penolakan" data-id="'.$value->id.'"><i class="fa fa-print"></i> LOJ</a> '.$alasan_ditolak;
    } else {
      $ResultData[] = '<span class="btn btn-xs btn-success" data-id="'.$value->id.'" data-toggle="tooltip" title="Selamat, Verifikasi abstract anda diterima"><i class="fa fa-check"></i> Diterima</span>';
    }

   if ($value->verifikasi=='Diterima') {
        if ($value->payment=='paid') {
      $ResultData[] = '<span class="btn btn-xs btn-success" data-id="'.$value->id.'" data-toggle="tooltip" title="Peserta Sudah Bayar"><i class="fa fa-check"></i> Sudah</span>';
    } else {
       $ResultData[] = '<span class="btn btn-xs btn-danger" data-id='.$value->id.' data-toggle="tooltip" data-title="Silakan Upload Bukti Bayar di Menu Payment Tiket"><i class="fa fa-times"></i> Belum</span> '.$alasan_ditolak;
    }
      if ($value->status_abstract=='Waiting') {
            $ResultData[] = '<span class="btn btn-xs btn-warning abstract-view" data-id="'.$value->id.'" data-toggle="tooltip" title="Waiting to be Reviewed">Waiting</span> '.$chat_abstract;
          } elseif ($value->status_abstract=='Rejected') {
             $ResultData[] = '<span class="btn btn-xs btn-danger abstract-view" data-id="'.$value->id.'"><i class="fa fa-times"></i> Rejected</span> '.$chat_abstract;
          } elseif ($value->status_abstract=='Reviewed') {
            $ResultData[] = '<span class="btn btn-xs btn-primary abstract-view" data-id="'.$value->id.'">Reviewed</span> '.$chat_abstract;
          } elseif ($value->status_abstract=='Revised') {
            $ResultData[] = '<span class="btn btn-xs btn-warning abstract-view" data-id="'.$value->id.'">Revised</span> '.$change_status_abstract;
          }else {
            $ResultData[] = '<span class="btn btn-xs btn-success abstract-view" data-id="'.$value->id.'"><i class="fa fa-check"></i> Accepted</span> '.$chat_abstract.' <a href="'.base_url().'loa.php?id='.$value->id.'" target="_blank" class="btn btn-xs btn-primary" data-toggle="tooltip" data-title="Print Letter of Acceptance" data-id="'.$value->id.'"><i class="fa fa-print"></i> LOA</a> ';
            //<a href="'.base_admin().'modul/submission/abstract/invitation.php?id='.$value->id.'" target="_blank" class="btn btn-xs btn-primary" data-toggle="tooltip" data-title="Print Letter of Invitation" data-id="'.$value->id.'"><i class="fa fa-print"></i> Invitation</a>
          }

        if ($value->status_paper=='Waiting') {
          $ResultData[] = '<span class="btn btn-xs btn-warning paper" data-toggle="tooltip" title="Waiting to be Reviewed" data-id='.$value->id.'>Waiting</span> '.$msg_for_author;
        } elseif ($value->status_paper=='Rejected') {
           $ResultData[] = '<span class="btn btn-xs btn-danger paper" data-id='.$value->id.'><i class="fa fa-times"></i> Rejected</span> '.$msg_for_author;
        } elseif ($value->status_paper=='Revised') {
          $ResultData[] = '<span class="btn btn-xs btn-warning paper" data-id="'.$value->id.'">Revised</span> '.$msg_for_author;
        } elseif ($value->status_paper=='Reviewed') {
          $ResultData[] = '<span class="btn btn-xs btn-primary paper" data-id='.$value->id.'>Reviewed</span> '.$msg_for_author;
        } elseif ($value->status_paper=='Accepted') { 
          $ResultData[] = '<span class="btn btn-xs btn-success paper" data-id="'.$value->id.'"><i class="fa fa-check"></i> Accepted</span> '.$msg_for_author;
        } else {
          $ResultData[] = '';
        }
    } else {
      $ResultData[] = '';
      $ResultData[] = '';
      $ResultData[] = '';
    }

    


    
    $ResultData[] = $value->id;

    $data[] = $ResultData;
    $i++;
  }

//set data
$datatable2->setData($data);
//create our json
$datatable2->createData();

?>