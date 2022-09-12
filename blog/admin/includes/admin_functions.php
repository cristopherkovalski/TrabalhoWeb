<?php 
// Variaveis de admin
$admin_id = 0;
$isEditingUser = false;
$username = "";
$role = "";
$email = "";
// variaveis gerais
$errors = [];


// variaveis de topicos
$topic_id = 0;
$isEditingTopic = false;
$topic_name = "";
//Ação de admin

// Se o usuário clicar no botão criar adm
if (isset($_POST['create_admin'])) {
	createAdmin($_POST);
}
// Se o usuário clicar no botão editar adm
if (isset($_GET['edit-admin'])) {
	$isEditingUser = true;
	$admin_id = $_GET['edit-admin'];
	editAdmin($admin_id);
}
// Se o usuário clicar no botão atualizar adm
if (isset($_POST['update_admin'])) {
	updateAdmin($_POST);
}
// Se o usuário clicar no botão deletar adm
if (isset($_GET['delete-admin'])) {
	$admin_id = $_GET['delete-admin'];
	deleteAdmin($admin_id);
}
//Ações para os Tópicos

// Se o usuário clicar no botão criar tópico
if (isset($_POST['create_topic'])) { createTopic($_POST); }
// if user clicks the Edit topic button
if (isset($_GET['edit-topic'])) {
	$isEditingTopic = true;
	$topic_id = $_GET['edit-topic'];
	editTopic($topic_id);
}
//Se o usuário clicar no botão atualizar tópico
if (isset($_POST['update_topic'])) {
	updateTopic($_POST);
}
// Se o usuário clicar no botão deletar tópico
if (isset($_GET['delete-topic'])) {
	$topic_id = $_GET['delete-topic'];
	deleteTopic($topic_id);
}
//Funções de tópicos
function getAllTopics() {
	global $conn;
	$sql = "SELECT * FROM topics";
	$result = mysqli_query($conn, $sql);
	$topics = mysqli_fetch_all($result, MYSQLI_ASSOC);
	return $topics;
}
function createTopic($request_values){
	global $conn, $errors, $topic_name;
	$topic_name = esc($request_values['topic_name']);
	//cria slug
	$topic_slug = makeSlug($topic_name);
	// valida o formulario
	if (empty($topic_name)) { 
		array_push($errors, "Nome do tópico é necessário!"); 
	}
	// Verifica se não existe duplicidade nos topicos
	$topic_check_query = "SELECT * FROM topics WHERE slug='$topic_slug' LIMIT 1";
	$result = mysqli_query($conn, $topic_check_query);
	if (mysqli_num_rows($result) > 0) { // if topic exists
		array_push($errors, "Tópico já existe!");
	}
	// registra o topico se não houver erros 
	if (count($errors) == 0) {
		$query = "INSERT INTO topics (name, slug) 
				  VALUES('$topic_name', '$topic_slug')";
		mysqli_query($conn, $query);

		$_SESSION['message'] = "Topico criado com sucesso!";
		header('location: topics.php');
		exit(0);
	}
}

/* * * * * * * * * * * * * * * * * * * * *
* - pega o id do topico como parametro
* - busca os tópicos no BD
* - Define os campos de formulário do Tópico para editar
* * * * * * * * * * * * * * * * * * * * * */
function editTopic($topic_id) {
	global $conn, $topic_name, $isEditingTopic, $topic_id;
	$sql = "SELECT * FROM topics WHERE id=$topic_id LIMIT 1";
	$result = mysqli_query($conn, $sql);
	$topic = mysqli_fetch_assoc($result);
	// Define os valores($topic_name) para ser atualizado
	$topic_name = $topic['name'];
}
function updateTopic($request_values) {
	global $conn, $errors, $topic_name, $topic_id;
	$topic_name = esc($request_values['topic_name']);
	$topic_id = esc($request_values['topic_id']);
	$topic_slug = makeSlug($topic_name);
	// valida o formulario
	if (empty($topic_name)) { 
		array_push($errors, "Nome do topico é necessário"); 
	}
	// registra o topico se não houver erros
	if (count($errors) == 0) {
		$query = "UPDATE topics SET name='$topic_name', slug='$topic_slug' WHERE id=$topic_id";
		mysqli_query($conn, $query);

		$_SESSION['message'] = "Tópico foi atualizado com sucesso!";
		header('location: topics.php');
		exit(0);
	}
}
// deleta topico
function deleteTopic($topic_id) {
	global $conn;
	$sql = "DELETE FROM topics WHERE id=$topic_id";
	if (mysqli_query($conn, $sql)) {
		$_SESSION['message'] = "Topic successfully deleted";
		header("location: topics.php");
		exit(0);
	}
}

