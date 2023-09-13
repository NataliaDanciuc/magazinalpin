<?php
// We need to use sessions, so you should always start sessions using the below code.
include "config.php";

// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}

include("connection.php");

$error = '';
if (isset($_POST['submit'])) {
    // preluam datele de pe formular
	$userid = $_SESSION['id'];
	$name = htmlentities($_POST['name'], ENT_QUOTES);
	$address = htmlentities($_POST['address'], ENT_QUOTES);
	$city = htmlentities($_POST['city'], ENT_QUOTES);
	$phone = htmlentities($_POST['phone'], ENT_QUOTES);
	$postcode = htmlentities($_POST['postcode'], ENT_QUOTES);
	// verificam daca numele, adresa, oras etc nu sunt goale
	if ($name == '' || $address == ''||$city==''||$phone==''||$postcode==''){ 
		
		// daca sunt goale afisam mesaj de eroare
        $error = 'ERROR: Campuri goale!';
    } else {
        // insert
        if ($stmt = $con->prepare("INSERT into client (userid, name, address, city, phone, postcode) VALUES (?, ?, ?, ?, ?, ?)")) {
            $stmt->bind_param("dsssss", $userid, $name, $address, $city, $phone, $postcode);
            $stmt->execute();
            $stmt->close();
			echo "<p>".$lang['clientul'] . $name .$lang['successmessage'] ."</p>";
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
    <title><?php echo $lang['clientaddtitle']; ?> </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <h1><?php echo $lang['clientaddtitle']; ?></h1>
    <?php if ($error != '') {
        echo "<div style='padding:4px; border:1px solid red; color:red'>" . $error . "</div>";
    } ?>
    <form action="" method="post">
        <div>
            <strong><?php echo $lang['name']?> </strong> <input type="text" name="name" value="" /><br />
            <strong><?php echo $lang['address']?> </strong> <input type="text" name="address" value="" /><br />
			<strong><?php echo $lang['city']?> </strong> <input type="text" name="city" value="" /><br />
            <strong><?php echo $lang['phonenumber']?> </strong> <input type="text" name="phone" value="" /><br />
            <strong><?php echo $lang['zip']?> </strong> <input type="text" name="postcode" value="" /><br />
            <br />
            <input type="submit" name="submit" value="<?php echo $lang['submit']?>" />
			<br>
			<a href="clientView.php"><? echo $lang['clientview']?></a>
            <a href="logout.php"><? echo $lang['logout']?></a>
        </div>
    </form>
</body>

</html>