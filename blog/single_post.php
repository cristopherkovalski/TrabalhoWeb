<?php  include('config.php'); ?>
<?php  include('includes/func_publica.php'); ?>
<?php 
	if (isset($_GET['post-slug'])) {
		$post = getPost($_GET['post-slug']);
	}
	$topics = getAllTopics();
?>
<?php include('includes/head_section.php'); ?>
<title> <?php echo $post['title'] ?> | Blogcomum</title>
</head>
<body>
<div class="container">
	
		<?php include( ROOT_PATH . '/includes/navbar.php'); ?>
	
	
	<div class="content" >
		
		<div class="post-wrapper">
			
			<div class="full-post-div">
			<?php if ((isset($post)) == false): ?>
				<h2 class="post-title">Desculpe, o post ainda não foi escrito.</h2>
			<?php else: ?>
				<h2 class="post-title"><?php echo $post['title']; ?></h2>
				<div class="post-body-div">
					<?php echo html_entity_decode($post['body']); ?>
				</div>
			<?php endif ?>
			</div>
		
			
			
			
		</div>
		

		<div class="post-sidebar">
			<div class="card">
				<div class="card-header">
					<h2>Tópicos</h2>
				</div>
				<div class="card-content">
					<?php foreach ($topics as $topic): ?>
						<a 
							href="<?php echo BASE_URL . 'filtered_posts.php?topic=' . $topic['id'] ?>">
							<?php echo $topic['name']; ?>
						</a> 
					<?php endforeach ?>
				</div>
			</div>
		</div>
		
	</div>
</div>


<?php include( ROOT_PATH . '/includes/rodape.php'); ?>