<?php
switch (uri_segment(2)) {
    case "detail":
    $data_edit = $db->fetch_single_row("tb_ref_rekening","id",uri_segment(3));
    include "data_rekening_detail.php";
    break;
    default:
    include "data_rekening_view.php";
    break;
}

?>