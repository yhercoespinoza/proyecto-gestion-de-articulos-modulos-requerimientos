<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/proyecto-gestion-de-articulos-modulos-requerimientos/capaNegocio/controllers/M2_seguridad_roles_auditoria/AccesoController.php');
AccesoController::registrar('login');

// Si no hay sesión activa, redirigir al login
if (!isset($_SESSION['id_rol'])) {
    header("Location: login.php");
    exit();
}

// Definir permisos por rol
$permisos = [
    1 => ['usuarios', 'ventas', 'compras', 'almacen'], // Admin
    2 => ['ventas'],                                   // Vendedor
    3 => ['compras'],                                  // Comprador
    4 => ['almacen']                                   // Almacenero
];

// Detectar el módulo actual (ej: usuarios.php → "usuarios")
$modulo = basename($_SERVER['PHP_SELF'], ".php");

// Verificar acceso
$rol = $_SESSION['id_rol'];
if (!in_array($modulo, $permisos[$rol])) {
    echo "<h2 style='color:red;text-align:center;'>Acceso denegado al módulo: $modulo</h2>";
    exit();
}
