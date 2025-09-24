<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/proyecto-gestion-de-articulos-modulos-requerimientos/capaNegocio/controllers/M2_seguridad_roles_auditoria/UsuarioController.php');
require_once("seguridad.php");
require_once($_SERVER['DOCUMENT_ROOT'] . '/proyecto-gestion-de-articulos-modulos-requerimientos/capaNegocio/controllers/M2_seguridad_roles_auditoria/ArticuloController.php');

// Procesar formularios
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if ($_POST['accion'] === 'adicionar_articulo') {
    ArticuloController::procesarFormulario($_POST);
    $errorArticulo = ArticuloController::obtenerError();
  } else {
    UsuarioController::procesarFormulario($_POST);
    $errorUsuario = UsuarioController::obtenerError();
  }
}

$usuarios = UsuarioController::mostrarUsuarios();

?>

<link rel="stylesheet" href="../assets/css/estilos_usuario.css">

<h3>Adicionar nuevo usuario</h3>

<?php if (!empty($errorUsuario)): ?>
  <div style="color: red; margin-bottom: 15px; text-align: center;">
    <?= $errorUsuario ?>
  </div>
<?php endif; ?>

<form method="POST">
  <div>
    <label>Nombre</label>
    <input type="text" name="nombre" placeholder="Nombre" required>
  </div>
  <div>
    <label>Nombre de usuario</label>
    <input type="text" name="usuario" placeholder="Usuario nuevo" required>
  </div>
  <div>
    <label>Contraseña</label>
    <input type="password" name="contraseña" placeholder="Contraseña" required>
  </div>
  <div>
    <label>Rol</label>
    <select name="rol" required>
      <option value="1">Administrador</option>
      <option value="2">Vendedor</option>
      <option value="3">Comprador</option>
      <option value="4">Almacenero</option>
    </select>
  </div>
  <button name="accion" value="adicionar">Adicionar</button>
</form>

<div class="nav-links">
  <a href="../../../index.php">Volver</a>
  <a href="almacen.php">Ir a almacenes</a>
  <a href="compras.php">Ir a compras</a>
  <a href="ventas.php">Ir a ventas</a>
  <a href="respaldo.php" style="padding:10px 20px; background-color:#007BFF; color:white; text-decoration:none; border-radius:5px;">Generar respaldo</a>
  <a href="recuperar.php" style="padding:10px 20px; background-color:#007BFF; color:white; text-decoration:none; border-radius:5px;">Restaurar respaldo</a>
  


</div>

<h2>Lista de Usuarios</h2>
<table>
  <tr><th>ID</th><th>Nombre</th><th>Nombre de usuario</th><th>Contraseña</th><th>Rol</th><th>Acciones</th></tr>
  <?php foreach ($usuarios as $u): ?>
    <tr>
      <form method="POST">
        <td><?= $u['id_usuario'] ?></td>
        <td><input name="nombre" value="<?= $u['nombre'] ?>"></td>
        <td><input name="nombre_usuario" value="<?= $u['username'] ?>"></td>
        <td><input name="contrasena" value="<?= $u['password'] ?>"></td>
        <td><input name="rol" value="<?= $u['id_rol'] ?>"></td>
        <td>
          <input type="hidden" name="id" value="<?= $u['id_usuario'] ?>">
          <button name="accion" value="editar">Editar</button>
          <button name="accion" value="eliminar">Eliminar</button>
        </td>
      </form>
    </tr>
  <?php endforeach; ?>
</table>

<h3>Adicionar nuevo artículo</h3>

<?php if (!empty($errorArticulo)): ?>
  <div style="color:red;text-align:center;"><?= $errorArticulo ?></div>
<?php endif; ?>

<form method="POST">
  <input type="hidden" name="accion" value="adicionar_articulo">
  <div>
    <label>Nombre del artículo:</label>
    <input type="text" name="nombre_articulo" required>
  </div>
  <div>
    <label>Descripción:</label>
    <input type="text" name="descripciuon" required>
  </div>
  <div>
    <label>Categoría:</label>
    <select name="id_categoria" required>
      <option value="1">Electrónica</option>
      <option value="2">Ropa</option>
      <option value="3">Alimentos</option>
    </select>
  </div>
  <div>
    <label>Unidad de medida:</label>
    <select name="id_unidad_medida" required>
      <option value="1">Unidad</option>
      <option value="2">Caja</option>
      <option value="3">Litro</option>
    </select>
  </div>
  <button type="submit">Adicionar artículo</button>
</form>

<h2>Lista de Artículos</h2>
<table>
  <tr><th>ID</th><th>Nombre</th><th>Descripción</th><th>Categoría</th><th>Unidad</th><th>Firma Digital</th><th>Acciones</th></tr>
  <?php foreach (ArticuloController::listarArticulos() as $a): ?>
    <tr>
      <form method="POST">
        <td><?= $a['id_articulo'] ?></td>
        <td><input name="nombre_articulo" value="<?= $a['nombre'] ?>"></td>
        <td><input name="descripciuon" value="<?= $a['descripcion'] ?>"></td>
        <td><input name="id_categoria" value="<?= $a['id_categoria'] ?>"></td>
        <td><input name="id_unidad_medida" value="<?= $a['id_unidad_medida'] ?>"></td>
        <td><?= $a['firma_digital'] ?></td>
        <td>
          <input type="hidden" name="id_articulo" value="<?= $a['id_articulo'] ?>">
          <button name="accion" value="editar_articulo">Editar</button>
          <button name="accion" value="eliminar_articulo">Eliminar</button>
        </td>
      </form>
    </tr>
  <?php endforeach; ?>
</table>
<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/proyecto-gestion-de-articulos-modulos-requerimientos/capaNegocio/controllers/M2_seguridad_roles_auditoria/AccesoController.php');

$accesos = AccesoController::listar();
?>

<h2>Historial de Accesos</h2>
<table border="1" cellpadding="5">
  <tr>
    <th>Usuario</th>
    <th>Acción</th>
    <th>Módulo</th>
    <th>Fecha y Hora</th>
    <th>IP</th>
    <th>Firma Digital</th>
  </tr>
  <?php foreach ($accesos as $a): ?>
    <tr>
      <td><?= $a['nombre'] ?></td>
      <td><?= $a['accion'] ?></td>
      <td><?= $a['modulo'] ?></td>
      <td><?= $a['fecha_hora'] ?></td>
      <td><?= $a['ip'] ?></td>
      <td><?= $a['firma_digital'] ?></td>
    </tr>
  <?php endforeach; ?>
</table>


