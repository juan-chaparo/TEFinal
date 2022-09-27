<?php
/**
 * id_estado_civil -> id_tipdoc
 * correo -> numdoc
 * hijos -> fecha
 * direccion -> color
 */
/**
 * Inicia sesión 
 */
  require_once './../../vendor/autoload.php';
use Firebase\JWT\JWT; 

  function iniciarSesion(){
      session_start();
  }
  /**
   * Registro usuario, metodo menos inseguro
   * @param $nombres: nombres del usaurio
   * @param $apellidos: apellidos del usuario
   * @param $tipdoc: select del est de documetno del usuario
   * @param $doc: numero de correo del usuario
   * @param $hijos: numero de hijos del usuario
   * @param $fecha: fecha de nacimiento del usaurio
   * @param $color: color favorito del usuario
   * @param $usuario: login de usuario
   * @param $clave: clave del usuario 
   * @param $img: nombre delarchivo de la foto
   * */  
  function registarUsuarioDB($my_Db_Connection, $usuario, $contra, $est, $correo, $imagen, $hijos, $nombre, $apellido, $direccion){
    $w="SELECT u.USER FROM ta_usuarios u  WHERE USER=:usuario ";
    $my_Select_Statement = $my_Db_Connection->prepare($w);
    $my_Select_Statement->bindParam(':usuario', $usuario);
    $my_Select_Statement->execute();
    $row = $my_Select_Statement->fetch();
    if ($row) {
      header("Location: ../../index.php"); 
    }else {
      $q="INSERT INTO ta_usuarios(USER, CONTRA,ID_ESTADO_CIVIL, CORREO, PATHIMAGEN, HIJOS, NOMBRE, APELLIDO, DIRECCION) VALUES (:usuario, :contra, :est, :correo, :imagen, :hijos, :nombre, :apellido, :direccion)";

      $my_Insert_Statement = $my_Db_Connection->prepare($q);
      $my_Insert_Statement->bindParam(':usuario', $usuario);
      $my_Insert_Statement->bindParam(':contra', $contra);
      $my_Insert_Statement->bindParam(':est', $est);
      $my_Insert_Statement->bindParam(':correo', $correo);
      $my_Insert_Statement->bindParam(':imagen', $imagen);
      $my_Insert_Statement->bindParam(':hijos', $hijos);
      $my_Insert_Statement->bindParam(':nombre', $nombre);
      $my_Insert_Statement->bindParam(':apellido', $apellido);
      $my_Insert_Statement->bindParam(':direccion', $direccion);
      if ($my_Insert_Statement->execute()) {
        header("Location: ../../index.php"); 
      }
      else {
        echo 'no';
        //return FALSE;
      }
    }
  } 

  function UsuarioRegistrado($my_Db_Connection, $usuario){
    $w="SELECT u.USER FROM ta_usuarios u  WHERE USER=:usuario ";
    $my_Select_Statement = $my_Db_Connection->prepare($w);
    $my_Select_Statement->bindParam(':usuario', $usuario);
    $my_Select_Statement->execute();
    $row = $my_Select_Statement->fetch();
    if ($row) {
      return true;
    }else {
      return false;
    }
  }
   
