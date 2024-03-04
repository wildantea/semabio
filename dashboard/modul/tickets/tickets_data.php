<?php
include "../../inc/config.php";

$columns = array(
  'fungsi_get_artcile_payment(tb_data_payment_proof.id)',
    'tb_data_payment_proof.asal_bank',
    'tb_data_payment_proof.nama_pengirim',
    'tb_data_payment_proof.jumlah',
    'tb_data_payment_proof.file_proof',
    'tb_data_payment_proof.status_payment',
    'tb_data_payment_proof.id',
  );

  //if you want to exclude column for searching, put columns name in array
  //$new_table->disable_search = array('status_payment','tb_data_payment_proof.id');
  
  //set numbering is true
  $datatable->set_numbering_status(0);

  //set order by column
  $datatable->set_order_by("tb_data_payment_proof.id");

  //set order by type
  $datatable->set_order_type("desc");

  //set group by column
  //$new_table->group_by = "group by tb_data_payment_proof.id";

  $query = $datatable->get_custom("select fungsi_get_artcile_payment(tb_data_payment_proof.id) as jml_article,tb_data_payment_proof.asal_bank,tb_data_payment_proof.nama_pengirim,tb_data_payment_proof.jumlah,tb_data_payment_proof.file_proof,tb_data_payment_proof.status_payment,tb_data_payment_proof.id from tb_data_payment_proof where status_payment='paid'",$columns);

  //buat inisialisasi array data
  $data = array();

  $i=1;
  foreach ($query as $value) {

    //array data
    $ResultData = array();
    $ResultData[] = $value->jml_article;
  
    $ResultData[] = $value->asal_bank;
    $ResultData[] = $value->nama_pengirim;
    $ResultData[] = number_format($value->jumlah,0,",",".");
    $ResultData[] = '<a class="btn btn-sm btn-social-icon btn-twitter" href="'.base_url().'upload/payment_proofs/'.$value->file_proof.'" target="_blank"><i class="fa fa-file"></i></a>';
    $ResultData[] = '<span class="btn btn-sm btn-success"><i class="fa fa-check"></i> Received<span>';
    $ResultData[] = $value->id;

    $data[] = $ResultData;
    $i++;
  }

//set data
$datatable->set_data($data);
//create our json
$datatable->create_data();

?>