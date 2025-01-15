<?php
      require('layout/header.php'); 
       ?>
<section class="call-to-action-section">
  <div class="cta-content">
    <div class="image-container">
      <img src="./assets/img/registrate.png" alt="Animals" class="cta-image" />
    </div>
    <div class="text-container">
      <h1 style="color: #2d4a34;" class="cta-title">Unete a VetCap</h1>
      <p style="color: #2d4a34;" class="cta-quote">
        Unete a una comunidad apasionada por la veterinaria
      </p>
      <a href="#lobo-promo"><button style="color: white;" class="cta-button2">REGISTRARME</button></a>
    </div>
  </div>
</section>


<div id="lobo-promo" class="promo-bar">
  <div class="text-section">
    <div class="logo-info">LOBO CORPORATION | FUNDACIÓN VETCAP</div>
    <div class="collection-title">HIVE <a style="color:white;">& HOWL</a></div>
    <div class="collection-subtitle">COLLECTION</div>
  </div>
  <div class="image-section">
    <img src="./assets/img/vetcap_lobo.png" alt="Cap image">
  </div>
  <div class="hashtag-section">
    <h2>#VETCAPXLOBO</h2>
  </div>
  <div class="button-section">
    <button class="rounded-button">SHOP NOW</button>
  </div>
</div>


<section  class="call-to-action-section">
  <div class="cta-content">
    <div class="text-container">
      <h1  style="color: #2d4a34;" class="cta-title">Regístrate en VetCap</h1>
      <form action="enviar_registro.php" class="registration-form" method="POST" style="display: flex; flex-direction: column; gap: 20px;">
        <!-- Nombre -->
        <label style="color: #2d4a34;">
          Nombre:
          <input type="text" name="nombre" placeholder="Ingrese su nombre" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        </label>

        <!-- Apellido -->
        <label style="color: #2d4a34;">
          Apellido:
          <input type="text" name="apellido" placeholder="Ingrese su apellido" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        </label>

        <!-- Correo Electrónico -->
        <label style="color: #2d4a34;">
          Correo Electrónico:
          <input type="email" name="correo" placeholder="Ingrese su correo electrónico" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        </label>

        <!-- Teléfono -->
        <label style="color: #2d4a34;">
          Teléfono:
          <input type="tel" name="telefono" placeholder="Ingrese su número de teléfono" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        </label>

        <!-- Motivación -->
        <label style="color: #2d4a34;">
          ¿Qué te motiva a unirte a VetCap?
          <select name="motivacion" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
            <option value="" disabled selected>Selecciona una opción</option>
            <option value="estudiante_veterinario">Soy estudiante veterinario</option>
            <option value="solo_visita">Solo estoy de visita</option>
            <option value="profesional_veterinario">Soy veterinario profesional</option>
          </select>
        </label>

        <!-- Etapa de Estudios -->
        <label style="color: #2d4a34;">
          ¿En qué etapa de tus estudios estás?
          <select name="etapa_estudios" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
            <option value="" disabled selected>Selecciona una opción</option>
            <option value="comenzando">He comenzado hace poco</option>
            <option value="mitad_carrera">Estoy a mediados de carrera</option>
            <option value="termino">Soy estudiante de término</option>
          </select>
        </label>

        <!-- Universidad -->
        <label style="color: #2d4a34;">
          ¿En qué universidad estudias?
          <select name="universidad" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
            <option value="" disabled selected>Selecciona una universidad</option>
            <option value="ucateci">Universidad Católica del Cibao</option>
            <option value="unapec">Universidad APEC</option>
            <option value="uasd">Universidad Autónoma de Santo Domingo</option>
            <!-- Add all other universities here -->
          </select>
        </label>

        <!-- Fecha de Nacimiento -->
        <label style="color: #2d4a34;">
          Fecha de Nacimiento:
          <input type="date" name="fecha_nacimiento" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        </label>

        <!-- Contraseña -->
        <label style="color: #2d4a34;">
          Contraseña:
          <input type="password" name="contraseña" placeholder="Ingrese su contraseña" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        </label>

        <!-- Confirmar Contraseña -->
        <label style="color: #2d4a34;">
          Confirmar Contraseña:
          <input type="password" name="confirmar_contraseña" placeholder="Confirme su contraseña" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        </label>

        <!-- Botón -->
        <button type="submit" style="background-color: #2d4a34; color: white; padding: 15px; border: none; border-radius: 5px; font-size: 16px;">
          REGISTRARME
        </button>
      </form>
    </div>
  </div>
</section>


<?php 
//include header template
require('layout/footer.php'); 
?>