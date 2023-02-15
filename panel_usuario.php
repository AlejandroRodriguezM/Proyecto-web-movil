<?php
session_start();
include_once 'php/funciones/funciones.php';
include_once 'php/funciones/funciones_csv.php';
checkCookiesUser();
$hora_conexion = $_SESSION['conexion'];
$nombre = $_SESSION['user'];
$id_user = id_user($nombre);
$privilegio = privilegio_usuario($nombre);
$csv = csvtoarray('./csv/usuarios.csv');
$pass = check_pass($nombre, $csv);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="./assets/img/webico.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/style/styleCrud.css">
    <link rel="stylesheet" href="assets/style/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <title>Tienda Virtual de Reparación de Móviles</title>

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-dark" style="background-color: #333 !important;">
        <div class="container-logo">
            <div class="box">
                <div class="title">
                    <span class="block"></span>
                    <a href="inicio.php">
                        <h1 style="cursor: pointer;">Reparación de Móviles<span></span></h1>
                    </a>
                </div>
            </div>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active efecto">
                    <a href="inicio.php">Inicio</a>
                </li>
                <li class="nav-item active efecto"">
                    <a href=" gestion_moviles.php">Gestionar</a>
                </li>
                <?php
                if ($privilegio == 'admin') {
                    echo '<li class="nav-item active efecto"">
                    <a href="panel_administrador.php">Panel de administracion</a>
                    </li>';
                }
                ?>
                <li class="nav-item active efecto"">
                    <a href=" panel_usuario.php">Panel de usuario</a>
                </li>
                <li class="nav-item active efecto"">
                    <a href=" acercade.php">Acerca de</a>
                </li>
                <li class="nav-item active efecto"">
                    <a href=" #!" onclick=closeSesion() style="cursor: pointer;">Salir</a>
                </li>
            </ul>
            <span class="navbar-text">
                <ul class="navbar-nav mr-auto">
                    <?php
                    $file = './csv/usuarios.csv';
                    $login = $_SESSION['user'];
                    $picture = pictureProfile($file, $login);
                    echo "<img src='$picture' id='avatar' alt='Avatar' class='avatarPicture' onclick='pictureProfileAvatar()'>";
                    ?>

                    <div id="myModal" class="modal_picture" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <span class="close"></span>
                        <!-- Modal Content (The Image) -->
                        <img class="modal_picture-content" id="img01">
                    </div>

                    <li class="nav-item usuario" style="margin-top: 15px;">
                        Bienvenido <?php echo $_SESSION['user'] ?>
                    </li>
                    <li class="nav-item usuario" style=" margin-top: 15px;">
                        Hora de conexión: <?php echo $hora_conexion ?>
                    </li>
                </ul>
            </span>
        </div>
    </nav>

    <?php if (password_verify($nombre, $pass)) { ?>
        <!-- FORMULARIO INSERTAR -->
        <div id="new_pass" class="modal fade" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post" id="modal_pass" onsubmit="return false;">
                        <div class="modal-header">
                            <h4 class="modal-title">Insertar</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Nueva contraseña</label>
                                <input type="hidden" id="nombre_trabajador" value='<?php echo $nombre ?>' class="form-control">
                                <input type="text" id="password_trabajador" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-info" value="Guardar" onclick="modify_pass()">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php } ?>

        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" id="formModify" onsubmit="return false;">
                    <div class="modal-header">
                        <h4 class="modal-title">Modificar Usuario</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nombre de usuario</label>
                            <input type="text" class="form-control" id="nombre_trabajador" name="nombre_trabajador" value="<?php echo nombre_tecnico($id_user) ?>" readonly>
                            <input type="hidden" id="id_trabajador" name="id_trabajador" value="<?php echo $id_user ?>">
                        </div>
                        <div class="form-group">
                            <label>Contraseña</label>
                            <div class="input-group">
                                <input type="password" id="password_trabajador" name="password_trabajador" class="form-control">
                                <div class="input-group-append">
                                    <span class="input-group-text" onclick="password_show_hide('trabajador');">
                                        <i class="fas fa-eye" id="show_eye_trabajador"></i>
                                        <i class="fas fa-eye-slash d-none" id="hide_eye_trabajador"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <img class="chosenUserProfile mb-2" id="output2" src="./assets/img/chosePicture.png" />
                            <input class="form-control" type="file" name="files" id="files2" accept=".jpg, .png" onchange="loadFile2(event)">
                        </div>
                        <div class="modal-footer">
                            <a href="inicio.php"><input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar"></a>
                            <input type="submit" class="btn btn-info" value="Modificar" onclick="modify_user()">
                            <script>
                                function handleFileSelect(evt) {
                                    var f = evt.target.files[0]; // FileList object
                                    var reader = new FileReader();
                                    // Closure to capture the file information.
                                    reader.onload = (function(theFile) {
                                        return function(e) {
                                            var binaryData = e.target.result;
                                            //Converting Binary Data to base 64
                                            var base64String = window.btoa(binaryData);
                                            //save into var globally string
                                            image = base64String;
                                        };
                                    })(f);
                                    // Read in the image file as a data URL
                                    reader.readAsBinaryString(f);
                                }
                                document.getElementById('files2').addEventListener('change', handleFileSelect, false);
                            </script>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    <!-- FOOTER -->
    <footer class="pie-pagina">
        <div class="grupo-1">
            <div class="box">
                <figure>
                    <a href="https://iesplayamar.es/" class="enlace_footer" target="_blank" style="margin-right: 150px;">
                    </a>
                    <a href="inicio.php">
                        <img src="assets/img/logo.png" alt="Logo Tienda reparación de Móviles">
                    </a>
                </figure>
            </div>
            <div class="box">
                <h2>SOBRE LA WEB</h2>
                <p>Proyecto de reparación de móviles enfocado para el uso por parte del alumnado de FP Básica del Instituto I.E.S. Playamar. </p>
                <p>Este proyecto forma parte de los módulos Desarrollo Web en Entorno Cliente y Desarrollo Web en Entorno de Servidor.</p>
            </div>
            <div class="box">
                <h2>REDES SOCIALES</h2>
                <div class="red-social">
                    <a href="https://twitter.com/iesplayamar" target="_blank"> <img src="assets/icons/Twitter.svg" alt="Twitter" width="50px"></a>
                    <a href="https://www.facebook.com/profile.php?id=100075955310474" target="_blank"> <img src="assets/icons/Facebook.svg" alt="Facebook" width="50px"></a>
                    <a href="https://www.instagram.com/iesplayamar/" target="_blank"> <img src="assets/icons/Instagram.svg" alt="Instagram" width="50px"></a>
                </div>
            </div>
        </div>
        <div class="grupo-2">
            &copy; 2023 <b>Reparación de Móviles</b> - Tienda Virtual
        </div>
    </footer>

    <script type="text/javascript">
        window.onload = function() {
            OpenBootstrapPopup();
        };

        function OpenBootstrapPopup() {
            $("#new_pass").modal('show');
        }
    </script>
    <script>
        function password_show_hide(id) {
            var passwordField = document.getElementById("password_" + id);
            var showEye = document.getElementById("show_eye_" + id);
            var hideEye = document.getElementById("hide_eye_" + id);
            hideEye.classList.remove("d-none");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                showEye.style.display = "none";
                hideEye.style.display = "block";
            } else {
                passwordField.type = "password";
                showEye.style.display = "block";
                hideEye.style.display = "none";
            }
        }
    </script>
    <!-- SCRIPTS -->
    <script src="./assets/js/login.js"></script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="assets/js/sweetalert2.all.min.js"></script>
    <script src="assets/js/funciones.js"></script>

</body>

</html>