/**
 * Actualiza la información de usuario
 * @param $nombres: nombres del usaurio
  * @param $apellidos: apellidos del usuario
  * @param $tipdoc: select del est de documetno del usuario
  * @param $doc: numero de correo del usuario
  * @param $hijos: numero de hijos del usuario
  * @param $direccion: direccion favorito del usuario
  * @param $img: nombre delarchivo de la foto
 */
  function actualizar($my_Db_Connection,$nombres, $apellidos, $est, $correo, $direccion, $img, $hijos){
    $q="UPDATE ta_usuarios SET 
      ID_ESTADO_CIVIL= CASE WHEN :est IS NOT NULL THEN :est ELSE ID_ESTADO_CIVIL END 
      ,CORREO= CASE WHEN :correo IS NOT NULL THEN :correo ELSE CORREO END
      ,PATHIMAGEN= CASE WHEN :imagen IS NOT NULL THEN :imagen ELSE PATHIMAGEN END
      ,NOMBRE= CASE WHEN :nombre IS NOT NULL THEN :nombre ELSE NOMBRE END
      ,APELLIDO= CASE WHEN :apellido IS NOT NULL THEN :apellido ELSE APELLIDO END
      ,DIRECCION= CASE WHEN :direccion IS NOT NULL THEN :direccion ELSE DIRECCION END 
      ,HIJOS= CASE WHEN :hijos IS NOT NULL THEN :hijos ELSE HIJOS END 
      WHERE ID_USUARIO = :id_usuario";
      echo $img;
    $my_Update_Statement = $my_Db_Connection->prepare($q);
    $my_Update_Statement->bindParam(':id_usuario', $_SESSION['id_usuario']);
    $my_Update_Statement->bindParam(':est', $est);
    $my_Update_Statement->bindParam(':correo', $correo);
    $my_Update_Statement->bindParam(':imagen', $img);
    $my_Update_Statement->bindParam(':nombre', $nombres);
    $my_Update_Statement->bindParam(':apellido', $apellidos);
    $my_Update_Statement->bindParam(':direccion', $direccion);
    $my_Update_Statement->bindParam(':hijos', $hijos);

    if ($my_Update_Statement->execute()) {
      echo 'Si';
      //return TRUE;
      $_SESSION['perfil']=$img;
      $_SESSION['nombre']=$nombres;
      $_SESSION['apellido']=$apellidos;
      $_SESSION['idestado']=$est;
      $_SESSION['correo']=$correo;
      $_SESSION['direccion']=$direccion;
      $_SESSION['hijos']=$hijos;
      switch ($_SESSION['idestado']) {
        case '1':
          $_SESSION['tipest']="Soltero";
          break;
        case '2':
          $_SESSION['tipest']="Casado";
          break;
        case '3':
          $_SESSION['tipest']="Union libre";
          break;
        case '4':
          $_SESSION['tipest']="Viudo";
          break;
      }
    }
    else {
      echo 'no';
      //return FALSE;
    }
  }

  /**
   * Carga usuario y clave en $_SESSION
   */
  function verificar($my_Db_Connection, $usuario, $clave){
    $confirmar = false;
    $clave=md5($clave);
    $q="SELECT u.USER,u.CONTRA, ec.TIPO_ESTADO ,u.ID_ESTADO_CIVIL,u.CORREO,u.PATHIMAGEN,u.HIJOS,u.NOMBRE,u.APELLIDO,u.DIRECCION, u.ID_USUARIO FROM ta_usuarios u inner join tm_estados_civiles ec on ec.ID_ESTADO_CIVIL=u.ID_ESTADO_CIVIL WHERE USER=:usuario AND CONTRA=:contra";
    $my_Select_Statement = $my_Db_Connection->prepare($q);
    $my_Select_Statement->bindParam(':usuario', $usuario);
    $my_Select_Statement->bindParam(':contra', $clave);
    $my_Select_Statement->execute();
    while ($row = $my_Select_Statement->fetch()) {
      $confirmar = true;
      $_SESSION['name']=htmlspecialchars($row['USER']);
      $_SESSION['perfil']=htmlspecialchars($row['PATHIMAGEN']);
      $_SESSION['nombre']=htmlspecialchars($row['NOMBRE']);
      $_SESSION['apellido']=htmlspecialchars($row['APELLIDO']);
      $_SESSION['tipest']=htmlspecialchars($row['TIPO_ESTADO']);
      $_SESSION['idestado']=htmlspecialchars($row['ID_ESTADO_CIVIL']);
      $_SESSION['correo']=htmlspecialchars($row['CORREO']);
      $_SESSION['hijos']=htmlspecialchars($row['HIJOS']);
      $_SESSION['direccion']=htmlspecialchars($row['DIRECCION']);
      $_SESSION['id_usuario']=htmlspecialchars($row['ID_USUARIO']);
      switch ($_SESSION['idestado']) {
        case '1':
          $_SESSION['tipest']="Soltero";
          break;
        case '2':
          $_SESSION['tipest']="Casado";
          break;
        case '3':
          $_SESSION['tipest']="Union libre";
          break;
        case '4':
          $_SESSION['tipest']="Viudo";
          break;
      }
    }
    if($confirmar){
      $_SESSION['inicio']=1;
      header("Location: ../../index.php");
      return true;
    }else {
      echo "<div name='loginerror'>Usuario no encontrado</div>";
      return false;
   }
    /* $user = $my_Select_Statement->fetch();
    $my_Select_Statement->bindParam(':usuario', $usuario);
    $my_Select_Statement->bindParam(':contra', $clave);
    echo $q."     ".$clave;
    $my_Select_Statement->execute([':usuario' => $usuario, ':contra' => $clave]);
    if ($user) {
        echo "exito";
    } */
    /* $file = "usuario.txt";
    $fp = fopen($file, "r");
    $contents = fread($fp, filesize($file));
    $usuarios =explode("\n",$contents);
    foreach ($usuarios as $u) {
      $datos=explode(":",$u);
      if($usuario==$datos[0]){
        if($clave==$datos[1]){
          $confirmar = true;
          $_SESSION['name']=$datos[0];
          $_SESSION['perfil']=$datos[2];
          $_SESSION['nombre']=$datos[3];
          $_SESSION['apellido']=$datos[4];
          $_SESSION['tipdoc']=$datos[5];
          $_SESSION['numdoc']=$datos[6];
          $_SESSION['hijos']=$datos[7];
          $_SESSION['fecha']=$datos[8];
          $_SESSION['direccion']=$datos[9];
        }  
      }
    }
    
    if($confirmar){
      echo "<br>Inició sesión con éxito";
      $_SESSION['inicio']=1;
      header("Location: index.php");
    }else {
      echo "<br>Usuario no encontrado";
   } */
  }
