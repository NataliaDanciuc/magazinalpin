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

if (isset($_POST['submit']) ) {
    // preluam datele de pe formular
	$clientId = htmlentities($_POST['clientId'], ENT_QUOTES);
	$total = $_POST['clientId'];

	// insert
	if ($stmt = $con->prepare("INSERT into orders (clientId, total, status) VALUES (?, ?, 'comanda plasata')")) {
		$stmt->bind_param("id", $clientId, $_POST["total"]);
		$stmt->execute();
		$stmt->close();
	}else {
		echo "ERROR: Nu se poate executa insert.";
	}
	
	$orderId =  mysqli_insert_id($con);
	foreach ($_SESSION["cart_item"] as $item){
		
		$totalItemPrice = $item["quantity"]*$item["price"];
		if ($stmt = $con->prepare("INSERT into orderdetail (orderid, productid, quantity, price) VALUES (?, ?, ?, ?)")) {
			$stmt->bind_param("iiii", $orderId, $item["id"], $item["quantity"], $totalItemPrice);
			$stmt->execute();
			$stmt->close();			
		}else {
			echo "ERROR: Nu se poate executa insert.";
		}
	}
	unset($_SESSION["cart_item"]);
	echo $lang["ordersuccess"];
}

?>
<html lang="ro">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
	<?php

	if(isset($_SESSION["cart_item"])){
		$total_quantity = 0;
		$total_price = 0;
	?>	
		<table border='1' cellpadding='10'>
		<tbody>
		
		<tr><th><?php echo $lang['name']?></th><th><?php echo $lang['code']?></th><th><?php echo $lang['quantity']?></th><th><?php echo $lang['unitprice']?></th><th><?php echo $lang['price']?></th><th><?php echo $lang['delete']?></th></tr>	
		<?php		
			foreach ($_SESSION["cart_item"] as $item){
				$item_price = $item["quantity"]*$item["price"];
				?>
						<tr>
						<td><img src="<?php echo $item["image"]; ?>" class="cart-item-image" height="50px" width="50px" /><?php echo $item["name"]; ?></td>
						<td><?php echo $item["code"]; ?></td>
						<td style="text-align:right;"><?php echo $item["quantity"]; ?></td>
						<td  style="text-align:right;"><?php echo "$ ".$item["price"]; ?></td>
						<td  style="text-align:right;"><?php echo "$ ". number_format($item_price,2); ?></td>
						<td style="text-align:center;"><a href="products.php?action=remove&code=<?php echo $item["code"]; ?>" ><?php echo $lang['delete']?></a></td>
						</tr>
						<?php
						$total_quantity += $item["quantity"];
						$total_price += ($item["price"]*$item["quantity"]);
				}
				?>

		<tr>
		<td colspan="2" align="right"><?php echo $lang['total']?></td>
		<td align="right"><?php echo $total_quantity; ?></td>
		<td align="right" colspan="2"><strong><?php echo "$ ".number_format($total_price, 2); ?></strong></td>
		<td></td>
		</tr>
		</tbody>
		</table>
		
		<?php
		if ($result = $con->query('SELECT * FROM client WHERE id = ' . $_GET['clientId'])) {
			if ($result->num_rows > 0){
				?>
				
				<table border='1' cellpadding='10'>
				<tr><th>ID</th><th><?php echo $lang['name']?></th><th><?php echo $lang['address']?></th><th><?php echo $lang['city']?></th><th><?php echo $lang['phonenumber']?></th><th><?php echo $lang['zip']?></th><tr>
				<?php 
				
				$row = $result->fetch_object()

				?>
				<tr>
				<td> <?php echo $row->id; ?> </td>
				<td> <?php echo $row->name; ?> </td>
				<td> <?php echo $row->address; ?> </td>
				<td> <?php echo $row->city; ?> </td>
				<td> <?php echo $row->phone; ?> </td>
				<td> <?php echo $row->postcode; ?> </td>
				</tr>
				<?php
				
				echo "</table>";
			}
		}else{
			// eroare in caz de insucces in interogare
			 echo "Error: " . $con->error(); 
		}
		// se inchide
		$con->close();

	?>
	<form action='' method='post'>
		<input type='hidden' name='clientId' value='<?php echo $_GET["clientId"]?>'>
		<input type='hidden' name='total' value='<?php echo $total_price?>'>
		<input type='submit' name='submit' value="<?php echo $lang["placeorder"]?>">
	</form>
	
	<?php
	} ?>
	<a href="products.php"><?php echo $lang["productspage"]?></a>
    <a href="logout.php"><?php echo $lang["logout"]?></a>
</body>
</html>