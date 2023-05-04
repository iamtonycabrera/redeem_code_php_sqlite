<?php

// Incluir la conexión con "include once"
include_once __DIR__ . "/conexion_sqlite.php";

// Mostrar registros
$query = "SELECT * FROM registros";
$stmt = $database->query($query);

$registros = $stmt->fetchAll(PDO::FETCH_OBJ);

// Mostrarlos en pantalla
var_dump($registros);