/**
 * Cambia la clave de un usuario
 * @param $clave: Clave antigua del usuario
 * @param $clavenueva: Clave que reemplazará la antigua clave
 */
  function cambiarClave($my_Db_Connection, $clave, $clavenueva){
    $clave=md5($clave);
    $clavenueva=md5($clavenueva);
    $q="UPDATE ta_usuarios SET 
      CONTRA= CASE WHEN :contranueva IS NOT NULL THEN :contranueva ELSE CONTRA END 
      WHERE USER = :usuario AND CONTRA=:contra";
    $my_Update_Statement = $my_Db_Connection->prepare($q);
    $my_Update_Statement->bindParam(':usuario', $_SESSION['name']);
    $my_Update_Statement->bindParam(':contra', $clave);
    $my_Update_Statement->bindParam(':contranueva', $clavenueva);
    if ($my_Update_Statement->execute()) {
      echo 'Si';
      header("Location: ../../index.php");
      //return TRUE;
    }
    else {
      echo 'Contraseña erronea';
      //return FALSE;
    }
  }

  /**
   * Crea un tweet a partir de un texto ingresado por el usuario
   * @param $tuit: texto del usuario
   */
  function crearTuit($my_Db_Connection, $tuit, $estado){
    $tuit=limpiarCadena($tuit);
    $q="INSERT INTO ta_tweets(TWEET, ID_USUARIO, ESTADO) VALUES (:tweet, :id_usuario, :estado)";
    $my_Insert_Statement = $my_Db_Connection->prepare($q);
    $my_Insert_Statement->bindParam(':tweet', $tuit);
    $my_Insert_Statement->bindParam(':id_usuario',$_SESSION['id_usuario']);
    $my_Insert_Statement->bindParam(':estado',$estado);
    if ($my_Insert_Statement->execute()) {
    }
    else {
    }
  }

  /**
   * Lee todos los tweets ingresados por usuarios
   */
