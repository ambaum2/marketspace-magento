<?php

	// CLIENT INFORMATION
	$fname        = htmlspecialchars(trim($_POST['fname']));
	$lname        = htmlspecialchars(trim($_POST['lname']));

    $addClient  = "Select * From catalogrule";
    //mysql_query($addClient) or die(mysql_error());

?>
