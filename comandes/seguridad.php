<?php
include("conexion.php");
error_reporting(E_ERROR | E_PARSE);
header("Content-Type: text/html;charset=utf-8"); 
mysqli_query($link,"SET NAMES 'utf8'");
//error_reporting(E_ALL);

//Inici de sessió
session_start();
//Comprovació que l'usuari està autentificat
if ($_SESSION['autentificado'] != "SI") {
    //si no existeix, es redirigeix pàgina d'autentificació
    $lk=$_SERVER["REQUEST_URI"];
    $in = array("/", "?", "=");
    $out   = array("", ">", "<");
    $lkd = str_replace($in, $out, $lk);
    header("Location: index.php?lkd=".$lkd);
    exit();
}
include ("permis.php");
?>