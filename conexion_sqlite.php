<?php

// Instancia de PDO para conexion SQLite
// Creacion de base de datos usuarios.db, queda en el mismo directorio
// Base de datos local

$database = new PDO("sqlite:" . __DIR__ . "/usuarios.db");
$database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Definicion de la tabla
$defineTable = "CREATE TABLE IF NOT EXISTS registros(
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        dni TEXT NOT NULL,
        nombre TEXT NOT NULL,
        telefono TEXT NOT NULL,
        email TEXT NOT NULL,
        direccion TEXT NOT NULL,
        dpto TEXT NOT NULL,
        ciudad TEXT NOT NULL,
        fecha_creacion DATE
    );";

$result = $database->exec($defineTable);
echo "Table created successfuly";