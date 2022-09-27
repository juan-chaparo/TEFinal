<?php
  extract($_POST);
  if(isset($tuit)){
    require_once("tools.php");
    require_once("../../db/db_tools.php");
    proteger();
    if ($publico==NULL) {
      $publico=0;
    }
    $tuit.=" ";
    if (validarArticulo($tuit)) {
      crearTuit(conexionDB(),$tuit,$publico);
    }
    header("Location: MisArticulos.php");
  }
?>