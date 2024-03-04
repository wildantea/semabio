<?php
switch (uri_segment(2)) {
    case "tambah":
          foreach ($db->fetch_all("sys_menu") as $isi) {
               if (uri_segment(1)==$isi->url&&uri_segment(2)=="tambah") {
                          if ($role_act["insert_act"]=="Y") {
                             include "data_member_add.php";
                          } else {
                            echo "permission denied";
                          }
                       }

      }
    break;
 case 'reset':
    $data_edit = $db->fetch_single_row("sys_users","id",uri_segment(3));
        include "user_reset.php";
    break;
  case "edit":
    $data_edit = $db->fetch_single_row("tb_data_member","id_user",uri_segment(3));
    $data_user = $db->fetch_single_row("sys_users","id",uri_segment(3));
    
        foreach ($db->fetch_all("sys_menu") as $isi) {
                      if (uri_segment(1)==$isi->url&&uri_segment(2)=="edit") {
                          if ($role_act["up_act"]=="Y") {
                             include "data_member_edit.php";
                          } else {
                            echo "permission denied";
                          }
                       }

      }

    break;
    case "detail":
    $data_edit = $db->fetch_single_row("tb_data_member","id",uri_segment(3));
    include "data_member_detail.php";
    break;
    default:
    include "data_member_view.php";
    break;
}

?>