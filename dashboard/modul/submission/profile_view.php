<style type="text/css">
  .profile-user-img {
    width: 200px;
}
.fa-6 {
    font-size: 20px;
    display: block;
    text-align: center;
}
.fa-6:hover {
  transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
  color: #999;
}
  .nav-tabs-custom>.nav-tabs {
    border-bottom-color: #3c8dbc;
  }
.nav-tabs-custom>.nav-tabs>li.active>a {
    border-left-color: #3c8dbc;
    border-right-color: #3c8dbc;
  }

</style>
<!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Profile
                    </h1>
                        <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>profile">Profile</a></li>
                        <li class="active">Profile List</li>
                    </ol>
                </section>

                 <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-4">
 <?php
$data_profil_user = $db->fetch_single_row('sys_users','id',$_SESSION['id_user']);
 $data_profil = $db->fetch_custom_single('select tb_data_member.*,country_name from tb_data_member inner join tb_ref_country on tb_data_member.country_id=tb_ref_country.id where id_user=?',array('id_user' => $_SESSION['id_user']));
?>
          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="../../upload/back_profil_foto/<?=$data_profil_user->foto_user;?>" alt="User profile picture">
           <!--   <i class="fa fa-camera fa-6" data-toggle="tooltip" title="Change Photo" ></i> -->
              <h3 class="profile-username text-center"><?=ucwords($data_profil_user->full_name)?></h3>

              <p class="text-muted text-center">Presenter</p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Email</b> <a class="pull-right"><?=$data_profil_user->email;?></a>
                </li>
                <li class="list-group-item">
                  <b>Username</b> <a class="pull-right"><?=$data_profil_user->username;?></a>
                </li>
                <li class="list-group-item">
                  <b>Phone</b> <a class="pull-right"><?=$data_profil->phone;?></a>
                </li>
              </ul>
              <a href="<?=base_index();?>profil/change-password" class="btn btn-primary btn-block"><b>Change Password</b></a>

               <a class="btn btn-primary btn-block edit-profile" data-id="<?=$_SESSION['id_user'];?>"><b>Edit Profile</b></a>
   
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->


          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-8">
                    <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">About Me</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <strong><i class="fa fa-institution"></i> Affiliation</strong>

              <p class="text-muted">
                <?=$data_profil->affiliation;?>
              </p>

              <hr>

              <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>

              <p class="text-muted"> <?=$data_profil->city;?>,  <?=$data_profil->country_name;?></p>
              <hr>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
 <div class="modal" id="modal_change_password" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> <div class="modal-dialog modal-lg"> <div class="modal-content"><div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button> <h4 class="modal-title">Change Password</h4> </div> <div class="modal-body" id="isi_change_password"> </div> </div><!-- /.modal-content --> </div><!-- /.modal-dialog --> </div>
    <div class="modal" id="modal_member_change" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> <div class="modal-dialog modal-lg"> <div class="modal-content"><div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button> <h4 class="modal-title">Edit Profile</h4> </div> <div class="modal-body" id="isi_member_change"> </div> </div><!-- /.modal-content --> </div><!-- /.modal-dialog --> </div>
<script type="text/javascript">

  $(".edit-profile").click(function() {
        $("#loadnya").show();
        event.preventDefault();
        var currentBtn = $(this);

        id = currentBtn.attr('data-id');

        $.ajax({
            url : "<?=base_admin();?>modul/member_change/member_change_edit.php",
            type : "post",
            data : {id_data:id},
            success: function(data) {
                $("#isi_member_change").html(data);
                $("#loadnya").hide();
          }
        });

    $('#modal_member_change').modal({ keyboard: false,backdrop:'static' });

    });

</script>