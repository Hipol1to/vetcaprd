<?php
require_once('../includes/config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $correo_electronico = $_POST['correo_electronico'];
    $usuario = $_POST['usuario'];
    $tipo_documento = $_POST['tipo_documento'];
    $cedula_numero = $_POST['cedula_numero'];
    $pasaporte_numero = $_POST['pasaporte_numero'];
    $cedula_validada = $_POST['cedula_validada'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $tipo_visitante = $_POST['tipo_visitante'];
    $tipo_estudiante = $_POST['tipo_estudiante'];
    $universidad = $_POST['universidad'];
    $suscrito_newsletter = $_POST['suscrito_newsletter'];
    $suscrito_socials = $_POST['suscrito_socials'];
    $rol = $_POST['rol'];
    $activo = $_POST['activo'];

    try {
        // Prepare SQL statement to update the visitor's details
        $query = "UPDATE usuarios SET 
                  nombre = :nombre, 
                  apellido = :apellido, 
                  telefono = :telefono, 
                  correo_electronico = :correo_electronico, 
                  usuario = :usuario, 
                  tipo_documento = :tipo_documento, 
                  cedula_numero = :cedula_numero, 
                  pasaporte_numero = :pasaporte_numero, 
                  cedula_validada = :cedula_validada, 
                  fecha_nacimiento = :fecha_nacimiento, 
                  tipo_visitante = :tipo_visitante, 
                  tipo_estudiante = :tipo_estudiante, 
                  universidad = :universidad, 
                  suscrito_newsletter = :suscrito_newsletter, 
                  suscrito_socials = :suscrito_socials, 
                  rol = :rol, 
                  activo = :activo 
                  WHERE Id = :id";

        $stmt = $db->prepare($query);

        // Bind parameters
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':correo_electronico', $correo_electronico);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->bindParam(':tipo_documento', $tipo_documento);
        $stmt->bindParam(':cedula_numero', $cedula_numero);
        $stmt->bindParam(':pasaporte_numero', $pasaporte_numero);
        $stmt->bindParam(':cedula_validada', $cedula_validada, PDO::PARAM_INT);
        $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);
        $stmt->bindParam(':tipo_visitante', $tipo_visitante);
        $stmt->bindParam(':tipo_estudiante', $tipo_estudiante);
        $stmt->bindParam(':universidad', $universidad);
        $stmt->bindParam(':suscrito_newsletter', $suscrito_newsletter, PDO::PARAM_INT);
        $stmt->bindParam(':suscrito_socials', $suscrito_socials, PDO::PARAM_INT);
        $stmt->bindParam(':rol', $rol);
        $stmt->bindParam(':activo', $activo, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id);

        // Execute the statement
        $stmt->execute();

        // Redirect back to the visitor details page with a success message
        header('Location: detalle_visitante.php?id=' . $id . '&update=success');
        exit();
    } catch (PDOException $e) {
        // Handle database errors
        echo "Error: " . $e->getMessage();
    }
} else {
    // If the form was not submitted via POST, redirect to the visitor list
    header('Location: visitantes.php');
    exit();
}
?>