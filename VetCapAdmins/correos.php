<?php
// Include header template
require_once('../includes/config.php');
require('layout/header.php'); 
?>
<script src="https://cdn.tiny.cloud/1/qwy0iakijn65n26ksmjygx7cs4wutio4tqiy0z8viy4skn6b/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

<div class="body flex-grow-1">
    <div class="container-lg px-4">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Correos</h1>
            </div>
            <div class="col-sm-6 text-end">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearCorreoModal">Nuevo mensaje</button>
            </div>
        </div>

        <!-- Tab Navigation -->
        <ul class="nav nav-tabs" id="emailTabs" role="tablist">
            <li class="nav-item"><button class="nav-link active" id="correos-tab" data-bs-toggle="tab" data-bs-target="#correos">Correos</button></li>
            <li class="nav-item"><button class="nav-link" id="contenedores-tab" data-bs-toggle="tab" data-bs-target="#contenedores">Listas de direcciones</button></li>
            <li class="nav-item"><button class="nav-link" id="direcciones-tab" data-bs-toggle="tab" data-bs-target="#direcciones">Direcciones registradas</button></li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content mt-3" id="emailTabsContent">
            <!-- Correos Tab -->
            <div class="tab-pane fade show active" id="correos">
    <?php
    $query = "SELECT Id, titulo, mensaje, remitente, destinatario, image_paths FROM emails";
    $stmt = $db->prepare($query);
    $stmt->execute();
    ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Título</th>
                <th>Mensaje</th>
                <th>Remitente</th>
                <th>Destinatario</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $mensaje = $row['mensaje'];
                    $imagePaths = json_decode($row['image_paths'], true);
                
                    if ($imagePaths) {
                        foreach ($imagePaths as $cid => $path) {
                            $mensaje = str_replace('src="cid:' . $cid . '"', 'src="' . $path . '"', $mensaje);
                        }
                    }
                
                    echo "<tr>
                            <td>" . htmlspecialchars($row['titulo']) . "</td>
                            <td><button class='btn btn-info btn-sm' data-bs-toggle='modal' data-bs-target='#mensajeModal' data-mensaje='" . htmlspecialchars($mensaje) . "'>Ver Mensaje</button></td>
                            <td>" . htmlspecialchars($row['remitente']) . "</td>
                            <td>" . htmlspecialchars($row['destinatario']) . "</td>
                            <td>
                                <button class='btn btn-danger eliminar-mensaje' data-id='{$row['Id']}'>Eliminar</button>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No hay correos registrados</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".eliminar-mensaje").forEach(button => {
        button.addEventListener("click", function () {
            const mensajeId = this.getAttribute("data-id");
            const row = this.closest("tr");

            if (confirm("¿Estás seguro de que deseas eliminar este mensaje?")) {
                fetch(`eliminar_mensaje.php?id=${mensajeId}`)
                    .then(response => response.text())
                    .then(data => {
                        if (data === "Mensaje eliminado correctamente") {
                            row.remove();
                            alert("Mensaje eliminado correctamente.");
                        } else {
                            alert("Error al eliminar el mensaje.");
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        alert("Error al eliminar el mensaje.");
                    });
            }
        });
    });
});
</script>

<!-- Modal for Displaying Message -->
<div class="modal fade" id="mensajeModal" tabindex="-1" aria-labelledby="mensajeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mensajeModalLabel">Mensaje</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="modalMensajeContent">
                <!-- The HTML message will be rendered here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Add event listener to all "Ver Mensaje" buttons
    document.querySelectorAll("[data-bs-target='#mensajeModal']").forEach(button => {
        button.addEventListener("click", function () {
            // Get the HTML message from the data-mensaje attribute
            const mensaje = this.getAttribute("data-mensaje");

            // Set the modal content
            document.getElementById("modalMensajeContent").innerHTML = mensaje;
        });
    });
});
</script>

            <!-- Contenedores Tab -->
            <div class="tab-pane fade" id="contenedores">
                <div class="text-end mb-2">
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#crearContenedorModal">Agregar nueva lista</button>
                </div>

                <?php
                $query = "SELECT HEX(id) AS id, nombre_lista, descripcion FROM lista_direcciones_email";
                $stmt = $db->prepare($query);
                $stmt->execute();
                ?>

                <table class="table table-striped">
                    <thead>
                        <tr><th>Nombre de Lista</th><th>Descripción</th><th>Acciones</th></tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($stmt->rowCount() > 0) {
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>
                                        <td>" . htmlspecialchars($row['nombre_lista']) . "</td>
                                        <td>" . htmlspecialchars($row['descripcion']) . "</td>
                                        <td>
                                            <button class='btn btn-warning btn-editar editar-lista' data-id='{$row['id']}' data-bs-toggle='modal' data-bs-target='#editarContenedorModal'>Editar</button>
                                            <button class='btn btn-danger btn-eliminar eliminar-lista' data-id='{$row['id']}'>Eliminar</button>
                                        </td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3'>No hay listas registradas</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".eliminar-lista").forEach(button => {
        button.addEventListener("click", function () {
            const listaId = this.getAttribute("data-id");
            const row = this.closest("tr");

            if (confirm("¿Estás seguro de que deseas eliminar esta lista?")) {
                fetch(`eliminar_lista.php?id=${listaId}`)
                    .then(response => response.text())
                    .then(data => {
                        if (data === "Evento eliminado correctamente") {
                            row.remove();
                            alert("Lista eliminada correctamente.");
                        } else {
                            alert("Error al eliminar la lista.");
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        alert("Error al eliminar la lista.");
                    });
            }
        });
    });
});
</script>


            <!-- Modal: Editar Lista -->
