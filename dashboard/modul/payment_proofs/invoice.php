<?php
session_start();
include "../../inc/config.php";
$detail_data = $db->fetch_custom_single("select presenter_name, title_abstract, tb_data_payment.* from tb_data_payment left join tb_data_abstract
on tb_data_payment.id_abstract=tb_data_abstract.id
where tb_data_payment.id=?",array('id' => $_GET['id']));

$setting = $db->fetch_single_row('tb_ref_setting_conference','is_aktif','Y');
$full_name= $db->fetch_single_row('sys_users','id',$_SESSION['id_user']);

$total_payment = $detail_data->jumlah+$detail_data->kode_unik;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta content="IE=edge" http-equiv="X-UA-Compatible">
	<meta content="width=device-width, initial-scale=1" name="viewport">
	<title><?=$setting->conference_name;?> - Invoice</title>
	<link rel="stylesheet" type="text/css" href="invoice_css.css">
	<link href="<?=base_admin();?>assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<style type="text/css">
	@media print {

    html, body {
      height:100vh; 
      margin: 0 !important; 
      padding: 0 !important;
      overflow: hidden;
      font-family: calibri
    }

}
</style>
</head>
<body>
	<div class="container-fluid invoice-container" id="invoice-table">
		<div class="row">
					<table class="table table-condensed">
						<thead>
							<tr>
								<td>
									<img src="../../../upload/logo/<?=$setting->conference_logo;?>">
								</td>
							
								<td class="text-center" width="80%" style="text-align: right;">
									<span style="font-weight: bold;font-size: 15pt"><?=$setting->conference_secretary;?></td>
							</tr>
						</thead>
					</table>
		</div>
		
		<div class="row">
			<div class="col-xs-12" style="margin:3px">
				<h5>Tanggal : <?=tgl_indo(date('Y-m-d'));?> </h5>
				<div class="invoice-status" style="margin: 0;text-align: center;">
					KWITANSI
				</div>
				Panitia Penyelenggara <?=$setting->conference_name;?> mengakui pembayaran berikut untuk biaya pendaftaran,
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><strong>Item Pembayaran</strong></h3>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-condensed">
						<thead style="font-weight: bold">
							<tr>
								<td >ID Abstract</td>
								<td>:</td>
								<td><?=$detail_data->inv_number;?></td>
							</tr>
							<tr>
								<td>Judul</td>
								<td>:</td>
								<td><?=$detail_data->title_abstract;?></td>
							</tr>
							<tr>
								<td>Author(s)</td>
								<td>:</td>
								<td>
<?php
				if ($_SESSION['group_level']=='participant') {
					?>
					<?=$full_name->full_name;?>
					<?php

				} else {
					?>
					<?=$detail_data->presenter_name;?>
					<?php
				}
				?>
								</td>
							</tr>
							<tr>
								<td>Jumlah Bayar</td>
								<td>:</td>
								<td>IDR <?=number_format($total_payment,0,",",".");?></td>
							</tr>
							<tr>
								<?php
								$payment_proof = $db->fetch_custom_single('select * from tb_data_payment_detail inner join tb_data_payment_proof on payment_proof_id=tb_data_payment_proof.id where payment_id=?',array('id' => $_GET['id']))
								?>
								<td>Tanggal Bayar</td>
								<td>:</td>
								<td><?=$payment_proof->date_payment;?></td>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				Salam Hormat,<br>
Panitia <?=$setting->conference_name;?>
</div>
		</div>
	</div>
	<div class="text-center hidden-print margin-footer">
		<a class="btn btn-default" href="<?=base_index();?>payment-proofs">&laquo; Back</a> <a class="btn btn-default" href="javascript:window.print()"><i class="fa fa-print"></i> Print</a>
	</div>
</body>
</html>