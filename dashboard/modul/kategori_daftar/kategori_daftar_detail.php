<!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>Kategori Daftar</h1>
                   <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>kategori-daftar">Kategori Daftar</a></li>
                        <li class="active">Detail Kategori Daftar</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-solid box-primary">
                            <div class="box-header">
                            <h3 class="box-title">Detail Kategori Daftar</h3>
                                <div class="box-tools pull-right">
                                    <button class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                    <button class="btn btn-info btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                                </div>
                            </div>

                    <div class="box-body">
                      <form class="form-horizontal">
                        
              <div class="form-group">
                <label for="Nama Kategori" class="control-label col-lg-2">Nama Kategori <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="text" disabled="" value="<?=$data_edit->nama_kategori;?>" class="form-control">
                </div>
              </div><!-- /.form-group -->
              <div class="form-group">
                        <label for="Jenis Partisipasi" class="control-label col-lg-2">Jenis Partisipasi <span style="color:#FF0000">*</span></label>
                        <div class="col-lg-10">
              <?php foreach ($db->fetch_all("jenis_partisipasi") as $isi) {
                  if ($data_edit->id_jenis_partisipasi==$isi->id) {

                    echo "<input disabled class='form-control' type='text' value='$isi->jenis_partisipasi'>";
                  }
               } ?>
              </div>
                      </div><!-- /.form-group -->

          <div class="form-group">
              <label for="Biaya" class="control-label col-lg-2">Biaya <span style="color:#FF0000">*</span></label>
              <div class="col-lg-10">
                <input type="text" disabled="" value="<?=$data_edit->biaya_daftar;?>" class="form-control">
              </div>
          </div><!-- /.form-group -->
          
          <div class="form-group">
              <label for="Tanggal Buka Daftar" class="control-label col-lg-2">Tanggal Buka Daftar <span style="color:#FF0000">*</span></label>
              <div class="col-lg-10">
                <input type="text" disabled="" value="<?=tgl_indo($data_edit->tanggal_open);?>" class="form-control">
              </div>
          </div><!-- /.form-group -->
          
          <div class="form-group">
              <label for="Tanggal Akhir Daftar" class="control-label col-lg-2">Tanggal Akhir Daftar <span style="color:#FF0000">*</span></label>
              <div class="col-lg-10">
                <input type="text" disabled="" value="<?=tgl_indo($data_edit->tanggal_close);?>" class="form-control">
              </div>
          </div><!-- /.form-group -->
          
                        
                      </form>
                      <a href="<?=base_index();?>kategori-daftar" class="btn btn-success "><i class="fa fa-step-backward"></i> <?php echo $lang["back_button"];?></a>

                        </div>
                      </div>
                    </div>
                </div>

                </section><!-- /.content -->
