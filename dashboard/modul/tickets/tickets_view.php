<!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Tickets
                    </h1>
                        <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>tickets">Tickets</a></li>
                        <li class="active">Tickets List</li>
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
 <div class="alert alert-warning fade in error_data_delete" style="display:none">
          <button type="button" class="close hide_alert_notif">&times;</button>
          <i class="icon fa fa-warning"></i> <span class="isi_warning_delete"></span>
        </div>
                        <table id="dtb_tickets" class="table table-bordered table-striped display responsive nowrap" width="100%">
                            <thead>
                                <tr>
                                  <th>Num Of Article</th>
                                  <th>Bank Account</th>
                                  <th>Account Holder</th>
                                  <th>Total</th>
                                  <th>Payment Proof</th>
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

    </section><!-- /.content -->

        <script type="text/javascript">
      
      
      var dtb_tickets = $("#dtb_tickets").DataTable({
           'bProcessing': true,
            'bServerSide': true,
            
         //disable order dan searching pada tombol aksi use "className":"none" for always responsive hide column
                 "columnDefs": [ 
              
            {
            "targets": [6],
              "orderable": false,
              "searchable": false,
              "className": "all",
              "render": function(data, type, full, meta){
                return '<a href="<?=base_admin();?>modul/tickets/download_ticket.php?id='+data+'"  class="btn btn-primary btn-sm" data-toggle="tooltip" title="Detail"><i class="fa fa-cloud-download"></i> Download Ticket</a>';
               }
            },
            ],
      
            'ajax':{
              url :'<?=base_admin();?>modul/tickets/tickets_data.php',
            type: 'post',  // method  , by default get
            error: function (xhr, error, thrown) {
            console.log(xhr);

            }
          },
        });
</script>
            