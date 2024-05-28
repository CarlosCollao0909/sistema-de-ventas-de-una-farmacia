<?php
//definicion de constante de URL
if(!defined('BASE_URL')){
    define('BASE_URL', 'http://localhost/proyFarmacia(pruebas)/');
}

//conexión a la base de datos
$servidor = 'localhost';
$baseDatos = 'db_farmacia';
$usuario = 'root';
$contrasena = '';

$conn = new mysqli($servidor, $usuario, $contrasena, $baseDatos);
if($conn -> connect_error){
    die('error en la conexión a la base de datos' . $conn->connect_error);
}
else{
    //echo 'conexión exitosa a la base de datos';
}
?>