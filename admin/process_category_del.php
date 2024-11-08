<?php

	session_start();
	
	include("../includes/connection.php");

	$query="delete from category where cat_id =".$_GET['id'];

	$result=mysql_query($query,$link);

	$run=mysql_fetch_assoc($result);

	header("location:category_view.php");

?>