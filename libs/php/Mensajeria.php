<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mensajes</title>
</head>
<body>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <?php 
    require_once("./../../libs/php/tools.php"); 
    require_once("./../../db/db_tools.php"); 
    proteger();
  ?>
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
  <div class="row align-items-start">
    <div class="col">
      <form action="Mensajeria.php" method="post">
        <button type="Submit" name="idP" class="btn btn-primary"  aria-current="page">Mensajes recibidos</button>
      </form>
    </div>
    <div class="col">
      <form action="MensajesEnviados.php" method="post">
        <button type="Submit" name="idP2" class="btn btn-primary active color"  aria-current="page">Mensajes enviados</button>
      </form>
    </div>
    <div class="col">
      <a href="EnviarMensaje.php" class="btn btn-primary active color">Enviar mensaje</a>
    </div>
    <div class="col">
      <form action="./../../index.php" method="post">
        <button type="Submit" class="btn btn-primary"  aria-current="page">Volver al inicio</button>
      </form>
    </div>
  </div>
  <div class="container">
  <br><br>
  <?php leerMensajesRecibidos(conexionDB());
      /* if (isset($datos)) {
        foreach ($datos as $data) {
          echo '<img weight="80px" height="80px" src="'.$data[3].'">
                <h5>'.$data[2].': </h5>
                <p>'.$data[0].'</p>
                <p>'.$data[1].'</p>
                <p>';
                if ($data[4]!=null) {
                  echo'<a href="'.$data[4].'" download="'.md5(substr($data[4],7)).'">'.md5(substr($data[4],7)).'</a>';
                  echo "<br><br>";
                } 
        }
      } */
  ?>
  </div>
</body>
</html>