<div class="modal fade" id="editarContenedorModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar lista</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editarContenedorForm">
                    <input type="hidden" name="lista_id" id="edit-lista-id">
                    <div class="mb-3">
                        <label class="form-label">Nombre de Lista</label>
                        <input type="text" class="form-control" name="nombre_lista" id="edit-nombre-lista" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea class="form-control" name="descripcion" id="edit-descripcion"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Direcciones de Email</label>
                        <div id="edit-emailsContainer"></div>
                        <button type="button" class="btn btn-success mt-2" id="add-edit-email">Añadir Correo</button>
                    </div>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".editar-lista").forEach(button => {
        button.addEventListener("click", function () {
            let listaId = this.getAttribute("data-id");

            fetch("fetch_lista.php?lista_id=" + listaId)
                .then(response => response.json())
                .then(data => {
                    document.getElementById("edit-lista-id").value = data.lista_id;
                    document.getElementById("edit-nombre-lista").value = data.nombre_lista;
                    document.getElementById("edit-descripcion").value = data.descripcion;

                    let emailsContainer = document.getElementById("edit-emailsContainer");
                    emailsContainer.innerHTML = ""; // Clear previous emails

                    data.emails.forEach(email => {
                        let div = document.createElement("div");
                        div.classList.add("input-group", "mb-2");

                        let input = document.createElement("input");
                        input.type = "email";
                        input.classList.add("form-control");
                        input.name = "emails[]";
                        input.value = email;
                        input.required = true;

                        let button = document.createElement("button");
                        button.type = "button";
                        button.classList.add("btn", "btn-danger");
                        button.innerText = "X";
                        button.addEventListener("click", function () {
                            div.remove();
                        });

                        div.appendChild(input);
                        div.appendChild(button);
                        emailsContainer.appendChild(div);
                    });
                });
        });
    });

    document.getElementById("add-edit-email").addEventListener("click", function () {
        let div = document.createElement("div");
        div.classList.add("input-group", "mb-2");

        let input = document.createElement("input");
        input.type = "email";
        input.classList.add("form-control");
        input.name = "emails[]";
        input.required = true;

        let button = document.createElement("button");
        button.type = "button";
        button.classList.add("btn", "btn-danger");
        button.innerText = "X";
        button.addEventListener("click", function () {
            div.remove();
        });

        div.appendChild(input);
        div.appendChild(button);
        document.getElementById("edit-emailsContainer").appendChild(div);
    });
});

document.getElementById("editarContenedorForm").addEventListener("submit", function (e) {
    e.preventDefault(); // Prevent the form from submitting the traditional way

    let formData = new FormData(this);

    fetch('actualizar_lista.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            if(confirm(data.message)) {
                  location.reload(true);
                } else {
                  location.reload(true);
                }
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al actualizar la lista.');
    });
});


</script>







