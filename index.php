<?php
session_start();

// Configuración de la base de datos
$sqluser = "user";
$sqlpassword = "password";
$sqldatabase = "login";

$post = $_SERVER['REQUEST_METHOD'] == 'POST';

if ($post) {
    if (isset($_POST['login'])) {
        // Proceso de login
        if (empty($_POST['uname']) || empty($_POST['pass'])) {
            $empty_fields = true;
        } else {
            try {
                $pdo = new PDO("mysql:host=localhost;dbname=" . $sqldatabase, $sqluser, $sqlpassword);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                exit($e->getMessage());
            }

            $st = $pdo->prepare('SELECT * FROM list WHERE user_name = ?');
            $st->execute([$_POST['uname']]);
            $r = $st->fetch();

            if ($r != null && $r["password"] == $_POST['pass']) {
                $_SESSION["uname"] = $_POST["uname"];
                $_SESSION["pass"] = $_POST["pass"];
                $_SESSION["fname"] = $r["first_name"];
                header("Location: inicio.php");
                exit;
            } else {
                $login_err = true;
            }
        }
    } elseif (isset($_POST['signup'])) {
        // Proceso de signup
        if (empty($_POST['uname']) || empty($_POST['fname']) || empty($_POST['lname']) || empty($_POST['email']) || empty($_POST['pass']) || empty($_POST['repass'])) {
            $empty_fields = true;
        } else {
            $unmatch = preg_match('/^[A-Za-z][A-Za-z0-9_]{3,}$/', $_POST['uname']);
            $fnmatch = preg_match('/^[A-Za-z]+$/', $_POST['fname']);
            $lnmatch = preg_match('/^[A-Za-z]+$/', $_POST['lname']);
            $emmatch = preg_match('/^[A-Za-z_0-9]+@[A-Za-z]+\.[A-Za-z]+$/', $_POST['email']);
            $pmatch = preg_match('/.{5,}/', $_POST['pass']);
            $peq = $_POST['pass'] == $_POST['repass'];

            if ($unmatch && $fnmatch && $lnmatch && $emmatch && $pmatch && $peq) {
                try {
                    $pdo = new PDO("mysql:host=localhost;dbname=" . $sqldatabase, $sqluser, $sqlpassword);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (PDOException $e) {
                    exit($e->getMessage());
                }

                $st = $pdo->prepare('SELECT * FROM list WHERE user_name=?');
                $st->execute([$_POST['uname']]);
                $uname_err = $st->fetch() != null;

                $st = $pdo->prepare('SELECT * FROM list WHERE email=?');
                $st->execute([$_POST['email']]);
                $email_err = $st->fetch() != null;

                if (!$uname_err && !$email_err) {
                    $stmt = 'INSERT INTO list(user_name, first_name, last_name, email, password) VALUES (?,?,?,?,?)';
                    $pdo->prepare($stmt)->execute([$_POST['uname'], $_POST['fname'], $_POST['lname'], $_POST['email'], $_POST['pass']]);
                    $_SESSION["uname"] = $_POST["uname"];
                    $_SESSION["pass"] = $_POST["pass"];
                    $_SESSION["fname"] = $_POST["fname"];
                    header("Location: inicio.php");
                    exit;
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login y Registro</title>
    <link rel="stylesheet" href="login.css">
    <link rel="icon" href="/img/img1.png" type="img/png">
</head>
<body>
    <main>
        <div class="contenedor__todo">
            <div class="caja__trasera">
                <div class="caja__trasera-login">
                    <h3>¿Ya tienes una cuenta?</h3>
                    <p>Inicia sesión para entrar en el sitio</p>
                    <button id="btn__iniciar-sesion">Inicia sesión</button>
                </div>
                <div class="caja__trasera-register">
                    <h3>¿Aún no tienes una cuenta?</h3>
                    <p>Registrate para que puedas iniciar sesión</p>
                    <button id="btn__registrarse">Registrarse</button>
                </div>
            </div>
            <!--formulario de login y registro-->
            <div class="contenedor__login-register">
                <!--Login-->
                <form class="formulario__login" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
                    <h2>Iniciar sesión</h2>
                    <input type="text" name="uname" placeholder="Nombre de Usuario" value="<?php echo $_POST['uname'] ?? ''; ?>"><br>
                    <input type="password" name="pass" placeholder="Contraseña"><br>
                    <?php if (isset($login_err)) echo '<span>Invalid username or password.</span><br>'; ?>
                    <button name="login" value="Login">Entrar</button>
            <!-- Registro -->
                </form>
                    <form class="formulario__register" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                    <h2>Registrarse</h2>
                    <input type="text" name="uname" placeholder="Nombre de Usuario" value="<?php echo $_POST['uname'] ?? ''; ?>"><br>
                    <input type="text" name="fname" placeholder="Nombre" value="<?php echo $_POST['fname'] ?? ''; ?>"><br>
                    <input type="text" name="lname" placeholder="Apellido" value="<?php echo $_POST['lname'] ?? ''; ?>"><br>
                    <input type="text" name="email" placeholder="Correo" value="<?php echo $_POST['email'] ?? ''; ?>"><br>
                    <input type="password" name="pass" placeholder="Contraseña"><br>
                    <input type="password" name="repass" placeholder="Repite contraseña"><br>
                    <?php if (isset($empty_fields)) echo "<span>Please fill all fields.</span><br>"; ?>
                    <input type="submit" name="signup" value="SignUp"><br><br>
                </form>
            </div>
        </div>
    </main>
    <script src="login.js"></script>
</body>
</html>