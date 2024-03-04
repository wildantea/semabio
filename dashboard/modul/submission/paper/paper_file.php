<?php
session_start();
include "../../../inc/config.php";

$columns = array(
    'file_name',
    'message',
    'id_user',
    'date_created',
    'tb_data_abstract.id',
  );

  //if you want to exclude column for searching, put columns name in array
  //$new_table->disable_search = array('presenter_name','tb_data_abstract.id');
  
  //set numbering is true
  $datatable->set_numbering_status(0);

  //set order by column
  $datatable->set_order_by("tb_data_papers.date_created");

  //set order by type
  $datatable->set_order_type("asc");

  //set group by column
  //$new_table->group_by = "group by tb_data_abstract.id";
$id_abstract = $_POST['id'];
  $query = $datatable->get_custom("select message,id,file_name,date_created,status_paper,function_get_reviewer_name(id_abstract,id_user) as reviewer,function_get_author_name(id_user) as author,function_get_group_level(id_user) as group_level from tb_data_papers where has_file='Y'
    and id_abstract='$id_abstract' ",$columns);

  //buat inisialisasi array data
  $data = array();

  $i=1;
  foreach ($query as $value) {
      if ($value->group_level=='reviewer') {
                  if ($_SESSION['group_level']=='presenter') {
                    $nama = 'Reviewer';
                  } elseif($_SESSION['group_level']=='reviewer') {
                    $nama = $value->reviewer;
                  } else {
                    $nama = 'Reviewer';
                  }
                  
                }  elseif ($value->group_level=='presenter') {
                  if ($_SESSION['group_level']=='reviewer') {
                    $nama = 'Author';
                  } elseif ($_SESSION['group_level']=='presenter') {
                    $nama = $value->author;
                  } else {
                    $nama = 'Author';
                  }
                  
                } else {
                  $nama = 'Admin';

                }
    //array data
    $ResultData = array();
    $ResultData[] = $value->file_name;
    $ResultData[] = $value->message;
    $ResultData[] = $nama;
    $ResultData[] = $value->date_created;
   /* 
    if ($value->status_paper=='Waiting') {
      $ResultData[] = '<span class="btn btn-xs btn-warning paper" data-toggle="tooltip" title="Waiting to be Reviewed" data-id='.$value->id.'>Waiting</span>';
    } elseif ($value->status_paper=='Rejected') {
       $ResultData[] = '<span class="btn btn-xs btn-danger paper" data-id='.$value->id.'>Rejected</span>';
    } elseif ($value->status_paper=='Reviewed') {
      $ResultData[] = '<span class="btn btn-xs btn-primary paper" data-toggle="tooltip" title="Your paper is being Reviewed" data-id='.$value->id.'>Reviewed</span>';
    } elseif ($value->status_paper=='Revised') {
      $ResultData[] = '<span class="btn btn-xs btn-warning paper" data-toggle="tooltip" title="Your paper need to be revised, upload new one revised from chat below" data-id='.$value->id.'>Revised</span>';
    } else {
      $ResultData[] = '<span class="btn btn-xs btn-primary paper" data-id='.$value->id.'>Accepted</span>';
    }*/

    $presenter_name = $db->fetch_single_row("tb_data_abstract","id",$id_abstract);
    $dir_name = str_replace(" ", "_", $presenter_name->presenter_name);

     $ResultData[] = '<a data-id='.$value->id.'  class="btn btn-primary btn-sm open-document" data-toggle="tooltip" title="Open document"><i class="fa fa-eye"></i></a> <a href="'.base_url().'upload/papers/'.$dir_name.'/'.$presenter_name->id.'/'.$value->file_name.'" target="_blank" class="btn btn-success btn-sm" data-toggle="tooltip" title="Download document"><i class="fa fa-download"></i></a>';
    $data[] = $ResultData;
    $i++;
  }

//set data
$datatable->set_data($data);
//create our json
$datatable->create_data();

?>