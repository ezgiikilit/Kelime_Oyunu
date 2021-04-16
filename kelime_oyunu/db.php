<?php 
session_start();
ob_start();
try{
    $db = new PDO("mysql:host=localhost;dbname=kelimeoyunu;charset=utf8;","root","859601ev");
}catch(PDOException $e){
    die("MySQL Error : ". $e->getMessage());
}