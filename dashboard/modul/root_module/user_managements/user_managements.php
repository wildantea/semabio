<?php
switch (uri_segment(2)) {
    case "tambah":
      include "user_managements_add.php";
    break;
  case "edit":
    $data_edit = $db->fetch_single_row("sys_users","id",uri_segment(3));
      include "user_managements_edit.php";
    break;
  case 'reset':
    $data_edit = $db->fetch_single_row("sys_users","id",uri_segment(3));
        include "user_reset.php";
    break;
    case "detail":
    $data_edit = $db->fetch_single_row("sys_users","id",uri_segment(3));
    include "user_managements_detail.php";
    break;
    default:
    include "user_managements_view.php";
    break;
}

?>