function leerTuit($my_Db_Connection){
    $confirmar = false;
    $q="SELECT t.TWEET, u.USER, T.FECHA_CREACION, T.ESTADO, U.PATHIMAGEN FROM ta_tweets t inner join ta_usuarios u on u.ID_USUARIO=t.ID_USUARIO WHERE T.ESTADO=1";
    $my_Select_Statement = $my_Db_Connection->prepare($q);
    $my_Select_Statement->execute();
    while ($row = $my_Select_Statement->fetch()) {
        echo '<div class="row">
        <div class="col-md-auto">
          <div class="col-md-auto">
          <h5>'.htmlspecialchars($row['USER']).': </h5>
          </div>
          <div class="col-md-auto">
          <img weight="80px" height="80px" src="'.$row['PATHIMAGEN'].'">
          </div>
        </div>
        <div class="col-8">
          <div class="col-8">
          <p>'.htmlspecialchars($row['FECHA_CREACION']).'</p>
          </div>
          <div class="col-8">
          <p>'.htmlspecialchars($row['TWEET']).'</p>
          </div>
        </div>
      </div><br><br>';
    }
  }

function leerTuitPersonal($my_Db_Connection){
  try{
    $confirmar = false;
    $q="SELECT t.TWEET, u.USER, T.FECHA_CREACION, T.ESTADO, U.PATHIMAGEN, t.ID_USUARIO, t.ID_TWEET FROM ta_tweets t inner join ta_usuarios u on u.ID_USUARIO=t.ID_USUARIO WHERE t.ID_USUARIO=:id_usuario";
    $my_Select_Statement = $my_Db_Connection->prepare($q);
    $my_Select_Statement->bindParam(':id_usuario',$_SESSION['id_usuario']);
    $my_Select_Statement->execute();
    while ($row = $my_Select_Statement->fetch()) {
        echo '<div class="row">
        <div class="col-md-auto">
          <div class="col-md-auto">
          <h5>Articulo: </h5>
          </div>
          <div class="col-md-auto">
          <h5>Es publico:</h5>
          </div>';
        if ($row['ESTADO']==1) {
          echo '<div class="col-md-auto">
          <h5>Si</h5>
          </div>
          </div>';
        }else {
          echo '<div class="col-md-auto">
          <h5>No</h5>
          </div>
          </div>';
        }
        echo '
        <div class="col-8">
          <div class="col-8">
          <p>'.htmlspecialchars($row['TWEET']).'</p>
          </div>
          <div class="col-8">
          <p>'.htmlspecialchars($row['FECHA_CREACION']).'</p>
          </div>
        </div>
      </div>';
      if ($row['ESTADO']==1) {
          echo'
          <form method="post" action="./Borrar.php">
            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
              <input type="hidden" value='.$row['ID_TWEET'].' name="mensaje">
              <button type="submit" name="publicar" class="btn btn-outline-primary" disabled="TRUE">Publicar</button>
              <button type="submit" name="despublicar" class="btn btn-primary">Despublicar</button>
              <button type="submit" name="borrar" class="btn btn-danger">Borrar</button>
            </div>
          </form>
          <br><br>';
        }else {
          echo'
          <form method="post" action="./Borrar.php">
            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
              <input type="hidden" value='.$row['ID_TWEET'].' name="mensaje">
              <button type="submit" name="publicar" class="btn btn-primary">Publicar</button>
              <button type="submit" name="despublicar" class="btn btn-outline-primary" disabled="TRUE">Despublicar</button>
              <button type="submit" name="borrar" class="btn btn-danger">Borrar</button>
            </div>
          </form>
          <br><br>';
        }
    }
  }catch(\Throwable $th){
      return null;
  }

  } 


