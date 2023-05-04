<?php

// Incluir la conexión con "include once"
include_once __DIR__ . "/conexion_sqlite.php";

// Configurar la zona horaria
date_default_timezone_set('Europe/Madrid');

// Insertamos datos
if (isset($_POST["btnRegistrarse"])) {

    // Obtener los valores
    $dni = $_POST["dni"];
    $nombre = $_POST["nombre"];
    $telefono = $_POST["telefono"];
    $email = $_POST["email"];
    $direccion = $_POST["direccion"];
    $departamento = $_POST["departamento"];
    $ciudad = $_POST["ciudad"];

    // Validar que los campos no estén vacíos
    if (empty($dni) || empty($nombre) || empty($telefono) || empty($email) || empty($direccion) || empty($departamento) || empty($ciudad)) {
        $error = "Error, algunos campos obligatorios están vacíos";
        header('Location: index.php?error=' . urlencode($error));
    } else {
        // Validar si ya exite dni
        $query = "SELECT * FROM registros WHERE dni = :dni";
        $stmt = $database->prepare($query);
        $stmt->bindParam(":dni", $dni, PDO::PARAM_STR);
        $result = $stmt->execute();

        $registroDni = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($registroDni) {
            $error = "Error, el DNI ya existe";
            header('Location: index.php?error=' . urlencode($error));
        } else {
            // Si entra, es porque el DNI no existe y se puede registrar
            $query = "INSERT INTO registros(dni, nombre, telefono, email, direccion, departamento, ciudad) VALUES(:dni, :nombre, :telefono, :email, :direccion, :departamento, :ciudad)";

            $stmt = $database->prepare($query);

            // Pasar al bindParam las variables, no se puede pasar el dato directamente
            $stmt->bindParam(":dni", $dni, PDO::PARAM_STR);
            $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $stmt->bindParam(":telefono", $telefono, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":direccion", $direccion, PDO::PARAM_STR);
            $stmt->bindParam(":departamento", $departamento, PDO::PARAM_STR);
            $stmt->bindParam(":ciudad", $ciudad, PDO::PARAM_STR);

            $result = $stmt->execute();

            if ($result == true) {
                //  Validad creacion y obtener el ultimo ID que seria el codigo
                $codigoId = $database->lastInsertId();
                $message = "Registry created successfuly";
                header("Location: index.php?message=" . urlencode($message) . '&codigo=' . urlencode($codigoId));
                exit();
            } else {
                // Se genera un error y se lleva al index
                $error = "Error, no se pudo crear el registro";
                header('Location: index.php?error=' . urlencode($error));
                exit();
            }
        }
    }
}