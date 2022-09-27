<?php

      /**
       * Crea y retorna la conexion a la base de datos
       */
      function conexionDB(){
        $servername = "localhost";
        $database = "te";
        $username = "root";
        $password = "123456";

        $sql = "mysql:host=$servername;dbname=$database;";
        $dsn_Options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
        try {
          $my_Db_Connection = new PDO($sql, $username, $password, $dsn_Options);
          return $my_Db_Connection;
        } catch (PDOException $error) {
            echo 'Connection error ' . $error->getMessage();
            return NULL;
        }
      }
      
    function verificarr($my_Db_Connection, $usuario, $clave){
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
  }

   function protegerr(){
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
    session_start();
    session_regenerate_id(true);
  }

   function validarrNombres($nombre){
    $patron="/\A[A-Za-z]+\Z/";
    $validar = false;
    if(preg_match ($patron,$nombre)){
      $validar = true;
    }
    return $validar;
  }

  function validarrContra($pass){
    $patron="/^(?=.*\d)(?=.*[\u0021-\u002b\u003c-\u0040])(?=.*[A-Z])(?=.*[a-z])\S{6,12}$/";
    $validar = false;
    if(preg_match ($patron,$pass)){
      $validar = true;
    }
    return $validar;
  }
?>