<!-- Direcciones Registradas Tab -->
<div class="tab-pane fade" id="direcciones">
    <div class="text-end mb-2">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addEmailModal">Añadir Correo Electrónico</button>
    </div>

    <?php
    $query = "SELECT HEX(id) AS id, email FROM direcciones_email";
    $stmt = $db->prepare($query);
    $stmt->execute();
    ?>
    <table class="table table-striped">
        <thead><tr><th>Email</th><th>Acciones</th></tr></thead>
        <tbody>
            <?php
            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr><td>" . htmlspecialchars($row['email']) . "</td>
                            <td>
                                <button class='btn btn-warning btn-editar editar-email' data-id='{$row['id']}' data-bs-toggle='modal' data-bs-target='#editarSingleEmailModal'>Editar</button>
                                <button class='btn btn-danger btn-eliminar borrar-email' data-id='{$row['id']}'>Eliminar</button>
                            </td>
                        </tr>";
                }
            } else echo "<tr><td colspan='2'>No hay direcciones registradas</td></tr>";
            ?>
        </tbody>
    </table>
</div>
 <!-- Modal: Editar Lista -->
 <div class="modal fade" id="editarSingleEmailModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar correo electrónico</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editarEmailForm">
                    <input type="hidden" name="email_id" id="edit-email-id">
                    <div class="mb-3">
                        <label class="form-label">Correo electrónico</label>
                        <input type="text" class="form-control" name="correo_electronico" id="edit-correo-electronico" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".editar-email").forEach(button => {
        button.addEventListener("click", function () {
            let emailId = this.getAttribute("data-id");

            fetch("fetch_direcciones.php?email_id=" + emailId)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    
                    document.getElementById("edit-email-id").value = data.id;
                    document.getElementById("edit-correo-electronico").value = data.email;
                });
        });
    });
});

document.getElementById("editarEmailForm").addEventListener("submit", function (e) {
    e.preventDefault(); // Prevent the form from submitting the traditional way

    let formData = new FormData(this);

    fetch('actualizar_direccion.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            if(confirm(data.message)) {
                  location.reload(true);
                } else {
                  location.reload(true);
                }
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al actualizar la lista.');
    });
});


document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".borrar-email").forEach(button => {
        button.addEventListener("click", function () {
            const emailId = this.getAttribute("data-id");
            const row = this.closest("tr");

            if (confirm("¿Estás seguro de que deseas eliminar esta direccion de correo?")) {
                fetch(`eliminar_direccion.php?emailId=${emailId}`)
                    .then(response => response.text())
                    .then(data => {
                        if (data === "Correo electrónico eliminado correctamente") {
                            row.remove();
                            alert("Correo electrónico eliminada correctamente.");
                        } else {
                            alert("Error al eliminar la dirección de correo electrónico.");
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        alert("Error al eliminar la lista.");
                    });
            }
        });
    });
});

</script>



<!-- Modal: Añadir Correo Electrónico -->
<div class="modal fade" id="addEmailModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Añadir Correo Electrónico</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addEmailForm">
                    <div class="mb-3">
                        <label class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Handle form submission (AJAX to save email)
    document.querySelector("#addEmailForm").addEventListener("submit", function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        fetch("registrar_direccion.php", {
            method: "POST",
            body: formData
        }).then(response => response.text()).then(result => {
            alert(result);
            location.reload();
        });
    });
});
</script>

<!-- Modal: Crear Contenedor -->
<div class="modal fade" id="crearContenedorModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Crear lista</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="crearContenedorForm">
                    <div class="mb-3">
                        <label class="form-label">Nombre de Lista</label>
                        <input type="text" class="form-control" name="nombre_lista" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea class="form-control" name="descripcion"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Direcciones de Email</label>
                        <div id="emailsContainer">
                            <div class="input-group mb-2">
                                <input type="email" class="form-control" name="emails[]" required>
                                <button type="button" class="btn btn-success add-email">+</button>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Add new email input field
    document.querySelector("#emailsContainer").addEventListener("click", function(e) {
        if (e.target.classList.contains("add-email")) {
            const newInputGroup = document.createElement("div");
            newInputGroup.classList.add("input-group", "mb-2");
            newInputGroup.innerHTML = `
                <input type="email" class="form-control" name="emails[]" required>
                <button type="button" class="btn btn-danger remove-email">-</button>
            `;
            e.target.closest("#emailsContainer").appendChild(newInputGroup);
        }
    });

    // Remove an email input field
    document.querySelector("#emailsContainer").addEventListener("click", function(e) {
        if (e.target.classList.contains("remove-email")) {
            e.target.closest(".input-group").remove();
        }
    });

    // Handle form submission (AJAX for better UX)
    document.querySelector("#crearContenedorForm").addEventListener("submit", function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        fetch("registrar_lista.php", {
            method: "POST",
            body: formData
        }).then(response => response.text()).then(result => {
            alert(result);
            location.reload();
        });
    });
});
</script>





