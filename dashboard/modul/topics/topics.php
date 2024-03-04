<?php
switch (uri_segment(2)) {
    case "detail":
    $data_edit = $db->fetch_single_row("tb_ref_scope","id",uri_segment(3));
    include "topics_detail.php";
    break;
    default:
    include "topics_view.php";
    break;
}

?>