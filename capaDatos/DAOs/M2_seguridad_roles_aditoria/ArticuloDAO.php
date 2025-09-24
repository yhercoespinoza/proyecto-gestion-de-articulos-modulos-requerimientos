<?php
class ArticuloDAO {
  private static function conectar() {
    return new PDO("mysql:host=localhost;dbname=bd_articulos", "root", "");
  }

  public static function existeDuplicado($nombre, $id_categoria, $id_unidad_medida, $id_articulo = null) {
    $db = self::conectar();
    $sql = "SELECT COUNT(*) FROM articulos WHERE nombre = ? AND id_categoria = ? AND id_unidad_medida = ?";
    $params = [$nombre, $id_categoria, $id_unidad_medida];

    if ($id_articulo !== null) {
      $sql .= " AND id_articulo != ?";
      $params[] = $id_articulo;
    }

    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchColumn() > 0;
  }

  public static function adicionar($nombre, $descripcion, $id_categoria, $id_unidad_medida) {
    if (self::existeDuplicado($nombre, $id_categoria, $id_unidad_medida)) {
      throw new Exception("Ya existe un artículo con ese nombre, categoría y unidad de medida.");
    }

    $id_usuario = $_SESSION['id_usuario'] ?? 0;
    $fecha_hora = date("Y-m-d H:i:s");
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'localhost';
    $firma = hash('sha256', $id_usuario . 'adicionar' . $fecha_hora . $ip);

    $db = self::conectar();
    $stmt = $db->prepare("INSERT INTO articulos (nombre, descripcion, id_categoria, id_unidad_medida, firma_digital) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$nombre, $descripcion, $id_categoria, $id_unidad_medida, $firma]);
  }

  public static function editar($id, $nombre, $descripcion, $id_categoria, $id_unidad_medida) {
    if (self::existeDuplicado($nombre, $id_categoria, $id_unidad_medida, $id)) {
      throw new Exception("Ya existe otro artículo con ese nombre, categoría y unidad.");
    }

    $id_usuario = $_SESSION['id_usuario'] ?? 0;
    $fecha_hora = date("Y-m-d H:i:s");
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'localhost';
    $firma = hash('sha256', $id_usuario . 'editar' . $fecha_hora . $ip);

    $db = self::conectar();
    $stmt = $db->prepare("UPDATE articulos SET nombre = ?, descripcion = ?, id_categoria = ?, id_unidad_medida = ?, firma_digital = ? WHERE id_articulo = ?");
    $stmt->execute([$nombre, $descripcion, $id_categoria, $id_unidad_medida, $firma, $id]);
  }

  public static function eliminar($id) {
    $db = self::conectar();
    $stmt = $db->prepare("DELETE FROM articulos WHERE id_articulo = ?");
    $stmt->execute([$id]);
  }

  public static function listar() {
    $db = self::conectar();
    return $db->query("SELECT * FROM articulos")->fetchAll(PDO::FETCH_ASSOC);
  }
}
?>
