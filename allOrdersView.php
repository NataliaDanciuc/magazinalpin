<?php
// We need to use sessions, so you should always start sessions using the below code.
include "config.php";
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.php');
	exit;
}
// connectare bazadedate
include("connection.php");
?>
<html>
<body>
<?php
// se preiau inregistrarile din baza de date
if ($result = $con->query('SELECT * FROM orders WHERE clientId IN (SELECT id FROM client WHERE userId= ' . $_SESSION['id'] .')' )) {
	if ($result->num_rows > 0){
		?>
		
		<table border='1' cellpadding='10'>
		<tr><th>ID</th><th><?php echo  $lang['total']?></th><th><?php echo  $lang['status']?></th></tr>
		<?php 
		
		while ($row = $result->fetch_object()){
			// definirea unei linii pt fiecare inregistrare
			?>
			<tr>
			<td><a href="orderDetailView.php?orderId=<?php echo $row->id; ?>" ><?php echo $row->id ?></a></td>
			<td> <?php echo $row->total; ?> </td>
			<td> <?php echo $row->status; ?> </td>
			</tr>
			<?php
		}
		echo "</table>";
	}
}else{
	// eroare in caz de insucces in interogare
	 echo "Error: " . $con->error(); 
}
	// se inchide
	$con->close();?>


<a href="logout.php"><?php echo  $lang['logout']?> </a>
<br>
</body>
</html>