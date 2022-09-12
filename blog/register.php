<?php  include('config.php'); ?>

<?php  include('includes/registro_login.php'); ?>

<?php include('includes/head_section.php'); ?>

<script src="valida.js"></script>

<title>BlogComum | Cadastre-se </title>
</head>
<body>
<div class="container">
	
		<?php include( ROOT_PATH . '/includes/navbar.php'); ?>
	

	<div style="width: 40%; margin: 20px auto;">
		<form method="post" action="register.php" onsubmit="return check_form()" >
			<h2>Cadastre-se</h2>
			<?php include(ROOT_PATH . '/includes/errors.php') ?>
			<input  type="text" class="text required" name="username" value="<?php echo $username; ?>"  placeholder="Usuário">
			<input type="email" class="text required" name="email" value="<?php echo $email ?>" placeholder="Email">
			<input type="password" class="text required" name="password_1" placeholder="Senha">
			<input type="password" class="text required" name="password_2" placeholder="Confirmação de Senha">
			<button type="submit" class="btn" name="reg_user">Cadastrar</button>
			<p>
				Já possui Cadastro? <a href="login.php">Logue aqui</a>
			</p>
		</form>
	</div>
</div>

	<?php include( ROOT_PATH . '/includes/rodape.php'); ?>
