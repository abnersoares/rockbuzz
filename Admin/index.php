<?php require_once '../Config/Config.php' ?>
<?php require_once '../Config/Auth.php' ?>

<!DOCTYPE HTML>

<html>

<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Rockbuzz :: Admin</title>

	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="assets/style.css">

	<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="assets/helper.js"></script>

	<link rel="stylesheet" type="text/css" href="assets/jquery-tagsinput/jquery.tagsinput.css">
	<script type="text/javascript" src="assets/jquery-tagsinput/jquery.tagsinput.js"></script>

	<script type="text/javascript">
		var BASE_URL = '<?= URL ?>';
		var UPLOADS  = '<?= UPLOADS ?>';
	</script>

</head>

<body>

	<header>

		<div class="size">

			<div class="logo">
				<a href="?page=PostList"><img src="assets/images/logo.png"></a>
			</div>

			<nav>
				<ul>
					<li class="<?= count(explode('Post', $_GET['page'])) > 1 ? 'active' : '' ?>"><a href="?page=PostList">Postagens</a></li>
					<li class="<?= count(explode('Author', $_GET['page'])) > 1 ? 'active' : '' ?>"><a href="?page=AuthorList">Autores</a></li>
					<li class="<?= count(explode('Tag', $_GET['page'])) > 1 ? 'active' : '' ?>"><a href="?page=TagList">Tags</a></li>
					<li class="<?= count(explode('User', $_GET['page'])) > 1 ? 'active' : '' ?>"><a href="?page=UserList">Usuários</a></li>
					<li class="<?= count(explode('Log', $_GET['page'])) > 1 ? 'active' : '' ?>"><a href="?page=LogList">Log</a></li>
					<li><a href="logout.php">Logout</a></li>
				</ul>
			</nav>

		</div>

	</header>
	
	<section id="content" class="size">
	
		<?php
		if( !empty($_GET['page']) && file_exists( 'partials/' . $_GET['page'] . '.htm' ) )
			include 'partials/' . $_GET['page'] . '.htm';
		else
			include 'partials/404.htm';
		?>
		
	</section>

	<section id="loading">
		<h3>Carregando ...</h3>
	</section>

	<footer>
		<p>Copyright 2009 - Abner Soares</p>
	</footer>

</body>

</html>