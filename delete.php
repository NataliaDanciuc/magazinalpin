<?php
// We need to use sessions, so you should always start sessions using the below code.
include ("config.php");
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin']) || (isset($_SESSION['loggedin'])&& $_SESSION['userType']!='admin')) {
	header('Location: index.php');
	exit;
}

// conectare la baza de date database
include("connection.php");

// se verifica daca id a fost primit
if (isset($_GET['id'])){
	// preluam variabila 'id' din URL
	$id = $_GET['id'];
	// stergem inregistrarea cu id=$id
	if ($stmt = $con->query("DELETE FROM product WHERE id =" . $id)){
		echo "<div>".$lang['deletemessage']."</div>";
	}else{
		echo "ERROR: Nu se poate executa delete.";
	}
	$con->close();
}
echo "<p><a href=\"products.php\">".$lang['productslist']."</a></p>";
echo "<p><a href=\"logout.php\">".$lang['logout']."</a></p>";
?>
