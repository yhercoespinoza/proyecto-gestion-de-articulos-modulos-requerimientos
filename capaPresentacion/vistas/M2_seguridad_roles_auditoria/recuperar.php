<?php
session_start();
if ($_SESSION['id_rol'] !== 1) {
  echo "<h2 style='color:red;text-align:center;'>Solo el administrador puede restaurar la base de datos.</h2>";
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['archivo_sql'])) {
  $archivo = $_FILES['archivo_sql']['tmp_name'];

  // Comando mysql para restaurar
  $comando = "mysql -u root bd_articulos < \"$archivo\"";
  exec($comando, $output, $resultado);

  if ($resultado === 0) {
    echo "<h3>Base de datos restaurada correctamente.</h3>";
  } else {
    echo "<h3 style='color:red;'>Error al restaurar la base de datos.</h3>";
  }
}
?>

<form method="POST" enctype="multipart/form-data">
  <label>Selecciona archivo .sql para restaurar:</label>
  <input type="file" name="archivo_sql" accept=".sql" required>
  <button type="submit">Restaurar</button>
</form>
