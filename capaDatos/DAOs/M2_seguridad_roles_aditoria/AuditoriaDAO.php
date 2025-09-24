<?php

class AuditoriaDAO {
  private static function conectar() {
    return new PDO("mysql:host=localhost;dbname=bd_articulos", "root", "");
  }

  public static function registrar($id_usuario, $accion, $modulo) {
    $db = self::conectar();
    $fecha_hora = date("Y-m-d H:i:s");
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'localhost';

    $stmt = $db->prepare("INSERT INTO auditoria_movimientos (id_usuario, accion, modulo, fecha_hora, ip) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$id_usuario, $accion, $modulo, $fecha_hora, $ip]);
  }
}
