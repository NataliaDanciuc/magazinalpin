<?php
// We need to use sessions, so you should always start sessions using the below code.
include "config.php";
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.php');
	exit;
}

include("connection.php");

//Modificare datelor
// se preia id din pagina vizualizare
$error='';
if (isset($_POST['submit'])){ 
	if (!empty($_POST['id'])){ 
	// verificam daca id-ul din URL este unul valid
		if (is_numeric($_POST['id'])){ 
			// preluam variabilele din URL/form
			$id = $_POST['id'];
			$name = htmlentities($_POST['name'], ENT_QUOTES);
			$address = htmlentities($_POST['address'], ENT_QUOTES);
			$city = htmlentities($_POST['city'], ENT_QUOTES);
			$phone = htmlentities($_POST['phone'], ENT_QUOTES);
			$postcode = htmlentities($_POST['postcode'], ENT_QUOTES);
			// verificam daca numele, prenumele, an si grupa nu sunt goale
			if ($name == '' || $address == ''||$city==''||$phone==''||$postcode==''){ 
				// daca sunt goale afisam mesaj de eroare
				echo "<div> ERROR: Completati campurile obligatorii!</div>";
			}else{
				// daca nu sunt erori se face update 
				if ($stmt = $con->prepare("UPDATE client SET name=?,address=?,city=?,phone=?,postcode=? WHERE id='".$id."'")) {
					$stmt->bind_param("sssss", $name, $address, $city, $phone, $postcode);
					$stmt->execute();
					echo $lang['modifymessageclient'];
					$stmt->close();
				}else{
					// mesaj de eroare in caz ca nu se poate face update
					echo "ERROR: nu se poate executa update.";
				}
			}
		}else{		
			// daca variabila 'id' nu este valida, afisam mesaj de eroare
			echo "id incorect!";
		} 
	}
}?>
<html> 
<head>
<title> <?php if ($_GET['id'] != '') { echo $lang['modifyregistration']; }?> </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf8"/></head>
<body>
	<h1><?php if ($_GET['id'] != '') { echo $lang['modifyregistration']; }?></h1>
	<?php 
	if ($error != '') {
		echo "<div style='padding:4px; border:1px solid red; color:red'>" . $error."</div>";
	} 
	?>
	
	<form action="" method="post">
		<div>
			<?php 
			if ($_GET['id'] != '') { 
			?>
			<input type="hidden" name="id" value="<?php echo $_GET['id'];?>" />
			<p>ID: 
			<?php echo $_GET['id'];
				if ($result = $con->query("SELECT * FROM client where id='".$_GET['id']."'")){
					if ($result->num_rows > 0){
						$row = $result->fetch_object();?></p>
						<strong><?php echo $lang['name']?> </strong> <input type="text" name="name" value="<?php echo$row->name;?>"/><br/>
						<strong><?php echo $lang['address']?> </strong> <input type="text" name="address" value="<?php echo$row->address;?>"/><br/>
						<strong><?php echo $lang['city']?> </strong> <input type="text" name="city" value="<?php echo$row->city;?>"/><br/>
						<strong><?php echo $lang['phonenumber']?> </strong> <input type="text" name="phone" value="<?php echo$row->phone; ?>"/><br/>
						<strong><?php echo $lang['zip']?> </strong> <input type="text" name="postcode" value="<?php echo$row->postcode; ?>"/><br/>
			<?php
					}
				}
			}
			?>
			<br/>
			<input type="submit" name="submit" value="<?php echo $lang['submit']?>" />
			<a href="clientView.php"><? echo $lang['clientview']?></a>
			<a href="logout.php"><? echo $lang['logout']?></a>
		</div>
	</form>
</body> </html>