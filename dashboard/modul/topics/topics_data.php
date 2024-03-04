<?php
include "../../inc/config.php";

$columns = array(
    'tb_ref_scope.scope_name',
    'tb_ref_scope.id',
  );

  //if you want to exclude column for searching, put columns name in array
  //$new_table->disable_search = array('scope_name','tb_ref_scope.id');
  
  //set numbering is true
  $datatable->set_numbering_status(1);

  //set order by column
  $datatable->set_order_by("tb_ref_scope.id");

  //set order by type
  $datatable->set_order_type("desc");

  //set group by column
  //$new_table->group_by = "group by tb_ref_scope.id";

  $query = $datatable->get_custom("select tb_ref_scope.scope_name,tb_ref_scope.id from tb_ref_scope",$columns);

  //buat inisialisasi array data
  $data = array();

  $i=1;
  foreach ($query as $value) {

    //array data
    $ResultData = array();
    $ResultData[] = $datatable->number($i);
  
    $ResultData[] = $value->scope_name;
    $ResultData[] = $value->id;

    $data[] = $ResultData;
    $i++;
  }

//set data
$datatable->set_data($data);
//create our json
$datatable->create_data();

?>