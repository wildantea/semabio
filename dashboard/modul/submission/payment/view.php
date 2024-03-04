                <!-- Main content -->
                <section class="content">
<div class="table-responsive">
  <p class="lead">You can send your payment to one of these</p>
                <table class="table no-margin">
                  <thead>
                  <tr>
                    <th>Bank</th>
                    <th>Atas Nama</th>
                    <th>No Rekening</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                    $db->query("select * from tb_ref_rekening");
                    foreach ($db->query("select * from tb_ref_rekening") as $dt) {
                      ?>
                      <td><span class="label label-success"><?=$dt->nama_bank;?></span></td>
                      <td><?=$dt->nama_pemilik;?></td>
                      <td><?=$dt->no_rekening;?></td>
                      <?php
                    }
                    ?>
                  </tbody>
                </table>
              </div>
<p>&nbsp;</p>
<?php
                                  foreach ($db->fetch_all("sys_menu") as $isi) {
                                      if (uri_segment(1)==$isi->url) {
                                          if ($role_act["insert_act"]=="Y") {
                                      ?>
                                      <a id="add_payment_proof" class="btn btn-primary "><i class="fa fa-plus"></i> Add Payment Proof</a>
                                      <?php
                                          }
                                      }
                                  }
                                ?>
<p>&nbsp;</p>
<div class="alert alert-warning fade in error_data_delete" style="display:none">
          <button type="button" class="close hide_alert_notif">&times;</button>
          <i class="icon fa fa-warning"></i> <span class="isi_warning_delete"></span>
        </div>
                        <table id="dtb_payment_proof" class="table table-bordered table-striped display responsive nowrap" width="100%">
                            <thead>
                                <tr>
                                  <th>No</th>
                                  <th>Abstract</th>
                                  <th>Dikirim ke</th>
                                  <th>Pengirim</th>
                                  <th>No Rek</th>
                                  <th>Asal Bank</th>
                                  <th>Bukti</th>
                                  <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>

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
                
    $del = "<button data-id='+data+' data-uri=".base_admin()."modul/payment_proof/payment_proof_action.php".' class="btn btn-danger hapus_dtb_notif btn-sm" data-toggle="tooltip" title="Hapus" data-variable="dtb_payment_proof"><i class="fa fa-trash"></i></button>';
    
            } else {
                $del="";
            }
                             }
            }

        ?>

    <div class="modal" id="modal_payment_proof" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> <div class="modal-dialog modal-lg"> <div class="modal-content"><div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button> <h4 class="modal-title"><?php echo $lang["add_button"];?> Payment Proof</h4> </div> <div class="modal-body" id="isi_payment_proof"> </div> </div><!-- /.modal-content --> </div><!-- /.modal-dialog --> </div>
    
    </section><!-- /.content -->

        <script type="text/javascript">
      
      $("#add_payment_proof").click(function() {
          $.ajax({
              url : "<?=base_admin();?>modul/payment_proof/payment_proof_add.php",
              type : "GET",
              success: function(data) {
                  $("#isi_payment_proof").html(data);
              }
          });

      $('#modal_payment_proof').modal({ keyboard: false,backdrop:'static',show:true });

    });
    
      
    $(".table").on('click','.edit_data',function(event) {
        $("#loadnya").show();
        event.preventDefault();
        var currentBtn = $(this);

        id = currentBtn.attr('data-id');

        $.ajax({
            url : "<?=base_admin();?>modul/payment_proof/payment_proof_edit.php",
            type : "post",
            data : {id_data:id},
            success: function(data) {
                $("#isi_payment_proof").html(data);
                $("#loadnya").hide();
          }
        });

    $('#modal_payment_proof').modal({ keyboard: false,backdrop:'static' });

    });
    
      var dtb_payment_proof = $("#dtb_payment_proof").DataTable({
           'bProcessing': true,
            'bServerSide': true,
            
         //disable order dan searching pada tombol aksi use "className":"none" for always responsive hide column
                 "columnDefs": [ 
              
            {
            "targets": [7],
              "orderable": false,
              "searchable": false,
              "className": "all",
              "render": function(data, type, full, meta){
                return '<a href="<?=base_index();?>payment-proof/detail/'+data+'"  class="btn btn-success btn-sm" data-toggle="tooltip" title="Detail"><i class="fa fa-eye"></i></a> <?=$edit;?> <?=$del;?>';
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
              url :'<?=base_admin();?>modul/payment_proof/payment_proof_data.php',
            type: 'post',  // method  , by default get
            error: function (xhr, error, thrown) {
            console.log(xhr);

            }
          },
        });
</script>
            