function leerMensajesRecibidos($my_Db_Connection){
    $q="SELECT m.MENSAJE, m.FECHA_ENVIO, u.USER, u.PATHIMAGEN, m.PATH_ARCHIVO  FROM ta_mensajes m  inner join ta_usuarios u on u.ID_USUARIO = m.ID_USUARIO_E WHERE m.ID_USUARIO_R = (SELECT ID_USUARIO FROM ta_usuarios WHERE USER=:usuario)";
    $my_Select_Statement = $my_Db_Connection->prepare($q);
    $my_Select_Statement->bindParam(':usuario', $_SESSION['name']);
    $my_Select_Statement->execute();
    while ($row = $my_Select_Statement->fetch()) {
      echo '<img weight="80px" height="80px" src="'.$row['PATHIMAGEN'].'">
                <h5>'.$row['USER'].': </h5>
                <p>'.$row['MENSAJE'].'</p>
                <p>'.$row['FECHA_ENVIO'].'</p>
                <p>';
                if ($row['PATH_ARCHIVO']!=null) {
                  echo'<a href="'.$row['PATH_ARCHIVO'].'" download="'.$row['PATH_ARCHIVO'].'">'.md5(substr($row['PATH_ARCHIVO'],7)).'</a>';
                  echo "<br><br>";
                } 
    }
  }

function leerMensajesEnviados($my_Db_Connection){
    $q="SELECT m.MENSAJE, m.FECHA_ENVIO, u.USER, u.PATHIMAGEN, m.PATH_ARCHIVO FROM ta_mensajes m  inner join ta_usuarios u on u.ID_USUARIO = m.ID_USUARIO_R WHERE m.ID_USUARIO_E = (SELECT ID_USUARIO FROM ta_usuarios WHERE USER=:usuario)";
    $my_Select_Statement = $my_Db_Connection->prepare($q);
    $my_Select_Statement->bindParam(':usuario', $_SESSION['name']);
    $my_Select_Statement->execute();
    while ($row = $my_Select_Statement->fetch()) {
      echo '<img weight="80px" height="80px" src="'.$row['PATHIMAGEN'].'">
                <h5>'.$row['USER'].': </h5>
                <p>'.$row['MENSAJE'].'</p>
                <p>'.$row['FECHA_ENVIO'].'</p>';
                if ($row['PATH_ARCHIVO']!=null) {
                  echo'<a href="'.$row['PATH_ARCHIVO'].'" download="'.md5(substr($row['PATH_ARCHIVO'],7)).'">'.md5(substr($row['PATH_ARCHIVO'],7)).'</a>';
                  echo "<br><br>";
                }
  }
}

function listarUsuarios(){
  $q="SELECT USER FROM ta_usuarios";
  $my_Insert_Statement = $my_Db_Connection->prepare($q);
  if ($my_Insert_Statement->execute()) {
     
  }
}

function enviarMensaje($my_Db_Connection, $mensaje, $path, $id_r){
    $q="INSERT INTO ta_mensajes(MENSAJE, PATH_ARCHIVO, ID_USUARIO_E, ID_USUARIO_R, FECHA_ENVIO) VALUES (:mensaje, :path_ar, :id_usuario_e, :id_usuario_r, NOW())";
    $my_Insert_Statement = $my_Db_Connection->prepare($q);
    $my_Insert_Statement->bindParam(':mensaje', $mensaje);
    $my_Insert_Statement->bindParam(':path_ar', $path);
    $my_Insert_Statement->bindParam(':id_usuario_e', $_SESSION['id_usuario']);
    $my_Insert_Statement->bindParam(':id_usuario_r',$id_r);
    if ($my_Insert_Statement->execute()) {
      echo 'Si';
      //return TRUE;
    }
    else {
      echo 'no';
      //return FALSE;
    }
}

function leerUsuarios($my_Db_Connection){
  $q="SELECT u.ID_USUARIO, u.NOMBRE, u.APELLIDO FROM ta_usuarios u WHERE u.ID_USUARIO <> :usuario";
  $my_Insert_Statement = $my_Db_Connection->prepare($q);
  $my_Insert_Statement->bindParam(':usuario', $_SESSION['id_usuario']);
  $my_Insert_Statement->execute(); 
  $datos = $my_Insert_Statement->fetchAll();
  if($datos){
    return $datos;
  }
  else{
    return 0;
  }
}
  /**
   * Destruye la sesion del usuario
   */
  function cerrarSesion(){
    unset($_SESSION['name']);
    session_destroy();
    header("Location: ../../index.php");
  }
