<?php
if( empty($_SESSION['credential']) && count(explode('login.php', $_SERVER['REQUEST_URI'])) == 1 )
	header("Location: login.php");
elseif( !empty($_SESSION['credential'] && count(explode('login.php', $_SERVER['REQUEST_URI'])) > 1) )
	header("Location: ./");

if( empty($_GET['page']) && count(explode('login.php', $_SERVER['REQUEST_URI'])) == 1 )
	header("Location: ./?page=PostList");
?>