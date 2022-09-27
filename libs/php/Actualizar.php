<!DOCTYPE html>
<html lang="es-CO">
  <head>
    <meta charset = "UTF-8">
    <title>Actualizar usuario</title> 
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
  </head>
  <body>
    <?php 
      require_once "tools.php";
      require_once "../../db/db_tools.php";
      proteger();
      if(isset($_POST['name'])){
        var_dump($_FILES['foto']);
        if(isset($_FILES['foto'])&&$_FILES['foto']['error']===UPLOAD_ERR_OK){
          $fileTmpPath=$_FILES['foto']['tmp_name'];
          $filename=$_FILES['foto']['name'];
          $fileNameCamps=explode(".", $filename);
          $fileextension=strtolower(end($fileNameCamps));
          $permitidas=['jpg','png','jpeg'];
          if(in_array($fileextension, $permitidas)){
            $uploadFileDir='./file/';
            $filename=md5(time().$filename).','.$fileextension;
            $dest_path=$uploadFileDir.$filename;
            if(move_uploaded_file($fileTmpPath, $dest_path)){
              $img = imagecreatefromjpeg($dest_path);
              imagejpeg($img, $dest_path, 100);
              imagedestroy($img);
              $message='archivo subido';
              $_SESSION['perfil'] = $dest_path;
            }
            else{
              echo 'no';
            }
          }
        }
        $nombres = $_POST['name'];
        $apellidos = $_POST['lastname'];
        $hijos = $_POST['hijos'];
        $est = $_POST['est'];
        $correo = $_POST['correo'];
        $direccion = $_POST['direccion'];
        if(isset($_POST['anticsrf'])){
          if($_POST['anticsrf']=='1111') {
          actualizar(conexionDB(),$nombres, $apellidos, $est, $correo, $direccion, $_SESSION['perfil'], $hijos);
          header("Location: ../../index.php");
        }
        }
        if((isset($_POST['anticsrf'])) && isset($_SESSION['anticsrf']) && ($_SESSION['anticsrf']==$_POST['anticsrf'])) {
          actualizar(conexionDB(),$nombres, $apellidos, $est, $correo, $direccion, $_SESSION['perfil'], $hijos);
          header("Location: ../../index.php");
        }
        else {
          echo "Peticion invalida";
        }
      }
      $anticsrf=random_int(1000,9999);
      $_SESSION['anticsrf']=$anticsrf;
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
            <h1>Actualizar</h1>
        </div>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label for="name">Nombres: </label>
              <input type="text" class="form-control" name="name" id="name" value="<?php echo $_SESSION['nombre']; ?>" pattern="[A-Za-z]+" required>
            </div>
            <div class="form-group">
              <label for="lastname">Apellidos: </label>
              <input type="text" name="lastname" id="lastname" value="<?php echo $_SESSION['apellido']; ?>" class="form-control" pattern="[A-Za-z]+" required>
            </div>
            <div class="form-group">
              <label for="correo">Correo: </label>
              <input type="email" name="correo" id="correo" class="form-control" value="<?php echo $_SESSION['correo']; ?>" required="required">
            </div>
            <div class="form-group">
              <label for="est">Estado civil: </label>
              <select class="form-control" name="est" id="est" required>
                <option value="<?php echo $_SESSION['idestado'];?>"><?php echo $_SESSION['tipest']; ?></option>
                <option value="1">Soltero</option>
                <option value="2">Casado</option>
                <option value="3">Unión libre</option>
                <option value="4">Viudo </option>
              </select>
            </div>
            <div class="form-group">
              <label for="direccion">Dirección: </label>
              <input type="text" class="form-control" name="direccion" id="direccion" value="<?php echo $_SESSION['direccion']; ?>" required>
            </div>
            <div class="form-group">
              <label for="hijos">Cantidad de hijos: </label>
              <input type="number" class="form-control" placeholder="1,2,3,4..." name="hijos" id="hijos"  value="<?php echo $_SESSION['hijos']; ?>" required>
            </div>
            <div class="form-group">
              <label for="foto">Foto de perfil: </label>
              <input type="file" class="form-control" name="foto" >
            </div>
            <div class="form-group form-group-btn">
              <input type='hidden' name='anticsrf' value='<?php echo $anticsrf;?>'>
              <input type="submit" class="btn btn-success btn-lg" value="Actualizar" id="subRegistrar">
              <br>
              <button type="submit" class="btn btn-success btn-lg" formaction="CambioClave.php">Cambiar contraseña</button>
            </div>
            </div>
        </form>
    </div>
  </body>
</html>
