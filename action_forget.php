<?php
session_start();
include "dashboard/inc/config.php";

//i only receive ajax request :D
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	$id_user = $db->fetch_single_row("tb_reset_pass","token",$_POST['token']);
	if ($id_user) {
		$pass = array(
			'password' => md5($_POST['password'])
		);
		$db->update('sys_users',$pass,'id',$id_user->id_user);
		$db->delete('tb_reset_pass','id_user',$id_user->id_user);
		action_response($db->getErrorMessage(),array('success' => 'You have successfully change the password. Click <a href="'.base_admin().'login.php">Here</a> to login'));
	}
} else {
	echo "fuck off dude";
}