<?php  include('../config.php'); ?>
<?php  include(ROOT_PATH . '/admin/includes/admin_functions.php'); ?>
<?php 
	//Pega todos os adms do banco de dados
	$admins = getAdminUsers();
	$roles = ['Admin', 'Author'];				
?>
<?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>
	<title>Admin | Menu</title>
</head>
<body>
	<!-- admin navbar -->
	<?php include(ROOT_PATH . '/admin/includes/navbar.php') ?>
	<div class="container content">
		
		<?php include(ROOT_PATH . '/admin/includes/menu.php') ?>
		
		<div class="action">
			<h1 class="page-title">Criar/Editar Admin </h1>

			<form method="post" action="<?php echo BASE_URL . 'admin/users.php'; ?>" >

				
				<?php include(ROOT_PATH . '/includes/errors.php') ?>

				<!-- verifica se o usuário está editando-->
				<?php if ($isEditingUser === true): ?>
					<input type="hidden" name="admin_id" value="<?php echo $admin_id; ?>">
				<?php endif ?>

				<input type="text" name="username" value="<?php echo $username; ?>" placeholder="Usuário">
				<input type="email" name="email" value="<?php echo $email ?>" placeholder="Email">
				<input type="password" name="password" placeholder="Senha">
				<input type="password" name="passwordConfirmation" placeholder="Confirmação de Senha">
				<select name="role">
					<option value="" selected disabled>Função</option>
					<?php foreach ($roles as $key => $role): ?>
						<option value="<?php echo $role; ?>"><?php echo $role; ?></option>
					<?php endforeach ?>
				</select>

				<!-- se editando, mostra editando e não criando -->
				<?php if ($isEditingUser === true): ?> 
					<button type="submit" class="btn" name="update_admin">Atualizar</button>
				<?php else: ?>
					<button type="submit" class="btn" name="create_admin">Salvar usuário</button>
				<?php endif ?>
			</form>
		</div>
		<!-- // Middle form - to create and edit -->

		<!-- Display records from DB-->
		<div class="table-div">
			<!-- Display notification message -->
			<?php include(ROOT_PATH . '/includes/messages.php') ?>

			<?php if (empty($admins)): ?>
				<h1>Sem adms no Bando de Dados.</h1>
			<?php else: ?>
				<table class="table">
					<thead>
						<th>N</th>
						<th>Admin</th>
						<th></th>
						<th colspan="2">Ações</th>
					</thead>
					<tbody>
					<?php foreach ($admins as $key => $admin): ?>
						<tr>
							<td><?php echo $key + 1; ?></td>
							<td>
								<?php echo $admin['username']; ?>, &nbsp;
								<?php echo $admin['email']; ?>	
							</td>
							<td><?php echo $admin['role']; ?></td>
							<td>
								<a class="fa fa-pencil btn edit"
									href="users.php?edit-admin=<?php echo $admin['id'] ?>">
								</a>
							</td>
							<td>
								<a class="fa fa-trash btn delete" 
								    href="users.php?delete-admin=<?php echo $admin['id'] ?>">
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