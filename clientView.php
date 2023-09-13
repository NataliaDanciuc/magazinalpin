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
if ($result = $con->query('SELECT * FROM client WHERE userId = ' . $_SESSION['id'])) {
	if ($result->num_rows > 0){
		?>
		
		<table border='1' cellpadding='10'>
		<tr><th>ID</th><th><?php echo $lang['name']?></th><th><?php echo $lang['address']?></th><th><?php echo $lang['city']?></th><th><?php echo $lang['phonenumber']?></th><th><?php echo $lang['zip']?></th><tr>
		<?php 
		
		while ($row = $result->fetch_object()){
			// definirea unei linii pt fiecare inregistrare
			?>
			<tr>
			<td> <?php echo $row->id; ?> </td>
			<td> <?php echo $row->name; ?> </td>
			<td> <?php echo $row->address; ?> </td>
			<td> <?php echo $row->city; ?> </td>
			<td> <?php echo $row->phone; ?> </td>
			<td> <?php echo $row->postcode; ?> </td>
			<td><a href='order.php?clientId=<?php echo $row->id; ?>'><?php echo $lang['choose']?></a></td>
			<td><a href='clientModify.php?id=<?php echo $row->id; ?>'><?php echo $lang['modify']?></a></td>
			<td><a href='clientDelete.php?id=<?php echo $row->id; ?>'><?php echo $lang['delete']?></a></td>
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

<a href="clientAdd.php"><?php echo $lang['addClient']?></a>
<br>
<a href="logout.php"><?php echo $lang['logout']?></a>
<br>
<a href="products.php"><?php echo $lang['viewcart']?></a>
</body>
</html>