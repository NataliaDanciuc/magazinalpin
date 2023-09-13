<?php
include "config.php";
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <title><?php echo $lang['login_title']?></title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
   <div class="login-form">
        <form action="login.php" method="post">
        <h2><?php echo $lang['login_title']?></h2>
        <div class="labels">
            <!-- <label><?php echo $lang['username']?></label> -->
            <input type="text" name="username" placeholder="<?php echo $lang['username']?>"><br>
            <!-- <label><?php echo $lang['password']?></label> -->
            <input type="password" name="password" placeholder="<?php echo $lang['password']?>"><br> 
            <button type="submit" ><?php echo $lang['submitbutton']?></button><br>
        </div>
       

		<br><p><?php echo $lang['registertext']?> </p>
        <div class="register-btn">
            <a href='registerform.php'><?php echo $lang['register']?></a>
        </div>
		
     </form>
   </div>
     
     <div class="languages"> 
        <a href="index.php?lang=ro"><?php echo $lang['lang_ro']?> </a>
        <a href="index.php?lang=en"><?php echo $lang['lang_en']?> </a>
    </div>

</body>
</html>