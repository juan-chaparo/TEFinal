<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <title>Artículos</title>
</head>
<body>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <?php
    require_once "tools.php";
    require_once "../../db/db_tools.php";
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
      <form action="Articulos.php" method="post">
        <button type="Submit" name="idP" class="btn btn-primary active color"  aria-current="page">Todos los artículos</button>
      </form>
      </div>
    <div class="col">
      <a href="MisArticulos.php" class="btn btn-primary active color">Mis artículos</a>
    </div>
    <div class="col">
      <form action="CrearArticulo.php" method="post">
        <button type="Submit" name="idP2" class="btn btn-primary"  aria-current="page">Crear artículo</button>
      </form>
    </div>
    <div class="col">
      <form action="./../../index.php" method="post">
        <!-- <input type='hidden' name='idP' value='2'> -->
        <button type="Submit" class="btn btn-primary"  aria-current="page">Volver al inicio</button>
      </form>
    </div>
  </div>
  <div class="container">
    <br><br>
    <?php leerTuit(conexionDB());
     /* if (isset($datos)) {
        foreach ($datos as $data) {
          echo '<div class="row">
            <div class="col-md-auto">
              <div class="col-md-auto" name="usuario">
              <h5>'.htmlspecialchars($data[1]).': </h5>
              </div>
              <div class="col-md-auto">
              <img weight="80px" height="80px" src="'.$data[4].'">
              </div>
            </div>
            <div class="col-8">
              <div class="col-8">
              <p>'.htmlspecialchars($data[2]).'</p>
              </div>
              <div class="col-8" name="tweet">
              <p>'.htmlspecialchars($data[0]).'</p>
              </div>
            </div>
          </div><br><br>';
        }
      }*/
    ?>
</div>
</body>
</html>