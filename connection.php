 <?php
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = "";
$DATABASE_NAME = 'magazinalpin';
//$DATABASE_PORT='3307';
// //Încercați să vă conectați folosind informațiile de mai sus.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER,$DATABASE_PASS, $DATABASE_NAME);
/* se verifica daca s-a realizat conexiunea */

if(!mysqli_connect_errno()){
	//echo 'Connectat la baza de date: '. $DATABASE_NAME;
	// $con->close();
} else {
	echo 'Nu se poate connecta';
	exit();
}
?> 
