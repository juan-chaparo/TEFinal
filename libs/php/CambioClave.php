<!DOCTYPE html>
<html lang="es-CO">
  <head>
    <meta charset = "UTF-8">
    <title>Cambiar contraseña</title> 
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
  </head>
  <body>
    <?php 
      require_once "tools.php";
      require_once "../../db/db_tools.php";
      proteger();
      if(isset($_POST['pw'])){
        if (validarContra($_POST["pw"])) {
          if($_POST['pwn']!=$_POST['pw'])
          {
            if($_POST['pwn']==$_POST['pwr']){
              if (validarContra($_POST["pwn"])&&validarContra($_POST["pwr"])) {
                cambiarClave(conexionDB(),$_POST['pw'], $_POST['pwn']);
              }
            }
          }
          else{
            echo "Las contraseñas no coinciden";
          }
        }
      }
    ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
          <div class="container">
          <a class="navbar-brand" href="./../../index.php">
            <img src="./../css/casita.png" width="80" height="80">Página de inicio
          </a>
        </div>
        <form class="d-flex">
          <?php echo "<img weight='80px'  height='80px' class='rounded mx-auto d-block' src='".$_SESSION['perfil']."'>";?>&nbsp &nbsp &nbsp &nbsp
          <h3 class="row align-items-center"><?php echo " ".$_SESSION["nombre"]." ".$_SESSION["apellido"];?></h3>&nbsp &nbsp
        </form>
      </div>
    </div>
  </nav>
    <div class="container" id="log-in-form">
        <div class="heading">
            <h1>Cambio de contraseña</h1>
        </div>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label for="pw">Contraseña: </label>
              <input type="password" class="form-control" name="pw" id="pw">
              <p>La contraseña debe contener letras, números y los siguientes caracteres especiales(-_*), como por ejemplo: a-6</p>
              <br>
            </div>
            <div class="form-group">
              <label for="pw">Nueva contraseña: </label>
              <input type="password" name="pwn" class="form-control" id="pwn">
            </div>
            <div class="form-group">
              <label for="pw">Repetir contraseña: </label>
              <input type="password" name="pwr" id="pwr" class="form-control">
            </div>
            <div class="form-group form-group-btn">
              <input type="submit" class="btn btn-success btn-lg" value="Cambiar" id="cambio" required="required">
            </div>
            </div>
        </form>
    </div>
    
  </body>
</html>