/**
 * Borra el tweet seleccionado en el index
 * @param $mensaje: mensaje que se desea eliminar, mandado desde el index
 */
  function borrarTuit($my_Db_Connection,$mensaje){
    $q="DELETE FROM ta_tweets WHERE ID_TWEET=:id and ID_USUARIO=:idusr";
    $my_Insert_Statement = $my_Db_Connection->prepare($q);
    $my_Insert_Statement->bindParam(':id', limpiarCadena($mensaje));
    $my_Insert_Statement->bindParam(':idusr', $_SESSION['id_usuario']);
    if ($my_Insert_Statement->execute()) {
      //return TRUE;
    }
    else {
      //return FALSE;
    }
  }
function ActualizarEstadoTuit($my_Db_Connection,$mensaje,$estado){
    $q="UPDATE ta_tweets SET ESTADO=:estado WHERE ID_TWEET=:id";
    $my_Insert_Statement = $my_Db_Connection->prepare($q);
    $my_Insert_Statement->bindParam(':id', $mensaje);
    $my_Insert_Statement->bindParam(':estado', $estado);
    if ($my_Insert_Statement->execute()) {
      //return TRUE;
    }
    else {
      //return FALSE;
    }
  }
  /**
   * Protege las cookies e inicia sesión
   */

  function proteger(){
    $cookieParams = session_get_cookie_params();
    $path = $cookieParams["path"];
    $secure = true;
    $httponly = true;
    $samesite = 'strict';
    session_set_cookie_params([
      'lifetime' => $cookieParams["lifetime"],
      'path' => $path,
      'domain' => $_SERVER['HTTP_HOST'],
      'secure' => $secure,
      'httponly' => $httponly,
      'samesite' => $samesite
    ]);
    iniciarSesion();
    session_regenerate_id(true);
  }

  function validarNombres($nombre){
    $patron="/\A[A-Za-z]+\Z/";
    $validar = false;
    if(preg_match ($patron,$nombre)){
      $validar = true;
    }
    return $validar;
  }
  function validarNumbers($numero){
    $patron="/\A[0-9]+\Z/";
    $validar = false;
    if(preg_match ($patron,$numero)){
      $validar = true;
    }
    return $validar;
  }
  function validarSelect($select){
    $patron="/\A[1-4]\Z/";
    $validar = false;
    if(preg_match ($patron,$select)){
      $validar = true;
    }
    return $validar;
  }
  function validarContra($pass){
    $patron="/^(?=.*\d)(?=.*[\u0021-\u002b\u003c-\u0040])(?=.*[A-Z])(?=.*[a-z])\S{6,12}$/";
    $validar = false;
    if(preg_match ($patron,$pass)){
      $validar = true;
    }
    return $validar;
  }
 function validarFecha($fecha){
    $patron="/^(\d{4})(\-)(0[1-9]|1[0-2])(\-)([0-2][0-9]|3[0-1])/";
    $validar = false;
    if(preg_match ($patron,$fecha)){
      $validar = true;
    }
    return $validar;
  }
  function validarArticulo($articulo){
    $patron='/^(([A-Za-z0-9]+)+([\:\-\.\,\"\s])+)+$/';
    $patron2='/^([A-Za-z0-9]+)$/';
    $validar = false;
    if(preg_match ($patron,$articulo)||preg_match ($patron2,$articulo)){
      $validar = true;
    }
    return $validar;
  }

  function limpiarCadena($cadena){

    $patron = array('/<script>.*<\/script>/');

    $cadena = preg_replace($patron, '', $cadena);

    $cadena = htmlspecialchars($cadena);

    return $cadena;

  }

/**---------------------------------------------API----------------------------------------------------- */

function usuarioActuals(){
  $jwt = $_SERVER['HTTP_AUTHORIZATION'];
  $key = 'my_secret_key';

  if(substr($jwt, 0, 6) === "Bearer"){
    $jwt = str_replace("Bearer ", "", $jwt);
    try{
      $data = JWT::decode($jwt, $key, array('HS256'));
      $datos = $data->data;
      return $datos->id;
      exit();
    }catch(\Throwable $th){
      echo $th;
      return '1';
    }
  }
  return '2';
}

