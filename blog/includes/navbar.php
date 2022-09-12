<div class="navbar">
			<div class="logo_div">
				<a href="index.php"><h1>BlogComum</h1></a>
			</div>
			<ul>
			  <li><a class="active" href="index.php">Home</a></li>
			  <li><a href="#news">Novidades</a></li>
			  <?php if ((isset($_SESSION['user']['username'])) && ($_SESSION['user']['role'] == "Admin")) { ?>
			  <li><a href="<?php echo BASE_URL .'admin/dashboard.php' ?>">Menu</a></li>
			  <?php }else{ ?>
				<li><a href="Contato"> Contato </a></li>
				<?php } ?>
			<li><a href="#about">Sobre</a></li>
			</ul>
		</div>