
<?php  include('../config.php'); ?>
<?php  include(ROOT_PATH . '/admin/includes/admin_functions.php'); ?>
<?php  include(ROOT_PATH . '/admin/includes/post_functions.php'); ?>
<?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>
<script src="editortext.js"></script>
<!-- Pega todos os tópicos -->
<?php $topics = getAllTopics();	?>
	<title>Admin | Criar Post</title>
</head>
<body>

	<?php include(ROOT_PATH . '/admin/includes/navbar.php') ?>

	

		<!-- área de edição  -->
		<div class="action create-post-div">
			<h1 class="page-title">Criar/Editar Post</h1>
			<form method="post" enctype="multipart/form-data" action="<?php echo BASE_URL . 'admin/create_post.php'; ?>" >
				<!-- valida erros -->
				<?php include(ROOT_PATH . '/includes/errors.php') ?>

				<!-- Se for editar, pega o id para identificar o post -->
				<?php if ($isEditingPost === true): ?>
					<input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
				<?php endif ?>

				<input type="text" name="title" value="<?php echo $title; ?>" placeholder="Titulo">
				<label style="float: left; margin: 5px auto 5px;">Imagem de capa</label>
				<input type="file" name="featured_image" >
                <?php include(ROOT_PATH . '/admin/includes/areatexto.php')?><?php echo $body; ?></textarea>
                <select name="topic_id">
					<option value="" selected disabled>Selecione o topico</option>
					<?php foreach ($topics as $topic): ?>
						<option value="<?php echo $topic['id']; ?>">
							<?php echo $topic['name']; ?>
						</option>
					<?php endforeach ?>
				</select>
				
				<!-- Só usuários admin podem verificar  -->
				<?php if ($_SESSION['user']['role'] == "Admin"): ?>
					<!-- mostra um "checkbox" de acordo com a situação, publicado ou não -->
					<?php if ($published == true): ?>
						<label for="publish">
							Publicar
							<input type="checkbox" value="1" name="publish" checked="checked">&nbsp;
						</label>
					<?php else: ?>
						<label for="publish">
							Publicar
							<input type="checkbox" value="1" name="publish">&nbsp;
						</label>
					<?php endif ?>
				<?php endif ?>
				
				<!-- se for edição, mostra atualizar e não criar-->
				<?php if ($isEditingPost === true): ?> 
					<button type="submit" class="btn" name="update_post">Atualizar</button>
				<?php else: ?>
					<button type="submit" class="btn" name="create_post">Criar o Post</button>
				<?php endif ?>

			</form>
		</div>
	</div>
</body>
</html>