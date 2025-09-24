<?php
$nombreArchivo = "respaldo_bd_articulos_" . date("Ymd_His") . ".sql";

// Ruta absoluta en Windows (sin mezclar con DOCUMENT_ROOT)
$ruta = "proyecto-gestion-de-articulos-modulos-requerimientos\\respaldos\\$nombreArchivo";

// Comando mysqldump
$comando = "mysqldump -u root bd_articulos > \"$ruta\"";

// Ejecutar
exec($comando, $output, $resultado);

if ($resultado === 0) {
  echo "<h3>Respaldo generado correctamente:</h3>";
  echo "<a href='/proyecto-gestion-de-articulos-modulos-requerimientos/respaldos/$nombreArchivo' download>Descargar respaldo</a>";
} else {
  echo "<h3 style='color:red;'>respaldo Exitoso!!</h3>";
}
?>
