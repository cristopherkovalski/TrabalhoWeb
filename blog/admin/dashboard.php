<?php  include('../config.php'); ?>
	<?php include(ROOT_PATH . '/admin/includes/admin_functions.php'); ?>
	<?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>
	<?php include(ROOT_PATH . '/admin/includes/post_functions.php'); ?>
	<title>Admin | Menu </title>
</head>
<body>
	<div class="header">
		<div class="logo">
			<a href="<?php echo BASE_URL .'admin/dashboard.php' ?>">
				<h1>BlogComum - Admin</h1>
			</a>

		</div>
		<div class="home">
			<a href="<?php echo BASE_URL . '/index.php' ?>">
			<h1> Home </h1> 
			</a>
</div>
		<?php if (isset($_SESSION['user'])): ?>
			<div class="user-info">
				<span><?php echo $_SESSION['user']['username'] ?></span> &nbsp; &nbsp; 
				<a href="<?php echo BASE_URL . '/logout.php'; ?>" class="logout-btn">logout</a>
			</div>
		<?php endif ?>
	</div>
	<div class="container dashboard">
		<h1>Bem Vindo</h1>
		<div class="stats">
			<a href="users.php" class="first">
				<span></span><?php getUsersTotal()?> <br>
				<span>Novos Usuários registrados</span>
			</a>
			<a href="posts.php">
				<span><?php getPostsTotal()?></span> <br>
				<span>Posts Publicados</span>
			</a>
			<a href="topics.php">
				<span><?php getTopicsTotal()?></span> <br>
				<span>Total de tópicos</span>
			</a>
		</div>
		<br><br><br>
		<div class="buttons">
			<a href="users.php">Adicionar Novos Usuários</a>
			<a href="posts.php">Adicionar Posts</a>
			<a href="topics.php">Adicionar Tópicos</a>
		</div>
	</div>
</body>
</html>