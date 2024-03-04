<?php
session_start();
include "dashboard/inc/config.php";

      $id_jenis_partisipasi = $_POST["par"];
      $ada_kat = 0;
      if ($id_jenis_partisipasi!='') {
      	      $data = $db->query("select * from kategori_daftar where id_jenis_partisipasi=? and now() > tanggal_open and now() <=tanggal_close",array("id_jenis_partisipasi" => $id_jenis_partisipasi));
      	      echo "<option value=''>Pilih Kategori</option>";
		      if ($data->rowCount()>0) {
			      foreach ($data as $dt) {
			      	if ($dt->biaya_daftar>0) {
			      		echo "<option value='$dt->id_kat'>Rp. ".rupiah($dt->biaya_daftar).', ('.$dt->nama_kategori.")</option>";
			      	} else {
			      		echo "<option value='$dt->id_kat'>Gratis ($dt->nama_kategori)</option>";
			      	}

			      }
		      } else {
		      	echo "<option value=''>Saat ini Belum ada Kategori Pendaftaran yang dibuka</option>";
		      }

      } else {
      	echo "<option value=''>Silakan pilih jenis partisipasi</option>";
      }

