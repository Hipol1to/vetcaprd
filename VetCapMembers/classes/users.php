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
				$stmt = $this->_db->prepare('SELECT nombre, activo, correo_electronico, usuario, contraseña, tipo_documento, cedula_validada, eventos_registrados, pasaporte_validado, puntos, rol from usuarios WHERE LOWER(usuario) = LOWER(:usuario) AND active="1" ');
			} else {
				$stmt = $this->_db->prepare('SELECT nombre, activo, correo_electronico, usuario, contraseña, tipo_documento, cedula_validada, eventos_registrados, pasaporte_validado, puntos, rol FROM usuarios WHERE usuario = :usuario AND active="1" ');
			}
			$stmt->execute(array('usuario' => $username));

			return $stmt->fetch();

		} catch(PDOException $e) {
			echo '<p class="bg-danger">'.$e->getMessage().'</p>';
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

		if (password_verify($password, $row['contraseña'])) {

			$_SESSION['loggedin'] = true;
			$_SESSION['username'] = $row['usuario'];
			$_SESSION['memberID'] = $row['Id'];
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
