<!DOCTYPE html>
<html lang="es-CO">
  <head>
    <meta charset = "UTF-8">
    <title>Registrar usuario</title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
  </head>
  <body>
    <?php 
      require_once "tools.php";
      require_once "../../db/db_tools.php";
      proteger();
      if(isset($_POST['name'])){
        if (validarNombres($_POST["name"]) && validarNombres($_POST["lastname"]) && validarNumbers($_POST["hijos"]) && validarNombres($_POST["user"]) && validarContra($_POST["pw"])) {
          $dest_path='Sin foto uwu';
          if(isset($_FILES['foto'])&&$_FILES['foto']['error']===UPLOAD_ERR_OK)
          {
            $fileTmpPath=$_FILES['foto']['tmp_name'];
            $filename=$_FILES['foto']['name'];
            $fileNameCamps=explode(".", $filename);
            $fileextension=strtolower(end($fileNameCamps));
            $permitidas=['jpg','png','jpeg'];
            if(in_array($fileextension, $permitidas)){
              $uploadFileDir='./file/';
              $filename=md5(time().$filename).'.'.$fileextension;
              $dest_path=$uploadFileDir.$filename;
              if(move_uploaded_file($fileTmpPath, $dest_path)){
                $img = imagecreatefromjpeg($dest_path);
                imagejpeg($img, $dest_path, 100);
                imagedestroy($img);
                $message='archivo subido';
              }
            else{
              echo 'no';
            }
          }
        }
        $nombres = $_POST['name'];
        $apellidos = $_POST['lastname'];
        $hijos = $_POST['hijos'];
        $correo = $_POST['correo'];
        $direccion = $_POST['direccion'];
        $est = $_POST['est'];
        $_SESSION['usuario'] =  $_POST['user'];
        $_SESSION['contra'] =  md5($_POST['pw']);
        $_SESSION['perfil'] = $dest_path;
       if ((isset($_POST['anticsrf'])) && isset($_SESSION['anticsrf']) && ($_SESSION['anticsrf']==$_POST['anticsrf'])) {
          if (UsuarioRegistrado(conexionDB(),$_SESSION['usuario'])) {
            $usuarioregistrado=true;
          }else {
            registarUsuarioDB(conexionDB(), $_SESSION['usuario'], $_SESSION['contra'], $est, $correo, $_SESSION['perfil'], $hijos, $nombres, $apellidos,$direccion);
          }
          //header("Location: ../../index.php"); 
        }
        else {
          echo "Petición invalida";
        }
      }
      else {
      }
      }
      $anticsrf=random_int(1000,9999);
      $_SESSION['anticsrf']=$anticsrf;
      ?>
      <div class="container" id="log-in-form">
        <div class="heading">
            <h1>Registro</h1>
            <?php
            if (isset($usuarioregistrado)) {
              echo "<div name='UserNR'><h3>El usuario ya esta registrado</h3></div>";
            }
            ?>
        </div>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label for="name">Nombres: </label>
              <input type="text" class="form-control" name="name" id="name" pattern="[A-Za-z]+" placeholder="Nombres" required>
            </div>
            <div class="form-group">
              <label for="lastname">Apellidos: </label>
              <input type="text" name="lastname" id="lastname" pattern="[A-Za-z]+" class="form-control" placeholder="Apellidos" required>
            </div>
            <div class="form-group">
              <label for="correo">Correo: </label>
              <input type="email" name="correo" id="correo" class="form-control" placeholder="Correo" required="required">
            </div>
            <div class="form-group">
              <label for="direccion">Dirección: </label>
              <input type="text" name="direccion" id="direccion" placeholder="Dirección" class="form-control" required="required">
            </div>
            <div class="form-group">
              <label for="hijos">Cantidad de hijos: </label>
              <input type="number" class="form-control" placeholder="1,2,3,4..." name="hijos" id="hijos" required>
            </div>
            <div class="form-group">
              <label for="est">Estado civil: </label>
              <select name="est" class="form-control" id="est" required>
                <option value="1">Soltera/o</option>
                <option value="2">Casado/a</option>
                <option value="3">Unión libre</option>
                <option value="4">Viuda/o</option>
              </select>
            </div>
            <div class="form-group">
              <label for="user">Usuario: </label>
              <input type="text" name="user" id="user" class="form-control" placeholder="DARRKARKO" pattern="[A-Za-z]+" required>
            </div>
            <div class="form-group">
              <label for="pw">Contraseña: </label>
              <input type="password" name="pw" id="pw" class="form-control" placeholder="qwert.12345" required>
              <?php
                    if(isset($_POST['name'])){
                      if(!validarContra($_POST["pw"])){
                        echo "<div name='loginerror'>Contraseña incorrecta</div>";
                      }
                    }
                 ?>
            </div>
            <div class="form-group">
              <label for="foto">Foto de perfil: </label>
              <input type="file" class="form-control" name="foto"  required>
            </div>
            <div class="form-group form-group-btn">
              <input type='hidden' name='anticsrf' value='<?php echo $anticsrf;?>'>
              <input type="submit" class="btn btn-success btn-lg" value="Registrar" id="subRegistrar">
            </div>
            </div>
        </form>
    </div>
  </body>
</html>
