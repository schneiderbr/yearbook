<?php
 function conn_mysql(){

   $servidor = 'br-cdbr-azure-south-a.cloudapp.net';
   $porta = 3306;
   $banco = "appschneiderdb";
   $usuario = "b5dc8119b63ac3";
   $senha = "0f047b48";
   
      $conn = new PDO("mysql:host=$servidor;port=$porta;dbname=$banco",$usuario,$senha,array(PDO::ATTR_PERSISTENT => true));
      return $conn;
   }
?>