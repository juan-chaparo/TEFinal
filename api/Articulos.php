<?php
 require_once "../db/db_tools.php";
  require_once "../libs/php/toolsApi.php";
use Firebase\JWT\JWT; 

 $_PUT=array();
  parse_str(file_get_contents('php://input'),$_PUT);

  $datos = usuarioActuals();
  foreach($datos as $index => $value){
      $a  = $value;
  }
  $id = $a;
  //ConsultarArticulos
  if ($_SERVER['REQUEST_METHOD']=='POST') {
    $idp4=limpiarCadena($_POST['idP4']);
    if (isset($_POST['idp'])) {
      $idp=limpiarCadena($_POST['idP']);
      $datos=leerTuitApi(conexionDB());
    }
    elseif (isset($_POST['idP2'])) {
      $idp=limpiarCadena($_POST['idP2']);
      $datos=leerTuitPersonalApi(conexionDB(),$id);
    }elseif (isset($idp4)){
      if (isset($_POST['publico'])) {
        $publico=1;
      }else {
        $publico=0;
      }
      $_POST['tuit'].=" ";
      $tuit=limpiarCadena($_POST['tuit']);
      if (isset($tuit)) {
        crearTuitApi(conexionDB(),$tuit,$publico,$id);
        echo "Tweet creado";
      }
      exit();
    } 
    else{
    $datos="No hay parametros";
    }
    header("HTTP/1.1 200 OK");
    echo json_encode($datos);
    return $datos;
  }
  if ($_SERVER['REQUEST_METHOD']=='DELETE') {
    if (isset($_GET['mensaje'])) {
      borrarTuitApi(conexionDB(),limpiarCadena($_GET['mensaje']),$id);
      $datos=leerTuitPersonalApi(conexionDB(),$id);
    }else{
      $datos="Digite el usuario";
    }
    header("HTTP/1.1 200 OK");
    echo json_encode($datos);
    return $datos;
  }

  if ($_SERVER['REQUEST_METHOD']=='PUT') {
    try{
      if (isset($_PUT['mensaje'])&&isset($_PUT['estado'])) {
        if ($_PUT['estado']==1||$_PUT['estado']==0) {
          ActualizarEstadoTuitApi(conexionDB(),limpiarCadena($_PUT['mensaje']),limpiarCadena($_PUT['estado']));
          echo 'Actualizado con éxito';
        }
      }else{
        echo 'No están todos los parámetros';
      }
      header("HTTP/1.1 200 OK");
      echo json_encode($datos);
      return $datos;
    }catch(\Throwable $th){
      echo $th;
    }
  }
  exit();
?>