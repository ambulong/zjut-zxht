<?php
$username = $_POST["username"];
$password = $_POST["password"];
$user = new User($username, $password);
if($user->auth()){
	if($user->login())
		header("Location:".func_url("show","index"));
	else
		header("Location:".func_url("show","login&err=2"));
}else{
	header("Location:".func_url("show","login&err=1"));
}
