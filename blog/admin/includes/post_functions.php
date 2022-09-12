<?php 
// Variaveis 
$post_id = 0;
$isEditingPost = false;
$published = 0;
$title = "";
$post_slug = "";
$body = "";
$featured_image = "";
$post_topic = "";



//Ações de postagem

// Usuário clicou no botão criar posts
if (isset($_POST['create_post'])) { createPost($_POST); }
// Se o usuário clicou no botão de edição de post
if (isset($_GET['edit-post'])) {
	$isEditingPost = true;
	$post_id = $_GET['edit-post'];
	editPost($post_id);
}
// se clicou botão de atualizar post
if (isset($_POST['update_post'])) {
	updatePost($_POST);
}
// se clicou em deleter
if (isset($_GET['delete-post'])) {
	$post_id = $_GET['delete-post'];
	deletePost($post_id);
}

//funções
function createPost($request_values)
	{
		global $conn, $errors, $title, $featured_image, $topic_id, $body, $published;
		$title = esc($request_values['title']);
		$body = htmlentities(esc($request_values['body']));
		if (isset($request_values['topic_id'])) {
			$topic_id = esc($request_values['topic_id']);
		}
		if (isset($request_values['publish'])) {
			$published = esc($request_values['publish']);
		}
		// cria o "slug" : se o titulo for "Caminho do Sol", retorna "Caminho-do-Sol" como parte da url.
		$post_slug = makeSlug($title);
		// valida o "form"
		if (empty($title)) { array_push($errors, "Titulo do post é necessário"); }
		if (empty($body)) { array_push($errors, "Corpo do post é necessário"); }
		if (empty($topic_id)) { array_push($errors, "Tópico do post é necessário"); }
		// Pega o nome da imagem
	  	$featured_image = $_FILES['featured_image']['name'];
	  	if (empty($featured_image)) { array_push($errors, "Imagem principal é necessária"); }
	  	// Abre o caminho dos arquivos de imagem
	  	$target = "../static/images/" . basename($featured_image);
	  	if (!move_uploaded_file($_FILES['featured_image']['tmp_name'], $target)) {
	  		array_push($errors, "Falha ao fazer upload da imagem, verificar a situação do server");
	  	}
		// Verifica se não está salvando algum post em duplicidade. 
		$post_check_query = "SELECT * FROM posts WHERE slug='$post_slug' LIMIT 1";
		$result = mysqli_query($conn, $post_check_query);

		if (mysqli_num_rows($result) > 0) { // se o post já existe
			array_push($errors, "O post já existe!");
		}
		//Cria o post se não há erro na validaçaõ
		if (count($errors) == 0) {
			$query = "INSERT INTO posts (user_id, title, slug, image, body, published, created_at, updated_at) VALUES(1, '$title', '$post_slug', '$featured_image', '$body', $published, now(), now())";
			if(mysqli_query($conn, $query)){ // se o post for criado
				$inserted_post_id = mysqli_insert_id($conn);
				//Cria relação entre post e tópico através dos ids do BD
				$sql = "INSERT INTO post_topics (post_id, topic_id) VALUES($inserted_post_id, $topic_id)";
				mysqli_query($conn, $sql);

				$_SESSION['message'] = "Post foi criado com sucesso!";
				header('location: posts.php');
				exit(0);
			}
		}
	}

	
	/*- Usa o id do post como parametro
	* - Pega o post do BD
	* - coloca os campos do post como formulário para edição*/

	function editPost($role_id)
	{
		global $conn, $title, $post_slug, $body, $published, $isEditingPost, $post_id;
		$sql = "SELECT * FROM posts WHERE id=$role_id LIMIT 1";
		$result = mysqli_query($conn, $sql);
		$post = mysqli_fetch_assoc($result);
		$title = $post['title'];
		$body = $post['body'];
		$published = $post['published'];
	}

	function updatePost($request_values)
	{
		global $conn, $errors, $post_id, $title, $featured_image, $topic_id, $body, $published;

		$title = esc($request_values['title']);
		$body = esc($request_values['body']);
		$post_id = esc($request_values['post_id']);
		if (isset($request_values['topic_id'])) {
			$topic_id = esc($request_values['topic_id']);
		}
		$post_slug = makeSlug($title);

		if (empty($title)) { array_push($errors, "Titulo do post é necessário"); }
		if (empty($body)) { array_push($errors, "Corpo do post é necessário"); }
		// Se nova imagem principal for colocada
		if (isset($_POST['featured_image'])) {
			// Pega o nome da imagem
		  	$featured_image = $_FILES['featured_image']['name'];
		  	// entra no diretório de imagens
		  	$target = "../static/images/" . basename($featured_image);
		  	if (!move_uploaded_file($_FILES['featured_image']['tmp_name'], $target)) {
		  		array_push($errors, "Falha ao fazer upload da imagem, verificar a situação do server");
		  	}
		}

		// registra tópico se não houver erros no formulário
		if (count($errors) == 0) {
			$query = "UPDATE posts SET title='$title', slug='$post_slug', views=0, image='$featured_image', body='$body', published=$published, updated_at=now() WHERE id=$post_id";
			// Relaciona o tópico com o post na tabela de post_topic da tabela
			if(mysqli_query($conn, $query)){ // se o post for criado 
				if (isset($topic_id)) {
					$inserted_post_id = mysqli_insert_id($conn);
					// cria relação em topico e post
					$sql = "INSERT INTO post_topics (post_id, topic_id) VALUES($inserted_post_id, $topic_id)";
					mysqli_query($conn, $sql);
					$_SESSION['message'] = "Post criado com sucesso!";
					header('location: posts.php');
					exit(0);
				}
			}
			$_SESSION['message'] = "Post atualizado com sucesso!";
			header('location: posts.php');
			exit(0);
		}
	}
	// deleta o post
	function deletePost($post_id)
	{
		global $conn;
		$sql = "DELETE FROM posts WHERE id=$post_id";
		if (mysqli_query($conn, $sql)) {
			$_SESSION['message'] = "Post deletado com sucesso!";
			header("location: posts.php");
			exit(0);
		}
	}
    // se o usuário clicar em publicar 
