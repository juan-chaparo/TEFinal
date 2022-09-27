<!DOCTYPE html>
<html lang="es-CO">
  <head>
    <meta charset = "UTF-8">
    <title>Login</title> 
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  </head>
  <body>
      <?php 
      require_once "tools.php";
      require_once "../../db/db_tools.php";
      proteger();
      if(isset($_POST['user'])){
        if ((isset($_POST['anticsrf'])) && isset($_SESSION['anticsrf']) && ($_SESSION['anticsrf']==$_POST['anticsrf'])) {
          if(validarNombres($_POST['user']) && validarContra($_POST['pw'])){
            echo '<br>Validando captcha...<br>';
            $secretKey = "6LeGH8kfAAAAAIMhuigR81bxnO6X2txGzFfxQHFC";
            $captcha=$_POST['g-recaptcha-response'];
            $ip=$_SERVER['REMOTE_ADDR'];
            $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
            $responseKeys=json_decode($response, true);
            echo'<br><b>Respuesta desde google: </b><br>';
            var_dump($responseKeys);
            echo'<br><br><br>';
            if (intval($responseKeys["success"])==1) {
              echo"Todo ta bien";
              //verificar(conexionDB(),$_POST['user'], $_POST['pw']);
            }else {
              echo'todo mal';
            }
          }
          else{
            echo "<div name='loginerror'>Usuario no encontrado</div>";
          }
        }
        else {
          echo "Peticion invalida";
        }
      }
      $anticsrf=random_int(1000,9999);
      $_SESSION['anticsrf']=$anticsrf;
    ?>
    <div class="container" id="log-in-form">
        <div class="heading">
            <h1>Login</h1>
        </div>
        <form method="post">
            <div class="form-group">
              <label for="user">Usuario: </label>
              <input type="text" class="form-control" id="username" placeholder="Usuario" name="user" placeholder="Enter username" required="required" pattern="[A-Za-z]+">
            </div>
            <div class="form-group">
              <label for="pw">Contraseña: </label>
              <input type="password" name="pw" id="pw" required="required" class="form-control" placeholder="Contraseña" >
            </div>
            <div class="g-recaptcha" data-sitekey="6LeGH8kfAAAAAMzEHg3aFjQemRCJ2Dq1FqPIkJSq"></div>
            <div class="form-group form-group-btn">
              <input type='hidden' name='anticsrf' value='<?php echo $anticsrf;?>'>
              <input type="submit" class="btn btn-success btn-lg" value="Iniciar sesión" id="sub2">
              <br><br>
            </div>
          </form>
          <form method="post">
            <div class="form-group form-group-btn">
              <button type="submit" class="btn btn-success btn-lg" formaction="Registro.php">Regístrate</button>
            </div>
          </form>
        </div>
    </div>
  </body>
</html>