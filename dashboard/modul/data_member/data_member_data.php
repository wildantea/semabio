<?php
session_start();
include "../../inc/config.php";

$columns = array(
    'sys_users.full_name',
    'username',
    'sys_users.email',
    'affiliation',
    'tb_data_member.phone',
    'sys_users.group_level',
    'sys_users.foto_user',
    'sys_users.aktif',
    'sys_users.id',
  );

  //if you want to exclude column for searching, put columns name in array
  //$new_table->disable_search = array('is_presenter','tb_data_member.id');
  
  //set numbering is true
  $datatable->set_numbering_status(1);

  //set order by column
  $datatable->set_order_by("tb_data_member.id");

  //set order by type
  $datatable->set_order_type("desc");

  //set group by column
  //$new_table->group_by = "group by tb_data_member.id";

  $query = $datatable->get_custom("select username,affiliation,sys_users.full_name,sys_users.email,tb_data_member.phone,sys_users.group_level,sys_users.foto_user,nama_kategori,ktm,sys_users.aktif,sys_users.id from tb_data_member inner join sys_users on tb_data_member.id_user=sys_users.id
    inner join kategori_daftar on id_kat_member=id_kat",$columns);

  //buat inisialisasi array data
  $data = array();
  $user_id = $_SESSION['id_user'];
  $array_login = array('root','administrator');
  $i=1;
  foreach ($query as $value) {
    $login_as = '';
    if (in_array($_SESSION['group_level'],$array_login)) {
      $login_as = '<a href="'.base_admin().'inc/login_as.php?id='.$value->id.'&adm_id='.$user_id.'" class="btn btn-success btn-sm" data-toggle="tooltip" title="" data-original-title="Login As Member"><i class="fa fa-user"></i></a>';
    }
    //array data
    $ResultData = array();
    $ResultData[] = $datatable->number($i);
  
    $ResultData[] = $value->full_name;
    $ResultData[] = $value->username;
    $ResultData[] = $value->email;
    $ResultData[] = $value->affiliation;
    $ResultData[] = $value->phone;
    $ResultData[] = $value->nama_kategori;
    $ResultData[] = '<img data-id="'.$value->id.'" class="look-photo" width="50" src="'.base_url().'upload/back_profil_foto/'.$value->foto_user.'">';
        if ($value->aktif=='Y') {
      $ResultData[] = '<span class="btn btn-success btn-xs"><i class="fa fa-check"></i> Yes</span>';
    } else {
      $ResultData[] = '<span class="btn btn-danger btn-xs"><i class="fa fa-close"></i> No</span>';
    }
             $ResultData[] = $login_as.' <a data-id="'.$value->id.'" href="'.base_index().'data-member/reset/'.$value->id.'" class="btn btn-danger btn-sm " data-toggle="tooltip" title="" data-original-title="Reset Password"><i class="fa fa-unlock"></i></a> <a data-id="'.$value->id.'" href="'.base_index().'data-member/edit/'.$value->id.'" class="btn btn-primary btn-sm edit_data " data-toggle="tooltip" title="" data-original-title="Edit"><i class="fa fa-pencil"></i></a> <button data-id="'.$value->id.'" data-uri="'.base_admin().'modul/data_member/data_member_action.php" class="btn btn-danger hapus_dtb_notif btn-sm" data-toggle="tooltip" title="" data-variable="dtb_data_member" data-original-title="Delete"><i class="fa fa-trash"></i></button>';

    $data[] = $ResultData;
    $i++;
  }

//set data
$datatable->set_data($data);
//create our json
$datatable->create_data();

?>