function traerId($my_Db_Connection, $usuario, $clave){
    $clave=md5($clave);
    $q="SELECT u.ID_USUARIO FROM ta_usuarios u  WHERE USER=:usuario AND CONTRA=:contra";
    try{
      $my_Select_Statement = $my_Db_Connection->prepare($q);
      $my_Select_Statement->bindParam(':usuario', $usuario);
      $my_Select_Statement->bindParam(':contra', $clave);
      $my_Select_Statement->execute();
      $id = $my_Select_Statement->fetch();
      return $id;
    }catch(\Throwable $th){
      return null;
    }
  }

  function actualizarUsuarioApi($my_Db_Connection,$nombres, $apellidos, $img){
    $q="UPDATE ta_usuarios SET 
      PATHIMAGEN= CASE WHEN :imagen IS NOT NULL THEN :imagen ELSE PATHIMAGEN END
      ,NOMBRE= CASE WHEN :nombre IS NOT NULL THEN :nombre ELSE NOMBRE END
      ,APELLIDO= CASE WHEN :apellido IS NOT NULL THEN :apellido ELSE APELLIDO END
      WHERE ID_USUARIO = :id_usuario";
      $datos = usuarioActuals();
      foreach($datos as $index => $value){
         $a  = $value;
      }
      $id = $a;
    $my_Update_Statement = $my_Db_Connection->prepare($q);
    $my_Update_Statement->bindParam(':id_usuario', $id);
    $my_Update_Statement->bindParam(':imagen', $img);
    $my_Update_Statement->bindParam(':nombre', $nombres);
    $my_Update_Statement->bindParam(':apellido', $apellidos);
    $my_Update_Statement->execute();
  }

  function cambiarClaveApi($my_Db_Connection, $clave, $clavenueva){
    $clave=md5($clave);
    $clavenueva=md5($clavenueva);
    $q="UPDATE ta_usuarios SET 
      CONTRA= CASE WHEN :contranueva IS NOT NULL THEN :contranueva ELSE CONTRA END 
      WHERE ID_USUARIO = :id_usuario";
    $datos = usuarioActuals();
    foreach($datos as $index => $value){
        $a  = $value;
    }
    $id = $a;
    $my_Update_Statement = $my_Db_Connection->prepare($q);
    $my_Update_Statement->bindParam(':id_usuario', $id);
    $my_Update_Statement->bindParam(':contranueva', $clavenueva);
    $my_Update_Statement->execute();
  }
    function crearTuitApi($my_Db_Connection, $tuit, $estado,$usr){
    $q="INSERT INTO ta_tweets(TWEET, ID_USUARIO, ESTADO) VALUES (:tweet, :id_usuario, :estado)";
    $my_Insert_Statement = $my_Db_Connection->prepare($q);
    $my_Insert_Statement->bindParam(':tweet', $tuit);
    $my_Insert_Statement->bindParam(':id_usuario',$usr);
    $my_Insert_Statement->bindParam(':estado',$estado);
    if ($my_Insert_Statement->execute()) {
    }
    else {
    }
  }

    function leerTuitApi($my_Db_Connection){
    $confirmar = false;
    $q="SELECT t.TWEET, u.USER, T.FECHA_CREACION, T.ESTADO, U.PATHIMAGEN FROM ta_tweets t inner join ta_usuarios u on u.ID_USUARIO=t.ID_USUARIO WHERE T.ESTADO=1 ORDER BY T.FECHA_CREACION DESC";
    $my_Select_Statement = $my_Db_Connection->prepare($q);
    $my_Select_Statement->execute();
    $row = $my_Select_Statement->fetchall();
    return $row;
  }

    function leerTuitPersonalApi($my_Db_Connection,$idusr){
    $q="SELECT t.TWEET, u.USER, T.FECHA_CREACION, T.ESTADO, U.PATHIMAGEN, t.ID_USUARIO, t.ID_TWEET FROM ta_tweets t inner join ta_usuarios u on u.ID_USUARIO=t.ID_USUARIO WHERE t.ID_USUARIO=:id_usuario ORDER BY T.FECHA_CREACION DESC";
    $my_Select_Statement = $my_Db_Connection->prepare($q);
    $my_Select_Statement->bindParam(':id_usuario',$idusr);
    $my_Select_Statement->execute();
    $row = $my_Select_Statement->fetchall();
    return $row;
  }

