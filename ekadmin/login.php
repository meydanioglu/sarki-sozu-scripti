<?php

session_start();

if( isset($_SESSION['user_id']) ){
	header("Location: index.php");
}

require 'database.php';

if(!empty($_POST['email']) && !empty($_POST['password'])):

	$records = $conn->prepare('SELECT id,email,password FROM users WHERE email = :email');
	$records->bindParam(':email', $_POST['email']);
	$records->execute();
	$results = $records->fetch(PDO::FETCH_ASSOC);

	$message = '';

	if(count($results) > 0 && password_verify($_POST['password'], $results['password']) ){

		$_SESSION['user_id'] = $results['id'];
		header("Location: index.php");

	} else {
		$message = 'Bilgiler eşleşmiyor.';
	}

endif;

?>

<!DOCTYPE html>
<html>
<head>
	<title>Giriş Yap</title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link href='http://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'>
</head>
<body>

	<?php if(!empty($message)): ?>
		<p><?= $message ?></p>
	<?php endif; ?>
<div class="text-center">
	<h1>Giriş Yap</h1>

	<form action="login.php" method="POST">
		
		<input type="text" placeholder="Kullanıcı Adı" name="email">
		<input type="password" placeholder="Şifre" name="password">

		<input type="submit">

	</form>
</div>
</body>
</html>