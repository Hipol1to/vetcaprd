<?php 
require_once('../includes/config.php');

//if not logged in redirect to login page
if (! $user->is_logged_in()){
    header('Location: login.php'); 
    //exit(); 
}

//define page title
$title = 'VetCap Usuarios';

//include header template
require('layout/header.php'); 
?>
<p><a style="text-decoration: unset !important;font-weight: 550 !important;" href="logout.php">Cerrar sesión</a></p></a>
<section class="events-button-section" style="text-align: center; margin-top: 40px;">
<h2 style="font-size: 70px; font-family: HelveticaBold; text-align: center; color: #2d4a34; margin-bottom: 0%;">Bienvenido/a <?php echo htmlspecialchars($_SESSION['name']) ?></h2>
  <button 
    id="view-events-button" 
    style="padding: 10px 20px; font-size: 16px; background-color: #2d4a34; color: white; border: none; border-radius: 5px; cursor: pointer;"
    onclick="openModal()">
    Ver Eventos
  </button>
</section>

<!-- Modal -->
<div id="events-modal" class="modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.7); justify-content: center; align-items: center; z-index: 9999;">
  <div class="modal-content" style="background: white; padding: 20px; border-radius: 8px; max-width: 90%; max-height: 90%; overflow-y: auto; position: relative;">
    <span 
      onclick="closeModal()" 
      style="position: absolute; top: 10px; right: 20px; font-size: 24px; cursor: pointer; color: #555;">
      &times;
    </span>
    <h2 style="color: #2d4a34; text-align: center; margin-bottom: 20px;">Eventos Suscritos</h2>
    
    <!-- Events List -->
    <div class="events-list">
      <!-- Event Container (Repeat this block for each event) -->
      <div class="event-container" style="display: flex; flex-direction: row; align-items: start; gap: 20px; margin-bottom: 20px;">
        <div class="event-image-container" style="flex: 1; max-width: 150px;">
          <img 
            src="./assets/img/event-photo.jpg" 
            alt="Event Photo" 
            style="width: 100%; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
          />
        </div>
        <div class="event-details-container" style="flex: 3;">
          <h2 class="event-title" style="color: #2d4a34; font-size: 1.5rem; margin-bottom: 10px;">Nombre del Evento</h2>
          <p class="event-description" style="color: #555; font-size: 1rem; margin-bottom: 10px;">
            Breve descripción del evento.
          </p>
          <p class="event-price" style="color: #007BFF; font-size: 1rem; font-weight: bold;">Precio de Suscripción: $50.00</p>
          <p class="event-date" style="color: #555; font-size: 1rem;">Fecha y Hora: 2025-02-10, 18:00 hrs</p>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function openModal() {
    document.getElementById('events-modal').style.display = 'flex';
  }

  function closeModal() {
    document.getElementById('events-modal').style.display = 'none';
  }
</script>





      <?php 
//include header template
require('layout/footer.php'); 
?>