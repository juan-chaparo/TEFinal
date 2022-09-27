<?php
  require_once "../db/db_tools.php";
  require_once "../libs/php/toolsApi.php";
  require_once '../vendor/autoload.php';
  
  use Firebase\JWT\JWT; 
  $key = 'my_secret_key';
  $time = time();
  
  $_PUT=array();
  parse_str(file_get_contents('php://input'),$_PUT);
 
  if($_SERVER['REQUEST_METHOD'] == 'GET'){
      echo var_dump(usuarioActuals());
      exit();
  }

  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['usuario'])&&isset($_POST['clave'])){
      $usuario = limpiarCadena($_POST['usuario']);
      $clave = limpiarCadena($_POST['clave']);
  
      if(!isset($usuario) || $usuario == ''){
        echo "Ingrese el usuario";
        http_response_code(200);
        exit();
      }
      
      if(verificar(conexionDB(), $usuario, $clave)){
        var_dump($_POST);
        echo verificar(conexionDB(), $usuario, $clave);
        $id = traerId(conexionDB(), $usuario, $clave);
        var_dump ($id);
        $data = array(
          'iat' => $time,
          'exp' => $time + (60*60),
          'data' => ['id' => $id]
        );
        var_dump($data);
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
    else{
      try{
        if(validarNombres($_POST["nombre"]) && validarNombres($_POST["apellido"]) && validarNumbers($_POST["est"]) && validarNumbers($_POST["hijos"]) && validarNombres($_POST["usuario"])&&validarContra($_POST['contrasena'])&&(limpiarCadena($_POST['correo'])!=NULL)&&(limpiarCadena($_POST['direccion'])!=NULL)){
          $usuario = $_POST['usuario'];
          $contra = md5($_POST['contrasena']);
          $est = $_POST['est'];
          $correo = $_POST['correo'];
          $imagen = base64_to_jpeg($_POST['img'],'tmp.jpeg');
          $hijos = $_POST['hijos'];
          $nombre = $_POST['nombre'];
          $apellido = $_POST['apellido'];
          $direccion = $_POST['direccion'];
          registarUsuarioDB(conexionDB(), limpiarCadena($usuario), limpiarCadena($contra), limpiarCadena($est), limpiarCadena($correo), $imagen, limpiarCadena($hijos), limpiarCadena($nombre), limpiarCadena($apellido), limpiarCadena($direccion));
          echo 'Registrado con éxito';
          header("HTTP/1.1 200 OK");
          exit();
        }
        echo 'Datos invalidos';
        http_response_code(401);
       
      }catch(\Throwable $th){
        echo $th;
        echo 'Error al registrar';
        http_response_code(401);
        exit();
      }
    }
    
  }
/* 
  if(usuarioActuals()==''){
    echo 'Acceso no autorizado';
    http_response_code(401);
    exit();
  } */

   if ($_SERVER['REQUEST_METHOD']=='PUT') {
     if(isset($_PUT['imagen'])&&isset($_PUT['nombre'])&&isset($_PUT['apellido'])){
       try{
          $nombre =limpiarCadena($_PUT['nombre']);
          $apellido = limpiarCadena($_PUT['apellido']);
          $data=explode(";",$_PUT['imagen']);
          if ($data[0]=="data:image/jpeg"||$data[0]=="data:image/png"||$data[0]=="data:image/bmp") {
            $imagen = base64_to_jpeg($_PUT['imagen'], "tmp.jpg");
            actualizarUsuarioApi(conexionDB(), $nombre, $apellido, $imagen);
            echo 'Actualizado con éxito';
            header("HTTP/1.1 200 OK");
            exit();
          }else {
            echo 'Formato de la imagen erroneo';
            http_response_code(401);
          }
      }catch(\Throwable $th){
          echo $th;
          echo 'Error al actualizar';
          http_response_code(401);
          exit();
      }
     }
     else if (isset($_PUT['opw'])&&isset($_PUT['npw'])&&isset($_PUT['npw2'])) {
       try{
          $opw = limpiarCadena($_PUT['opw']);
          $npw =limpiarCadena($_PUT['npw']);
          $npw2 = limpiarCadena($_PUT['npw2']);
          if($npw == $npw2){
            cambiarClaveApi(conexionDB(), $opw, $npw);
            header("HTTP/1.1 200 OK");
            echo 'Cambio de clave con éxito';
            exit();
          }
          echo "Las contraseñas son diferentes";
      }catch(\Throwable $th){
          echo $th;
          echo 'Error al actualizar';
          http_response_code(401);
          exit();
      }
     }
   
  }
  //
?>