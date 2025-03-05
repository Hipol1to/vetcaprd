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
                $query = "SELECT Id, titulo, mensaje, remitente, destinatario FROM emails";
                $stmt = $db->prepare($query);
                $stmt->execute();
                ?>
                <table class="table table-striped">
                    <thead><tr><th>Título</th><th>Mensaje</th><th>Remitente</th><th>Destinatario</th><th>Acciones</th></tr></thead>
                    <tbody>
                        <?php
                        if ($stmt->rowCount() > 0) {
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr><td>" . htmlspecialchars($row['titulo']) . "</td>
                                    <td>" . htmlspecialchars($row['mensaje']) . "</td>
                                    <td>" . htmlspecialchars($row['remitente']) . "</td>
                                    <td>" . htmlspecialchars($row['destinatario']) . "</td>
                                    <td><button class='btn btn-warning'>Editar</button> <button class='btn btn-danger'>Eliminar</button></td></tr>";
                            }
                        } else echo "<tr><td colspan='5'>No hay correos registrados</td></tr>";
                        ?>
                    </tbody>
                </table>
            </div>

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
                                            <button class='btn btn-warning btn-editar' data-id='{$row['id']}' data-bs-toggle='modal' data-bs-target='#editarContenedorModal'>Editar</button>
                                            <button class='btn btn-danger'>Eliminar</button>
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
    document.querySelectorAll(".btn-editar").forEach(button => {
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

</script>







<!-- Direcciones Registradas Tab -->
<div class="tab-pane fade" id="direcciones">
    <div class="text-end mb-2">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addEmailModal">Añadir Correo Electrónico</button>
    </div>

    <?php
    $query = "SELECT Id, email FROM direcciones_email";
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
                        <td><button class='btn btn-warning'>Editar</button> 
                        <button class='btn btn-danger'>Eliminar</button></td></tr>";
                }
            } else echo "<tr><td colspan='2'>No hay direcciones registradas</td></tr>";
            ?>
        </tbody>
    </table>
</div>

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

/*document.addEventListener("DOMContentLoaded", function() {
    document.querySelector("#crearContenedorForm").addEventListener("submit", function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch("registrar_lista.php", {
            method: "POST",
            body: formData
        }).then(response => response.text()).then(result => {
            alert(result);
            location.reload();
        }).catch(error => console.error("Error:", error));
    });
});*/

</script>





<!-- Create Email Modal -->
<div class="modal fade" id="crearCorreoModal" tabindex="-1" aria-labelledby="crearCorreoLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="crearCorreoLabel">Nuevo mensaje</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form id="crearCorreoForm" action="enviar_correo.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="emailDestinatario" class="form-label">Destinatario</label>
                        <input type="email" class="form-control" id="emailDestinatario" name="emailDestinatario" required>
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