<?php
//check has email
/*if ($hasEmail) {
  header("location:".base_index()."submission/edit/".$hasEmail->id);
  exit();
}*/
//https://iconistech.fst.uinsgd.ac.id/submission/dashboard/index.php/submission/edit/324
switch (uri_segment(2)) {
    case "tambah":
          foreach ($db->fetch_all("sys_menu") as $isi) {
               if (uri_segment(1)==$isi->url&&uri_segment(2)=="tambah") {
                  if ($role_act["insert_act"]=="Y") {
                        if ($_SESSION['group_level']=='presenter') {
                            include "add_abstract.php";
                        } else {
                            include "submission_admin/add_abstract.php";
                        }
                  } else {
                    echo "permission denied";
                  }
               }

      }
    break;
  case "edit":
    $data_edit = $db->fetch_single_row("tb_data_abstract","id",uri_segment(3));
        foreach ($db->fetch_all("sys_menu") as $isi) {
                      if (uri_segment(1)==$isi->url&&uri_segment(2)=="edit") {
                          if ($role_act["up_act"]=="Y") {
                              if ($_SESSION['group_level']=='presenter') {
                                  include "edit_abstract.php";
                              } else {
                                  include "submission_admin/edit_abstract.php";
                              }
                          } else {
                            echo "permission denied";
                          }
                       }

      }

    break;

    case "detail":
    $data_edit = $db->fetch_single_row("tb_data_abstract","id",uri_segment(3));
    include "submission_detail.php";
    break;
    default:
    if ($_SESSION['group_level']=='presenter') {
    	include "submission_view.php";
    } elseif ($_SESSION['group_level']=='reviewer') {
      include "view_reviewer.php";
    } else {
    	include "submission_admin/submission_view.php";
    }
    
    break;
}

?>