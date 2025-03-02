<?php
// Include header template
require_once('../includes/config.php');
require('layout/header.php'); 
?>
<div class="body flex-grow-1">
    <div class="container-lg px-4">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Pagos</h1>
            </div>
        </div>
        
        <?php
        // Query to fetch all payments
        $query = "SELECT * FROM pagos ORDER BY fecha_creacion DESC";
        $stmt = $db->prepare($query);
        $stmt->execute();
        ?>

<table id="pagosAllDataTable" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>Monto</th>
                    <th>Método de Pago</th>
                    <th>Pago Validado</th>
                    <th>Cuenta Remitente</th>
                    <th>Banco Remitente</th>
                    <th>Fecha de Pago</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($stmt->rowCount() > 0) {
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>$" . number_format($row['monto'], 2) . "</td>";
                        echo "<td>" . htmlspecialchars($row['metodo_de_pago']) . "</td>";
                        echo "<td>" . ($row['pago_validado'] == 1 ? 'Sí' : 'No') . "</td>";
                        echo "<td>" . htmlspecialchars($row['cuenta_remitente']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['banco_remitente']) . "</td>";
                        echo "<td>" . date("Y-m-d H:i:s", strtotime($row['fecha_de_pago'])) . "</td>";
                        echo "<td>
                            <a href='detalle_pago.php?id=" . htmlspecialchars($row['Id']) . "' class='btn btn-info'>Ver Detalle</a>
                            <button class='btn btn-warning' onclick='editarPago(" . htmlspecialchars($row['Id']) . ")'>Editar</button>
                            <button class='btn btn-danger' onclick='eliminarPago(" . htmlspecialchars($row['Id']) . ")'>Eliminar</button>
                        </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td >No hay pagos registrados</td>";
                    echo "<td ></td>";
                    echo "<td ></td>";
                    echo "<td ></td>";
                    echo "<td ></td>";
                    echo "<td ></td>";
                    echo "<td ></td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Modal for Editing Payment -->
        <div class="modal fade" id="editPagoModal" tabindex="-1" aria-labelledby="editPagoLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPagoLabel">Editar Pago</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editPagoForm">
                            <input type="hidden" id="pagoId" name="pagoId">
                            <div class="form-group">
                                <label for="pagoMonto">Monto</label>
                                <input type="number" class="form-control" id="pagoMonto" name="monto" step="0.01" required>
                            </div>
                            <div class="form-group">
                                <label for="pagoMetodo">Método de Pago</label>
                                <input type="text" class="form-control" id="pagoMetodo" name="metodo_de_pago" required>
                            </div>
                            <div class="form-group">
                                <label for="pagoValidado">Pago Validado</label>
                                <select class="form-control" id="pagoValidado" name="pago_validado">
                                    <option value="1">Sí</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
      let theEventosTable = document.getElementById("pagosAllDataTable");
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
      const table = document.getElementById('pagosAllDataTable');
          
      if (theEventosTable && theEventosTable.classList && isDarkMode) {
          table.classList.add('table-dark');
      } else {
          if (theEventosTable && theEventosTable.classList && !isDarkMode) {
            table.classList.add('table-light');
        }
      }

      function setTableTheme(theTheme) {
        let eventosTable = document.getElementById("pagosAllDataTable");
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
function editarPago(pagoId) {
    fetch("detalle_pago.php?id=" + pagoId)
        .then(response => response.json())
        .then(data => {
            document.getElementById("pagoId").value = data.Id;
            document.getElementById("pagoMonto").value = data.monto;
            document.getElementById("pagoMetodo").value = data.metodo_de_pago;
            document.getElementById("pagoValidado").value = data.pago_validado;
            $("#editPagoModal").modal("show");
        });
}

document.getElementById("editPagoForm").addEventListener("submit", function(event) {
    event.preventDefault();
    fetch("editar_pago.php", {
        method: "POST",
        body: new FormData(this),
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        location.reload();
    });
});

function eliminarPago(pagoId) {
    if (confirm("¿Estás seguro de que quieres eliminar este pago?")) {
        fetch("eliminar_pago.php?id=" + pagoId, { method: "GET" })
            .then(response => response.text())
            .then(data => {
                alert(data);
                location.reload();
            });
    }
}
</script>

<script>
new DataTable('#pagosAllDataTable', {
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
