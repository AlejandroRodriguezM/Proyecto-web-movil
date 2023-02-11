<?php
session_start();
include_once 'php/funciones/funciones.php';
include_once 'php/funciones/funciones_csv.php';
checkCookiesUser();
$hora_conexion = $_SESSION['conexion'];
$nombre = $_SESSION['user'];
$privilegio = privilegio_usuario($nombre);

if (!isset($_SESSION['user']) || !isset($_COOKIE['adminUser'])) {
    header('Location: inicio.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="./assets/img/webico.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/style/styleCrud.css">
    <link rel="stylesheet" href="assets/style/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <title>Panel de administracion</title>
</head>
<?php
$file_datos_usuario = "./csv/datos_usuarios.csv";
$file_usuario = "./csv/usuarios.csv";

if (isset($_POST['estadistica'])) {
    $id = $_POST['id'];
    header("Location: phpspreadsheet/datos_excel.php?id=$id");
}

if (isset($_POST['borrar'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    deleteSliceCSV($id, $file_datos_usuario);
    deleteSliceCSV($id, $file_usuario);
    delete_directory($id, $nombre);
}

if (isset($_POST['ver'])) {
    $tecnico = $_POST['tecnico'];
    $id = $_POST['id'];
    header("Location: estadisticas_empleado.php?id=$id&tecnico=$tecnico");
}
?>

<body onload="comprobarLogin()">
    <!-- NAVEGACION -->
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
                    <a href="panel_usuario.php">Panel de usuarios</a>
                    </li>';
                }
                ?>
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

    <!-- CONTENIDO -->
    <div class="tabla">
        <div class="container">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-6">
                            <h2>Datos de trabajadores</h2>
                        </div>
                    </div>
                </div>
                <table>
                    <tr>
                        <td>
                            <span>
                                <i class="material-icons">
                                    <a href="#insertar" class="btn btn-success" data-toggle="modal">&#xE147;CREAR USUARIO</a>
                                </i>
                            </span>
                        </td>
                        <td>
                            <span>
                                <i class="material-icons">
                                    <a href="./phpspreadsheet/datos_completos_excel.php" class="btn btn-success" data-toggle="modal">&#xE147;DESCARGAR EXCEL</a>
                                </i>
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
            <br>
            <?php
            $csv = array_map('str_getcsv', file($file_datos_usuario));
            if (num_users() > 1) {
                echo "<table class=' table-striped table-hover'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th class='table-header'>Imagen de perfil</th>";
                echo "<th class='table-header'>ID de usuario</th>";
                echo "<th class='table-header'>Nombre del trabajador</th>";
                echo "<th class='table-header'>Numero de horas trabajadas</th>";
                echo "<th class='table-header'>Numero de telefonos arreglados</th>";
                echo "<th class='table-header'>Porcentaje de horas trabajadas</th>";
                echo "<th class='table-header'>Porcentaje de moviles trabajados</th>";
                echo "<th class='table-header'>Descargar estadistica</th>";
                echo "<th class='table-header'>Ver tabla</th>";
                echo "<th class='table-header'>Modificar usuario</th>";
                echo "<th class='table-header'>Borrar usuario</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                $file = './csv/usuarios.csv';
                $picture = pictureProfile($file, $login);
                for ($i = 0; $i < count($csv); $i++) {
                    $row = $csv[$i];
                    $id = $row[0];
                    $nombre = $row[1];
                    $picture = pictureProfile($file, $nombre);
                    $horas_trabajadas = $row['2'];
                    $telefono_arreglados = $row['3'];
                    $porcentaje_horas =  porcentaje_horas($id, $file_datos_usuario);
                    $porcentaje_telefonos = porcentaje_moviles($id, $file_datos_usuario);
                    echo "<tr>";
            ?>
                    <td>
                        <input type='hidden' name='avatarUser'>
                        <input type='image' src='<?php echo $picture ?>' class='avatarPicture' name='avatarUser' id='avatar_<?php echo $id ?>' alt='Avatar' onclick="pictureProfileUser('avatar_<?php echo $id ?>')">
                    </td>
                    <?php
                    echo "<td>$id</td>";
                    echo "<td>$nombre</td>";
                    echo "<td>" . $horas_trabajadas . "</td>";
                    echo "<td>" . $telefono_arreglados . "</td>";
                    if ($horas_trabajadas > 0 || $id != 1) {
                        echo "<td>" . $porcentaje_horas . "%</td>";
                    } else {
                        echo "<td style='color: red;'>" . $porcentaje_horas . "</td>";
                    }
                    if ($telefono_arreglados > 0 || $id != 1) {
                        echo "<td>" . $porcentaje_telefonos . "%</td>";
                    } else {
                        echo "<td style='color: red;'>" . $porcentaje_telefonos . "</td>";
                    }
                    echo "<form action='panel_usuario.php' method='post'>";
                    echo "<input type='hidden' name='id' value='$id'>";
                    echo "<input type='hidden' name='nombre' value='$nombre'>";
                    echo "<input type='hidden' name='tecnico' value='$nombre'>";
                    echo "<td>";
                    echo "<i class='material-icons'>";
                    if ($id != 1) {
                        echo "<button class='edit' type='submit' name='estadistica'>&#xE2C4;</button>";
                    } else {
                        echo "<button class='edit' style='cursor: not-allowed' type='submit' name='estadistica' disabled>&#xE2C4;</button>";
                    }

                    echo "</i>";
                    echo "</td>";
                    echo "<td>";
                    echo "<i class='material-icons'>";
                    if ($id != 1) {
                        echo "<button class='edit' type='submit' name='ver'>&#xE8EF;</button>";
                    } else {
                        echo "<button class='edit' style='cursor: not-allowed' type='submit' name='ver' disabled>&#xE8EF;</button>";
                    }
                    echo "</i>";
                    echo "</td>";
                    echo "<td>";
                    if ($id != 1) {
                        echo "<button class='edit' type='button' name='modificar' data-toggle='modal' data-id='$id' data-nombre='$nombre' data-password='' data-target='#modificar'>";
                        echo "<i class='material-icons'>&#xE254;</i>";
                        echo "</button>";
                        echo "</td>";
                    } else {
                        echo "<button class='edit' style='cursor: not-allowed' type='button' name='modificar' disabled>";
                        echo "<i class='material-icons'>&#xE254;</i>";
                        echo "</button>";
                        echo "</td>";
                    }
                    if ($id != 1) {
                    ?>
                        <td>
                            <i class='material-icons'>
                                <button class='edit' type='submit' name='borrar' onclick='return confirm("Estas seguro que quieres borrar el usuario?");'>&#xE92B;</button>
                            </i>
                        </td>
            <?php
                    } else {
                        echo "<td>";
                        echo "<i class='material-icons'>";
                        echo "<button class='edit' style='cursor: not-allowed' type='submit' name='borrar' disabled>&#xE92B;</button>";
                        echo "</i>";
                        echo "</td>";
                    }
                    echo "</form>";
                }
                echo "</tr>";
                echo "</tbody>";
            } else {
                echo "<h2>No hay usuarios registrados</h2>";
            }
            ?>
            </table>
        </div>
    </div>

    <!-- FORMULARIO INSERTAR -->
    <div class="modal fade" id="insertar" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="post" id="formInsert" onsubmit="return false;">
                    <div class="modal-header">
                        <h4 class="modal-title">Insertar</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nombre de usuario</label>
                            <input type="text" id="nombre_user" name="nombre_user" class="form-control">
                            <input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo num_id() ?>">
                        </div>
                        <div class="form-group">
                            <img class="chosenUserProfile mb-2" id="output" src="./assets/img/chosePicture.png" />
                            <input class="form-control" type="file" name="files" id="files1" accept=".jpg, .png" onchange="loadFile(event)">
                        </div>
                        <div class="modal-footer">
                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                            <input type="submit" class="btn btn-info" value="Guardar" onclick="new_user()">
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
                                document.getElementById('files1').addEventListener('change', handleFileSelect, false);
                            </script>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- FORMULARIO MODIFICAR -->
    <div id="modificar" class="modal fade">
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
                            <input type="text" class="form-control" id="nombre_trabajador" name="nombre_trabajador" value="">
                            <input type="hidden" id="id_trabajador" name="id_trabajador" value="">
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
                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
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
    <script>
        $('#modificar').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var id = button.data('id');
            var nombre = button.data('nombre');
            var password = button.data('password');
            populateModalForm(id, nombre, password);
        });

        function populateModalForm(id, nombre, password) {
            var modal = $('#modificar');
            modal.find('#nombre_trabajador').val(nombre);
            modal.find('#id_trabajador').val(id);
            modal.find('#password_trabajador').val(password);
        }
    </script>

    <script src="assets/js/login.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="assets/js/sweetalert2.all.min.js"></script>
    <script src="assets/js/funciones.js"></script>

</body>

</html>