if (isset($_GET['publish']) || isset($_GET['unpublish'])) {
	$message = "";
	if (isset($_GET['publish'])) {
		$message = "Post publicado com sucesso";
		$post_id = $_GET['publish'];
	} else if (isset($_GET['unpublish'])) {
		$message = "Post foi retirado da publicação";
		$post_id = $_GET['unpublish'];
	}
	togglePublishPost($post_id, $message);
}
// deleta post
function togglePublishPost($post_id, $message)
{
	global $conn;
	$sql = "UPDATE posts SET published=!published WHERE id=$post_id";
	
	if (mysqli_query($conn, $sql)) {
		$_SESSION['message'] = $message;
		header("location: posts.php");
		exit(0);
	}
}

// pega todos os posts do BD
function getAllPosts()
{
	global $conn;
	
	// Admin consegue ver todos os posts
	// Autor só consegue ver os próprios posts 
	if ($_SESSION['user']['role'] == "Admin") {
		$sql = "SELECT * FROM posts";
	} elseif ($_SESSION['user']['role'] == "Author") {
		$user_id = $_SESSION['user']['id'];
		$sql = "SELECT * FROM posts WHERE user_id=$user_id";
	}
	$result = mysqli_query($conn, $sql);
	$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

	$final_posts = array();
	foreach ($posts as $post) {
		$post['author'] = getPostAuthorById($post['user_id']);
		array_push($final_posts, $post);
	}
	return $final_posts;
}
// pega o nome de usuário/autor pelo id
function getPostAuthorById($user_id)
{
	global $conn;
	$sql = "SELECT username FROM users WHERE id=$user_id";
	$result = mysqli_query($conn, $sql);
	if ($result) {
		// retorna o nome de usuário
		return mysqli_fetch_assoc($result)['username'];
	} else {
		return null;
	}
}

function getPostsTotal()
{
global $conn;
$sql = "SELECT COUNT(id) as count FROM posts where published";
$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, $sql);

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$count = mysqli_fetch_assoc($result)['count'];

echo $count;
}

function getUsersTotal()
{
global $conn;
$sql = "SELECT COUNT(id) as count FROM users";
$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, $sql);

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$count = mysqli_fetch_assoc($result)['count'];

echo $count;
}

function getTopicsTotal()
{
global $conn;
$sql = "SELECT COUNT(id) as count FROM topics";
$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, $sql);

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$count = mysqli_fetch_assoc($result)['count'];

echo $count;
}
?>
