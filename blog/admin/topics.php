<?php  include('../config.php'); ?>
<?php  include(ROOT_PATH . '/admin/includes/admin_functions.php'); ?>
<?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>
<!--pega todos os topicos do BD -->
<?php $topics = getAllTopics();	?>
	<title>Admin | Manage Topics</title>
</head>
<body>
	
	<?php include(ROOT_PATH . '/admin/includes/navbar.php') ?>
	<div class="container content">
		
		<?php include(ROOT_PATH . '/admin/includes/menu.php') ?>

		
		<div class="action">
			<h1 class="page-title">Criar/Editar Topicos</h1>
			<form method="post" action="<?php echo BASE_URL . 'admin/topics.php'; ?>" >
				<!-- valida-->
				<?php include(ROOT_PATH . '/includes/errors.php') ?>
				<!-- Se estiver editando pega o ID do topico em questão -->
				<?php if ($isEditingTopic === true): ?>
					<input type="hidden" name="topic_id" value="<?php echo $topic_id; ?>">
				<?php endif ?>
				<input type="text" name="topic_name" value="<?php echo $topic_name; ?>" placeholder="Topico">
				<!-- Mostra atualizar se editando ao inves de criar" -->
				<?php if ($isEditingTopic === true): ?> 
					<button type="submit" class="btn" name="update_topic">Atualizar</button>
				<?php else: ?>
					<button type="submit" class="btn" name="create_topic">Criar Topico</button>
				<?php endif ?>
			</form>
		</div>
		
		<!-- Mostra os registros do BD-->
		<div class="table-div">
			<!-- Notificação -->
			<?php include(ROOT_PATH . '/includes/messages.php') ?>
			<?php if (empty($topics)): ?>
				<h1>Sem tópicos no Banco de dados.</h1>
			<?php else: ?>
				<table class="table">
					<thead>
						<th>N</th>
						<th>Nome do Tópico</th>
						<th colspan="2">Ação</th>
					</thead>
					<tbody>
					<?php foreach ($topics as $key => $topic): ?>
						<tr>
							<td><?php echo $key + 1; ?></td>
							<td><?php echo $topic['name']; ?></td>
							<td>
								<a class="fa fa-pencil btn edit"
									href="topics.php?edit-topic=<?php echo $topic['id'] ?>">
								</a>
							</td>
							<td>
								<a class="fa fa-trash btn delete"								
									href="topics.php?delete-topic=<?php echo $topic['id'] ?>">
								</a>
							</td>
						</tr>
					<?php endforeach ?>
					</tbody>
				</table>
			<?php endif ?>
		</div>
	
	</div>
</body>
</html>