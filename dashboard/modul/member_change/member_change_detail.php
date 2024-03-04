<!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>Member Change</h1>
                   <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>member-change">Member Change</a></li>
                        <li class="active">Detail Member Change</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-solid box-primary">
                            <div class="box-header">
                            <h3 class="box-title">Detail Member Change</h3>
                                <div class="box-tools pull-right">
                                    <button class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                    <button class="btn btn-info btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                                </div>
                            </div>

                    <div class="box-body">
                      <form class="form-horizontal">
                        
              <div class="form-group">
                <label for="Full Name" class="control-label col-lg-2">Full Name <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" disabled="" value="<?=$data_edit->id_user;?>" class="form-control">
                </div>
              </div><!-- /.form-group -->
              
            <div class="form-group">
                <label for="Gender" class="control-label col-lg-2">Gender </label>
                <div class="col-lg-10">
                <?php
                  $option = array(
'Male' => 'Male',

'Female' => 'Female',
);
                  foreach ($option as $isi => $val) {
                  if ($data_edit->sex==$isi) {

                    echo "<input disabled class='form-control' type='text' value='$val'>";
                  }
               } ?>
                  </div>
            </div><!-- /.form-group -->
            
              <div class="form-group">
                <label for="City" class="control-label col-lg-2">City <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" disabled="" value="<?=$data_edit->city;?>" class="form-control">
                </div>
              </div><!-- /.form-group -->
              <div class="form-group">
                        <label for="Country" class="control-label col-lg-2">Country <span style="color:#FF0000">*</span></label>
                        <div class="col-lg-10">
              <?php foreach ($db->fetch_all("tb_ref_country") as $isi) {
                  if ($data_edit->country_id==$isi->id) {

                    echo "<input disabled class='form-control' type='text' value='$isi->country_name'>";
                  }
               } ?>
              </div>
                      </div><!-- /.form-group -->

              <div class="form-group">
                <label for="Telephone/Mobile" class="control-label col-lg-2">Telephone/Mobile <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" disabled="" value="<?=$data_edit->phone;?>" class="form-control">
                </div>
              </div><!-- /.form-group -->
              
              <div class="form-group">
                <label for="Affiliation" class="control-label col-lg-2">Affiliation <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" disabled="" value="<?=$data_edit->affiliation;?>" class="form-control">
                </div>
              </div><!-- /.form-group -->
              
                        
                      </form>
                      <a href="<?=base_index();?>member-change" class="btn btn-success "><i class="fa fa-step-backward"></i> <?php echo $lang["back_button"];?></a>

                        </div>
                      </div>
                    </div>
                </div>

                </section><!-- /.content -->
