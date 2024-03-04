<?php
include "../../../inc/config.php";

$columns = array(
    'sys_users.full_name',
    'sys_users.username',
    'sys_users.email',
    'sys_group_users.level_name',
    'sys_users.aktif',
    'sys_users.foto_user',
    'sys_users.id',
  );

  //if you want to exclude column for searching, put columns name in array
  //$new_table->disable_search = array('aktif','sys_users.id');
  
  //set numbering is true
  $datatable->set_numbering_status(1);

  //set order by column
  $datatable->set_order_by("sys_users.id");

  //set order by type
  $datatable->set_order_type("desc");

  //set group by column
  //$new_table->group_by = "group by sys_users.id";

  $query = $datatable->get_custom("select sys_users.full_name,sys_users.username,sys_users.email,sys_group_users.level_name,sys_users.aktif,sys_users.foto_user,sys_users.id from sys_users inner join sys_group_users on sys_users.group_level=sys_group_users.level",$columns);

  //buat inisialisasi array data
  $data = array();

  $i=1;
  foreach ($query as $value) {

    //array data
    $ResultData = array();
    $ResultData[] = $datatable->number($i);
  
    $ResultData[] = $value->full_name;
    $ResultData[] = $value->username;
    $ResultData[] = $value->email;
    $ResultData[] = $value->level_name;
    if ($value->aktif=='Y') {
      $ResultData[] = '<span class="btn btn-success btn-xs"><i class="fa fa-check"></i> Yes</span>';
    } else {
      $ResultData[] = '<span class="btn btn-danger btn-xs"><i class="fa fa-close"></i> No</span>';
    }
    $ResultData[] = '<img data-id="'.$value->id.'" class="look-photo" width="50" src="'.base_url().'upload/back_profil_foto/'.$value->foto_user.'">';
    //if admin user with id 1, not delete
    if ($value->id==1) {
          $ResultData[] ='<a href="'.base_index().'user-managements/detail/'.$value->id.'" class="btn btn-success btn-sm" data-toggle="tooltip" title="" data-original-title="Detail"><i class="fa fa-eye"></i></a> <a data-id="'.$value->id.'" href="'.base_index().'user-managements/edit/'.$value->id.'" class="btn btn-primary btn-sm edit_data " data-toggle="tooltip" title="" data-original-title="Edit"><i class="fa fa-pencil"></i></a>';
    } else {
          $ResultData[] ='<a href="'.base_admin().'inc/login_as.php?id='.$value->id.'&adm_id='.$_SESSION['id_user'].'&url=user&back_uri=user-managements" class="btn btn-success btn-sm" data-toggle="tooltip" title="" data-original-title="Login As"><i class="fa fa-user"></i></a> <a href="'.base_index().'user-managements/detail/'.$value->id.'" class="btn btn-success btn-sm" data-toggle="tooltip" title="" data-original-title="Detail"><i class="fa fa-eye"></i></a> <a data-id="'.$value->id.'" href="'.base_index().'user-managements/reset/'.$value->id.'" class="btn btn-danger btn-sm " data-toggle="tooltip" title="" data-original-title="Reset Password"><i class="fa fa-unlock"></i></a> <a data-id="'.$value->id.'" href="'.base_index().'user-managements/edit/'.$value->id.'" class="btn btn-primary btn-sm edit_data " data-toggle="tooltip" title="" data-original-title="Edit"><i class="fa fa-pencil"></i></a> <button data-id="'.$value->id.'" data-uri="'.base_admin().'modul/root_module/user_managements/user_managements_action.php" class="btn btn-danger hapus_dtb_notif btn-sm" data-toggle="tooltip" title="" data-variable="dtb_user_managements" data-original-title="Delete"><i class="fa fa-trash"></i></button>';
    }

    $ResultData[] = $value->id;

    $data[] = $ResultData;
    $i++;
  }

//set data
$datatable->set_data($data);
//create our json
$datatable->create_data();

?>