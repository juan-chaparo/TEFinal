<?php
  require_once('tools.php');
  require_once("../../db/db_tools.php"); 
  extract($_POST);
  if (isset($borrar)) {
    proteger();
    try{
      borrarTuit(conexionDB(),$mensaje);
    }catch(\Throwable $th){
      echo $th;
      return '1';
    }
  }
  if (isset($despublicar)) {
    proteger();
    try{
      ActualizarEstadoTuit(conexionDB(),$mensaje,0);
    }catch(\Throwable $th){
      echo $th;
      return '1';
    }
  }
  if (isset($publicar)) {
    proteger();
    try{
      ActualizarEstadoTuit(conexionDB(),$mensaje,1);
    }catch(\Throwable $th){
      echo $th;
      return '1';
    }
  }
  header("Location:MisArticulos.php");
?>