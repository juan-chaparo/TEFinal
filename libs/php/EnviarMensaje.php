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
    $datos = leerUsuarios(conexionDB());
    $anticsrf=random_int(1000,9999);
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
  </div>
  <br><br><br>
  <form method="post"  enctype="multipart/form-data">
    <div class="container">
    <label for="Destinatario">Destinatario: </label>
    <select name="Destinatario" id="Destinatario">
      <option value="0">Seleccione un destinatario</option>
      <?php 
        foreach ($datos as $usuarios) {
          echo "entra al while";
          if($usuarios['ID_USUARIO']!=$_SESSION['id_usuario'])
          {
            echo "<option value='".$usuarios['ID_USUARIO']."'>".htmlspecialchars($usuarios['NOMBRE'])." ".$usuarios['APELLIDO']."</option>";
          }else{
            echo "<option value='".$usuarios['ID_USUARIO']."' selected>".htmlspecialchars($usuarios['NOMBRE'])." ".$usuarios['APELLIDO']."</option>";
          }
        }
      ?>
    </select>
    <br><br>
    <label for="Mensaje">Mensaje: </label>
      <input type="text" max="140" id="mensaje" name="mensaje">
      <br><br>
      <label for="foto">Archivo:  </label>
      <input type="file" name="foto">
      <br><br>
      <input type='hidden' name='anticsrf' value='<?php echo $anticsrf;?>'>
      <input type="submit" name="smensaje">
    </div>
  </form>
  <?php
    extract($_POST);
    if(isset($smensaje)){
       if ((isset($_POST['anticsrf'])) && isset($_SESSION['anticsrf']) && ($_SESSION['anticsrf']==$_POST['anticsrf'])) {
                    if(isset($_FILES['foto'])&&$_FILES['foto']['error']===UPLOAD_ERR_OK){
                        $fileTmpPath=$_FILES['foto']['tmp_name'];
                        $filename=$_FILES['foto']['name'];
                        $fileNameCamps=explode(".", $filename);
                        $fileextension=strtolower(end($fileNameCamps));
                        $permitidas=['jpg','png','jpeg','pdf','docx','xlsx','mp3','mp4'];
                        try{
                          if(in_array($fileextension, $permitidas)){
                            $uploadFileDir='./file/';
                            $dest_path=$uploadFileDir.$filename;
                            if(move_uploaded_file($fileTmpPath, $dest_path)){
                              switch ($fileextension) {
                                case 'jpeg':
                                  $img = imagecreatefromjpeg($dest_path);
                                    imagejpeg($img, $dest_path, 100);
                                    imagedestroy($img);
                                    $message='archivo subido';
                                    enviarMensaje(conexionDB(), $mensaje, $dest_path, $Destinatario);
                                  break;
                                case 'png':
                                    $img = imagecreatefromjpeg($dest_path);
                                    imagejpeg($img, $dest_path, 100);
                                    imagedestroy($img);
                                    $message='archivo subido';
                                    enviarMensaje(conexionDB(), $mensaje, $dest_path, $Destinatario);
                                  break;
                                default:
                                  enviarMensaje(conexionDB(), $mensaje, $dest_path, $Destinatario);
                                  break;
                              }
                            }else{
                              echo 'no';
                            }
                        }}catch(PDOException $error){
                          echo "error";
                        }
                        
                    }else{
                      enviarMensaje(conexionDB(), $mensaje, null, $Destinatario);
                    }
       }else{
         echo "Peticion invalida";
       }
    }
    $_SESSION['anticsrf']=$anticsrf;
  ?>
</body>
</html>