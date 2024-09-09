<?php
  include_once("config.php");
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="CSS/EstiloLogin.css">
</head>
<!------ Include the above in your HEAD tag ---------->
<body>
    <div class="wrapper fadeInDown">
      <div id="formContent">
        <!-- Tabs Titles -->

        <!-- Icon -->
        <div class="fadeIn first">
        <img src="media/logo.png" width="160" height="60" style="margin-left: 8px; border-radius:5px;"  class="d-inline-block align-top" alt="">

        <!-- Login Form -->
        <form action="<?php echo $Url; ?>/loginexec.php" method="post">
          <input type="text" id="login" class="fadeIn second" name="login" placeholder="Usuario">
          <input type="password" id="password" class="fadeIn third" name="password" placeholder="Senha">
          <input type="submit" class="fadeIn fourth" value="Entrar">
        </form>

        <!-- Remind Passowrd -->
        <div id="formFooter">
          <!-- <a class="underlineHover" href="#">Esqueceu?</a> -->
        </div>
      </div>
    </div>
  </body>
</html>