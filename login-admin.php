<!DOCTYPE html>
<html lang="nl">

<head>
	<meta charset="UTF-8">
	<title>Construction</title>
	<link rel="stylesheet" type="text/css" href="company.css">
</head>

<body>
	<?php

	// use LDAP\Result;
	
	session_start();
	if (isset($_SESSION["signedInAdmin"])) {
		header("location: index.php"); // Replace "index.php" with the desired destination page
		exit();
	}
	?>
	<header>
		<h1>Welkom bij de Bread Company</h1>
		<!-- hieronder wordt het menu opgehaald. -->
		<?php
		include "nav.php";
		?>
	</header>

	<!-- Deze pagina is bestemd om functionaliteiten die nog niet af zijn van een 
	nette boodschap te voorzien -->
	<main>
		<h2>Login Admin</h2>
		<br>
		<form method="post" action="">
			<div>
				<label for="email">Email:</label>
				<input type="email" name="email" required>
			</div>
			<div>
				<label for="password">Wachtwoord:</label>
				<input type="password" name="password" required>
			</div>
			<div>
				<input type="submit" name="login" value="Login">
			</div>
		</form>
		<button>
			<a href="login.php">Log in als Gebruiker (Andere gegevens)</a>
		</button>
	</main>
	<?php
	require_once 'dbconnect.php';
	function submitted($db)
	{
		// Retrieves the email and password and stores them
		$email = $_POST["email"];
		$password = $_POST["password"];

		// Prepares the statement to select the email from the database
		$check = $db->prepare("SELECT COUNT(*) FROM client WHERE email = :email");
		// Executes the statement with the email variable
		$check->execute([":email" => $email]);

		// Fetches the result
		$exists = $check->fetchColumn();

		// Checks if the account exists in the database
		if ($exists == 1) {
			// Retrieves the hashed password and admin status from the database
			$retrieveData = $db->prepare("SELECT password, isadmin FROM client WHERE email = :email");
			$retrieveData->execute([":email" => $email]);

			$userData = $retrieveData->fetch();

			$hashedPassword = $userData['password'];
			$isAdmin = $userData['isadmin'];

			if (password_verify($password, $hashedPassword) && $isAdmin == 1) {
				$id = $db->prepare("SELECT id, first_name FROM client WHERE email = :email");
				$id->execute([":email" => $email]);
				$_SESSION['signedInAdmin'] = $id->fetch()['id'];
				$firstname = $db->prepare("SELECT first_name FROM client WHERE id = :id");
				$firstname->execute([":id" => $_SESSION['signedInAdmin']]);
				echo "<p>U bent succesvol ingelogd, " . $firstname->fetch()['first_name'] . "</p>";

			} else {
				echo '<p>Email, Wachtwoord of Admin incorrect</p>';
			}
		} else {
			echo '<p>Email, Wachtwoord of Admin incorrect</p>';
		}
	}
	if (isset($_POST['login'])) {
		submitted($db);
	}
	?>

</body>

</html>