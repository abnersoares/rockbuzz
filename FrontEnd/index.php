<?php require_once 'Config/Config.php' ?>

<!DOCTYPE HTML>

<html>

<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Rockbuzz :: Blog</title>

	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="FrontEnd/assets/style.css">

	<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="FrontEnd/assets/helper.js"></script>

	<script type="text/javascript">
		var BASE_URL = '<?= URL ?>';
		var UPLOADS  = '<?= UPLOADS ?>';
	</script>

</head>

<body>

	<header>

		<div class="size">

			<div class="logo">
				<a href="./"><img src="FrontEnd/assets/images/logo.png"></a>
			</div>

		</div>

	</header>


	<main>
		
		<?php if( empty($_GET['slug']) ): ?>
			<section id="search">

				<h1>Busca</h1>

				<form>
					<div>
						<input type="text" name="search" placeholder="Buscar ...">
					</div>
				</form>

			</section>
		<?php endif; ?>

		<section id="content">
			
			<?php
				if( empty($_GET['slug']) )
					include('partials/posts.htm');
				else
					include('partials/post.htm');
			?>

		</section>

	</main>


	<section id="loading">
		<h3>Carregando ...</h3>
	</section>


</body>

</html>