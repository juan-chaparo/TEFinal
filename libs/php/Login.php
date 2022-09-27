<!DOCTYPE html>
<html lang="es-CO">
  <head>
    <meta charset = "UTF-8">
    <title>Login</title> 
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
  </head>
  <body>
      <?php 
      require_once "../../db/db_tools.php";
      protegerr();
      if(isset($_POST['user'])){
        if(isset($_POST['anticsrf'])){
          if($_POST['anticsrf']=='1111') {
          verificarr(conexionDB(),$_POST['user'], $_POST['pw']); 
        }
      }
        if ((isset($_POST['anticsrf'])) && isset($_SESSION['anticsrf']) && ($_SESSION['anticsrf']==$_POST['anticsrf'])) {
          if(validarrNombres($_POST['user']) && validarrContra($_POST['pw'])){
            verificarr(conexionDB(),$_POST['user'], $_POST['pw']); 
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
            <div class="form-group form-group-btn">
              <input type='hidden' name='anticsrf' value='<?php echo $anticsrf;?>'>
              <input type="submit" class="btn btn-success btn-lg" value="Iniciar sesión" id="sub2">
              <br><br>
            </div>
          </form>
          <form method="post">
            <div class="form-group form-group-btn">
              <input type='hidden' name='anticsrf' value='<?php echo $anticsrf;?>'>
              <button type="submit" class="btn btn-success btn-lg" formaction="Registro.php">Regístrate</button>
            </div>
          </form>
        </div>
    </div>
    <a href="./Registro.php">Registro</a>
  </body>
</html>