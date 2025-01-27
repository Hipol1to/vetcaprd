<?php
require_once('../includes/config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    error_log("-----complete proffile process-----");
    error_log($_POST['cedula_numero']);
    error_log($_FILES['captura_frontal_cedula']);
    error_log($_FILES['captura_trasera_cedula']);
    if (isset($_POST['cedula_numero']) && isset($_FILES['captura_frontal_cedula']) && isset($_FILES['captura_trasera_cedula'])) {
        error_log("la vaca");
        error_log($_FILES['captura_frontal_cedula']);
        error_log($_FILES['captura_trasera_cedula']);
        error_log($_FILES['captura_frontal_cedula']);
        $cedulaNumber = $_POST['cedula_numero'];
        if (
            isset($_FILES['captura_frontal_cedula']) && 
            $_FILES['captura_frontal_cedula']['error'] === UPLOAD_ERR_OK &&
            isset($_FILES['captura_trasera_cedula']) && 
            $_FILES['captura_trasera_cedula']['error'] === UPLOAD_ERR_OK
        ) {
            error_log("muuu");
            error_log($_FILES['captura_frontal_cedula']);
            error_log($_FILES['captura_trasera_cedula']);
            $upload_directory = __DIR__ . "/uploads/";
            $front_file_name = uniqid() . '_front_' . $_FILES['captura_frontal_cedula']['name'];
            $back_file_name = uniqid() . '_back_' . $_FILES['captura_trasera_cedula']['name'];

            move_uploaded_file($_FILES['captura_frontal_cedula']['tmp_name'], $upload_directory . $front_file_name);
            move_uploaded_file($_FILES['captura_trasera_cedula']['tmp_name'], $upload_directory . $back_file_name);
            $front_cedula_path = $upload_directory . $front_file_name;
            $back_cedula_path = $upload_directory . $back_file_name;
        } else {
            // Handle the case where the file uploads failed
            $front_cedula_path = ""; // Set an empty path for front photo
            $back_cedula_path = ""; // Set an empty path for back photo
        }
        try {
            $cedula_path_mixed = $front_cedula_path."_.d1vis10n._".$back_cedula_path;
            error_log($cedula_path_mixed);

              // Prepare SQL statement to insert data into the clientes table
            $queryy = "UPDATE usuarios SET cedula_numero = :cedulaNumber, cedula_ruta = :cedulaPath WHERE usuario = :username";
              $stmt = $db->prepare($queryy);
            
            // Bind parameters
            $stmt->bindParam(':cedulaNumber', $cedulaNumber);
            $stmt->bindParam(':cedulaPath', $cedula_path_mixed);
            $stmt->bindParam(':username', $_SESSION['username']);

            
            error_log("Numero de cedula: " . $cedulaNumber);
            error_log("directorio de cedula: " . $cedula_path_mixed);
            error_log("usuario: " . $_SESSION['username']);
            
            // Execute the statement
            $stmt->execute();
            $_SESSION['cedulaHavePath'] = 1;
            error_log("does cedula have path?: ".$_SESSION['cedulaHavePath']);
            header('Location: http://localhost/vesca/VetCapMembers/index.php?photoUploaded=true');
            exit();
        } catch (PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
    }
}
?>