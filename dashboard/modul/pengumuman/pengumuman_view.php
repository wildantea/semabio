<!-- Content Header (Page header) -->
<section class="content-header">
                    <h1>Pengumuman</h1>
                   <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>pengumuman">Pengumuman</a></li>
                        <li class="active">Detail Pengumuman</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-solid box-info">
<?php
$setting = $db->fetch_single_row("tb_ref_setting_conference","id",1);
?>
                    <div class="box-body">
                    <div class="box box-widget">
  <div class="box-header with-border">
    <div class="user-block">
       <img class="img-circle" src="<?=base_url();?>upload/logo/<?=$setting->conference_logo;?>" alt="User Image"> 
      <span class="username">
        <a href="#"><?=ucwords($data_edit->judul_pengumuman);?></a>
      </span>
      <span class="description"> <?=tgl_indo(date('Y-m-d'));?></span>
    </div>
  </div>
  <div class="box-body">
    <?php
    $data_edit_before_payment = $db->fetch_single_row("tb_informasi","id",1);
    ?>
    <?=$data_edit_before_payment->isi_informasi;?>

<?php
$check_payment = $db->query("select * from tb_data_payment where status_payment='paid' and id_user=?",array("id_user" => $_SESSION['id_user']));
if ($check_payment->rowCount()>0) {
  $data_edit_before_payment = $db->fetch_single_row("tb_informasi","id",2);
  echo $data_edit_before_payment->isi_informasi;
}

?>
<!--   <a href="<?=base_index();?>pengumuman" class="btn btn-success "><i class="fa fa-step-backward"></i> <?php echo $lang["back_button"];?></a> -->

                        </div>
                      </div>
                    </div>
                </div>

                </section><!-- /.content -->