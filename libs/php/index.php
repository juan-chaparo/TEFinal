<!DOCTYPE html>
<html lang="es-CO">
  <head>
    <meta charset = "UTF-8">
    <title>Página principal</title> 
  </head>
  <?php 
    require_once("./tools.php"); 
    proteger();
    require_once("./../../db/db_tools.php"); 
  ?>
  <body>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <h1>Trabajo final</h1>
    <h2>Diego Andrés Castañeda Pardo - Juan Pablo Chaparro Vasquez</h2>
    <?php
      if(isset($_SESSION['inicio'])){
        if($_SESSION['inicio']==1){      }
      }else {
        header("Location: ./Login.php");
      }
    ?>
   <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
          <div class="container">
          <a class="navbar-brand" href="#">
            <img src="./casita.png" width="80" height="80">Página de inicio
          </a>
        </div>
        <form class="d-flex">
          <?php echo "<img weight='80px'  height='80px' class='rounded mx-auto d-block' src='libs/php".$_SESSION['perfil']."'>";?>&nbsp &nbsp &nbsp &nbsp
          <h3 class="row align-items-center"><?php echo " ".$_SESSION["nombre"]." ".$_SESSION["apellido"];?></h3>&nbsp &nbsp
        </form>
      </div>
    </div>
  </nav>
    <div class="container">
      <div class="row align-items-end">
        <div class="col">
          <form action="./Articulos.php" method="post">
            <input type='hidden' name='idP' value='1'>
            <button type="Submit" class="btn btn-primary"  aria-current="page">Artículos</button>
          </form>
        </div>
        <div class="col">
          <form action="./Mensajeria.php" method="post">
            <button type="Submit" name="idP" class="btn btn-primary"  aria-current="page">Mensajes</button>
          </form>
        </div>
        <div class="col">
          <a href='./Actualizar.php' class="btn btn-primary"> Mi perfil</a>
        </div>
        <div class="col">
          <a href='./CerrarSesion.php' class="btn btn-primary"> Cerrar sesión</a>
        </div>
    </div>
    </div>



    
  </body>
  </html>