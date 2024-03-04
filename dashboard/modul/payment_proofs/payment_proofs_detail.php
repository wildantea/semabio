<!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>Payment Proofs</h1>
                   <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>payment-proofs">Payment Proofs</a></li>
                        <li class="active">Detail Payment Proofs</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-solid box-primary">
                            <div class="box-header">
                            <h3 class="box-title">Detail Payment Proofs</h3>
                                <div class="box-tools pull-right">
                                    <button class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                    <button class="btn btn-info btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                                </div>
                            </div>

                    <div class="box-body">
                      <form class="form-horizontal">
                        
              <div class="form-group">
                <label for="Invoice Number" class="control-label col-lg-2">Invoice Number </label>
                <div class="col-lg-10">
                  <input type="text" disabled="" value="<?=$data_edit->inv_number;?>" class="form-control">
                </div>
              </div><!-- /.form-group -->
              
              <div class="form-group">
                <label for="Total" class="control-label col-lg-2">Total <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" disabled="" value="<?=$data_edit->jumlah;?>" class="form-control">
                </div>
              </div><!-- /.form-group -->
              
              <div class="form-group">
                <label for="Account bank name" class="control-label col-lg-2">Account bank name <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" disabled="" value="<?=$data_edit->nama_pengirim;?>" class="form-control">
                </div>
              </div><!-- /.form-group -->
              
          <div class="form-group">
              <label for="Account number" class="control-label col-lg-2">Account number <span style="color:#FF0000">*</span></label>
              <div class="col-lg-10">
                <input type="text" disabled="" value="<?=$data_edit->no_rekening_pengirim;?>" class="form-control">
              </div>
          </div><!-- /.form-group -->
          
              <div class="form-group">
                <label for="Bank Account" class="control-label col-lg-2">Bank Account <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" disabled="" value="<?=$data_edit->asal_bank;?>" class="form-control">
                </div>
              </div><!-- /.form-group -->
              <div class="form-group">
                        <label for="Payment proof" class="control-label col-lg-2">Payment proof <span style="color:#FF0000">*</span></label>
                        <div class="col-lg-10">
                  <input type="text" disabled="" value="<?=$data_edit->file_proof;?>" class="form-control">
                  </div>
                      </div><!-- /.form-group -->

                        
                      </form>
                      <a href="<?=base_index();?>payment-proofs" class="btn btn-success "><i class="fa fa-step-backward"></i> <?php echo $lang["back_button"];?></a>

                        </div>
                      </div>
                    </div>
                </div>

                </section><!-- /.content -->
