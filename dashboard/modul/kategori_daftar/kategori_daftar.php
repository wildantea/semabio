<?php
switch (uri_segment(2)) {
    case "detail":
    $data_edit = $db->fetch_single_row("kategori_daftar","id_kat",uri_segment(3));
    include "kategori_daftar_detail.php";
    break;
    default:
    include "kategori_daftar_view.php";
    break;
}

?>