//Funções de Admin

function createAdmin($request_values){
	global $conn, $errors, $role, $username, $email;
	$username = esc($request_values['username']);
	$email = esc($request_values['email']);
	$password = esc($request_values['password']);
	$passwordConfirmation = esc($request_values['passwordConfirmation']);

	if(isset($request_values['role'])){
		$role = esc($request_values['role']);
	}
	// Valida o formulario
	if (empty($username)) { array_push($errors, "Campo usuário é obrigatório"); }
	if (empty($email)) { array_push($errors, "O campo de email é obrigatório"); }
	if (empty($role)) { array_push($errors, "Função necessita preenchimento");}
	if (empty($password)) { array_push($errors, "Senha é obrigatório"); }
	if ($password != $passwordConfirmation) { array_push($errors, "As duas senhas devem combinar"); }
	// Garante que nenhum usuário seja registrado em duplicidade. 
	// emails e usuários devem ser unicos
	$user_check_query = "SELECT * FROM users WHERE username='$username' 
							OR email='$email' LIMIT 1";
	$result = mysqli_query($conn, $user_check_query);
	$user = mysqli_fetch_assoc($result);
	if ($user) { // se o usuário já existe
		if ($user['username'] === $username) {
		  array_push($errors, "Usuário já possui conta");
		}

		if ($user['email'] === $email) {
		  array_push($errors, "Email já está em uso");
		}
	}
	// registra usuário se não houver erros
	if (count($errors) == 0) {
		$password = md5($password);//criptografa a senha 
		$query = "INSERT INTO users (username, email, role, password, created_at, updated_at) 
				  VALUES('$username', '$email', '$role', '$password', now(), now())";
		mysqli_query($conn, $query);

		$_SESSION['message'] = "Usuário ADM criado com sucesso";
		header('location: users.php');
		exit(0);
	}
	
}
/* * * * * * * * * * * * * * * * * * * * *
* - Pega o id de admin como parametro
* - Busca o admin no BD
* - Define os campos de adm para edição no formulário
* * * * * * * * * * * * * * * * * * * * * */
function editAdmin($admin_id)
{
	global $conn, $username, $role, $isEditingUser, $admin_id, $email;

	$sql = "SELECT * FROM users WHERE id=$admin_id LIMIT 1";
	$result = mysqli_query($conn, $sql);
	$admin = mysqli_fetch_assoc($result);

	// Define os valores a serem atualizados ($username and $email) 
	$username = $admin['username'];
	$email = $admin['email'];
}

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
* -Recebe o pedido do adm para update no BD
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
function updateAdmin($request_values){
	global $conn, $errors, $role, $username, $isEditingUser, $admin_id, $email;
	// pega o id do adm para ser atualizado
	$admin_id = $request_values['admin_id'];
	//altera a situação de edição para falso
	$isEditingUser = false;


	$username = esc($request_values['username']);
	$email = esc($request_values['email']);
	$password = esc($request_values['password']);
	$passwordConfirmation = esc($request_values['passwordConfirmation']);
	if(isset($request_values['role'])){
		$role = $request_values['role'];
	}
	// registra usuário se não tiver erros no formulario
	if (count($errors) == 0) {
		//criptografa
		$password = md5($password);

		$query = "UPDATE users SET username='$username', email='$email', role='$role', password='$password' WHERE id=$admin_id";
		mysqli_query($conn, $query);

		$_SESSION['message'] = "Usuário Admin foi atualizado com sucesso!";
		header('location: users.php');
		exit(0);
	}
}
// deleta usuário admin
function deleteAdmin($admin_id) {
	global $conn;
	$sql = "DELETE FROM users WHERE id=$admin_id";
	if (mysqli_query($conn, $sql)) {
		$_SESSION['message'] = "Usuário foi deletado com sucesso!";
		header("location: users.php");
		exit(0);
	}
}
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
* - retorna todos os adms e suas funções
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
function getAdminUsers(){
	global $conn, $roles;
	$sql = "SELECT * FROM users WHERE role IS NOT NULL";
	$result = mysqli_query($conn, $sql);
	$users = mysqli_fetch_all($result, MYSQLI_ASSOC);

	return $users;
}
/* * * * * * * * * * * * * * * * * * * * *
* - escapa valores possivéis de "SQL INJECTION"
* * * * * * * * * * * * * * * * * * * * * */
function esc(String $value){
	//  conexão global do BD
	global $conn;
	$val = trim($value); 
	$val = mysqli_real_escape_string($conn, $value);
	return $val;
}
// Faz a slug" - url
function makeSlug(String $string){
	$string = strtolower($string);
	$slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
	return $slug;
}
?>