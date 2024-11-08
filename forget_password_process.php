<?php

	session_start();

	include("includes/connection.php");

	if(!empty($_POST))
	{
		$_SESSION['error']=array();
		extract($_POST);

		if(empty($unm))
		{
			$_SESSION['error']['unm']="Please enter User Name";
		}
		else if(empty($row))
		{
			$_SESSION['error']['unm']="Wrong User Name";
		}
		else if(empty($answer))
		{
			$_SESSION['error']['unm']="Please enter Security Answer";
		}

		if(empty($unm))
		{
			$_SESSION['error']['answer']="Please enter Security Answer";
		}

		if(empty($pwd) || empty($cpwd))
		{
			$_SESSION['error']['pwd']="Please enter New Password";
		}
		else if($pwd != $cpwd)
		{
			$_SESSION['error']['pwd']="Password isn't Match";
		}

		$q="select * from register where r_unm='$unm'";

		$res=mysql_query($q,$link);

		$row=mysql_fetch_assoc($res);

		if(!empty($_SESSION['error']))
		{
			header("location:forget_password.php");
		}
		else
		{
			echo "good";
		}
	}
	else
	{
		header("location:forget_password.php");
	}

?>