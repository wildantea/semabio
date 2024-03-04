<?php
switch (uri_segment(2)) {
    case "detail":
    $data_edit = $db->fetch_single_row("tb_data_member","id",uri_segment(3));
    include "member_change_detail.php";
    break;
    default:
    include "member_change_view.php";
    break;
}

?>