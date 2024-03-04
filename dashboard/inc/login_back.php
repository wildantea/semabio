<?php
include "config.php";
session_start();
$id_user = $_GET['id'];
$user = $db->fetch_single_row("sys_users","id",$id_user);
$_SESSION['group_level']= $user->group_level;
$_SESSION['id_user']= $user->id;
$_SESSION['username']=$user->username;
$_SESSION['login']=1;
unset ($_SESSION["admin_id"]);
unset ($_SESSION["login_as"]);
header("location:".base_url());