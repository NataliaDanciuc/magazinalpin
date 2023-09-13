<?php
include("connection.php");
include ("config.php");

if ($stmt = $con->prepare('SELECT image, name, code, price, description, category FROM product WHERE id = ?')) {
	$stmt->bind_param('s', $_GET['id']);
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows > 0) {
		$stmt->bind_result($image, $name, $code, $price, $description, $category);
		$stmt->fetch();
?>
		<html>
			<body>
				<p><?php echo $lang['name']?> : <?php echo $name ?></p>
				<p><?php echo $lang['code']?> : <?php echo $code ?></p>
				<p><?php echo $lang['price']?> : <?php echo $price ?></p>
				<p><?php echo $lang['description']?> : <?php echo $description ?></p>
				<p><?php echo $lang['category']?> : <?php echo $category ?></p>
				<img src='<?php echo $image ?>'>
			</body>
		</html>
<?php
	}
}
?>