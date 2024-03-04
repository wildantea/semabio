<?php
$type = $_POST['tipe'];
$itterate = $_POST['itterate'];
/*$type = 'number';
$itterate = 6;*/

$data_json = array(
	'number' =>   
    array(
	    "attr_type"=>"number",
	    "attr_name"=>"sks_mk",
	    "attr_label"=>"SKS Matakuliah",
	    "data-rule-minlength"=>"2",
	    "data-msg-minlength"=>"At least two chars",
	    "data-rule-maxlength"=>"4",
	    "data-msg-maxlength"=>"At most fours chars",
	    "data-rule-number"=>"true",
	    "data-msg-number"=>"At most fours chars",
	    "required"=>"true",
	    "data-msg-required"=>"Nama Wajib diisi"
  	),
  'text' =>   
	array( 
    "attr_type"=>"text",
    "attr_name"=>"sks_mk",
    "attr_label"=>"SKS Matakuliah",
    "data-rule-minlength"=>"2",
    "data-msg-minlength"=>"At least two chars",
    "data-rule-maxlength"=>"4",
    "data-msg-maxlength"=>"At most fours chars",
    "required"=>"true",
    "data-msg-required"=>"Nama Wajib diisi"
		
  ),
 'textarea' =>   
		    array( 
    "attr_type"=>"textarea",
    "attr_name"=>"sks_mk",
    "attr_label"=>"SKS Matakuliah",
    "data-rule-minlength"=>"2",
    "data-msg-minlength"=>"At least two chars",
    "data-rule-maxlength"=>"4",
    "data-msg-maxlength"=>"At most fours chars",
    "required"=>"true",
    "data-msg-required"=>"Nama Wajib diisi"
		
  ),
  'textareamce' =>   
		    array( 
    "attr_type"=>"textareamce",
    "attr_name"=>"sks_mk",
    "attr_label"=>"SKS Matakuliah",
    "data-rule-minlength"=>"2",
    "data-msg-minlength"=>"At least two chars",
    "data-rule-maxlength"=>"4",
    "data-msg-maxlength"=>"At most fours chars",
    "required"=>"true",
    "data-msg-required"=>"Nama Wajib diisi"
		
  ),
  'image' =>   
		    array( 
    "attr_type"=>"image",
    "attr_name"=>"sks_mk",
    "attr_label"=>"SKS Matakuliah",
    "required"=>"true",
    "data-msg-required"=>"Nama Wajib diisi",
    "allowed_type"=>"png|jpg|jpeg|gif|bmp"
		
  ),
  'file' =>   
		    array( 
    "attr_type"=>"file",
    "attr_name"=>"sks_mk",
    "attr_label"=>"SKS Matakuliah",
    "required"=>"true",
    "data-msg-required"=>"Nama Wajib diisi",
    "allowed_type"=>"pdf|docx|xlsx"
		
  )
);

echo '<div class="group-json">';
foreach ($data_json[$type] as $key => $value) {
			if ($key=='attr_type') {
			?>
			
          <div class="form-group">
              <label for="Jumlah Pembimbing" class="control-label col-lg-2"><?=$key;?></label>
              <div class="col-lg-5">
                <input type="text" data-rule-number="true" name="field[<?=$itterate;?>][<?=$key;?>]" value="<?=$value;?>" class="form-control" readonly>
              </div>
          </div><!-- /.form-group -->
			<?php
		} else {
			?>
          <div class="form-group">
              <label for="Jumlah Pembimbing" class="control-label col-lg-2"><?=$key;?></label>
              <div class="col-lg-5">
                <input type="text" data-rule-number="true" name="field[<?=$itterate;?>][<?=$key;?>]" value="<?=$value;?>" class="form-control">
              </div>
          </div><!-- /.form-group -->
			<?php
		}
}
echo ' <span class="btn btn-danger hapus-group"><i class="fa fa-trash"></i></span><hr></div>';
?>
