<?php
    session_start();

    $sqluser = "user";
    $sqlpassword = "password";
    $sqldatabase = "login";

    try {
        $pdo = new PDO("mysql:host=localhost;dbname=".$sqldatabase, $sqluser, $sqlpassword);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        exit($e->getMessage());
    }

    $st = $pdo->prepare('SELECT * FROM list WHERE user_name=?');
    $st->execute(array($_SESSION["uname"]));
    if(($r=$st->fetch()) == null || ($r["password"] != $_SESSION["pass"])) {
        header("Location: login.php");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        session_destroy();
        header("Location: index.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="inicio.css?v=1.0">
    <link rel="icon" href="img/img1.png" type="img/png">
</head>
<body>
    <!--Encabezado-->
    <header class="header">
        <!--Barra de navegación-->
        <input type="checkbox" id="open-menu" class="header__checkbox">
        <label for="open-menu" class="header__open-nav-button" role="button">=</label>
        <div class="header__title-container">
            <h1>Física en contexto</h1>
        </div>
        <nav class="header__nav">
            <ul class="header__nav-list">
                <li class="header__nav-item">
                    <img src="icons/icon0.png" alt="">
                    <a href="inicio.html">Inicio</a>
                </li>
                <li class="header__nav-item">
                    <img src="icons/icon1.png" alt="">
                    <a href="contacto.html">Contacto</a>
                </li>
                <li class="header__nav-item">
                    <img src="icons/icon2.png" alt="">
                    <a href="recursos.html">Recursos</a>
                </li>
                <li class="header__nav-item">
                    <img src="icons/icon5.png" alt="">
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                        Cerrar Sesión
                    </a>
                    <form id="logoutForm" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" style="display: none;">
                    </form>
                </li>
            </ul>
        </nav>
    </header>

    <div class="modal">
        <div class="modal__content">
            <h2 class="modal__title">Bienvenido <?php echo $_SESSION["uname"].'.';?></h2>
            <p class="modal__text">Aquí descubrirás cómo la física no es solo una materia abstracta, sino que está presente en cada momento de nuestra vida cotidiana. Desde el movimiento de los objetos que nos rodean, hasta los fenómenos naturales que nos sorprenden, te invitamos a entender cómo funciona el mundo que nos envuelve.</p>
            <span class="modal__close-button">x</span>
        </div>
    </div>
    
    <script>
        document.querySelector(".modal__close-button").addEventListener("click", () => {
            document.querySelector(".modal").style.display = "none";
        });
    </script>    

    <main class="container__content">
        <div class="sections__container">

            <!--Sección de Retos-->
            <div class="section__item item-1">
                <div class="section__item--front">
                    <h2 class="seccion__title">curso</h2>
                </div>
                <!--Parte trasera-->
                <div class="section__item--back">
                    <p>
                        Aprende física desde lo básico con explicaciones claras y ejercicios prácticos.
                    </p>
                    <a href="select.mod.html">Descúbrelo aquí</a>
                </div>
            </div>
            
            <!--Sección de Retos-->
            <div class="section__item item-2">
                <div class="section__item--front">
                    <h2 class="seccion__title">Teorias</h2>
                </div>
                <!--Parte trasera-->
                <div class="section__item--back">
                    <p>
                        Explora las ideas que han revolucionado nuestra comprensión del universo.
                    </p>
                    <a href="teorias.html">Descúbrelo aquí</a>
                </div>
            </div>

            <!--Sección de Retos-->
            <div class="section__item item-3">
                <div class="section__item--front">
                    <h2 class="seccion__title">Paradojas</h2>
                </div>
                <!--Parte trasera-->
                <div class="section__item--back">
                    <p>
                        Desafía tu lógica con situaciones que parecen imposibles pero tienen sentido.
                    </p>
                    <a href="paradojas.html">Descúbrelo aquí</a>
                </div>
            </div>

            <!--Sección de Retos-->
            <div class="section__item item-4">
                <div class="section__item--front">
                    <h2 class="seccion__title">Formulas</h2>
                </div>
                <!--Parte trasera-->
                <div class="section__item--back">
                    <p>
                        Encuentra y comprende las ecuaciones clave de la física.
                    </p>
                    <a href="formulas.html">Descúbrelo aquí</a>
                </div>
            </div>

            <!--Sección de Retos-->
            <div class="section__item item-5">
                <div class="section__item--front">
                    <h2 class="seccion__title">Datos curiosos</h2>
                </div>
                <!--Parte trasera-->
                <div class="section__item--back">
                    <p>
                        Descubre hechos sorprendentes que hacen la física fascinante.
                    </p>
                    <a href="datos.html">Descúbrelo aquí</a>
                </div>
            </div>

            <!--Sección de Retos-->
            <div class="section__item item-6">
                <div class="section__item--front">
                    <h2 class="seccion__title">Retos</h2>
                </div>
                <!--Parte trasera-->
                <div class="section__item--back">
                    <p>
                        Pon a prueba tu conocimiento con desafíos y problemas interesantes.
                    </p>
                    <a href="retos.html">Descúbrelo aquí</a>
                </div>
            </div>
        </div>
    </main>
    
    <!------ Pie de página ------>
    <footer class="site-footer">
        <p>&copy; 2024 Física en Contexto. Todos los derechos reservados.</p>
        <ul>
            <li><strong>Autor:</strong> Miguel Angel Jimenez Pérez</li>
            <li><strong>Escuela:</strong> CETiS núm. 141</li>
            <li><strong>Redes sociales:</strong> <a href="https://www.instagram.com/miguel_jp1003?igsh=dzByMW1seXgxMm1j">miguel_jp1003</a> y <a href="https://www.instagram.com/fisica_en_contexto_/profilecard/?igsh=MWttdHBvZHJtc2huMw==">fisica_en_contexto_</a></li>
        </ul>
    </footer>
</body>
</html>
