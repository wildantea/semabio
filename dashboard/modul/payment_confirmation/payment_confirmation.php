<?php
switch (uri_segment(2)) {
    case "detail":
    $data_edit = $db->fetch_single_row("tb_data_payment_proof","id",uri_segment(3));
    include "payment_confirmation_detail.php";
    break;
    default:
    include "payment_confirmation_view.php";
    break;
}

?>