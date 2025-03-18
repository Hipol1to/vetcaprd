<?php 
require_once('../includes/config.php');

//if not logged in redirect to login page
if (! $user->is_logged_in() || !isset($_SESSION['rol']) || $_SESSION['rol'] != "administrador" ){
    header('Location: login.php'); 
    exit(); 
}
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
                    <th>Comprobante</th>
                    <th>Método de Pago</th>
                    <th>Pago Validado</th>
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
                        echo "<td>" . (!empty($row['comprobante_pago_ruta']) ? "<a href='" . htmlspecialchars($row['comprobante_pago_ruta']) . "' target='_blank'>Ver Comprobante</a>" : "No disponible") . "</td>";
                        echo "<td>" . htmlspecialchars($row['metodo_de_pago']) . "</td>";
                        echo "<td>" . ($row['pago_validado'] ? 'Sí' : 'No') . "</td>";
                        echo "<td>" . date("Y-m-d H:i:s", strtotime($row['fecha_de_pago'])) . "</td>";
                        echo "<td>
                            <button class='btn btn-warning' onclick='validarPago(\"" . htmlspecialchars($row['Id']) . "\")'>Validar</button>
                            <button class='btn btn-danger' onclick='eliminarPago(\"" . htmlspecialchars($row['Id']) . "\")'>Eliminar</button>
                        </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='1'>No hay pagos registrados</td>";
                    echo "<td colspan='1'></td>";
                    echo "<td colspan='1'></td>";
                    echo "<td colspan='1'></td>";
                    echo "<td colspan='1'></td>";
                    echo "<td colspan='1'></td></tr>";
                }
                ?>
            </tbody>
        </table>
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
// Validate payment
function validarPago(pagoId) {
    if (confirm("¿Estás seguro de que quieres validar este pago?")) {
        fetch("validar_pago.php?id=" + pagoId, { method: "GET" })
            .then(response => response.text())
            .then(data => {
                alert(data);
                location.reload();
            });
    }
}

// Delete payment
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
