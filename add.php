<?php
// We need to use sessions, so you should always start sessions using the below code.
include("config.php");

// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin']) || (isset($_SESSION['loggedin'])&& $_SESSION['userType']!='admin')) {
    header('Location: index.php');
    exit;
}

include("connection.php");

$error = '';
if (isset($_POST['submit'])) {
    // preluam datele de pe formular
	$name = htmlentities($_POST['name'], ENT_QUOTES);
	$code = htmlentities($_POST['code'], ENT_QUOTES);
	$image = htmlentities($_POST['image'], ENT_QUOTES);
	$price = htmlentities($_POST['price'], ENT_QUOTES);
	$description = htmlentities($_POST['description'], ENT_QUOTES);
	$category = htmlentities($_POST['category'], ENT_QUOTES);
	// verificam daca numele, prenumele, an si grupa nu sunt goale
	if ($name == '' || $code == ''||$image==''||$price==''||$description==''||$category==''){ 
		//echo $name . $code.$image.$price.$description.$category;
		// daca sunt goale afisam mesaj de eroare
        $error = 'ERROR: Campuri goale!';
    } else {
        // insert
        if ($stmt = $con->prepare("INSERT into product (name, code, image, price, description, category) VALUES (?, ?, ?, ?, ?, ?)")) {
            $stmt->bind_param("sssdss", $name, $code, $image, $price, $description, $category);
            $stmt->execute();
            $stmt->close();
			echo "<p> ".$lang['product'] . $name . $lang['successmessage']."</p>";
        }
        // eroare le inserare
        else {
            echo "ERROR: Nu se poate executa insert.";
        }
    }
}
// se inchide conexiune con
$con->close();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
    <title><?php echo $lang['addnewproduct']; ?> </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <h1><?php echo $lang['addnewproduct']; ?></h1>
    <?php if ($error != '') {
        echo "<div style='padding:4px; border:1px solid red; color:red'>" . $error . "</div>";
    } ?>
    <form action="" method="post">
        <div>
            <strong><?php echo $lang['name']?> : </strong> <input type="text" name="name" value="" /><br />
            <strong><?php echo $lang['code']?>: </strong> <input type="text" name="code" value="" /><br />
            <strong><?php echo $lang['image']?> : </strong> <input type="text" name="image" value="" /><br />
            <strong><?php echo $lang['price']?> : </strong> <input type="text" name="price" value="" /><br />
            <strong><?php echo $lang['description']?> : </strong> <input type="text" name="description" value="" /><br />
            <strong><?php echo $lang['category']?>: </strong> <input type="text" name="category" value="" /><br />
            <br />
            <input type="submit" name="submit" value="Submit" />
            <a href="products.php"><?php echo $lang['productslist']?></a>
			<br>
            <a href="logout.php"><?php echo $lang['logout']?></a>
        </div>
    </form>
</body>

</html>