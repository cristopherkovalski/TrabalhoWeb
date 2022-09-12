<?php 
	session_start();

	// conexão DB
	$conn = mysqli_connect("localhost", "root", "", "blog-php");

	if (!$conn) {
		die("Erro ao conectar com o DB: " . mysqli_connect_error());
	}
    // Definição de "variaveis" globais
	define ('ROOT_PATH', realpath(dirname(__FILE__)));
	define('BASE_URL', 'http://localhost/blog/');
?>