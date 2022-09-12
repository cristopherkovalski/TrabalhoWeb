<script src="valida.js"></script>

<?php if (isset($_SESSION['user']['username'])) { ?>
	<div class="logged_in_info">
		<span>Bem vindo <?php echo $_SESSION['user']['username'] ?></span>
		|
		<span><a href="logout.php">logout</a></span>
	</div>
	<?php }elseif ((isset($_SESSION['user']['username'])) && ($_SESSION['user']['role'] == "Admin")) { ?>
	<div class="logged_in_info">
		<span>Bem vindo <a href="<?php echo BASE_URL .'admin/dashboard.php' ?>"><?php echo $_SESSION['user']['username'] ?>"</a></span>
		|
		<span><a href="logout.php">logout</a></span>
	</div>

<?php }else{ ?>
	<div class="banner">
		<div class="welcome_msg">
			<h1>Olá</h1>
			<p> 
			    aaaaaaaaa <br> 
			    BBBBBBB <br> 
			    CDDDD <br>
				<span>~ Alguém</span>
			</p>
			<a href="register.php" class="btn">Cadastre-se</a>
		</div>

		<div class="login_div">
			<form action="<?php echo BASE_URL . 'index.php'; ?>" method="post" onsubmit="return check_form()" >
				<h2>Login</h2>
				<div style="width: 60%; margin: 0px auto;">
					<?php include(ROOT_PATH . '/includes/errors.php') ?>
				</div>
				<input type="text" class="text required" name="username" value="<?php echo $username; ?>" placeholder="Usuário">
				<input type="password" class="text required" name="password"  placeholder="Senha"> 
				<button class="btn" type="submit" name="login_btn">Login</button>
			</form>
		</div>
	</div>
<?php } ?>