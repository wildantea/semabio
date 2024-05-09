<?php
include "../../../inc/config.php";
if ($_POST['download']=='data') {
	include "download_data.php";
} elseif ($_POST['download']=='abstract') {
	include "download_abstract.php";
} else {
	include "download_paper.php";
}
?>