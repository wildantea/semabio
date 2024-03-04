<?php
include "../../inc/config.php";

$columns = array(
    'tb_ref_setting_conference.conference_name',
    'tb_ref_setting_conference.conference_date',
    'tb_ref_setting_conference.conference_email',
    'tb_ref_setting_conference.id',
  );

  //if you want to exclude column for searching, put columns name in array
  //$new_table->disable_search = array('is_non_presenter_free','tb_ref_setting_conference.id');
  
  //set numbering is true
  $datatable->set_numbering_status(1);

  //set order by column
  $datatable->set_order_by("tb_ref_setting_conference.id");

  //set order by type
  $datatable->set_order_type("desc");

  //set group by column
  //$new_table->group_by = "group by tb_ref_setting_conference.id";

  $query = $datatable->get_custom("select tb_ref_setting_conference.conference_name,tb_ref_setting_conference.conference_date,tb_ref_setting_conference.conference_email,tb_ref_setting_conference.id from tb_ref_setting_conference",$columns);

  //buat inisialisasi array data
  $data = array();

  $i=1;
  foreach ($query as $value) {

    //array data
    $ResultData = array();
    $ResultData[] = $datatable->number($i);
  
    $ResultData[] = $value->conference_name;
    $ResultData[] = tgl_indo($value->conference_date);
    $ResultData[] = $value->conference_email;
    $ResultData[] = $value->id;

    $data[] = $ResultData;
    $i++;
  }

//set data
$datatable->set_data($data);
//create our json
$datatable->create_data();

?>