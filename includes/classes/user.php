<?php

class User 
{
	private $_db;
	private $_ignoreCase;

	function __construct($db)
	{
		$this->_db = $db;
		$this->_ignoreCase = false;
	}
	
	public function setIgnoreCase($sensitive) {
		$this->_ignoreCase = $sensitive;
	}

	public function getIgnoreCase() {
		return $this->_ignoreCase;
	}

	private function get_user_hash($username)
	{
		try {
			if ($this->_ignoreCase) {
				$stmt = $this->_db->prepare('SELECT Id, nombre, activo, correo_electronico, usuario, contrasena, tipo_documento, cedula_validada, pasaporte_validado, puntos, rol from usuarios WHERE LOWER(usuario) = LOWER(:usuario) AND activo="1" ');
			} else {
				$stmt = $this->_db->prepare('SELECT Id, nombre, activo, correo_electronico, usuario, contrasena, tipo_documento, cedula_validada, pasaporte_validado, puntos, rol FROM usuarios WHERE usuario = :usuario AND activo="1" ');
			}
			$stmt->execute(array('usuario' => $username));

			return $stmt->fetch();

		} catch(PDOException $e) {
			echo '<p class="bg-danger">'.$e->getMessage().'</p>';
		}
	}

	private function get_cedula_validated($username)
	{
		try {
			if ($this->_ignoreCase) {
				$stmt = $this->_db->prepare('SELECT cedula_validada from usuarios WHERE LOWER(usuario) = LOWER(:usuario) AND activo="1" ');
			} else {
				$stmt = $this->_db->prepare('SELECT cedula_validada FROM usuarios WHERE usuario = :usuario AND activo="1" ');
			}
			$stmt->execute(array('usuario' => $username));

			return $stmt->fetch();

		} catch(PDOException $e) {
			echo '<p class="bg-danger">'.$e->getMessage().'</p>';
		}
	}

	private function get_cedula_path($username)
	{
		try {
			if ($this->_ignoreCase) {
				$stmt = $this->_db->prepare('SELECT cedula_ruta, cedula_validada from usuarios WHERE LOWER(usuario) = LOWER(:usuario) AND activo="1" ');
			} else {
				$stmt = $this->_db->prepare('SELECT cedula_ruta, cedula_validada FROM usuarios WHERE usuario = :usuario AND activo="1" ');
			}
			$stmt->execute(array('usuario' => $username));

			return $stmt->fetch();

		} catch(PDOException $e) {
			echo '<p class="bg-danger">'.$e->getMessage().'</p>';
		}
	}

	public function isUserCedulaUploaded($username)
	{
		$row = $this->get_cedula_path($username);
		write_log("peroviejo".$row['cedula_validada']);
		write_log(!isset($row['cedula_validada']));

		if (isset($row['cedula_ruta']) && $row['cedula_ruta'] != null && $row['cedula_ruta'] != "" && $row['cedula_validada'] == 1 ||
			isset($row['cedula_ruta']) && $row['cedula_ruta'] != null && $row['cedula_ruta'] != "" && $row['cedula_validada'] == 2 ||
			isset($row['cedula_ruta']) && $row['cedula_ruta'] != null && $row['cedula_ruta'] != "" && $row['cedula_validada'] == 3) {
			write_log("sissss");
			return true;
		} else {
			write_log("nonnnn");
			return false;
		}

		
	}

	public function isUserCedulaValidated($username)
	{
		$row = $this->get_cedula_validated($username);

		if ($row['cedula_validada'] == 1) {
			return true;
		} else {
			return false;
		}

		
	}

	public function isUserCedulaInvalid($username)
	{
		$row = $this->get_cedula_validated($username);

		if ($row['cedula_validada'] == 3) {
			return true;
		} else {
			return false;
		}

		
	}
	public function isUserCedulaWaitingForValidation($username)
	{
		$row = $this->get_cedula_validated($username);

		if ($row['cedula_validada'] == 2) {
			write_log("do");
			return true;
		} else {
			write_log("no e do");
			return false;
		}

		
	}

	public function isValidUsername($username)
	{
		if (strlen($username) < 3) {
			return false;
		}

		if (strlen($username) > 17) {
			return false;
		}

		if (! ctype_alnum($username)) {
			return false;
		}

		return true;
	}

	public function login($username, $password)
	{
		if (! $this->isValidUsername($username)) {
			return false;
		}

		if (strlen($password) < 3) {
			return false;
		}

		$row = $this->get_user_hash($username);

		if (password_verify($password, $row['contrasena'])) {

			$_SESSION['loggedin'] = true;
			$_SESSION['username'] = $row['usuario'];
			$_SESSION['name'] = $row['nombre'];
			$_SESSION['memberID'] = $row['Id'];
			$_SESSION['rol'] = $row['rol'];
			$_SESSION['cedulaValidated'] = $row['cedula_validada'];
			$_SESSION['passportValidated'] = $row['pasaporte_validado'];
      $_SESSION['eventsRegistered'] = $row['eventsRegistered'];
      $jsonString = $_SESSION['eventsRegistered'];
      $datas = json_decode($jsonString, true); // Convert JSON to PHP associative array

      $eventIdsArray = explode(',', $eventIds);
$placeholders = rtrim(str_repeat('?,', count($eventIdsArray)), ',');
$eventsQueryResult = $this->_db->prepare("SELECT Id, nombre, descripcion, foto_evento, precio_inscripcion, fecha_evento FROM `eventos` WHERE Id IN ($placeholders)");
$eventsQueryResult->execute($eventIdsArray);


      $data = $eventsQueryResult->fetchAll(PDO::FETCH_ASSOC);

      $_SESSION['eventsQueryResult'] = $data;
		    
			return true;
		}
		return false;
	}

	public function logout()
	{
		session_destroy();
	}

	public function is_logged_in()
	{
		if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
			return true;
		}
	}

}
