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
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearCorreoModal">Crear Correo</button>
            </div>
        </div>

        <?php
        // Query to fetch all emails
        $query = "SELECT Id, titulo, mensaje, remitente, destinatario, adjuntos_ruta FROM emails";
        $stmt = $db->prepare($query);
        $stmt->execute();
        ?>

        <table id="emailsTable" class="table table-striped" style="width:100%">
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
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['titulo']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['mensaje']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['remitente']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['destinatario']) . "</td>";
                        echo "<td>
                            <button class='btn btn-warning' onclick='editarCorreo(\"" . htmlspecialchars($row['Id']) . "\")'>Editar</button>
                            <button class='btn btn-danger' onclick='eliminarCorreo(\"" . htmlspecialchars($row['Id']) . "\")'>Eliminar</button>
                        </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td>No hay correos registrados</td>";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "<td></td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>



<!-- Create Email Modal -->
<div class="modal fade" id="crearCorreoModal" tabindex="-1" aria-labelledby="crearCorreoLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen"> <!-- Added modal-xl for extra large size -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="crearCorreoLabel">Crear Correo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form id="crearCorreoForm" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="emailDestinatario" class="form-label">Destinatario</label>
                        <input type="email" class="form-control" id="emailDestinatario" required>
                    </div>
                    <div class="mb-3">
                        <label for="emailTitulo" class="form-label">Título</label>
                        <input type="text" class="form-control" id="emailTitulo" required>
                    </div>
                    <div class="mb-3">
                        <label for="emailMensaje" class="form-label">Mensaje</label>
                        <textarea class="form-control" id="emailMensaje" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="emailAdjunto" class="form-label">Adjunto</label>
                        <input type="file" class="form-control" id="emailAdjunto">
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
        plugins: 'lists link image table code help wordcount',
        toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist | link image'
    });

    document.getElementById("crearCorreoForm").addEventListener("submit", function(event) {
        event.preventDefault();
        const formData = new FormData(this);
        fetch("enviar_correo.php", {
            method: "POST",
            body: formData
        }).then(response => response.text())
          .then(data => {
              alert(data);
              location.reload();
          });
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
