<?php
// Include the database connection
require_once 'includes/config.php';

// Process form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve and sanitize form inputs
    $nombre = $conn->real_escape_string($_POST["nombre"]);
    $apellido = $conn->real_escape_string($_POST["apellido"]);
    $correo = $conn->real_escape_string($_POST["correo"]);
    $telefono = $conn->real_escape_string($_POST["telefono"]);
    $motivacion = $conn->real_escape_string($_POST["motivacion"]);
    $etapa_estudios = $conn->real_escape_string($_POST["etapa_estudios"]);
    $universidad = $conn->real_escape_string($_POST["universidad"]);
    $fecha_nacimiento = $conn->real_escape_string($_POST["fecha_nacimiento"]);
    $contraseña = password_hash($_POST["contraseña"], PASSWORD_DEFAULT); // Hash password for security

    // Prepare an SQL statement to insert data
    $sql = "INSERT INTO users (nombre, apellido, correo, telefono, motivacion, etapa_estudios, universidad, fecha_nacimiento, contraseña) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param(
            "sssssssss", 
            $nombre, 
            $apellido, 
            $correo, 
            $telefono, 
            $motivacion, 
            $etapa_estudios, 
            $universidad, 
            $fecha_nacimiento, 
            $contraseña
        );

        // Execute the query
        if ($stmt->execute()) {
            echo "Data inserted successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
