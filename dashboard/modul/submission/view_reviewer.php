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
<!--  <div class="post">
<h4 class="box-title">FAQ</h4>
             <div class="box-group" id="accordion">
               we are adding the .panel class so bootstrap.js collapse plugin detects it
               <div class="panel box box-primary">
                 <div class="box-header with-border">
                   <h4 class="box-title">
                     <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" class="collapsed">
                       Q: I would like to submit more than one abstract, do i have to make more than one accounts?
                     </a>
                   </h4>
                 </div>
                 <div id="collapseOne" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                   <div class="box-body">
                    A: No, you just make one account. After you logging in, you can submit as many titles as you want.
                   </div>
                 </div>
               </div>
               <div class="panel box box-primary">
                 <div class="box-header with-border">
                   <h4 class="box-title">
                     <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="collapsed" aria-expanded="false">
                       Q : Can I edit my abstract later, after I submit it?
                     </a>
                   </h4>
                 </div>
                 <div id="collapseTwo" class="panel-collapse collapse" aria-expanded="false">
                   <div class="box-body">
                    A : Yes you can. You can edit or delete your abstract after you submit it.
                   </div>
                 </div>
               </div>
             </div>
               </div> -->
                            <div class="box">
                                <div class="box-header">
                                <?php
                                  foreach ($db->fetch_all("sys_menu") as $isi) {
                                      if (uri_segment(1)==$isi->url) {
                                          if ($role_act["insert_act"]=="Y") {
                                      ?>
                                      <a href="<?=base_index();?>submission/tambah" class="btn btn-primary "><i class="fa fa-plus"></i> <?php echo $lang["add_button"];?> Submission</a>
                                      <?php
                                          }
                                      }
                                  }
                                ?>
                            </div><!-- /.box-header -->
                            <div class="box-body">
<div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Filter</h3>
            </div>
            <div class="box-body">
           <form class="form-horizontal" id="filter_form" method="post" action="<?=base_admin();?>modul/submission/submission_reviewer/download_data.php" target="_blank">
                   
              <div class="form-group">
                    <label for="Program studi" class="control-label col-lg-2">Article Scope</label>
                    <div class="col-lg-5">
                    <select id="scope" name="scope" data-placeholder="Pilih Program studi ..." class="form-control chzn-select" tabindex="2" required="">
                       <option value="all">All</option>
                      <?php
                      $scope = $db->query("select scope_name,id_scope from tb_data_abstract 
inner join tb_ref_scope on id_scope=tb_ref_scope.id
group by id_scope ");
                      foreach ($scope as $scope_name) {
                        echo "<option value='$scope_name->id_scope'>$scope_name->scope_name</option>";
                      }
                      ?>
                    </select>
                    </div>
              </div><!-- /.form-group -->
              <div class="form-group">
                    <label for="Jenis Kelamin" class="control-label col-lg-2">Status Abstract</label>
                    <div class="col-lg-5">
                    <select id="abstract" name="abstract" data-placeholder="Pilih Jenis Pendaftaran ..." class="form-control chzn-select" tabindex="2">
                        <option value="all">All</option>
                   <option value="Waiting">Waiting</option>
                      <option value="Reviewed">Reviewed</option>
                      <option value="Revised">Revised</option>
                      <option value="Accepted">Accepted</option>
                        <option value="Rejected">Rejected</option>
                    </select>
                    </div>
              </div><!-- /.form-group -->
              <div class="form-group">
                    <label for="Jenis Kelamin" class="control-label col-lg-2">Status Paper</label>
                    <div class="col-lg-5">
                    <select id="paper" name="paper" data-placeholder="Pilih Jenis Kelamin ..." class="form-control chzn-select" tabindex="2" required="">
                        <option value="all">All</option>
                    <option value="Waiting">Waiting</option>
                      <option value="Reviewed">Reviewed</option>
                      <option value="Revised">Revised</option>
                      <option value="Accepted">Accepted</option>
                      <option value="Rejected">Rejected</option>
                    </select>
                    </div>
              </div><!-- /.form-group -->



                      <div class="form-group">
                        <label for="tags" class="control-label col-lg-2">&nbsp;</label>
                        <div class="col-lg-10">
                          <span id="filter" class="btn btn-primary"><i class="fa fa-refresh"></i> Filter</span>
                          <button type="submit" class="btn btn-success"><i class="fa fa-cloud-download"></i> Download Data</button>
                    </div>
                    </form>
            </div>
            <!-- /.box-body -->
          </div>
 <div class="alert alert-warning fade in error_data_delete" style="display:none">
          <button type="button" class="close hide_alert_notif">&times;</button>
          <i class="icon fa fa-warning"></i> <span class="isi_warning_delete"></span>
        </div>
                        <table id="dtb_abstract" class="table table-bordered table-striped display" width="100%">
                            <thead>
                                <tr>
                                  <th rowspan="2">No</th>
                                  <th rowspan="2">Account Name</th>
                                  <th rowspan="2">Title</th>
                                  <th rowspan="2">Presenter</th>
                                  <th rowspan="2">Affiliation</th>
                                  <th rowspan="2">Scope</th>
                                  <th rowspan="2">Reviewer</th>
                                  <th colspan="2" class="dt-center">Status</th>
                                  <th rowspan="2">Action</th>
                                </tr>
                                <tr>
                                  <th>Abstract</th>
                                  <th>Full Paper</th>
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
    <div class="modal" id="modal_abstract" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> <div class="modal-dialog modal-lg"> <div class="modal-content"><div class="modal-header"> <button type="button" class="close btn btn-default" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button> <h4 class="modal-title"><?php echo $lang["add_button"];?> Abstract</h4> </div> <div class="modal-body" id="isi_abstract"> </div> </div><!-- /.modal-content --> </div><!-- /.modal-dialog --> </div>
    <div class="modal" id="modal_paper" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> <div class="modal-dialog modal-lg modal-paper"> <div class="modal-content modal-content-paper"><div class="modal-header"> <button type="button" class="close-modal btn btn-danger" style="float:right;"><span aria-hidden="true"><i class="fa fa-times fa-6"></i></span></button> <h4 class="modal-title">Full Paper Detail</h4> </div> <div class="modal-body" id="isi_paper"> </div> </div><!-- /.modal-content --> </div><!-- /.modal-dialog --> </div>

    <div class="modal" id="modal_abs" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> <div class="modal-dialog modal-lg modal-abs"> <div class="modal-content modal-content-abs"><div class="modal-header"> <button type="button" class="close-modal-abstract btn btn-danger" style="float:right;"><span aria-hidden="true"><i class="fa fa-times fa-6"></i></span></button> <h4 class="modal-title">Abstract Detail</h4> </div> <div class="modal-body" id="isi_abs"> </div> </div><!-- /.modal-content --> </div><!-- /.modal-dialog --> </div>

    <div class="modal" id="modal_rev" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> <div class="modal-dialog modal-lg modal-abs"> <div class="modal-content modal-content-abs"><div class="modal-header"> <button type="button"  class="close-modal-abstract btn btn-danger" style="float:right;"><span aria-hidden="true"><i class="fa fa-times fa-6"></i></span></button> <h4 class="modal-title">Assign Reviewer</h4> </div> <div class="modal-body" id="isi_rev"> </div> </div><!-- /.modal-content --> </div><!-- /.modal-dialog --> </div>

    <div class="modal" id="modal_status_change" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> <div class="modal-dialog"> <div class="modal-content"><div class="modal-header"> <button type="button" class="close close-modal" data-dismiss="modal"><span aria-hidden="true"><i class="fa fa-times text-red fa-6"></i></span></button> <h4 class="modal-title title-status"></h4> </div> <div class="modal-body" id="isi_status"> </div> </div><!-- /.modal-content --> </div><!-- /.modal-dialog --> </div>


    
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
              url : "<?=base_admin();?>modul/submission/submission_reviewer/add_abstract.php",
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
             scrollX: true,
            //'order' : [7,'asc'],
            
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
              url :'<?=base_admin();?>modul/submission/submission_reviewer/submission_data.php',
            type: 'post',  // method  , by default get
            error: function (xhr, error, thrown) {
            console.log(xhr);

            }
          },
        });

