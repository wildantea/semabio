<!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Payment Proofs & Ticket
                    </h1>
                        <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>payment-proofs">Payment Proofs</a></li>
                        <li class="active">Payment Proofs List</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                              
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <div class="row aksi-top" style="display: none">
                                    <div class="col-sm-12" style="margin-bottom: 10px">
                                    <button id="show-invoice" class="btn btn-success btn-sm"><i class="fa fa-file-text-o"></i> Show Invoice</button>
                                    <button id="input-bulk" class="btn btn-success btn-sm"><i class="fa fa-money"></i> Confirm Payment</button> <span class="selected-data"></span>
                            </div>
                            </div>
 <div class="alert alert-warning fade in error_data_delete" style="display:none">
          <button type="button" class="close hide_alert_notif">&times;</button>
          <i class="icon fa fa-warning"></i> <span class="isi_warning_delete"></span>
        </div>
                        <table id="dtb_payment_proofs" class="table table-bordered table-striped display responsive nowrap" width="100%">
                            <thead>
                                <tr>
        <th style="padding-right: 8px;width: 7%"><?=($_SESSION['group_level'])=='presenter'?'<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline "> <input type="checkbox" class="group-checkable bulk-check"> <span></span></label>':'';?></th>

                                  <th>Invoice</th>
                                  <th>Tang</th>
                                  <th>Jatuh Tempo</th>
                                  <th>Total</th>
                                  <th>Status</th>
                                  <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                  </div><!-- /.box -->
                </div>
              </div>
<form id="myform" action="<?=base_admin();?>modul/payment_proofs/invoice_all.php" method="POST" style="display: none" target="_blank">
  <input type="text" id="isi_val" name="id_payment">
    <button type="submit">Send</button>
</form>
    <div class="modal" id="modal_payment_proof" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> <div class="modal-dialog modal-lg"> <div class="modal-content"><div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button> <h4 class="modal-title">Add Payment Proof</h4> </div> <div class="modal-body" id="isi_payment_proof"> </div> </div><!-- /.modal-content --> </div><!-- /.modal-dialog --> </div>


    </section><!-- /.content -->

        <script type="text/javascript">
  
      $(".table").on('click','.edit_data',function(event) {
        $("#loadnya").show();
        event.preventDefault();
        var currentBtn = $(this);

        id = currentBtn.attr('data-id');

        $.ajax({
            url : "<?=base_admin();?>modul/payment_proofs/payment_proofs_add.php",
            type : "post",
            data : {id_data:id},
            success: function(data) {
                $("#isi_payment_proof").html(data);
                $("#loadnya").hide();
          }
        });

    $('#modal_payment_proof').modal({ keyboard: false,backdrop:'static' });

    });    
      var dtb_payment_proofs = $("#dtb_payment_proofs").DataTable({
           'bProcessing': true,
            'bServerSide': true,
            'order' : [1,'asc'],
            
         //disable order dan searching pada tombol aksi use "className":"none" for always responsive hide column
                 "columnDefs": [ 
              
            {
            "targets": [6],
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
              url :'<?=base_admin();?>modul/payment_proofs/payment_proofs_data.php',
            type: 'post',  // method  , by default get
            error: function (xhr, error, thrown) {
            console.log(xhr);

            }
          },
        });

$(".bulk-check").on('click',function() { // bulk checked
          var status = this.checked;
          if (status) {
            select_deselect('select');
          } else {
            select_deselect('unselect');
          }
          
          $(".check-selected").each( function() {
            $(this).prop("checked",status);
          });
        });



  function init_selected() {
      var selected = check_selected();
      var btn_hide = $('.aksi-top');
      if (selected.length > 0) {
          btn_hide.show()
      } else {
          btn_hide.hide()
      }
  }


  function check_selected() {
      var table_select = $('#dtb_payment_proofs tbody tr.selected');
      var array_data_delete = [];
      table_select.each(function() {
          var check_data = $(this).find('.cek-cek').attr('data-id');
          if (typeof check_data != 'undefined') {
              array_data_delete.push(check_data)
          }
      });
      $('.selected-data').text(array_data_delete.length + ' <?=$lang["selected_data"];?>');
      return array_data_delete
  }


  function select_deselect(type) {
      var cek = $('#dtb_payment_proofs tbody tr:has(td.cek-cek)');
      if (type == 'select') {
        if ($('#dtb_payment_proofs tbody tr:has(.cek-cek)').length) {
            $('#dtb_payment_proofs tbody tr:has(.cek-cek)').addClass('DTTT_selected selected');
          }
      } else {
          $('#dtb_payment_proofs tbody tr').removeClass('DTTT_selected selected');
          $(".bulk-check").prop("checked",false );
      }
      init_selected()
  }

  $(document).on('click', '#dtb_payment_proofs tbody tr .check-selected', function(event) {
      var btn = $(this).find('button');
      $(".bulk-check").prop("checked",false );
      if (btn.length == 0) {
          $(this).parents('tr').toggleClass('DTTT_selected selected');
          var selected = check_selected();
          console.log(selected);
          init_selected();

      }
  });


/* Add a click handler for the delete row */
  $('#show-invoice').click( function() {
    var anSelected = fnGetSelected( dtb_payment_proofs );
    var data_array_id = check_selected();
    var all_ids = data_array_id.toString();

    $('#isi_val').val(all_ids);
    $("#myform").submit();
  });

  $('#input-bulk').click( function() {
    var anSelected = fnGetSelected( dtb_payment_proofs );
    var data_array_id = check_selected();
    var all_ids = data_array_id.toString();
           $.ajax({
            url : "<?=base_admin();?>modul/payment_proofs/payment_proofs_edit.php",
            type : "post",
            data : {id_data:all_ids},
            success: function(data) {
                $("#isi_payment_proof").html(data);
                $("#loadnya").hide();
          }
        });

    $('#modal_payment_proof').modal({ keyboard: false,backdrop:'static' });

  });

  /* Get the rows which are currently selected */
  function fnGetSelected( oTableLocal )
  {
      return oTableLocal.$('tr.selected');
  }
</script>
            