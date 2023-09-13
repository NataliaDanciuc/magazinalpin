

<?php
// We need to use sessions, so you should always start sessions using the below code.
include "config.php";

// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
// connectare bazadedate
include("connection.php");
if(!empty($_GET["action"])) {
	switch($_GET["action"]) {
		case "add":
			
			if(!empty($_POST["quantity"])) {
				$result = mysqli_query($con, "SELECT * FROM product WHERE code='" . $_GET["code"] . "' limit 1");
				$row = mysqli_fetch_assoc($result);
				$id = $row['id'];
				$name = $row['name'];
				$code = $row['code'];
				$price = $row['price'];
				$image = $row['image'];
				$description = $row['description'];
				$category = $row['category'];
				
				$itemArray = array(
					$code=>array(
					'id'=>$id,
					'name'=>$name,
					'code'=>$code,
					'price'=>$price,
					'quantity'=>$_POST["quantity"],
					'image'=>$image,
					'description'=>$description,
					'category'=>$category
					)
				);
				
				if(!empty($_SESSION["cart_item"])) {
					if(in_array($code, array_keys($_SESSION["cart_item"]))) {
						//daca produsul este deja in array, parcurg array ul pana gasesc produsul si modific cantitatea
						foreach($_SESSION["cart_item"] as $k => $v) {
								if($code == $k) {
									if(empty($_SESSION["cart_item"][$k]["quantity"])) {
										$_SESSION["cart_item"][$k]["quantity"] = 0;
									}
									$_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
								}
						}
					} else {
						$_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
					}
				} else {
					$_SESSION["cart_item"] = $itemArray;
				}
			}
			
			
		break;
		case "remove":
			if(!empty($_SESSION["cart_item"])) {
				foreach($_SESSION["cart_item"] as $k => $v) {
						if($_GET["code"] == $k)
							unset($_SESSION["cart_item"][$k]);				
						if(empty($_SESSION["cart_item"]))
							unset($_SESSION["cart_item"]);
				}
			}
		break;
		case "empty":
			unset($_SESSION["cart_item"]);
		break;	
	}
}
?>
<html lang="ro">
<head>
<title><?php echo $lang['productslist']?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>


	<!-- Afisarea cosului -->
	<?php
	
	
	if($_SESSION['userType'] == 'user'){?>
		<a id="btnEmpty" href="products.php?action=empty"><?php echo $lang['emptycart']?></a><br>
		<a id="btnEmpty" href="clientView.php"><?php echo $lang['checkout']?></a>
		<?php
		
		if(isset($_SESSION["cart_item"])){
			$total_quantity = 0;
			$total_price = 0;
			
		?>	
			<table border='1' cellpadding='10'>
			<tbody>
			
			<tr><th><?php echo $lang['name']?></th><th><?php echo $lang['code']?></th><th><?php echo $lang['quantity']?></th><th><?php echo $lang['unitprice']?></th><th><?php echo $lang['price']?></th><th><?php echo $lang['delete']?></th></tr>	
			<?php	
				
				foreach ($_SESSION["cart_item"] as $key => $item){

					$item_price = $item["quantity"]*$item["price"];
					
					?>
							<tr>
							<td><img src="<?php echo $item["image"]; ?>" class="cart-item-image" height="50px" width="50px" /><?php echo $item["name"]; ?></td>
							<td><?php echo $item["code"]; ?></td>
							<td style="text-align:right;"><?php echo $item["quantity"]; ?></td>
							<td  style="text-align:right;"><?php echo "€ ".$item["price"]; ?></td>
							<td  style="text-align:right;"><?php echo "€ ". number_format($item_price,2); ?></td>
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
			<td align="right" colspan="2"><strong><?php echo "€".number_format($total_price, 2); ?></strong></td>
			<td></td>
			</tr>
			</tbody>
			</table>		
		  <?php
		} else {
			?>
			<div class="no-records"><?php echo $lang['emptymessage']?></div>
			<?php 
		}
		
	}
	?>
	
	
	
	
	
	
	<!-- Afisarea tuturor produselor  -->
	<br><br>
	
	<?php
	// se preiau inregistrarile din baza de date
	if ($result = $con->query("SELECT * FROM product ORDER BY id ")){ 
		// Afisare inregistrari pe ecran
		if ($result->num_rows > 0){
			// afisarea inregistrarilor intr-o table
			echo "<table border='1' cellpadding='10'>";
			// antetul tabelului
			echo "<tr><th>ID</th><th>".$lang['name']."</th><th>".$lang['code']."</th><th>".$lang['image']."</th><th>".$lang["price"]."</th><th>".$lang['description']."</th><th>".$lang['category']."</th>";
			if($_SESSION['userType']=='user'){
				echo "<th>" .$lang['quantity']."</th><th></th></tr>";
			}else{
				echo "<th></th><th></th></tr>";
			}
			while ($row = $result->fetch_object()){
				// definirea unei linii pt fiecare inregistrare
				?>
				 <tr>
				 <td> <?php echo $row->id; ?> </td>
				 <td> <a href ='productDetails.php?id=<?php echo $row->id; ?>'> <?php echo $row->name; ?>
				 <td> <?php echo $row->code; ?> </td>
				 <td> <img src="<?php echo $row->image; ?>" height="50px" width="50px"></td>
				 <td> <?php echo $row->price; ?><?php echo $lang['unit']?> </td>
				 <td> <?php echo $row->description; ?> </td>
				 <td> <?php echo $row->category; ?> </td>
				
				<?php
				if($_SESSION['userType'] == 'admin') {?> 
					<td><a href='modify.php?id=<?php echo $row->id; ?>'><?php echo $lang['modify']?></a></td>
					<td><a href='delete.php?id=<?php echo $row->id; ?>'><?php echo $lang['delete']?></a></td>
				<?php
				} else {?>
					<form method="post" action="products.php?action=add&code=<?php echo  $row->code; ?>">
						<td><input type="number" id="quantity" name="quantity" min="1" value="1"></td>
						<td><input type="submit" value="<?php echo $lang['add']?>" /></td>
					</form>
				<?php
				}?>
				</tr>
				<?php
			}
			echo "</table>";
		}else{
			// daca nu sunt inregistrari se afiseaza un rezultat de eroare
			echo "Nu sunt inregistrari in tabela!";
		}
	}else{
		// eroare in caz de insucces in interogare
		 echo "Error: " . $con->error(); }
		// se inchide
		$con->close();
	if($_SESSION['userType'] == 'admin') {?> 
		<a href="add.php"><?php echo $lang['addnewproduct']?></a>
		<br>
	<?php
	} ?>
	<a href="allOrdersView.php"><?php echo $lang['ordershistory']?></a>
	<a href="logout.php"><?php echo $lang['logout']?></a>
</body>
</html>