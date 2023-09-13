<?php
include("config.php");
include("connection.php");
// Acum verificăm dacă datele din formularul de autentificare au fost trimise,isset () va verifica dacă datele există.
if ( !isset($_POST['username'], $_POST['password']) ) {
	// Nu s-au putut obține datele care ar fi trebuit trimise.
	exit('Completati username si password !');
}
// Pregătiți SQL-ul nostru, pregătirea instrucțiunii SQL va împiedica injecțiaSQL.
if ($stmt = $con->prepare('SELECT id, password, user_type FROM users WHERE username = ?')) {
	// Parametrii de legare (s = șir, i = int, b = blob etc.), în cazul nostru numele de utilizator este un șir, //așa că vom folosi „s”
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	// Stocați rezultatul astfel încât să putem verifica dacă contul există în baza de date.
	$stmt->store_result();
	if ($stmt->num_rows > 0) {
		$stmt->bind_result($id, $password, $userType);
		$stmt->fetch();
		// Contul există, acum verificăm parola.
		// Notă: nu uitați să utilizați password_hash în fișierul de înregistrare pentrua stoca parolele hash.
		if (password_verify($_POST['password'], $password)) {
			// Verification success! User has loggedin!
			// Creați sesiuni, astfel încât să știm că utilizatorul este conectat, acestea acționează practic ca cookie-//uri, dar rețin datele de pe server.session_regenerate_id();
			$_SESSION['loggedin'] = TRUE;
			$_SESSION['name'] = $_POST['username'];
			$_SESSION['id'] = $id;
			$_SESSION['userType'] = $userType;
			header('Location: products.php');
		} else {
			// password incorrect
			echo 'Incorrect username sau password!';
		}
	} else {
		// username incorect
		echo 'Incorrect username sau password!';
	}
	$stmt->close();
}
$con->close();
?>