function enviarMensajeApi($my_Db_Connection, $mensaje, $path, $id_r){
    $q="INSERT INTO ta_mensajes(MENSAJE, PATH_ARCHIVO, ID_USUARIO_E, ID_USUARIO_R, FECHA_ENVIO) VALUES (:mensaje, :path_ar, :id_usuario_e, :id_usuario_r, NOW())";
    $datos = usuarioActuals();
      foreach($datos as $index => $value){
         $a  = $value;
      }
      $id = $a;
    $my_Insert_Statement = $my_Db_Connection->prepare($q);
    $my_Insert_Statement->bindParam(':mensaje', $mensaje);
    $my_Insert_Statement->bindParam(':path_ar', $path);
    $my_Insert_Statement->bindParam(':id_usuario_e', $id);
    $my_Insert_Statement->bindParam(':id_usuario_r',$id_r);
    if ($my_Insert_Statement->execute()) {
      echo 'Si';
      //return TRUE;
    }
    else {
      echo 'no';
      //return FALSE;
    }
}
  function leerMensajesRecibidosApi($my_Db_Connection){
    $q="SELECT m.MENSAJE, m.FECHA_ENVIO, u.USER, u.PATHIMAGEN, m.PATH_ARCHIVO  FROM ta_mensajes m  inner join ta_usuarios u on u.ID_USUARIO = m.ID_USUARIO_E WHERE m.ID_USUARIO_R = (SELECT ID_USUARIO FROM ta_usuarios WHERE USER=:usuario) ORDER BY m.FECHA_ENVIO DESC";
    $my_Select_Statement = $my_Db_Connection->prepare($q);
    $my_Select_Statement->bindParam(':usuario', $_SESSION['name']);
    $my_Select_Statement->execute();
    $row = $my_Select_Statement->fetchall();
    return $row;
      echo '<img weight="80px" height="80px" src="'.$row['PATHIMAGEN'].'">
                <h5>'.$row['USER'].': </h5>
                <p>'.$row['MENSAJE'].'</p>
                <p>'.$row['FECHA_ENVIO'].'</p>
                <p>';
                if ($row['PATH_ARCHIVO']!=null) {
                  echo'<a href="'.$row['PATH_ARCHIVO'].'" download="'.md5(substr($row['PATH_ARCHIVO'],7)).'">'.md5(substr($row['PATH_ARCHIVO'],7)).'</a>';
                  echo "<br><br>";
                } 
  }

    function leerMensajesEnviadosApi($my_Db_Connection){
    $q="SELECT m.MENSAJE, m.FECHA_ENVIO, u.USER, u.PATHIMAGEN, m.PATH_ARCHIVO FROM ta_mensajes m  inner join ta_usuarios u on u.ID_USUARIO = m.ID_USUARIO_R WHERE m.ID_USUARIO_E = (SELECT ID_USUARIO FROM ta_usuarios WHERE USER=:usuario) ORDER BY m.FECHA_ENVIO DESC";
    $my_Select_Statement = $my_Db_Connection->prepare($q);
    $my_Select_Statement->bindParam(':usuario', $_SESSION['name']);
    $my_Select_Statement->execute();
    $row = $my_Select_Statement->fetchall();
    return $row;
  }

  function base64_to_jpeg($base64_string, $output_file) {
        // open the output file for writing
        $ifp = fopen( $output_file, 'wb' ); 

        // split the string on commas
        // $data[ 0 ] == "data:image/png;base64"
        // $data[ 1 ] == <actual base64 string>
        $data = explode( ',', $base64_string );

        // we could add validation here with ensuring count( $data ) > 1
        fwrite( $ifp, base64_decode( $data[ 1 ] ) );

        // clean up the file resource
        fclose( $ifp ); 

        return $output_file; 
    }
?>