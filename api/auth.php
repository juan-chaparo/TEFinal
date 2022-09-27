<?php
  require_once "../db/db_tools.php";
  require_once "../libs/php/toolsApi.php";
  require_once '../vendor/autoload.php';

  use Firebase\JWT\JWT; 
  $key = 'my_secret_key';
  $time = time();

  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];

    if(!isset($usuario) || $usuario == ''){
      echo "Ingrese el usuario";
      http_response_code(200);
      exit();
    }

    if(verificar(conexionDB(), $usuario, $clave)){
      $id = traerId(conexionDB(), $usuario, $clave);
      $data = array(
        'iat' => $time,
        'exp' => $time + (60*60),
        'data' => ['id' => $id]
      );

      $jwt = JWT::encode($data, $key);
      echo $jwt;
      header("HTTP/1.1 200 OK");
      exit();
    }
    else{
      echo "Acceso no autorizado";
      http_response_code(401);
      exit();
    } 
  }
?>