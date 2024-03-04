<?php
session_start();
include "../../inc/config.php";
 $data_edit = $db->fetch_single_row("tb_data_payment_proof","id",$_POST['id']);
?>
<img width="512" src="<?=base_url();?>upload/payment_proofs/<?=$data_edit->file_proof;?>">