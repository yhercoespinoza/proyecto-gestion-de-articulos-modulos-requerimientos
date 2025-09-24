<?php

class UsuarioDAO {
  private static function conectar() {
    return new PDO("mysql:host=localhost;dbname=bd_articulos", "root", "");
  }

  public static function obtenerTodos() {
    $db = self::conectar();
    return $db->query("SELECT * FROM usuarios")->fetchAll(PDO::FETCH_ASSOC);
  }

  public static function existeUsernameConRol($username, $rol) {
    $db = self::conectar();
    $stmt = $db->prepare("SELECT COUNT(*) FROM usuarios WHERE username = ? AND id_rol = ?");
    $stmt->execute([$username, $rol]);
    return $stmt->fetchColumn() > 0;
  }

  public static function editar($id, $nombre, $username, $password, $rol) {
    $db = self::conectar();
    $stmt = $db->prepare("UPDATE usuarios SET nombre = ?, username = ?, password = ?, id_rol = ? WHERE id_usuario = ?");
    $stmt->execute([$nombre, $username, $password, $rol, $id]);
  }

  public static function eliminar($id) {
    $db = self::conectar();
    $stmt = $db->prepare("DELETE FROM usuarios WHERE id_usuario = ?");
    $stmt->execute([$id]);
  }

  public static function adicionar($nombre, $username, $password, $rol) {
    if (self::existeUsernameConRol($username, $rol)) {
      throw new Exception("El nombre de usuario '$username' ya existe con ese rol. Cambie de rol o elija otro nombre.");
    }

    $db = self::conectar();
    $stmt = $db->prepare("INSERT INTO usuarios (nombre, username, password, id_rol) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nombre, $username, $password, $rol]);
  }
}
