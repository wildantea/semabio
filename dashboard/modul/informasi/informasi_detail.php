<!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>Informasi</h1>
                   <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>informasi">Informasi</a></li>
                        <li class="active">Detail Informasi</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-solid box-primary">
                            <div class="box-header">
                            <h3 class="box-title">Detail Informasi</h3>
                                <div class="box-tools pull-right">
                                    <button class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                    <button class="btn btn-info btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                                </div>
                            </div>

                    <div class="box-body">
                      <form class="form-horizontal">
                        
            <div class="form-group">
                <label for="Jenis Informasi" class="control-label col-lg-2">Jenis Informasi <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                <?php
                  $option = array(
'B' => 'Informasi Sebelum Bayar',

'A' => 'Informasi Setelah Bayar',
);
                  foreach ($option as $isi => $val) {
                  if ($data_edit->kat_informasi==$isi) {

                    echo "<input disabled class='form-control' type='text' value='$val'>";
                  }
               } ?>
                  </div>
            </div><!-- /.form-group -->
            
          <div class="form-group">
              <label for="Isi Informasi" class="control-label col-lg-2">Isi Informasi <span style="color:#FF0000">*</span></label>
              <div class="col-lg-10">
                <textarea id="editbox" name="isi_informasi" disabled="" class="editbox"required><?=$data_edit->isi_informasi;?> </textarea>
              </div>
          </div><!-- /.form-group -->
          
            <div class="form-group">
                <label for="Tampil" class="control-label col-lg-2">Tampil <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                <?php if ($data_edit->is_aktif=="Y") {
                  ?>
                  <input name="is_aktif" data-on-text="On" data-off-text="Off" class="make-switch" disabled type="checkbox" checked>
                  <?php
                } else {
                  ?>
                  <input name="is_aktif" data-on-text="On" data-off-text="Off" class="make-switch" disabled type="checkbox">
                  <?php
                }?>
                </div>
            </div><!-- /.form-group -->
            
                        
                      </form>
                      <a href="<?=base_index();?>informasi" class="btn btn-success "><i class="fa fa-step-backward"></i> <?php echo $lang["back_button"];?></a>

                        </div>
                      </div>
                    </div>
                </div>

                </section><!-- /.content -->
