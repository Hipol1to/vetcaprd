<?php
require_once('../includes/config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    write_log("-----complete proffile process-----");
    write_log($_POST['cedula_numero']);
    write_log(print_r($_FILES['captura_frontal_cedula'], true));
    write_log($_FILES['captura_trasera_cedula'], true);

    if (isset($_POST['cedula_numero']) && isset($_FILES['captura_frontal_cedula']) && isset($_FILES['captura_trasera_cedula'])) {
        write_log("la vaca");
        write_log(print_r($_FILES['captura_frontal_cedula'], true));
        write_log($_FILES['captura_trasera_cedula'], true);

        $cedulaNumber = $_POST['cedula_numero'];

        if (
            isset($_FILES['captura_frontal_cedula']) && 
            $_FILES['captura_frontal_cedula']['error'] === UPLOAD_ERR_OK &&
            isset($_FILES['captura_trasera_cedula']) && 
            $_FILES['captura_trasera_cedula']['error'] === UPLOAD_ERR_OK
        ) {
            write_log("muuu");
            write_log(print_r($_FILES['captura_frontal_cedula'], true));
            write_log($_FILES['captura_trasera_cedula'], true);

            // Define the upload directory relative to the web root
            $upload_directory = __DIR__ . "/uploads/"; // Server-side directory
            $web_upload_directory = "/VetCapMembers/uploads/"; // Web-accessible directory

            // Generate unique file names
            $front_file_name = uniqid() . '_front_' . $_FILES['captura_frontal_cedula']['name'];
            $back_file_name = uniqid() . '_back_' . $_FILES['captura_trasera_cedula']['name'];

            // Move uploaded files to the server-side directory
            move_uploaded_file($_FILES['captura_frontal_cedula']['tmp_name'], $upload_directory . $front_file_name);
            move_uploaded_file($_FILES['captura_trasera_cedula']['tmp_name'], $upload_directory . $back_file_name);

            // Construct relative paths for the database
            $front_cedula_path = $web_upload_directory . $front_file_name;
            $back_cedula_path = $web_upload_directory . $back_file_name;
        } else {
            // Handle the case where the file uploads failed
            $front_cedula_path = ""; // Set an empty path for front photo
            $back_cedula_path = ""; // Set an empty path for back photo
        }

        try {
            // Combine paths with the delimiter
            $cedula_path_mixed = $front_cedula_path . "_.d1vis10n._" . $back_cedula_path;
            write_log($cedula_path_mixed);

            // Prepare SQL statement to update the usuarios table
            $queryy = "UPDATE usuarios SET cedula_numero = :cedulaNumber, cedula_ruta = :cedulaPath, cedula_validada = 2 WHERE usuario = :username";
            $stmt = $db->prepare($queryy);

            // Bind parameters
            $stmt->bindParam(':cedulaNumber', $cedulaNumber);
            $stmt->bindParam(':cedulaPath', $cedula_path_mixed);
            $stmt->bindParam(':username', $_SESSION['username']);

            write_log("Numero de cedula: " . $cedulaNumber);
            write_log("directorio de cedula: " . $cedula_path_mixed);
            write_log("usuario: " . $_SESSION['username']);

            // Execute the statement
            $stmt->execute();
            $_SESSION['cedulaHavePath'] = 1;
            write_log("does cedula have path?: " . $_SESSION['cedulaHavePath']);

            // Redirect to the index page
            header('Location: https://www.vetcaprd.com///VetCapMembers/index.php?photoUploaded=true');
            exit();
        } catch (PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
    }
}
?>