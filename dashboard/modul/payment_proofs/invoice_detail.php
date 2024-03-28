<?php
session_start();
include "../../inc/config.php";
$detail_data = $db->fetch_custom_single("select presenter_name, title_abstract, tb_data_payment.* from tb_data_payment left join tb_data_abstract
on tb_data_payment.id_abstract=tb_data_abstract.id
where tb_data_payment.id=?",array('id' => $_GET['id']));

$full_name= $db->fetch_single_row('sys_users','id',$_SESSION['id_user']);

$setting = $db->fetch_single_row('tb_ref_setting_conference','is_aktif','Y');

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
.bank>tbody>tr>th {
	padding:3px;
}
</style>
</head>
<body>
	<div class="container-fluid invoice-container" id="invoice-table">
		<div class="row">
			<div class="col-sm-6">
				<img src="../../../upload/logo/<?=$setting->conference_logo;?>" style="width: 100px;">
				<h3>Invoice <strong>#<?=$detail_data->inv_number;?></strong></h3>
				<?php
				if ($_SESSION['group_level']=='participant') {
					?>
					<h5><?=$full_name->full_name;?></h5>
					<?php

				} else {
					?>
					<h5><?=$detail_data->presenter_name;?></h5>
					<?php
				}
				?>
				
				<div class="invoice-status">
					<?php
					if ($detail_data->status_payment=='paid') {
						$class = 'paid';
						$status = 'LUNAS';
					} elseif ($detail_data->status_payment=='unpaid') {
						$class = 'unpaid';
						$status = 'BELUM BAYAR';
					} else {
						$class = 'unpaid';
						$status = 'BELUM BAYAR';
					}
					?>
					Status: <span class="<?=$class;?>"><?=$status;?></span>
				<br>
					<?php
					if ($_SESSION['group_level']=='participant') {
						echo "PARTICIPANT";
					} else {
						echo "PRESENTER";
					}
					?>
				</div>
				<span class="small-text">Tanggal Invoice: <?=date("d F Y", strtotime($detail_data->inv_date));?><br>Jatuh Tempo : 
				<?=date("d F Y", strtotime($detail_data->due_date));?></span><br>
				<br>
			</div>
			<div class="col-sm-6 text-right"><span style="font-weight: bold;font-size: 15pt"> <?=$setting->conference_name;?></span><br><?=$setting->conference_secretary;?>
			Email : <?=$setting->conference_email;?> Website : <?=$setting->conference_site;?>

			 </div>
		</div>
		<hr>
		<div class="row">
			<div class="col-xs-6">
				<h5><strong>Silakan Transfer Ke:</strong></h5>
				<address class="small-text">
					<?php
					$rek = $db->fetch_single_row('tb_ref_rekening','id',1);

					?>
					<table class="bank">
						<tr>
							<td>Bank</td>
							<th> : </th>
							<th><?=$rek->nama_bank;?></th>
						</tr>
						<tr>
							<td>Atas Nama</td>
							<th> : </th>
							<th><?=$rek->nama_pemilik;?></th>
							</tr>
							<tr>
							<td>Nomor Rekening</td>
							<th> : </th>
							<th><?=$rek->no_rekening;?></th>
							</tr>
							<tr>
							<td>Cabang</td>
							<th> : </th>
							<th><?=$rek->cabang;?></th>
						</tr>
					</table>
				</address>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><strong>Invoice Items</strong></h3>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-condensed">
						<thead>
							<tr>
								<?php
								if ($_SESSION['group_level']=='presenter') {
									?>
										<td><strong>Paper</strong></td>
									<?php
								} else {
									?>
									<td>&nbsp;</td>
									<?php
								}
								?>
							
								<td class="text-center" width="20%"><strong>Amount</strong></td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?=$detail_data->title_abstract;?></td>
								<td class="text-center">Rp. <?=number_format($detail_data->jumlah,0,",",".");?></td>
							</tr>
							<tr>
								<td class="total-row text-right"><strong>Unique Code</strong></td>
								<td class="total-row text-center">Rp <?=$detail_data->kode_unik;?></td>
							</tr>
							<tr>
								<td class="total-row text-right"><strong>Total</strong></td>
								<td class="total-row text-center">Rp <?=number_format($total_payment,0,",",".");?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="text-center hidden-print margin-footer">
		<a class="btn btn-default" href="<?=base_index();?>payment-proofs">&laquo; Back</a> <a class="btn btn-default" href="javascript:window.print()"><i class="fa fa-print"></i> Print</a>
	</div>
</body>
</html>