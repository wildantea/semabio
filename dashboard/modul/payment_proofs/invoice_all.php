<?php
session_start();
include "../../inc/config.php";
$id_payment = $_POST['id_payment'];
$detail_data = $db->query("select title_abstract, tb_data_payment.* from tb_data_payment inner join tb_data_abstract
on tb_data_payment.id_abstract=tb_data_abstract.id
where tb_data_payment.id in($id_payment)");

$inv = array();
foreach ($detail_data as $dts) {
	$inv[]=$dts->inv_number;
}

$invoice_number = implode(" #", $inv);

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta content="IE=edge" http-equiv="X-UA-Compatible">
	<meta content="width=device-width, initial-scale=1" name="viewport">
	<title>Iconistect - Invoice</title>
	<link rel="stylesheet" type="text/css" href="invoice_css.css">
	<link href="<?=base_admin();?>assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<style type="text/css">
	@media print {

    html, body {
      height:100vh; 
      margin: 0 !important; 
      padding: 0 !important;
      overflow: hidden;
    }

}
</style>
</head>
<body>
	<div class="container-fluid invoice-container" id="invoice-table">
		<div class="row">
			<div class="col-sm-6">
				<img src="semnas.jpg">
				<h3>Invoice <strong>#<?=$invoice_number;?></strong></h3>
				<div class="invoice-status">
					Status: <span class="unpaid">Unpaid</span>
				</div>
			</div>
			<div class="col-sm-6 text-center"></div>
		</div>
		<hr>
		<div class="row">
			<div class="col-xs-6">
				<h5><strong>Please Transfer To:</strong></h5>
				<address class="small-text">
					<?php
					$rek = $db->fetch_single_row('tb_ref_rekening','id',1);

					?>
					Bank : <b><?=$rek->nama_bank;?></b><br>
					Account Holder   : <b><?=$rek->nama_pemilik;?></b><br>
					Account No : <b><?=$rek->no_rekening;?></b><br>
					Branch : <b><?=$rek->cabang;?></b><br>
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
								<td><strong>Paper</strong></td>
								<td class="text-center" width="20%"><strong>Amount</strong></td>
							</tr>
						</thead>
						<tbody>
							<?php
$detail_data = $db->query("select title_abstract, tb_data_payment.* from tb_data_payment inner join tb_data_abstract
on tb_data_payment.id_abstract=tb_data_abstract.id
where tb_data_payment.id in($id_payment)");

$total = 0;
							foreach ($detail_data as $dt) {
$total_payment = $dt->jumlah+$dt->kode_unik;
								?>
							<tr>
								<td><?=$dt->title_abstract;?></td>
								<td class="text-center">Rp. <?=number_format($total_payment,0,",",".");?></td>
							</tr>
								<?php
								$total+= $total_payment;
							}
							?>
							<tr>
								<td class="total-row text-right"><strong>Total</strong></td>
								<td class="total-row text-center">Rp <?=number_format($total,0,",",".");?></td>
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