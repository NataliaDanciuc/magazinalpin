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
if ($result = $con->query('SELECT p.id, p.name, od.quantity, od.price FROM `orderdetail` as od
							inner join product as p
							on od.productid=p.id
							WHERE orderid='. $_GET ['orderId'] )) {
	
	
	if ($result->num_rows > 0){
		?>
		
		<table border='1' cellpadding='10'>
		<tr><th>ID</th><th><?php echo $lang['name']?></th><th><?php echo $lang['quantity']?></th><th><?php echo $lang['total']?></th></tr>
		<?php 
		
		while ($row = $result->fetch_object()){
			// definirea unei linii pt fiecare inregistrare
			?>
			<tr>
			<td><a href="productDetails.php?id=<?php echo $row->id; ?>" ><?php echo $row->id ?></a></td>
			<td> <?php echo $row->name; ?> </td>
			<td> <?php echo $row->quantity; ?> </td>
			<td> <?php echo $row->price; ?> </td>
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


<a href="logout.php"><?php echo $lang['logout']?></a>
<br>
</body>
</html>