<?php
session_start();
include "../../../inc/config.php";
$columns = array(
    'full_name',
    'tb_data_abstract.title_abstract',
    'tb_data_abstract.presenter_name',
    'affiliation',
    'scope_name',
    'verifikasi',
    'fungsi_nama_reviewer(tb_data_abstract.id)',
    'payment',
    'tb_data_abstract.status_abstract',
    'get_status_paper(tb_data_abstract.id)',
    'tb_data_abstract.id',
  );

  //if you want to exclude column for searching, put columns name in array
  $datatable2->setDisableSearchColumn(
    'fungsi_nama_reviewer(tb_data_abstract.id)',
    'payment',
    'tb_data_abstract.status_abstract',
    'get_status_paper(tb_data_abstract.id)',
    'tb_data_abstract.id',
  );

  //if you want to exclude column for searching, put columns name in array
  //$new_table->disable_search = array('function_get_reviewer_name(tb_data_reviewer.id_reviewer)','tb_data_abstract.id');
  
  //set numbering is true
    $datatable2->setNumberingStatus(1);
    $datatable2->setOrderBy("tb_data_abstract.id desc");

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

$datatable2->setDebug(1);

  $datatable2->setFromQuery("tb_data_abstract inner join sys_users on tb_data_abstract.id_user=sys_users.id inner join tb_ref_scope on tb_data_abstract.id_scope=tb_ref_scope.id $join_reviewer where tb_data_abstract.id is not null $where_reviewer $scope $abstract $paper $verifikasi $bayar");
  $query = $datatable2->execQuery("select full_name,scope_name,id_user,tb_data_abstract.status_abstract,tb_data_abstract.title_abstract,tb_data_abstract.verifikasi,tb_data_abstract.alasan_ditolak, tb_data_abstract.presenter_name,sys_users.email,tb_data_abstract.id,fungsi_check_message_reviewer(tb_data_abstract.id) as msg_for_author,sys_users.id as id_user,fungsi_check_message_abstract(tb_data_abstract.id,'reviewer') as chat_abstract,
(select status_payment from tb_data_payment where tb_data_payment.id_abstract=tb_data_abstract.id) as payment,
    fungsi_nama_reviewer(tb_data_abstract.id) as reviewer,get_status_paper(tb_data_abstract.id) as status_paper,affiliation from tb_data_abstract inner join sys_users on tb_data_abstract.id_user=sys_users.id inner join tb_ref_scope on tb_data_abstract.id_scope=tb_ref_scope.id $join_reviewer where tb_data_abstract.id is not null $where_reviewer $scope $abstract $paper $verifikasi $bayar",$columns);

  //buat inisialisasi array data
  $data = array();

  $i=1;
  $msg_for_author = '';
  $array_login = array('root','administrator');
  $chat_abstract = "";
  $user_id = $_SESSION['id_user'];
  foreach ($query as $value) {
    $login_as = '';
    $msg_for_author = '';
    $alasan_ditolak = '';
    if (in_array($_SESSION['group_level'],$array_login)) {
      $login_as = '<a href="'.base_admin().'inc/login_as.php?id='.$value->id_user.'&adm_id='.$user_id.'" class="btn btn-success btn-sm" data-toggle="tooltip" title="" data-original-title="Login As Peserta/Presenter"><i class="fa fa-user"></i></a>';
    }
    if ($_SESSION['group_level']!='reviewer') {
      $btn_reviewer = '<span data-id="'.$value->id.'" class="btn btn-xs btn-info assign-reviewer" data-toggle="tooltip" title="Change Reviewer"><i class="fa fa-user-plus"></i></span>';
    }

    if ($value->msg_for_author>0) {
      $msg_for_author = '<span class="btn btn-xs btn-success paper" data-toggle="tooltip" title="You have unread message from reviewer" data-id='.$value->id.'><i class="fa fa-envelope"></i></span>';
    }
    if ($value->chat_abstract>0) {
      $chat_abstract = '<span class="btn btn-xs btn-success abstract-view" data-toggle="tooltip" title="You have unread message from reviewer" data-id='.$value->id.'><i class="fa fa-envelope"></i></span>';
    }

    $change_status_abstract = '<span data-id="'.$value->id.'" class="btn btn-xs btn-info change-abstract" data-toggle="tooltip" title="Change Abstract Status"><i class="fa fa-gear"></i></span>';
    $change_status_paper = '<span data-id="'.$value->id.'" class="btn btn-xs btn-info change-paper" data-toggle="tooltip" title="Change Abstract Status"><i class="fa fa-gear"></i></span>';

    //array data
    $ResultData = array();
    $ResultData[] = $datatable->number($i);
    $ResultData[] = $value->full_name.' '.$login_as;
    $ResultData[] = $value->title_abstract;
    $ResultData[] = $value->presenter_name;
    $ResultData[] = $value->affiliation;
    $ResultData[] = $value->scope_name;

    if ($value->reviewer=="") {
      $ResultData[] = '<span data-id="'.$value->id.'" class="btn btn-xs btn-info assign-reviewer" data-toggle="tooltip" title="Assign Reviewer"><i class="fa fa-user-plus"></i></span>';
    } else {  
        $reviewer = array_map('trim', explode('#', $value->reviewer));
        $reviewer = trim(implode("<br>- ", $reviewer));
        $ResultData[] = '- '.$reviewer.' '.$btn_reviewer;
    }

    if ($value->verifikasi=='Ditolak' || $value->verifikasi=='Revisi') {
      $alasan_ditolak = $value->alasan_ditolak;
    }

    if ($value->verifikasi=='Menunggu') {
      $ResultData[] = '<span class="btn btn-xs btn-warning verifikasi" data-toggle="tooltip" title="Belum di Verifikasi" data-id='.$value->id.'>Belum</span>';
    } elseif ($value->verifikasi=='Ditolak') {
       $ResultData[] = '<span class="btn btn-xs btn-danger verifikasi" data-id='.$value->id.'><i class="fa fa-times"></i> Ditolak</span> '.$alasan_ditolak;
    } elseif ($value->verifikasi=='Revisi') {
       $ResultData[] = '<span class="btn btn-xs btn-info" data-id='.$value->id.'><i class="fa fa-times"></i> Revisi</span> '.$alasan_ditolak;
    } else {
      $ResultData[] = '<span class="btn btn-xs btn-success verifikasi" data-id="'.$value->id.'" data-toggle="tooltip" title="Verifikasi diterima"><i class="fa fa-check"></i> Diterima</span>';
    }

    if ($value->verifikasi=='Diterima') {
    if ($value->payment=='paid') {
      $ResultData[] = '<span class="btn btn-xs btn-success" data-id="'.$value->id.'" data-toggle="tooltip" title="Peserta Sudah Bayar"><i class="fa fa-check"></i> Sudah</span>';
    } else {
       $ResultData[] = '<span class="btn btn-xs btn-danger" data-id='.$value->id.' data-toggle="tooltip" data-title="Belum Bayar"><i class="fa fa-times"></i> Belum</span> '.$alasan_ditolak;
    }
    if ($value->status_abstract=='Waiting') {
      $ResultData[] = '<span class="btn btn-xs btn-warning abstract-view" data-id="'.$value->id.'" data-toggle="tooltip" title="Click to see detail">Waiting</span> '.$change_status_abstract;
    } elseif ($value->status_abstract=='Rejected') {
       $ResultData[] = '<span class="btn btn-xs btn-danger abstract-view" data-id="'.$value->id.'" data-toggle="tooltip" title="Click to see detail"><i class="fa fa-times"></i> Rejected</span> '.$change_status_abstract;
    } elseif ($value->status_abstract=='Reviewed') {
      $ResultData[] = '<span class="btn btn-xs btn-primary abstract-view" data-id="'.$value->id.'" data-toggle="tooltip" title="Click to see detail">Reviewed</span> '.$change_status_abstract;
    } elseif ($value->status_abstract=='Revised') {
      $ResultData[] = '<span class="btn btn-xs btn-warning abstract-view" data-id="'.$value->id.'" data-toggle="tooltip" title="Click to see detail">Revised</span> '.$change_status_abstract;
    } else {
      $ResultData[] = '<span class="btn btn-xs btn-success abstract-view" data-id="'.$value->id.'" data-toggle="tooltip" title="Click to see detail"><i class="fa fa-check"></i> Accepted</span> '.$change_status_abstract;
    }
    if ($value->status_paper=='Waiting') {
      $ResultData[] = '<span class="btn btn-xs btn-warning paper" data-toggle="tooltip" title="Click to see detail" data-id='.$value->id.'>Waiting</span> '.$change_status_paper;
    } elseif ($value->status_paper=='Rejected') {
       $ResultData[] = '<span data-toggle="tooltip" title="Click to see detail" class="btn btn-xs btn-danger paper" data-id='.$value->id.'><i class="fa fa-times"></i> Rejected</span> '.$change_status_paper;
    } elseif ($value->status_paper=='Revised') {
      $ResultData[] = '<span class="btn btn-xs btn-warning paper" data-id="'.$value->id.'" data-toggle="tooltip" title="Click to see detail">Revised</span> '.$change_status_paper;
    } elseif ($value->status_paper=='Reviewed') {
      $ResultData[] = '<span data-toggle="tooltip" title="Click to see detail" class="btn btn-xs btn-primary paper" data-id='.$value->id.'>Reviewed</span> '.$change_status_paper;
    }
    elseif ($value->status_paper=='Accepted') { 
      $ResultData[] = '<span class="btn btn-xs btn-success paper" data-id="'.$value->id.'"><i class="fa fa-check"></i> Accepted</span> '.$change_status_paper;
    } else {
      $ResultData[] = '';
    }

    $ResultData[] = '<a href="'.base_url().'loa.php?id='.$value->id.'" target="_blank" class="btn btn-xs btn-primary" data-toggle="tooltip" data-title="Print Letter of Acceptance" data-id="'.$value->id.'"><i class="fa fa-print"></i> LOA</a>';

  } else {
    $ResultData[] = '';
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