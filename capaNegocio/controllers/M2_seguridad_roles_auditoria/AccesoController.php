<?php
class AccesoController {
  public static function registrar($accion, $modulo = '') {
    $id_usuario = $_SESSION['id_usuario'] ?? 0;
    $fecha_hora = date("Y-m-d H:i:s");
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'localhost';
    $firma = hash('sha256', $id_usuario . $accion . $fecha_hora . $ip);

    $db = new PDO("mysql:host=localhost;dbname=bd_articulos", "root", "");
    $stmt = $db->prepare("INSERT INTO accesos_personales (id_usuario, accion, modulo, fecha_hora, ip, firma_digital) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$id_usuario, $accion, $modulo, $fecha_hora, $ip, $firma]);
  }

  public static function listar() {
    $db = new PDO("mysql:host=localhost;dbname=bd_articulos", "root", "");
    $sql = "SELECT a.*, u.nombre FROM accesos_personales a JOIN usuarios u ON a.id_usuario = u.id_usuario ORDER BY fecha_hora DESC";
    return $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
  }
}
?>
