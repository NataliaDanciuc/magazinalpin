

<?php
include("connection.php");

if (!isset($_POST['username'], $_POST['password'], $_POST['email'])) {
	// Nu s-au putut obține datele care ar fi trebuit trimise.
	exit('Completare formular registration !');
}
// Asigurați-vă că valorile înregistrării trimise nu sunt goale.
if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
	// One or more values are empty.
	exit('Completare registration form');
}
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	exit('Email nu este valid!');
}

// verificam daca contul userului exista.
if ($stmt = $con->prepare('SELECT id, password FROM users WHERE username = ?')) {
	// hash parola folosind funcția PHP password_hash.
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	$stmt->store_result();
	// Memoram rezultatul, astfel încât să putem verifica dacă contul există în baza de date.
	if ($stmt->num_rows > 0) {
		// Username exista
		echo 'Username exists, alegeti altul!';
	} else {
		if ($stmt = $con->prepare('INSERT INTO users (username,password, email, user_type) VALUES (?, ?, ?, ?)')) {
			// Nu dorim să expunem parole în baza noastră de date, așa că hash parola și utilizați 
			//password_verify atunci când un utilizator se conectează.
			$password = password_hash($_POST['password'],PASSWORD_DEFAULT);
			$usertype = 'user';
			$stmt->bind_param('ssss', $_POST['username'], $password, $_POST['email'], $usertype);
			$stmt->execute();
			echo 'Success inregistrat!';
			header('Location: index.php');
		} else {
			// Ceva nu este în regulă cu declarația sql, verificați pentru a vă asigura că tabelul conturilor //există cu toate cele 3 câmpuri.
			echo 'Nu se poate face prepare statement!';
		}
	}
	$stmt->close();
} else {
	// Ceva nu este în regulă cu declarația sql, verificați pentru a vă asigura că tabelul conturilor //există cu toate cele 3 câmpuri.
	echo 'Nu se poate face prepare statement!';
}
$con->close();
?>


