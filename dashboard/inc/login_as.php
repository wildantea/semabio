<?php
session_start();
include "config.php";
$id_user = $_GET['id'];
$admin_id = $_GET['adm_id'];
$user = $db->fetch_single_row("sys_users","id",$id_user);

$_SESSION['group_level']= $user->group_level;
$_SESSION['id_user']= $user->id;
$_SESSION['admin_id']= $admin_id;
$_SESSION['login']=1;
$_SESSION['login_as']=1;
header("location:".base_url());
//print_r($_SESSION);
//header("location:./");