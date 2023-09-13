<?php
include "config.php";
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>
    <div class="login-form">
        <form action="register.php" method="post">
            <h2><?php echo $lang['register']?></h2>
            <div class="labels">
                <!-- <label><?php echo $lang['username']?></label> -->
                <input type="text" name="username" placeholder="<?php echo $lang['username']?>"><br>
                <!-- <label><?php echo $lang['password']?></label> -->
                <input type="password" name="password" placeholder="<?php echo $lang['password']?>">
                <!-- <label><?php echo $lang['email']?></label> -->
                <input type="text" name="email" placeholder="<?php echo $lang['email']?>"><br> 
                <button type="submit"><?php echo $lang['register']?></button>
            </div>
           
        </form>
    </div>
     
     <!-- <div>
        <a href="registerform.php?lang=ro"><?php echo $lang['lang_ro']?> </a>
        <a href="registerform.php?lang=en"><?php echo $lang['lang_en']?> </a>
    </div> -->
</body>
</html>