$('#filter').click(function(){
       var dtb_abstract = $("#dtb_abstract").DataTable({
               destroy : true,
                scrollX: true,
           'bProcessing': true,
            'bServerSide': true,
            //'order' : [7,'asc'],
            
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
               url :'<?=base_admin();?>modul/submission/submission_reviewer/submission_data.php',
            type: 'post',  // method  , by default get
            data: function ( d ) {
                  d.scope = $("#scope").val();
                  d.abstract = $("#abstract").val();
                  d.paper = $("#paper").val();
                },
            error: function (xhr, error, thrown) {
            console.log(xhr);

            }
          },
          });

});
//assign reviewer
$(".table").on('click','.assign-reviewer',function(event) {
        $("#loadnya").show();
        event.preventDefault();
        var currentBtn = $(this);

        $('.title-status').html('Assign Reviewer');

        id = currentBtn.attr('data-id');

  
            $.ajax({
           url : "<?=base_admin();?>modul/submission/submission_reviewer/reviewer_modal.php",
            type : "post",
            data : {id_data:id},
            success: function(data) {
              $("#isi_status").html(data);
                $("#loadnya").hide();
          }
        });

       $('#modal_status_change').modal({ keyboard: false,backdrop:'static' });


    });

 $(".table").on('click','.change-paper',function(event) {
        $("#loadnya").show();
        event.preventDefault();
        var currentBtn = $(this);

        $('.title-status').html('Change Paper Status');

        id = currentBtn.attr('data-id');

  
            $.ajax({
           url : "<?=base_admin();?>modul/submission/submission_reviewer/status_modal_paper.php",
            type : "post",
            data : {id_data:id},
            success: function(data) {
                $("#isi_status").html(data);
                $("#loadnya").hide();
          }
        });

      $('#modal_status_change').modal({ keyboard: false,backdrop:'static' });


    });

    $(".table").on('click','.change-abstract',function(event) {
        $("#loadnya").show();
        event.preventDefault();
        var currentBtn = $(this);

        $('.title-status').html('Change Abstract Status');

        id = currentBtn.attr('data-id');

  
            $.ajax({
           url : "<?=base_admin();?>modul/submission/submission_reviewer/status_modal.php",
            type : "post",
            data : {id_data:id},
            success: function(data) {
                $("#isi_status").html(data);
                $("#loadnya").hide();
          }
        });

      $('#modal_status_change').modal({ keyboard: false,backdrop:'static' });


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
                //dtb_abstract.draw(false);
          }
        });

    $('#modal_abs').modal({ keyboard: false,backdrop:'static' });

    });

</script>