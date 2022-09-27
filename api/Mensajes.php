<?php
   require_once "../db/db_tools.php";
  require_once "../libs/php/toolsApi.php";
use Firebase\JWT\JWT; 

  $datos = usuarioActuals();
  foreach($datos as $index => $value){
      $a  = $value;
  }
  $id = $a;
  //CrearMensajes
  if ($_SERVER['REQUEST_METHOD']=='POST') {
    if (isset($_POST['idP'])) {
      $datos=leerMensajesRecibidosApi(conexionDB(),$id);
    }
    if (isset($_POST['idP2'])&&isset($_POST['idusr'])) {
      $datos=leerMensajesEnviadosApi(conexionDB(),$id);
    }
    if (isset($_POST['mensaje'])&&isset($_POST['id_r'])) {
        $mensaje=htmlspecialchars($_POST['mensaje']);
        $path=isset($_POST['path'])? $_POST["path"]:null;
        $id_r=$_POST['id_r'];
        $id_e=$id;
        enviarMensajeApi(conexionDB(), $mensaje, $path, $id_r, $id_e);
        $datos="Se envio el mensaje";
      
    }
    header("HTTP/1.1 200 OK");
    echo json_encode($datos);
    exit();
  }
?>