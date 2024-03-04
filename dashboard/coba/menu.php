<link href="../assets/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
<link href="../assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
<link href="../assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <script src="../assets/plugins/jQuery/jQuery-2.1.3.min.js"></script>
<style type="text/css">

	ul li {
		list-style-type: none;
	}
</style>
<?php
include "../inc/config.php";

function display_children($parent, $level) {
	global $db;

$result = $db->query("SELECT a.id, a.title, a.link, Deriv1.Count FROM `menu` a  LEFT OUTER JOIN (SELECT parent, COUNT(*) AS Count FROM `menu` GROUP BY parent) Deriv1 ON a.id = Deriv1.parent WHERE a.parent=" . $parent);
echo "<ul>";
	foreach ($result as $row) {
$row = convert_obj_to_array($row);
if ($row['Count'] > 0) {
echo "<li><a href='" . $row['link'] . "'>" . $row['title'] . "</a>";
display_children($row['id'], $level + 1);
echo "</li>";
} elseif ($row['Count']==0) {
echo "<li><a href='" . $row['link'] . "'>" . $row['title'] . "</a></li>";
} else;
}
echo "</ul>";
}
 
display_children(0, 1);

    //obj to array
    function convert_obj_to_array($obj)
    {
        if (is_object($obj)) $obj = (array)$obj;
        if (is_array($obj)) {
            $new = array();
            foreach ($obj as $key => $val) {
                $new[$key] = convert_obj_to_array($val);
            }
        } else {
            $new = $obj;
        }

        return $new;
    }


$data_array = array(
			array('nama' => 'ucing','musuh' => 'berit'),
			array('nama' => 'ucing dua')
		);


$json_data = json_decode($db->fetch_single_row("tes","id",1)->attrb);



for ($i=0; $i < count($json_data); $i++) { 
	echo $json_data[$i]->attr_type."<br>";

	$new = json_encode($json_data[$i]);
}

?>
<form id="edit_pengaturan_pendaftaran" method="post" class="form-horizontal" action="submit.php">
                            
<div class="form-group">
	<div class="col-lg-2" style="text-align: right">
		<span class="btn btn-success add-attr"><i class="fa fa-plus"></i> Add Attribute</span>
	</div>
 
  <div class="col-lg-5 show-select" style="display: none">
   <select class="form-control select-type">
   	<option value="">Pilih</option>
   	<option value="number">Number</option>
   	<option value="text">Text</option>
   	<option value="textarea">Textarea</option>
   	<option value="textareamce">Text Area With Style</option>
   	<option value="image">Image</option>
   	<option value="file">File</option>
   </select>
  </div>
</div><!-- /.form-group -->


                      
<?php


$i=1;
foreach ($json_data as $dta => $dt) {
	$dtas = convert_obj_to_array($dt);
	
	echo '<div class="group-json">';
	foreach ($dtas as $key => $value) {
		if ($key=='attr_type') {
			?>
		

          <div class="form-group">
              <label for="Jumlah Pembimbing" class="control-label col-lg-2"><?=$key;?></label>
              <div class="col-lg-5">
                <input type="text" data-rule-number="true" name="field[<?=$i;?>][<?=$key;?>]" value="<?=$value;?>" class="form-control" readonly>
              </div>
          </div><!-- /.form-group -->
			<?php
		} else {
			?>
          <div class="form-group">
              <label for="Jumlah Pembimbing" class="control-label col-lg-2"><?=$key;?></label>
              <div class="col-lg-5">
                <input type="text" data-rule-number="true" name="field[<?=$i;?>][<?=$key;?>]" value="<?=$value;?>" class="form-control">
              </div>
          </div><!-- /.form-group -->
      
			<?php
		}
?>

		<?php
			
	}
	echo '<span class="btn btn-danger hapus-group"><i class="fa fa-trash"></i></span><hr></div>';
$i++;
}

?>
<div class="isi_embed"></div>
 <div class="form-group">
              <label for="Jumlah Pembimbing" class="control-label col-lg-2">&nbsp;</label>
              <div class="col-lg-5">
                <input type="submit" class="btn btn-primary">
              </div>
          </div><!-- /.form-group -->
    </form>
    <?php
echo "<pre>";
print_r($data_array);

foreach ($data_array as $dt => $val) {
	print_r($val);
	if ($val['nama']=='ucing') {
		
	}
}

print_r($json_data);
echo "<textarea cols='50' rows='50'>".json_format($new)."</textarea>";


   function json_format($json) 
{ 
    $tab = "  "; 
    $new_json = ""; 
    $indent_level = 0; 
    $in_string = false; 

    $json_obj = json_decode($json); 

    if($json_obj === false) 
        return false; 

    $json = json_encode($json_obj); 
    $len = strlen($json); 

    for($c = 0; $c < $len; $c++) 
    { 
        $char = $json[$c]; 
        switch($char) 
        { 
            case '{': 
            case '[': 
                if(!$in_string) 
                { 
                    $new_json .= $char . "\n" . str_repeat($tab, $indent_level+1); 
                    $indent_level++; 
                } 
                else 
                { 
                    $new_json .= $char; 
                } 
                break; 
            case '}': 
            case ']': 
                if(!$in_string) 
                { 
                    $indent_level--; 
                    $new_json .= "\n" . str_repeat($tab, $indent_level) . $char; 
                } 
                else 
                { 
                    $new_json .= $char; 
                } 
                break; 
            case ',': 
                if(!$in_string) 
                { 
                    $new_json .= ",\n" . str_repeat($tab, $indent_level); 
                } 
                else 
                { 
                    $new_json .= $char; 
                } 
                break; 
            case ':': 
                if(!$in_string) 
                { 
                    $new_json .= ": "; 
                } 
                else 
                { 
                    $new_json .= $char; 
                } 
                break; 
            case '"': 
                if($c > 0 && $json[$c-1] != '\\') 
                { 
                    $in_string = !$in_string; 
                } 
            default: 
                $new_json .= $char; 
                break;                    
        } 
    } 

    return $new_json; 
} 
?>
<script type="text/javascript">
$(document).ready(function(){
	$(document).on('click','.hapus-group',function() {
		$(this).parent().remove();
	});
	$('.add-attr').click(function(){
		$('.show-select').show();
	});
	$('.select-type').change(function(){
		tipe = this.value;
		if (this.value!='') {
			$('.show-select').hide();
			$('.select-type option:first').prop('selected',true);
			itterate = $('.group-json').length;
			$.ajax({
				url : "json_attr.php",
				type : "post",
				data : {tipe:tipe,itterate:itterate},
				success : function(data) {
					$('.isi_embed').html(data);
				}
			});
		}
	});
});
</script>