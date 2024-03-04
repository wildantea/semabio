<?php
include "../../inc/config.php";

$columns = array(
    'tb_data_payment_proof.asal_bank',
    'tb_data_payment_proof.nama_pengirim',
    'tb_data_payment_proof.no_rekening_pengirim',
    'tb_data_payment_proof.jumlah',
    'tb_data_payment_proof.file_proof',
    'tb_data_payment_proof.date_payment',
    'tb_data_payment_proof.status_payment',
    'tb_data_payment_proof.id',
  );

  //if you want to exclude column for searching, put columns name in array
  //$new_table->disable_search = array('status_payment','tb_data_payment_proof.id');
  
  //set numbering is true
  $datatable->set_numbering_status(1);

  //set order by column
  $datatable->set_order_by("tb_data_payment_proof.id");

  //set order by type
  $datatable->set_order_type("desc");

  //set group by column
  //$new_table->group_by = "group by tb_data_payment_proof.id";

  $query = $datatable->get_custom("select fungsi_get_jenis_pendaftar(id_user) as reg_as,fungsi_get_presenter(tb_data_payment_proof.id) as presenter, tb_data_payment_proof.asal_bank,tb_data_payment_proof.nama_pengirim,tb_data_payment_proof.no_rekening_pengirim,tb_data_payment_proof.jumlah,tb_data_payment_proof.file_proof,tb_data_payment_proof.date_payment,tb_data_payment_proof.status_payment,tb_data_payment_proof.id from tb_data_payment_proof",$columns);

  //buat inisialisasi array data
  $data = array();

  $i=1;
  foreach ($query as $value) {

    //array data
    $ResultData = array();
    $ResultData[] = $datatable->number($i);
    $ResultData[] = ucwords($value->reg_as);
    if ($value->presenter!='') {
        $presenter = array_map('trim', explode('#', $value->presenter));
        $presenter = trim(implode("<br>- ", $presenter));
        $ResultData[] = '- '.$presenter;
    } else {
      $ResultData[] = '';
    }

    $ResultData[] = $value->asal_bank.'-'.$value->no_rekening_pengirim.'-A.N '.$value->nama_pengirim;
    $ResultData[] = number_format($value->jumlah,0,",",".");
    $ResultData[] = tgl_indo($value->date_payment);
   // $ResultData[] = '<a class="btn btn-sm btn-social-icon btn-twitter" href="'.base_url().'upload/payment_proofs/'.$value->file_proof.'" target="_blank"><i class="fa fa-file"></i></a>';
    $ResultData[] = '<a class="btn btn-sm btn-social-icon btn-twitter show-bukti" data-id="'.$value->id.'"><i class="fa fa-file"></i></a>';
    if ($value->status_payment=='unverified') {
        $ResultData[] = '<span data-id="'.$value->id.'" class="btn btn-sm btn-warning change-status"><i class="fa fa-warning"></i> Unverified<span>';
    } elseif(($value->status_payment=='verified')) {  
    $ResultData[] = '<span data-id="'.$value->id.'" class="btn btn-sm btn-success change-status"><i class="fa fa-check"></i> Verified<span>';
    } else {
      $ResultData[] = '<span data-id="'.$value->id.'" class="btn btn-sm btn-danger change-status"><i class="fa fa-times"></i> Invalid<span>';
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