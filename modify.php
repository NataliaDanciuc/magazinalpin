<?php
// We need to use sessions, so you should always start sessions using the below code.
include "config.php";
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin']) || (isset($_SESSION['loggedin'])&& $_SESSION['userType']!='admin')) {
	header('Location: index.php');
	exit;
}

//include("connection.php");

//Modificare datelor
// se preia id din pagina vizualizare
$error='';
if (!empty($_POST['id'])){ 
	if (isset($_POST['submit'])){ 
	// verificam daca id-ul din URL este unul valid
		if (is_numeric($_POST['id'])){ 
			// preluam variabilele din URL/form
			$id = $_POST['id'];
			$name = htmlentities($_POST['name'], ENT_QUOTES);
			$code = htmlentities($_POST['code'], ENT_QUOTES);
			$image = htmlentities($_POST['image'], ENT_QUOTES);
			$price = htmlentities($_POST['price'], ENT_QUOTES);
			$description = htmlentities($_POST['description'], ENT_QUOTES);
			$category = htmlentities($_POST['category'], ENT_QUOTES);
			// verificam daca numele, prenumele, an si grupa nu sunt goale
			if ($name == '' || $code == ''||$image==''||$price==''||$description==''||$category==''){ 
				// daca sunt goale afisam mesaj de eroare
				echo "<div> ERROR: Completati campurile obligatorii!</div>";
			}else{
				// daca nu sunt erori se face update name, code, image, price, descriere, categorie
				if ($stmt = $con->prepare("UPDATE product SET name=?,code=?,image=?,price=?,description=?, category=? WHERE id='".$id."'")) {
					$stmt->bind_param("sssdss", $name, $code, $image, $price, $description, $category);
					$stmt->execute();
					echo $lang['modifymessageproduct'];
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
				if ($result = $con->query("SELECT * FROM product where id='".$_GET['id']."'")){
					if ($result->num_rows > 0){
						$row = $result->fetch_object();?></p>
						<strong><?php echo $lang['name']?> </strong> <input type="text" name="name" value="<?php echo$row->name;?>"/><br/>
						<strong><?php echo $lang['code']?> </strong> <input type="text" name="code" value="<?php echo$row->code;?>"/><br/>
						<strong><?php echo $lang['image']?> </strong> <input type="text" name="image" value="<?php echo$row->image;?>"/><br/>
						<strong><?php echo $lang['price']?> </strong> <input type="text" name="price" value="<?php echo$row->price; ?>"/><br/>
						<strong><?php echo $lang['description']?> </strong> <input type="text" name="description" value="<?php echo$row->description; ?>"/><br/>
						<strong><?php echo $lang['category']?> </strong> <input type="text" name="category" value="<?php echo $row->category;?>"/><br/>
			<?php
					}
				}
			}
			?>
			<br/>
			<input type="submit" name="submit" value="Submit" />
			<a href="products.php"><?php echo $lang['productslist']?></a>
			<a href="logout.php"><?php echo $lang['logout']?></a>
		</div>
	</form>
</body> </html>