<?php
session_start();
include "../../inc/config.php";

$columns = array(
    'tb_data_payment.inv_number',
    'tb_data_payment.due_date',
    'tb_data_payment.inv_date',
    'tb_data_payment.jumlah',
    'tb_data_payment.status_payment',
    'tb_data_payment.id',
  );

  //if you want to exclude column for searching, put columns name in array
  //$new_table->disable_search = array('file_proof','tb_data_payment.id');
  
  //set numbering is true
  $datatable->set_numbering_status(1);

  //set order by column
  $datatable->set_order_by("tb_data_payment.id");

  //set order by type
  $datatable->set_order_type("desc");

  //set group by column
  //$new_table->group_by = "group by tb_data_payment.id";
//$datatable->setDebug(1);
if ($_SESSION['group_level']=='participant') {
    $query = $datatable->get_custom("select tb_data_payment.id_user,tb_data_payment.inv_number,tb_data_payment.due_date,tb_data_payment.inv_date,tb_data_payment.jumlah,tb_data_payment.status_payment,tb_data_payment.id,id_abstract from tb_data_payment where id_user=?",$columns,array('id_user' => $_SESSION['id_user']));
} else {
    $query = $datatable->get_custom("select tb_data_payment.id_user,tb_data_payment.inv_number,tb_data_payment.due_date,tb_data_payment.inv_date,tb_data_payment.jumlah,tb_data_payment.status_payment,tb_data_payment.id,id_abstract from tb_data_payment
left join tb_data_abstract on tb_data_payment.id_abstract=tb_data_abstract.id where tb_data_abstract.id_user=?",$columns,array('id_user' => $_SESSION['id_user']));
}

//echo $_SESSION['id_user'];

  //buat inisialisasi array data
  $data = array();

  $i=1;
  foreach ($query as $value) {
    $check_payment = $value->status_payment;
   

    $ResultData = array();
    if ($check_payment=='unpaid') {
      if ($_SESSION['group_level']=='presenter') {
       $checkbox = '<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline"> <input type="checkbox" class="group-checkable check-selected cek-cek" data-id="'.$value->id.'"> <span></span></label>';  
      } else {
        $checkbox = "";
      }
    } else {
          $checkbox = '';
    }
    $ResultData[] = $checkbox;
    $ResultData[] = '<a target="_blank" data-toggle="tooltip" title="Lihat Invoice" href="'.base_admin().'modul/payment_proofs/invoice_detail.php?id='.$value->id.'" class="btn btn-xs btn-info">#'.$value->inv_number." Lihat Invoice</a>";
    $ResultData[] = date("d F Y", strtotime($value->due_date));
    $ResultData[] = date("d F Y", strtotime($value->inv_date));
    $ResultData[] = number_format($value->jumlah,0,",",".");
    if ($value->status_payment=="paid") {
      $ResultData[] = '<a target="_blank" href="'.base_admin().'modul/payment_proofs/invoice.php?id='.$value->id.'" class="btn btn-xs btn-success">Paid</a>';
    } elseif ($value->status_payment=='unpaid') {
      $ResultData[] = '<a target="_blank" href="'.base_admin().'modul/payment_proofs/invoice_detail.php?id='.$value->id.'" class="btn btn-xs btn-danger">Unpaid</a>';
    } else {
      $ResultData[] = '<a target="_blank" href="'.base_admin().'modul/payment_proofs/invoice_detail.php?id='.$value->id.'" data-toggle="tooltip" title="Waiting for verification" class="btn btn-xs btn-warning">Unverified</a>';
    }
    $inv = '';
    if ($value->status_payment=='paid') {
      if($_SESSION['group_level']=='presenter') {
        if ($value->status_payment=="paid") {
          $inv = '<a target="_blank" href="'.base_admin().'modul/payment_proofs/invoice.php?id='.$value->id.'" class="btn btn-sm btn-success"  data-toggle="tooltip" title="Show Paid Invoice">Paid Invoice</a>';
        }
          $ResultData[] = '<a target="_blank" href="'.base_admin().'modul/payment_proofs/download_ticket.php?&ab='.$value->id_abstract.'"  class="btn btn-primary btn-sm" data-toggle="tooltip" title="Detail"><i class="fa fa-cloud-download"></i> Download Ticket</a> '.$inv;
      } else {
        $ResultData[]= '';
      }
    } elseif($value->status_payment=='unverified') {
        $ResultData[] = '';
    } else {
       $ResultData[] = '<button data-id="'.$value->id.'"  class="btn btn-primary btn-sm edit_data" data-toggle="tooltip" title="Confirm Payment"><i class="fa fa-money"></i></button>';
    }

    $data[] = $ResultData;
    $i++;
  }

//set data
$datatable->set_data($data);
//create our json
$datatable->create_data();

?>