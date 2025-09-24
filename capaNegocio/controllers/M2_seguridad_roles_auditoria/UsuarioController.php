<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/proyecto-gestion-de-articulos-modulos-requerimientos/capaDatos/DAOs/M2_seguridad_roles_aditoria/AuditoriaDAO.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/proyecto-gestion-de-articulos-modulos-requerimientos/capaDatos/DAOs/M2_seguridad_roles_aditoria/UsuarioDAO.php');

class UsuarioController {
  public static $error = "";

  public static function procesarFormulario($post) {
    try {
      if (isset($post['accion'])) {
        switch ($post['accion']) {
          case 'editar':
            $id = intval($post['id'] ?? 0);
            $nombre = $post['nombre'] ?? '';
            $username = $post['nombre_usuario'] ?? '';
            $password = $post['contrasena'] ?? '';
            $rol = intval($post['rol'] ?? 0);
            UsuarioDAO::editar($id, $nombre, $username, $password, $rol);
            AuditoriaDAO::registrar($_SESSION['id_usuario'], 'editar', 'usuarios');


            break;

          case 'eliminar':
            $id = intval($post['id'] ?? 0);
            UsuarioDAO::eliminar($id);
            AuditoriaDAO::registrar($_SESSION['id_usuario'], 'eliminar', 'usuarios');
            break;

          case 'adicionar':
            $nombre = $post['nombre'] ?? '';
            $username = $post['usuario'] ?? '';
            $password = $post['contraseña'] ?? '';
            $rol = intval($post['rol'] ?? 0);
            UsuarioDAO::adicionar($nombre, $username, $password, $rol);
            AuditoriaDAO::registrar($_SESSION['id_usuario'], 'adicionar', 'usuarios');
            break;
        }
      }
    } catch (Exception $e) {
      self::$error = $e->getMessage();
    }
  }

  public static function mostrarUsuarios() {
    return UsuarioDAO::obtenerTodos();
  }

  public static function obtenerError() {
    return self::$error;
  }
}
