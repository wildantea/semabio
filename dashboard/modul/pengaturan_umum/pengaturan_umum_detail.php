<!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>Pengaturan Umum</h1>
                   <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>pengaturan-umum">Pengaturan Umum</a></li>
                        <li class="active">Detail Pengaturan Umum</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-solid box-primary">
                            <div class="box-header">
                            <h3 class="box-title">Detail Pengaturan Umum</h3>
                                <div class="box-tools pull-right">
                                    <button class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                    <button class="btn btn-info btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                                </div>
                            </div>

                    <div class="box-body">
                      <form class="form-horizontal">
                        
              <div class="form-group">
                <label for="Conference Name" class="control-label col-lg-2">Conference Name <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" disabled="" value="<?=$data_edit->conference_name;?>" class="form-control">
                </div>
              </div><!-- /.form-group -->
              
          <div class="form-group">
              <label for="Conference Date" class="control-label col-lg-2">Conference Date <span style="color:#FF0000">*</span></label>
              <div class="col-lg-10">
                <input type="text" disabled="" value="<?=tgl_indo($data_edit->conference_date);?>" class="form-control">
              </div>
          </div><!-- /.form-group -->
          
              <div class="form-group">
                <label for="Conference Place" class="control-label col-lg-2">Conference Place <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" disabled="" value="<?=$data_edit->conference_place;?>" class="form-control">
                </div>
              </div><!-- /.form-group -->
              
              <div class="form-group">
                <label for="Conference Description" class="control-label col-lg-2">Conference Description <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" disabled="" value="<?=$data_edit->conference_desc;?>" class="form-control">
                </div>
              </div><!-- /.form-group -->
              
              <div class="form-group">
                <label for="Conference Website" class="control-label col-lg-2">Conference Website <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" disabled="" value="<?=$data_edit->conference_site;?>" class="form-control">
                </div>
              </div><!-- /.form-group -->
              
              <div class="form-group">
                <label for="Conference Email" class="control-label col-lg-2">Conference Email <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" disabled="" value="<?=$data_edit->conference_email;?>" class="form-control">
                </div>
              </div><!-- /.form-group -->
              
              <div class="form-group">
                <label for="Conference City" class="control-label col-lg-2">Conference City <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" disabled="" value="<?=$data_edit->conference_city;?>" class="form-control">
                </div>
              </div><!-- /.form-group -->
              
              <div class="form-group">
                <label for="Conference Chairman" class="control-label col-lg-2">Conference Chairman <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" disabled="" value="<?=$data_edit->conference_chairman;?>" class="form-control">
                </div>
              </div><!-- /.form-group -->
              
            <div class="form-group">
                <label for="Email Activation on Register" class="control-label col-lg-2">Email Activation on Register </label>
                <div class="col-lg-10">
                <?php if ($data_edit->email_activation=="Y") {
                  ?>
                  <input name="email_activation" data-on-text="On" data-off-text="Off" class="make-switch" disabled type="checkbox" checked>
                  <?php
                } else {
                  ?>
                  <input name="email_activation" data-on-text="On" data-off-text="Off" class="make-switch" disabled type="checkbox">
                  <?php
                }?>
                </div>
            </div><!-- /.form-group -->
            <div class="form-group">
                        <label for="Conference Logo" class="control-label col-lg-2">Conference Logo </label>
                        <div class="col-lg-10">
              <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
                    <img src="<?=base_url();?>upload/pengaturan_umum/<?=$data_edit->conference_logo?>" class="myImage"></div>
                  </div>
                  </div>
                      </div><!-- /.form-group -->

          <div class="form-group">
              <label for="Due Date Invoice" class="control-label col-lg-2">Due Date Invoice </label>
              <div class="col-lg-10">
                <input type="text" disabled="" value="<?=tgl_indo($data_edit->due_date);?>" class="form-control">
              </div>
          </div><!-- /.form-group -->
          
          <div class="form-group">
              <label for="Invoice Date" class="control-label col-lg-2">Invoice Date </label>
              <div class="col-lg-10">
                <input type="text" disabled="" value="<?=tgl_indo($data_edit->inv_date);?>" class="form-control">
              </div>
          </div><!-- /.form-group -->
          
          <div class="form-group">
              <label for="LOA DATE" class="control-label col-lg-2">LOA DATE </label>
              <div class="col-lg-10">
                <input type="text" disabled="" value="<?=tgl_indo($data_edit->loa_date);?>" class="form-control">
              </div>
          </div><!-- /.form-group -->
          
          <div class="form-group">
              <label for="Last Date Payment" class="control-label col-lg-2">Last Date Payment <span style="color:#FF0000">*</span></label>
              <div class="col-lg-10">
                <input type="text" disabled="" value="<?=tgl_indo($data_edit->last_payment);?>" class="form-control">
              </div>
          </div><!-- /.form-group -->
          
            <div class="form-group">
                <label for="Is Non Presenter Free ?" class="control-label col-lg-2">Is Non Presenter Free ? </label>
                <div class="col-lg-10">
                <?php if ($data_edit->is_non_presenter_free=="Y") {
                  ?>
                  <input name="is_non_presenter_free" data-on-text="On" data-off-text="Off" class="make-switch" disabled type="checkbox" checked>
                  <?php
                } else {
                  ?>
                  <input name="is_non_presenter_free" data-on-text="On" data-off-text="Off" class="make-switch" disabled type="checkbox">
                  <?php
                }?>
                </div>
            </div><!-- /.form-group -->
            
                        
                      </form>
                      <a href="<?=base_index();?>pengaturan-umum" class="btn btn-success "><i class="fa fa-step-backward"></i> <?php echo $lang["back_button"];?></a>

                        </div>
                      </div>
                    </div>
                </div>

                </section><!-- /.content -->
