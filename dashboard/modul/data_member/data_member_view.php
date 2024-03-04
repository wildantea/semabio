<style type="text/css">
  .look-photo {
    cursor: pointer;
  }
</style>
<!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Data Member
                    </h1>
                        <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>data-member">Data Member</a></li>
                        <li class="active">Data Member List</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                <?php
                                  foreach ($db->fetch_all("sys_menu") as $isi) {
                                      if (uri_segment(1)==$isi->url) {
                                          if ($role_act["insert_act"]=="Y") {
                                      ?>
                                      <a href="<?=base_index();?>data-member/tambah" class="btn btn-primary "><i class="fa fa-plus"></i> <?php echo $lang["add_button"];?></a>
                                      <?php
                                          }
                                      }
                                  }
                                ?>
                            </div><!-- /.box-header -->
                            <div class="box-body">
 <div class="alert alert-warning fade in error_data_delete" style="display:none">
          <button type="button" class="close hide_alert_notif">&times;</button>
          <i class="icon fa fa-warning"></i> <span class="isi_warning_delete"></span>
        </div>
                        <table id="dtb_data_member" class="table table-bordered table-striped display  nowrap" width="100%">
                            <thead>
                                <tr>
                                  <th>No</th>
                                  <th>Full Name</th>
                                  <th>Username</th>
                                  <th>Email</th>
                                  <th>Affiliation</th>
                                  <th>Phone</th>
                                  <th>Register as</th>
                                  <th>Photo</th>
                                  <th>Aktif</th>
                                  <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                  </div><!-- /.box -->
                </div>
              </div>

       

    </section><!-- /.content -->
 <div class="modal" id="modal_photo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> <div class="modal-dialog"> <div class="modal-content"><div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button> <h4 class="modal-title">Thumbnail</h4> </div> <div class="modal-body" id="isi_photo" style="text-align: center;"> </div> </div><!-- /.modal-content --> </div><!-- /.modal-dialog --> </div>
        <script type="text/javascript">
         
    $(".table").on('click','.look-photo',function(event) {
        $("#loadnya").show();
        event.preventDefault();
        var currentBtn = $(this);

        id = currentBtn.attr('data-id');

        $.ajax({
            url : "<?=base_admin();?>modul/root_module/user_managements/photo.php",
            type : "post",
            data : {id:id},
            success: function(data) {
                $("#isi_photo").html(data);
                $("#loadnya").hide();
          }
        });

    $('#modal_photo').modal({ keyboard: false });

    });     
      
      var dtb_data_member = $("#dtb_data_member").DataTable({
           'bProcessing': true,
            'bServerSide': true,
            'scrollX' : true,
            
         //disable order dan searching pada tombol aksi use "className":"none" for always responsive hide column
                 "columnDefs": [ 
              
            {
            "targets": [9],
              "orderable": false,
              "searchable": false,
              "className": "all"
            },
      
            {
             "targets": [0],
             "width" : "5%",
              "orderable": false,
              "searchable": false,
              "className": "dt-center"
            } ],
      
            'ajax':{
              url :'<?=base_admin();?>modul/data_member/data_member_data.php',
            type: 'post',  // method  , by default get
            error: function (xhr, error, thrown) {
            console.log(xhr);

            }
          },
        });
</script>
            