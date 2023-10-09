<?php require_once('Connections/conexion1.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require(ROOT_BBDD);
require_once("./envio_correo/envio_correos.php");
?>
<?php
// *** Validate request to login to this site.
$conexion = new ApptivaDB();
$objEnvioEmail = new EnvioEmails();

if (!isset($_SESSION)) {
  session_start();
}

if (isset($_POST['usuario']) && isset($_POST['email_usuario'])) {
  $loginUsername = $_POST['usuario'];
  $emailUsername = $_POST['email_usuario'];
  $MM_redirectLoginSuccess = "usuario_olvido_password.php?id_m=1";
  $MM_redirectLoginFailed = "usuario_olvido_password.php?id_m=2";

  $LoginRS = $conexion->buscarTres('usuario', 'usuario, email_usuario', "WHERE email_usuario = '$_POST[email_usuario]' AND usuario = '$_POST[usuario]'");

  if ($LoginRS != '') {
    $usuario = $LoginRS['usuario'];
    $email = $LoginRS['email_usuario'];

    $temporalPassword = $usuario . "123";
    $newPassword = password_hash($temporalPassword, PASSWORD_DEFAULT);
    $conexion->actualizar("usuario", "clave_usuario='$newPassword'", "email_usuario= '$email'");



    //ENVIO DE E-MAIL AL USUARIO
    $to = $email;  // correo del usuario
    $asunto = 'Cambio de Clave SISADGE';
    $mensaje = "<p>Usted solicito informacion de la contraseña para ingresar al programa SISADGE:</p></b>";
    $mensaje .= "<p>Usuario: $usuario </p><p>Clave: $temporalPassword </p><p>E-mail: $email</p></b>";
    $mensaje .= "<p><strong> ESTA CLAVE ES TEMPORAL, VAYA AL SISADGE A CAMBIAR LA CLAVE POR UNA NUEVA </strong></p> ";
    $mensaje .= "<p><span style=\"color: #FF0000\">No responder este correo.</span> </p></b>";

    $objEnvioEmail->enviar($to, '', '', '', $asunto, $mensaje);
    header("Location: " . $MM_redirectLoginSuccess);
  } else {
    header("Location: " . $MM_redirectLoginFailed);
  }
}
?>
<html>

<head>
  <title>SISADGE AC &amp; CIA</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <link rel="StyleSheet" href="css/imageMenu.css" type="text/css">
  <script type="text/javascript" src="js/formato.js"></script>
  <link rel="stylesheet" type="text/css" media="all" href="css/style_login.css" />
</head>

<body oncontextmenu="return false">
  <div class="container-fluid" id="divconten">
    <div class="row">
      <div class="col-md-8"><img src="images/cabecera.jpg" style="width: 100%;margin:10px 0px 10px;">
      </div>
      <div class="col-md-4">
        <div class="menu2">
          <ul>
            <li><?php echo $row_usuario['nombre_usuario']; ?></li>
            <li><a href="usuario.php">SALIR</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div id="container">
        <h1>Olvido Contrase&ntilde;a !</h1>
        <form ACTION="<?php echo $loginFormAction; ?>" method="POST" name="form1">
          <ul>
            <li>
              <label for="pswd">E-mail:</label>
              <span>
                <input id="pswd" type="email" name="email_usuario" required />
              </span>
            </li>
            <li>
              <label for="pswd">Usuario:</label>
              <span><input id="pswd" type="text" name="usuario" required /></span>
            </li>
            <li>
              <button type="submit">Enviar</button>
            </li>
          </ul>
        </form>
        <?php if ($_GET['id_m'] == '1') {
          echo "<div id='verde'>La Informacion fue enviada a su correo personal !</b>  </div><meta http-equiv='refresh' content='2;URL=usuario.php'</b></div>";
        } ?>
        <?php if ($_GET['id_m'] == '2') {
          echo "<div id='rojo3'>La Informacion no es correcta !</b>";
        } ?>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div id="pie">ALBERTO CADAVID R. & CIA. S.A. Nit. 890.915.756-6 - Carrera 45 # 14 - 15 Sector Barrio Colombia - Correo Postal: 21519<br>
          PBX: 3112144 - FAX: 3524330 - E-mail: info@acycia.com - Medellin - Colombia
        </div>
      </div>
    </div>
  </div>

  </div>
</body>

</html>