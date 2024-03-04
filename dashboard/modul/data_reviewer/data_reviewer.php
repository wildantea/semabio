<?php
switch (uri_segment(2)) {
	 case "tambah":
      include "data_reviewer_add.php";
    break;
    case "detail":
    $data_edit = $db->fetch_single_row("sys_users","id",uri_segment(3));
    include "data_reviewer_detail.php";
    break;
     case 'reset':
    $data_edit = $db->fetch_single_row("sys_users","id",uri_segment(3));
        include "user_reset.php";
    break;
    case "detail":
    $data_edit = $db->fetch_single_row("sys_users","id",uri_segment(3));
    include "data_reviewer_detail.php";
    break;
    case "edit":
    $data_edit = $db->fetch_single_row("sys_users","id",uri_segment(3));
      include "data_reviewer_edit.php";
    break;
    default:
    include "data_reviewer_view.php";
    break;
}

?>