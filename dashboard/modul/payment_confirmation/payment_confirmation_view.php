<!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Payment Confirmation
                    </h1>
                        <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>payment-confirmation">Payment Confirmation</a></li>
                        <li class="active">Payment Confirmation List</li>
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
                                      <a id="add_payment_confirmation" class="btn btn-primary "><i class="fa fa-plus"></i> <?php echo $lang["add_button"];?></a>
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
                        <table id="dtb_payment_confirmation" class="table table-bordered table-striped display responsive nowrap" width="100%">
                            <thead>
                                <tr>
                                  <th>No</th>
                                  <th>Reg As</th>
                                  <th>Presenter</th>
                                  <th>Rekening</th>
                                  <th>Jumlah</th>
                                  <th>Tanggal Bayar</th>
                                  <th>Bukti Bayar</th>
                                  <th>Status</th>
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
<?php
    $del = "<button data-id='+data+' data-uri=".base_admin()."modul/payment_confirmation/payment_confirmation_action.php".' class="btn btn-danger hapus_dtb_notif btn-sm" data-toggle="tooltip" title="Delete" data-variable="dtb_payment_confirmation"><i class="fa fa-trash"></i></button>';
    ?>
    <div class="modal" id="modal_payment_confirmation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> <div class="modal-dialog modal-lg"> <div class="modal-content"><div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button> <h4 class="modal-title title-status"></h4> </div> <div class="modal-body" id="isi_payment_confirmation"> </div> </div><!-- /.modal-content --> </div><!-- /.modal-dialog --> </div>

 <div class="modal" id="modal_photo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> <div class="modal-dialog"> <div class="modal-content"><div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button> <h4 class="modal-title">Payment Proof</h4> </div> <div class="modal-body" id="isi_photo" style="text-align: center;"> </div> </div><!-- /.modal-content --> </div><!-- /.modal-dialog --> </div>
    
    </section><!-- /.content -->

        <script type="text/javascript">
     
    
    $(".table").on('click','.show-bukti',function(event) {
        $("#loadnya").show();
        event.preventDefault();
        var currentBtn = $(this);

        id = currentBtn.attr('data-id');

        $.ajax({
            url : "<?=base_admin();?>modul/payment_confirmation/bukti.php",
            type : "post",
            data : {id:id},
            success: function(data) {
                $("#isi_photo").html(data);
                $("#loadnya").hide();
          }
        });

    $('#modal_photo').modal({ keyboard: false });

    });   


      $("#add_payment_confirmation").click(function() {
          $.ajax({
              url : "<?=base_admin();?>modul/payment_confirmation/payment_confirmation_add.php",
              type : "GET",
              success: function(data) {
                  $("#isi_payment_confirmation").html(data);
              }
          });

      $('#modal_payment_confirmation').modal({ keyboard: false,backdrop:'static',show:true });

    });
    
      
    $(".table").on('click','.edit_data',function(event) {
        $("#loadnya").show();
        event.preventDefault();
        var currentBtn = $(this);

        id = currentBtn.attr('data-id');

        $.ajax({
            url : "<?=base_admin();?>modul/payment_confirmation/payment_confirmation_edit.php",
            type : "post",
            data : {id_data:id},
            success: function(data) {
                $("#isi_payment_confirmation").html(data);
                $("#loadnya").hide();
          }
        });

    $('#modal_payment_confirmation').modal({ keyboard: false,backdrop:'static' });

    });
    
      var dtb_payment_confirmation = $("#dtb_payment_confirmation").DataTable({
           'bProcessing': true,
            'bServerSide': true,
            'order' : [8,'desc'],
            
         //disable order dan searching pada tombol aksi use "className":"none" for always responsive hide column
                 "columnDefs": [ 
              
            {
            "targets": [8],
              "orderable": false,
              "searchable": false,
              "className": "all",
             "render": function(data, type, full, meta){
                return '<?=$del;?>';
               }
            },
      
            {
             "targets": [0],
             "width" : "5%",
              "orderable": false,
              "searchable": false,
              "className": "dt-center"
            } ],
      
            'ajax':{
              url :'<?=base_admin();?>modul/payment_confirmation/payment_confirmation_data.php',
            type: 'post',  // method  , by default get
            error: function (xhr, error, thrown) {
            console.log(xhr);

            }
          },
        });
 $(".table").on('click','.change-status',function(event) {
        $("#loadnya").show();
        event.preventDefault();
        var currentBtn = $(this);

        $('.title-status').html('Change Status');

        id = currentBtn.attr('data-id');

  
            $.ajax({
           url : "<?=base_admin();?>modul/payment_confirmation/change_status.php",
            type : "post",
            data : {id_data:id},
            success: function(data) {
                $("#isi_payment_confirmation").html(data);
                $("#loadnya").hide();
          }
        });

      $('#modal_payment_confirmation').modal({ keyboard: false,backdrop:'static' });


    });


</script>
            