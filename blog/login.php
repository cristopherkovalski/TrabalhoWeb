<?php  include('config.php'); ?>
<?php  include('includes/registro_login.php'); ?>
<?php  include('includes/head_section.php'); ?>
<script src="valida.js"></script>

	<title>BlogComum | Cadastre-se </title>
</head>
<body>
<div class="container">
	<?php include( ROOT_PATH . '/includes/navbar.php'); ?>


	<div style="width: 40%; margin: 20px auto;">
		<form method="post" id= "myForm" action="login.php" onsubmit="return check_form()" >
			<h2>Login</h2>
			<?php include(ROOT_PATH . '/includes/errors.php') ?>
			<input type="text" class="text required" name="username" value="<?php echo $username; ?>" value="" placeholder="Username">
			<input type="password" class="text required" name="password" placeholder="Senha">
			<button type="submit" class="btn" name="login_btn">Login</button>
			<p>
                Não possui Cadastro? <a href="register.php">Cadastre Aqui</a>
			</p>
		</form>
	</div>
</div>


	<?php include( ROOT_PATH . '/includes/rodape.php'); ?>
