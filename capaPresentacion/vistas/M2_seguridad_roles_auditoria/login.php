
<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/capaDatos/conexion.php');

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['correo_electronico'];
    $contrasena = $_POST['contrasena'];
    $rol = $_POST['rol'];
    $hora_reloj = $_POST['hora_reloj']; 
    $stmt = $db->prepare("SELECT * FROM cuenta WHERE correo_electronico = ? AND contrasena = ? AND rol = ?");
    $stmt->bind_param("sss", $usuario, $contrasena, $rol);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc(); 
        $_SESSION['cuenta_id'] = $row['cuenta_id'];
        $_SESSION['hora_entrada'] = $hora_reloj; 
        $_SESSION['correo_electronico'] = $usuario;
        if ($rol == "Vendedor") {
            header("Location: cuerpo1.php");
            exit();
        } else {
            header("Location: cuerpo2.php");
            exit();
        }
        
    } else {
        $error = "Usuario, contraseña o rol incorrectos.";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/estilo_login.css">
    <title>Login</title>
</head>
<body>
    <div class="login">
        <center><h2>Iniciar Sesión</h2></center>
        <p>Hora del sistema <span id="hora-reloj"></span></p>
        <?php if ($error): ?>
            <div style="color: red; margin-bottom: 15px; text-align: center;">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        <form method="POST" id="loginForm">
            <div>
                <label for="correo_electronico">Correo electronico</label>
                <input type="text" name="correo_electronico" id="correo_electronico" required>
            </div>
            <div>
                <label for="contrasena">Contraseña</label>
                <input type="password" name="contrasena" id="contrasena" required>
            </div>
            <div>
                <label for="rol">Seleccione su rol</label>
                <select name="rol" id="rol" required>
                    <option value="Vendedor">Vender</option>
                    <option value="Comprador">Comprar</option>
                </select>
            </div>
            <input type="hidden" name="hora_reloj" id="hora_reloj">
            <button type="submit">Iniciar</button>
            <p></p>
            <a href="../../index.php">Registrarse</a>
        </form>
    </div>
    <script src="assets/js/login.js"></script>
</body>
</html>
