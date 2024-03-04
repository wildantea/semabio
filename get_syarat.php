<?php
session_start();
include "dashboard/inc/config.php";

      $id_kat = $_POST["par"];
      $ada_kat = 0;
      if ($id_kat!='') {
      	      $data = $db->query("select * from kategori_daftar where id_kat=? and is_mahasiswa='Y'",array("id_kat" => $id_kat));
		      if ($data->rowCount()>0) {
			     ?>
			    <div class="form-group">
                        <label for="File" class="control-label col-lg-3">Kartu Mahasiswa <span style="color:#FF0000">*</span></label>
                      <div class="col-lg-7">
                      <div class="fileinput fileinput-new" data-provides="fileinput" style="margin-bottom:0">
                            <div class="input-group">
                              <div class="form-control uneditable-input span3" data-trigger="fileinput">
                                <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span>
                              </div>
                              <span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">Select file</span> <span class="fileinput-exists">Change</span>
                                <input type="file" id="ktm" name="ktm" required class="file-upload-data" accept="image/*">
                              </span>
                              <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>

                            </div>
                             <span class="help-block" style="margin-bottom:0">Silakan Upload Bukti Kartu Mahasiswa</span>
                          </div>
                         
                      </div>
			    </div>
			     <?php
		      }

      } else {
      	echo "";
      }

