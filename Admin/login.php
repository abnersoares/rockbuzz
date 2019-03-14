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

	<script type="text/javascript">
		var BASE_URL = '<?= URL ?>';
	</script>

	<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="assets/helper.js"></script>
	<script type="text/javascript" src="assets/login.js"></script>

</head>

<body>

	<form method="post" id="Login">
		
		<section class="login-box">

			<div class="logo">
				<img src="assets/images/logo_login.png">
			</div>

			<div class="form-group">
				<input type="text" name="email" placeholder="E-mail">
			</div>

			<div class="form-group">
				<input type="password" name="password" placeholder="Senha">
			</div>

			<div class="error">E-mail ou senha inválido.</div>

			<div class="form-group">
				<button>Logar</button>
			</div>

		</section>

	</form>

	<section id="loading">
		<h3>Carregando ...</h3>
	</section>

</body>

</html>