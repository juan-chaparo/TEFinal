<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <title>Crear artículo</title>
</head>
<body>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <?php
    require_once "tools.php";
    require_once "../../db/db_tools.php";
    proteger();
    if(!isset($_SESSION['name']))
    {
        header("Location: Login.php");
    }
    if (isset($_POST['tuit'])) {
      if ((isset($_POST['anticsrf'])) && isset($_SESSION['anticsrf']) && ($_SESSION['anticsrf']==$_POST['anticsrf'])) {
        if (isset($_POST['publico'])) {
          crearTuit(conexionDB(), $_POST['tuit'], $_POST['publico']);
          header("Location: CrearArticulo.php");
        }else {
          crearTuit(conexionDB(), $_POST['tuit'], 0);
          header("Location: CrearArticulo.php");
        }
      }
      else {
        echo "Peticion inválida";
      }
    }
    $anticsrf=random_int(1000,9999);
    $_SESSION['anticsrf']=$anticsrf;
  ?>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
          <div class="container">
          <a class="navbar-brand" href="./../../index.php">
            <img src="./../css/casita.png" width="80" height="80">Página de inicio
          </a>
        </div>
        <form class="d-flex">
          <?php echo "<img weight='80px'  height='80px' class='roundinválidaed mx-auto d-block' src='".$_SESSION['perfil']."'>";?>&nbsp &nbsp &nbsp &nbsp
          <input type='hidden' name='anticsrf' value='<?php echo $anticsrf;?>'>
          <h3 class="row align-items-center"><?php echo " ".$_SESSION["nombre"]." ".$_SESSION["apellido"];?></h3>&nbsp &nbsp
        </form>
      </div>
    </div>
  </nav>
  <div class="row align-items-start">
    <div class="col">
      <form action="Articulos.php" method="post">
        <input type='hidden' name='anticsrf' value='<?php echo $anticsrf;?>'>
        <button type="Submit" class="btn btn-primary"  aria-current="page">Todos los artículos</button>
      </form>
      </div>
    <div class="col">
      <form action="MisArticulos.php" method="post">
        <input type='hidden' name='anticsrf' value='<?php echo $anticsrf;?>'>
        <button type="Submit" class="btn btn-primary"  aria-current="page">Mis artículos</button>
      </form>
    </div>
    <div class="col">
      <a href="CrearArticulo.php" class="btn btn-primary active color">Crear artículo</a>
    </div>
    <div class="col">
      <form action="./../../index.php" method="post">
        <!-- <input type='hidden' name='idP' value='2'> -->
        <input type='hidden' name='anticsrf' value='<?php echo $anticsrf;?>'>
        <button type="Submit" class="btn btn-primary"  aria-current="page">Volver al inicio</button>
      </form>
    </div>
  </div>
  <form  method='post' action='CrearArticulo.php'>
    <div class="container">
      <br><br>
      <div class="row">
        <div class="col-md-auto">
          <div class="col-md-auto">
            <h5>Artículo: </h5>
          </div>
          <div class="col-md-auto">
            <h5>Es público: </h5>
          </div>
          <div class="col-md-auto">
          <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" name="publico" value="1">
          </div>
        </div>
        <div class="col-8">
          <div class="col-8">
            <div class="input-group">
            <textarea  class="form-control" aria-label="With textarea" name='tuit' max='140'></textarea>
          </div>
        </div>
        <input type='hidden' name='anticsrf' value='<?php echo $anticsrf;?>'>
        <div class="col-8">
          <button type="Submit" class="btn btn-success">Crear</button>
        </div>
      </div>
    </div>
    <br><br>
    </div>
  </form>
</body>
</html>