<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/proyecto-gestion-de-articulos-modulos-requerimientos/capaDatos/DAOs/M2_seguridad_roles_aditoria/ArticuloDAO.php');

class ArticuloController {
  public static $error = "";

  public static function obtenerCategorias() {
    $db = new PDO("mysql:host=localhost;dbname=bd_articulos", "root", "");
    return $db->query("SELECT id_categoria, nombre FROM categorias")->fetchAll(PDO::FETCH_ASSOC);
  }

  public static function obtenerUnidades() {
    $db = new PDO("mysql:host=localhost;dbname=bd_articulos", "root", "");
    return $db->query("SELECT id_unidad_medida, nombre FROM unidades_medidas")->fetchAll(PDO::FETCH_ASSOC);
  }

  public static function listarArticulos() {
    return ArticuloDAO::listar();
  }

  public static function procesarFormulario($post) {
    try {
      $accion = $post['accion'] ?? '';
      $id = intval($post['id_articulo'] ?? 0);
      $nombre = $post['nombre_articulo'] ?? '';
      $descripciuon = $post['descripciuon'] ?? '';
      $id_categoria = intval($post['id_categoria'] ?? 0);
      $id_unidad_medida = intval($post['id_unidad_medida'] ?? 0);

      if ($accion === 'adicionar_articulo') {
        ArticuloDAO::adicionar($nombre, $descripciuon, $id_categoria, $id_unidad_medida);
      } elseif ($accion === 'editar_articulo') {
        ArticuloDAO::editar($id, $nombre, $descripciuon, $id_categoria, $id_unidad_medida);
      } elseif ($accion === 'eliminar_articulo') {
        ArticuloDAO::eliminar($id);
      }

    } catch (Exception $e) {
      self::$error = $e->getMessage();
    }
  }

  public static function obtenerError() {
    return self::$error;
  }
}
?>
