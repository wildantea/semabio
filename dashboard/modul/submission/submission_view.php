<!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Submission
                    </h1>
                        <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>submission">Submission</a></li>
                        <li class="active">Submission List</li>
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
                                     <a href="<?=base_index();?>submission/tambah" class="btn btn-primary "><i class="fa fa-plus"></i> Tambah Submission</a>
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
                        <table id="dtb_abstract" class="table table-bordered table-striped display nowrap" width="100%">
                            <thead>
                                <tr>
                                  <th rowspan="2">No</th>
                                  <th rowspan="2">Title</th>
                                  <th rowspan="2">Presenter</th>
                                  <th colspan="4" class="dt-center">Status</th>
                                  <th rowspan="2">Action</th>
                                </tr>
                                <tr>
                                  <th>Verifikasi</th>
                                  <th>Bayar</th>
                                  <th>Abstract</th>
                                  <th>Paper</th>
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

            foreach ($db->fetch_all("sys_menu") as $isi) {

            //jika url = url dari table menu
            if (uri_segment(1)==$isi->url) {
              //check edit permission
              if ($role_act["up_act"]=="Y") {
                $edit = "<a data-id='+data+' href=".base_index()."submission/edit/'+data+' class=\"btn btn-primary btn-sm \" data-toggle=\"tooltip\" title=\"Edit\"><i class=\"fa fa-pencil\"></i></a>";
      
              } else {
                  $edit ="";
              }
            if ($role_act['del_act']=='Y') {
                
    $del = "<button data-id='+data+' data-uri=".base_admin()."modul/submission/submission_action.php".' class="btn btn-danger hapus_dtb_notif btn-sm" data-toggle="tooltip" title="Delete" data-variable="dtb_abstract"><i class="fa fa-trash"></i></button>';
    
            } else {
                $del="";
            }
                             }
            }

        ?>
<style type="text/css">
  .modal-abs {
  width: 98%;
  padding: 0;
}

.modal-content-abs {
  height: 99%;
}
</style>
    <div class="modal" id="modal_abstract" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> <div class="modal-dialog modal-lg"> <div class="modal-content"><div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button> <h4 class="modal-title"><?php echo $lang["add_button"];?> Abstract</h4> </div> <div class="modal-body" id="isi_abstract"> </div> </div><!-- /.modal-content --> </div><!-- /.modal-dialog --> </div>
    <div class="modal" id="modal_paper" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> <div class="modal-dialog modal-lg modal-paper"> <div class="modal-content modal-content-paper"><div class="modal-header"> <button type="button" class="close-modal btn btn-danger" style="float:right;"><span aria-hidden="true"><i class="fa fa-times fa-6"></i></span></button> <h4 class="modal-title">Full Paper Detail</h4> </div> <div class="modal-body" id="isi_paper"> </div> </div><!-- /.modal-content --> </div><!-- /.modal-dialog --> </div>

    <div class="modal" id="modal_abs" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> <div class="modal-dialog modal-lg modal-abs"> <div class="modal-content modal-content-abs"><div class="modal-header"> <button type="button" class="close-modal-abstract  btn btn-danger" style="float:right;"><span aria-hidden="true"><i class="fa fa-times fa-6"></i></span></button> <h4 class="modal-title">Abstract Detail</h4> </div> <div class="modal-body" id="isi_abs"> </div> </div><!-- /.modal-content --> </div><!-- /.modal-dialog --> </div>
    
    </section><!-- /.content -->

        <script type="text/javascript">
       $(".close-modal").on('click', function() {
        $('#modal_paper').modal('hide');
        $('.modal-paper').removeAttr( 'style' );
        $('.modal-content-paper').removeAttr( 'style' );
    });
       $(".close-modal-abstract").on('click', function() {
        $('#modal_abs').modal('hide');
    });


      $("#add_abstract").click(function() {
          $.ajax({
              url : "<?=base_admin();?>modul/submission/abstract/abstract_add.php",
              type : "GET",
              success: function(data) {
                  $("#isi_abstract").html(data);
              }
          });

      $('#modal_abstract').modal({ keyboard: false,backdrop:'static',show:true });

    });
    


    $(".table").on('click','.edit_data',function(event) {
        $("#loadnya").show();
        event.preventDefault();
        var currentBtn = $(this);

        id = currentBtn.attr('data-id');

        $.ajax({
            url : "<?=base_admin();?>modul/submission/abstract/abstract_edit.php",
            type : "post",
            data : {id_data:id},
            success: function(data) {
                $("#isi_abstract").html(data);
                $("#loadnya").hide();
          }
        });

    $('#modal_abstract').modal({ keyboard: false,backdrop:'static' });

    });
    
      var dtb_abstract = $("#dtb_abstract").DataTable({
           'bProcessing': true,
            'bServerSide': true,
            'scrollX' : true,
            
         //disable order dan searching pada tombol aksi use "className":"none" for always responsive hide column
                 "columnDefs": [ 
              
            {
            "targets": [-1],
              "orderable": false,
              "searchable": false,
              "className": "all",
              "render": function(data, type, full, meta){
                return '<?=$edit;?> <?=$del;?>';
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
              url :'<?=base_admin();?>modul/submission/abstract/abstract_data.php',
            type: 'post',  // method  , by default get
            error: function (xhr, error, thrown) {
            console.log(xhr);

            }
          },
        });

    $(".table").on('click','.paper',function(event) {
        $("#loadnya").show();
        event.preventDefault();
        var currentBtn = $(this);

        id = currentBtn.attr('data-id');

        $.ajax({
            url : "<?=base_admin();?>modul/submission/paper/paper_view.php",
            type : "post",
            data : {id_abstract:id},
            success: function(data) {
                $("#isi_paper").html(data);
                $("#loadnya").hide();
                dtb_abstract.draw(false);
          }
        });

    $('#modal_paper').modal({ keyboard: false,backdrop:'static' });

    });

    $(".table").on('click','.abstract-view',function(event) {
        $("#loadnya").show();
        event.preventDefault();
        var currentBtn = $(this);

        id = currentBtn.attr('data-id');

        $.ajax({
            url : "<?=base_admin();?>modul/submission/abstract/abstract_modal_view.php",
            type : "post",
            data : {id_abstract:id},
            success: function(data) {
                $("#isi_abs").html(data);
                $("#loadnya").hide();
                dtb_abstract.draw(false);
          }
        });

    $('#modal_abs').modal({ keyboard: false,backdrop:'static' });

    });

</script>