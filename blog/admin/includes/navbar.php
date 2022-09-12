<div class="header">
	<div class="logo">
		<a href="<?php echo BASE_URL .'admin/dashboard.php' ?>">
			<h1>BlogComum - Admin</h1>
            <div class="menu">
	<div class="card">
		<div class="card-header">
			<h2>Menu</h2>
		</div>
		<div class="card-content">
			<a href="<?php echo BASE_URL . 'admin/create_post.php' ?>">Criar Posts</a>
			<a href="<?php echo BASE_URL . 'admin/posts.php' ?>">Editar Posts</a>
			<a href="<?php echo BASE_URL . 'admin/users.php' ?>">Editar Usários</a>
			<a href="<?php echo BASE_URL . 'admin/topics.php' ?>">Editar Tópicos</a>
		</div>
	</div>
</div></a>
	</div>
	<div class="user-info">
		<span><?php echo $_SESSION['user']['username']?></span> &nbsp; &nbsp; <a href="<?php echo BASE_URL . '/logout.php'; ?>" class="logout-btn">logout</a>
	</div>
</div>