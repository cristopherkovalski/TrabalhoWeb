<?php 
	
	$username = "";
	$email    = "";
	$errors = array(); 

	// Registrar usuário
	if (isset($_POST['reg_user'])) {
		// recebe e valida os inputs do usuário com real_escape (tira os caracteres especiais) e o trim(remove os espaços)
		$username = esc($_POST['username']);
		$email = esc($_POST['email']);
		$password_1 = esc($_POST['password_1']);
		$password_2 = esc($_POST['password_2']);

		// Verifica se os campos estão preenchidos
		if (empty($username)) {  array_push($errors, "Necessário colocar o nome do usuário"); }
		if (empty($email)) { array_push($errors, "Necessário preencher o campo Email"); }
		if (empty($password_1)) { array_push($errors, "Favor colocar a senha"); }
		if ($password_1 != $password_2) { array_push($errors, "Os duas senhas devem ser iguais");}

		// Verifica se não existe dois usuários iguais na DB. 
		// Emails e usuários devem ser únicos
		$user_check_query = "SELECT * FROM users WHERE username='$username' 
								OR email='$email' LIMIT 1";

		$result = mysqli_query($conn, $user_check_query);
		$user = mysqli_fetch_assoc($result);

		if ($user) { // Valida se o nome de usuário/email já existe 
			if ($user['username'] === $username) {
			  array_push($errors, "Usuário já existe.");
			}
			if ($user['email'] === $email) {
			  array_push($errors, "Email já está em uso!");
			}
		}
		// registra quando a validação ok
		if (count($errors) == 0) {
			$password = md5($password_1);//criptografa a senha
			$query = "INSERT INTO users (username, email, password, created_at, updated_at) 
					  VALUES('$username', '$email', '$password', now(), now())";
			mysqli_query($conn, $query);

			// pega o id do novo usuário
			$reg_user_id = mysqli_insert_id($conn); 

			// Coloca o id do usuario logado na sessao
			$_SESSION['user'] = getUserById($reg_user_id);

			// if user is admin, redirect to admin area
			if ( in_array($_SESSION['user']['role'], ["Admin", "Author"])) {
				$_SESSION['message'] = "Você logou com sucesso!";
				// Redireciona para ADM
				header('location: ' . BASE_URL . 'admin/dashboard.php');
				exit(0);
			} else {
				$_SESSION['message'] = "Você logou com sucesso!";
				// Redireciona pra usuario normal
				header('location: index.php');				
				exit(0);
			}
		}
	}

	// Logar
	if (isset($_POST['login_btn'])) {
		$username = esc($_POST['username']);
		$password = esc($_POST['password']);

		if (empty($username)) { array_push($errors, "Username required"); }
		if (empty($password)) { array_push($errors, "Password required"); }
		if (empty($errors)) {
			$password = md5($password); //criptografa senha
			$sql = "SELECT * FROM users WHERE username='$username' and password='$password' LIMIT 1";

			$result = mysqli_query($conn, $sql);
			if (mysqli_num_rows($result) > 0) {
				// pega o id do usuário criado
				$reg_user_id = mysqli_fetch_assoc($result)['id']; 

				// Coloca o usuário logado na sessão
				$_SESSION['user'] = getUserById($reg_user_id); 

				// Se o usuário é ADM, rediriciona pra ADM
				if ( in_array($_SESSION['user']['role'], ["Admin", "Author"])) {
					$_SESSION['message'] = "Você logou com sucesso!";
					// Redireciona pra ADM
					header('location: ' . BASE_URL . '/admin/dashboard.php');
					exit(0);
				} else {
					$_SESSION['message'] = "Você logou com sucesso!";
					// se não, redireciona pra área comum
					header('location: index.php');				
					exit(0);
				}
			} else {
				array_push($errors, 'Os dados são inválidos!');
			}
		}
	}
	// Função escape
	function esc(String $value)
	{	
		
		global $conn;

		$val = trim($value); // remove os espaço vazios entre as strings
		$val = mysqli_real_escape_string($conn, $value); // remove os caracteres especiais

		return $val;
	}
	// Pega as informações do usuário pelo ID
	function getUserById($id)
	{
		global $conn;
		$sql = "SELECT * FROM users WHERE id=$id LIMIT 1";

		$result = mysqli_query($conn, $sql);
		$user = mysqli_fetch_assoc($result);

		// Retorna o usuário num formato de vetor: 
		// ['id'=>1 'username' => 'Cristopher', 'email'=>'Cristopherkovalski@gmail.com', 'senha'=> 'minhasenha']
		return $user; 
	}
?>