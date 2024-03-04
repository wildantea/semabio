<?php
include "../../inc/config.php";

$columns = array(
    'tb_data_member.phone',
    'tb_data_member.id',
  );

  //if you want to exclude column for searching, put columns name in array
  //$new_table->disable_search = array('affiliation','tb_data_member.id');
  
  //set numbering is true
  $datatable->set_numbering_status(1);

  //set order by column
  $datatable->set_order_by("tb_data_member.id");

  //set order by type
  $datatable->set_order_type("desc");

  //set group by column
  //$new_table->group_by = "group by tb_data_member.id";

  $query = $datatable->get_custom("select tb_data_member.phone,tb_data_member.id from tb_data_member",$columns);

  //buat inisialisasi array data
  $data = array();

  $i=1;
  foreach ($query as $value) {

    //array data
    $ResultData = array();
    $ResultData[] = $datatable->number($i);
  
    $ResultData[] = $value->phone;
    $ResultData[] = $value->id;

    $data[] = $ResultData;
    $i++;
  }

//set data
$datatable->set_data($data);
//create our json
$datatable->create_data();

?>