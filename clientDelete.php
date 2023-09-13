<?php
// We need to use sessions, so you should always start sessions using the below code.
include "config.php";
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.php');
	exit;
}

// conectare la baza de date database
include("connection.php");

// se verifica daca id a fost primit
if (isset($_GET['id']) && is_numeric($_GET['id'])){
	// preluam variabila 'id' din URL
	$id = $_GET['id'];
	// stergem inregistrarea cu ib=$id
	if ($stmt = $con->prepare("DELETE FROM client WHERE id = ?")){
		$stmt->bind_param("i",$id);
		$stmt->execute();
		$stmt->close();
	}else{
		echo "ERROR: Nu se poate executa stergerea.";
	}
	$con->close();
	echo "<div>". $lang['deletemessage']."</div>";
}
echo "<p><a href=\"clientView.php\">".$lang['clientview']."</a></p>";
echo "<p><a href=\"logout.php\">".$lang['logout']."</a></p>";
?>
