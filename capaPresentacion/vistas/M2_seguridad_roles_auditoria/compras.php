<?php
require_once("seguridad.php");
require_once($_SERVER['DOCUMENT_ROOT'] . '/proyecto-gestion-de-articulos-modulos-requerimientos/capaNegocio/controllers/M1_gestion_articulos/ArticuloController.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  ArticuloController::procesarFormulario($_POST);
}

$error = ArticuloController::obtenerError();


?>
<h3>Adicionar nuevo artículo</h3>
<?php if ($error): ?>
  <div style="color:red;text-align:center;"><?= $error ?></div>
<?php endif; ?>
<form method="POST">
  <input type="hidden" name="accion" value="adicionar_articulo">
  <div>
    <label>Nombre del artículo:</label>
    <input type="text" name="nombre_articulo" required>
  </div>
  <div>
    <label>Categoría:</label>
    <select name="id_categoria" required>
      <option value="1">Electrónica</option>
      <option value="2">Ropa</option>
      <option value="3">Alimentos</option>
      <!-- Puedes cargar dinámicamente desde BD -->
    </select>
  </div>
  <div>
    <label>Unidad de medida:</label>
    <select name="id_unidad_medida" required>
      <option value="1">Unidad</option>
      <option value="2">Caja</option>
      <option value="3">Litro</option>
      <!-- Puedes cargar dinámicamente desde BD -->
    </select>
  </div>
  <button type="submit">Adicionar artículo</button>
</form>