<!-- Create Email Modal -->
<div class="modal fade" id="crearCorreoModal" tabindex="-1" aria-labelledby="crearCorreoLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="crearCorreoLabel">Enviar a Lista</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form id="crearCorreoForm" action="enviar_correo.php" method="POST" enctype="multipart/form-data">
                    <!-- Autocomplete Search for Email List -->
                    <div class="mb-3">
                        <label for="emailLista" class="form-label">Lista de Direcciones</label>
                        <input type="text" class="form-control" id="emailLista" name="emailLista" placeholder="Buscar lista..." required>
                        <input type="hidden" id="listaId" name="listaId"> <!-- Hidden field for ID -->
                        <!-- Dropdown for all lists -->
                        <div id="listDropdown" class="list-group" style="max-height: 200px; overflow-y: auto; display: none;"></div>
                    </div>

                    <div class="mb-3">
                        <label for="emailTitulo" class="form-label">Título</label>
                        <input type="text" class="form-control" id="emailTitulo" name="emailTitulo" required>
                    </div>
                    <div class="mb-3">
                        <label for="emailMensaje" class="form-label">Mensaje</label>
                        <textarea class="form-control" id="emailMensaje" name="emailMensaje"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="emailAdjunto" class="form-label">Adjunto</label>
                        <input type="file" class="form-control" id="emailAdjunto" name="emailAdjunto">
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- JavaScript -->
<script>
$(document).ready(function() {
    console.log("Document ready!");

    // Fetch all lists on page load
    fetchAllLists();

    // Function to fetch all lists
    function fetchAllLists() {
        console.log("Fetching all lists...");
        $.ajax({
            url: "buscar_listas.php",
            method: "POST",
            data: { query: "" }, // Empty query to fetch all lists
            dataType: "json", // Ensure the response is parsed as JSON
            success: function(data) {
                console.log("Lists fetched:", data);
                populateDropdown(data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("AJAX Error:", textStatus, errorThrown);
            }
        });
    }

    // Function to populate the dropdown with lists
    function populateDropdown(suggestions) {
        console.log("Populating dropdown with:", suggestions);
        var dropdown = "<ul class='list-group'>";
        suggestions.forEach(function(item) {
            dropdown += `<li class='list-group-item list-item' data-id='${item.id}'>${item.nombre_lista}</li>`;
        });
        dropdown += "</ul>";
        $("#listDropdown").html(dropdown).show();
    }

    // Filter lists as the user types
    $("#emailLista").on("input", function() {
        var query = $(this).val().toLowerCase();
        console.log("User typed:", query);

        if (query === "") {
            // If the input is empty, fetch all lists
            fetchAllLists();
        } else {
            // Filter the existing lists
            var filteredLists = [];
            $(".list-item").each(function() {
                var listName = $(this).text().toLowerCase();
                if (listName.includes(query)) {
                    filteredLists.push({
                        id: $(this).attr("data-id"),
                        nombre_lista: $(this).text()
                    });
                }
            });

            console.log("Filtered lists:", filteredLists);
            populateDropdown(filteredLists);
        }
    });

    // Handle click on dropdown items
    $(document).on("click", ".list-item", function() {
        console.log("List item clicked:", $(this).text());
        $("#emailLista").val($(this).text());
        $("#listaId").val($(this).attr("data-id"));
        $("#listDropdown").hide();
    });

    // Close dropdown when clicking outside
    $(document).click(function(e) {
        if (!$(e.target).closest("#listDropdown, #emailLista").length) {
            console.log("Clicked outside, hiding dropdown.");
            $("#listDropdown").hide();
        }
    });

    // Show dropdown when input is focused
    $("#emailLista").on("focus", function() {
        console.log("Input focused, showing dropdown.");
        $("#listDropdown").show();
    });
});
</script>




<script>
    tinymce.init({
  selector: '#emailMensaje',
  height: 400,
  menubar: true,
  toolbar: 'undo redo | formatselect | fontselect fontsizeselect | bold italic underline strikethrough | forecolor backcolor removeformat | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media table | superscript subscript charmap emoticons | hr pagebreak | code fullscreen preview print',
  plugins: 'advlist autolink lists link image charmap preview anchor pagebreak searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking save table directionality emoticons help',
  content_style: "body { font-family:Arial, sans-serif; font-size:14px }",
  language: 'es', // Spanish
  branding: false,
  resize: true,

  // Enable image uploads
  images_upload_url: '/vesca/VetCapAdmins/subir_adjuntos.php',  // Change to your backend upload URL
  automatic_uploads: true,
  file_picker_types: 'image file media',

  // Enable file picking
  file_picker_callback: function (callback, value, meta) {
    var input = document.createElement('input');
    input.setAttribute('type', 'file');
    if (meta.filetype === 'image') {
      input.setAttribute('accept', 'image/*');
    } else if (meta.filetype === 'media') {
      input.setAttribute('accept', 'video/*,audio/*');
    }
    input.onchange = function () {
      var file = this.files[0];
      var reader = new FileReader();
      reader.onload = function () {
        callback(reader.result, { alt: file.name });
      };
      reader.readAsDataURL(file);
    };
    input.click();
  }
});

</script>



<!-- Edit Email Modal -->
<div class="modal fade" id="editEmailModal" tabindex="-1" aria-labelledby="editEmailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEmailModalLabel">Editar Correo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form id="editEmailForm">
                    <input type="hidden" id="emailId">
                    <div class="mb-3">
                        <label for="emailTitle" class="form-label">Título</label>
                        <input type="text" id="emailTitle" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="emailMessage" class="form-label">Mensaje</label>
                        <textarea id="emailMessage" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="emailSender" class="form-label">Remitente</label>
                        <input type="text" id="emailSender" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="emailReceiver" class="form-label">Destinatario</label>
                        <input type="text" id="emailReceiver" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function editarCorreo(emailId) {
    fetch("fetch_correo.php?id=" + emailId)
        .then(response => response.json())
        .then(data => {
            document.getElementById("emailId").value = data.Id;
            document.getElementById("emailTitle").value = data.titulo;
            document.getElementById("emailMessage").value = data.mensaje;
            document.getElementById("emailSender").value = data.remitente;
            document.getElementById("emailReceiver").value = data.destinatario;
            $("#editEmailModal").modal("show");
        });
}

function eliminarCorreo(emailId) {
    if (confirm("¿Estás seguro de que quieres eliminar este correo?")) {
        fetch("eliminar_correo.php?id=" + emailId, { method: "GET" })
            .then(response => response.text())
            .then(data => {
                alert(data);
                location.reload();
            });
    }
}
</script>
<script>
      let theEventosTable = document.getElementById("emailsTable");
      let getStoredThemee = () => localStorage.getItem('coreui-free-bootstrap-admin-template-theme');
      if (theEventosTable && theEventosTable.classList) {
        if (window.matchMedia('(prefers-color-scheme: '+getStoredThemee()+')').matches) {
            if(!theEventosTable.classList.contains('table-dark')) {
              theEventosTable.classList.add('table-dark');
            }
          } else {
            if(theEventosTable.classList.contains('table-dark')) {
              theEventosTable.classList.remove('table-dark');
            }
            }
      }

      const isDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
      const table = document.getElementById('emailsTable');
          
      if (theEventosTable && theEventosTable.classList && isDarkMode) {
          table.classList.add('table-dark');
      } else {
          if (theEventosTable && theEventosTable.classList && !isDarkMode) {
            table.classList.add('table-light');
        }
      }

      function setTableTheme(theTheme) {
        let eventosTable = document.getElementById("emailsTable");
        if (theTheme === 'dark' && theEventosTable && theEventosTable.classList && !eventosTable.classList.contains('table-dark')) {
        eventosTable.classList.add('table-dark');
      }
      if (theTheme === 'light' && theEventosTable && theEventosTable.classList && eventosTable.classList.contains('table-dark')) {
        eventosTable.classList.remove('table-dark');
      }
      if (theTheme === 'auto') {        
        if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
          if(theEventosTable && theEventosTable.classList && !eventosTable.classList.contains('table-dark')) {
             eventosTable.classList.add('table-dark');
          }
        } else {
          if(theEventosTable && theEventosTable.classList && eventosTable.classList.contains('table-dark')) {
            eventosTable.classList.remove('table-dark');
          }
          }
      }
      }
    </script>
<script>
new DataTable('#emailsTable', {
    layout: {
        topStart: {
            buttons: ['copy', 'excel', 'pdf', 'colvis']
        }
    }
});
</script>

<?php 
// Include footer template
require('layout/footer.php'); 
?>

 
<?php if (isset($_GET['enviado']) && $_GET['enviado'] == 1) {?>
    <script>
        alert("El mensaje fue enviado satisfactoriamente");
    </script>
<?php } ?>