<?php
echo "<pre>";
print_r($_POST);

foreach ($_POST['field'] as $data) {
	$js[] = $data;
}
$js = json_encode($js);
print_r($js);