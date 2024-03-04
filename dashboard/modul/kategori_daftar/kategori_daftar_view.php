<!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Kategori Daftar
                    </h1>
                        <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>kategori-daftar">Kategori Daftar</a></li>
                        <li class="active">Kategori Daftar List</li>
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
                                      <a id="add_kategori_daftar" class="btn btn-primary "><i class="fa fa-plus"></i> <?php echo $lang["add_button"];?></a>
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
                        <table id="dtb_kategori_daftar" class="table table-bordered table-striped display responsive nowrap" width="100%">
                            <thead>
                                <tr>
                                  <th>No</th>
                                  <th>Jenis Partisipasi</th>
                                  <th>Kategori</th>
                                  <th>Biaya Daftar</th>
                                  <th>Tanggal Mulai Daftar</th>
                                  <th>Tanggal Tutup Daftar</th>
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

            foreach ($db->fetch_all("sys_menu") as $isi) {

            //jika url = url dari table menu
            if (uri_segment(1)==$isi->url) {
              //check edit permission
              if ($role_act["up_act"]=="Y") {
                $edit = "<a data-id='+data+'  class=\"btn btn-primary btn-sm edit_data \" data-toggle=\"tooltip\" title=\"Edit\"><i class=\"fa fa-pencil\"></i></a>";
      
              } else {
                  $edit ="";
              }
            if ($role_act['del_act']=='Y') {
                
    $del = "<button data-id='+data+' data-uri=".base_admin()."modul/kategori_daftar/kategori_daftar_action.php".' class="btn btn-danger hapus_dtb_notif btn-sm" data-toggle="tooltip" title="Delete" data-variable="dtb_kategori_daftar"><i class="fa fa-trash"></i></button>';
    
            } else {
                $del="";
            }
                             }
            }

        ?>

    <div class="modal" id="modal_kategori_daftar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> <div class="modal-dialog modal-lg"> <div class="modal-content"><div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button> <h4 class="modal-title"><?php echo $lang["add_button"];?> Kategori Daftar</h4> </div> <div class="modal-body" id="isi_kategori_daftar"> </div> </div><!-- /.modal-content --> </div><!-- /.modal-dialog --> </div>
    
    </section><!-- /.content -->

        <script type="text/javascript">
      
      $("#add_kategori_daftar").click(function() {
          $.ajax({
              url : "<?=base_admin();?>modul/kategori_daftar/kategori_daftar_add.php",
              type : "GET",
              success: function(data) {
                  $("#isi_kategori_daftar").html(data);
              }
          });

      $('#modal_kategori_daftar').modal({ keyboard: false,backdrop:'static',show:true });

    });
    
      
    $(".table").on('click','.edit_data',function(event) {
        $("#loadnya").show();
        event.preventDefault();
        var currentBtn = $(this);

        id = currentBtn.attr('data-id');

        $.ajax({
            url : "<?=base_admin();?>modul/kategori_daftar/kategori_daftar_edit.php",
            type : "post",
            data : {id_data:id},
            success: function(data) {
                $("#isi_kategori_daftar").html(data);
                $("#loadnya").hide();
          }
        });

    $('#modal_kategori_daftar').modal({ keyboard: false,backdrop:'static' });

    });
    
      var dtb_kategori_daftar = $("#dtb_kategori_daftar").DataTable({
             
           'bProcessing': true,
            'bServerSide': true,
            
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
              url :'<?=base_admin();?>modul/kategori_daftar/kategori_daftar_data.php',
            type: 'post',  // method  , by default get
            error: function (xhr, error, thrown) {
            console.log(xhr);

            }
          },
        });
</script>
            