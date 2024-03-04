<!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>Tickets</h1>
                   <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>tickets">Tickets</a></li>
                        <li class="active">Detail Tickets</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-solid box-primary">
                            <div class="box-header">
                            <h3 class="box-title">Detail Tickets</h3>
                                <div class="box-tools pull-right">
                                    <button class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                    <button class="btn btn-info btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                                </div>
                            </div>

                    <div class="box-body">
                      <form class="form-horizontal">
                        
              <div class="form-group">
                <label for="no_rekening_pengirim" class="control-label col-lg-2">no_rekening_pengirim </label>
                <div class="col-lg-10">
                  <input type="text" disabled="" value="<?=$data_edit->no_rekening_pengirim;?>" class="form-control">
                </div>
              </div><!-- /.form-group -->
              
              <div class="form-group">
                <label for="file_proof" class="control-label col-lg-2">file_proof </label>
                <div class="col-lg-10">
                  <input type="text" disabled="" value="<?=$data_edit->file_proof;?>" class="form-control">
                </div>
              </div><!-- /.form-group -->
              
              <div class="form-group">
                <label for="Status" class="control-label col-lg-2">Status </label>
                <div class="col-lg-10">
                  <input type="text" disabled="" value="<?=$data_edit->status_payment;?>" class="form-control">
                </div>
              </div><!-- /.form-group -->
              
                        
                      </form>
                      <a href="<?=base_index();?>tickets" class="btn btn-success "><i class="fa fa-step-backward"></i> <?php echo $lang["back_button"];?></a>

                        </div>
                      </div>
                    </div>
                </div>

                </section><!-- /.content -->
