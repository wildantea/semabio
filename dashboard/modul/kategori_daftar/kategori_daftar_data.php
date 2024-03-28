<?php
include "../../inc/config.php";

$columns = array(
    'jenis_partisipasi.jenis_partisipasi',
    'kategori_daftar.nama_kategori',
    'kategori_daftar.biaya_daftar',
    'kategori_daftar.tanggal_open',
    'kategori_daftar.tanggal_close',
    'kategori_daftar.id_kat',
  );

  //if you want to exclude column for searching, put columns name in array
  //$new_table->disable_search = array('tanggal_close','kategori_daftar.id_kat');
  
  //set numbering is true
  $datatable->set_numbering_status(1);

  //set order by column
  $datatable->set_order_by("kategori_daftar.id_kat");

  //set order by type
  $datatable->set_order_type("desc");

  //set group by column
  //$new_table->group_by = "group by kategori_daftar.id_kat";

  $query = $datatable->get_custom("select jenis_partisipasi.jenis_partisipasi,kategori_daftar.nama_kategori,kategori_daftar.biaya_daftar,kategori_daftar.tanggal_open,kategori_daftar.tanggal_close,kategori_daftar.id_kat from kategori_daftar inner join jenis_partisipasi on kategori_daftar.id_jenis_partisipasi=jenis_partisipasi.id",$columns);

  //buat inisialisasi array data
  $data = array();

  $i=1;
  foreach ($query as $value) {

    //array data
    $ResultData = array();
    $ResultData[] = $datatable->number($i);
  
    $ResultData[] = $value->jenis_partisipasi;
    $ResultData[] = $value->nama_kategori;
    $ResultData[] = rupiah($value->biaya_daftar);
    $ResultData[] = tgl_time($value->tanggal_open);
    $ResultData[] = tgl_time($value->tanggal_close);
    if (strtotime(date('Y-m-d H:i:s')) >= strtotime($value->tanggal_open) && strtotime(date('Y-m-d H:i:s')) <= strtotime($value->tanggal_close)) {
      $ResultData[] = '<span class="btn btn-success btn-xs" data-toggle="tooltip" data-title="Gelombang ini Aktif"><i class="fa fa-check"></i> Aktif</span>';
    } else {
       $ResultData[] = '<span class="btn btn-danger btn-xs" data-toggle="tooltip" data-title="Gelombang ini Tidak Aktif"><i class="fa fa-close"></i> Tidak</span>';
    }
    $ResultData[] = $value->id_kat;

    $data[] = $ResultData;
    $i++;
  }

//set data
$datatable->set_data($data);
//create our json
$datatable->create_data();

?>