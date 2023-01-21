<?php
session_start();
include_once 'php/funciones/funciones.php';
include_once 'php/funciones/funciones_csv.php';
checkCookiesUser();
$conexion = $_SESSION['conexion'];

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
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="assets/style/font-awesome.min.css">
    <link rel="stylesheet" href="assets/style/bootstrap3.min.css">
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

    deleteSliceCSV($id, $file_datos_usuario);
    deleteSliceCSV($id, $file_usuario);
}

if (isset($_POST['ver'])) {
    $tecnico = $_POST['tecnico'];
    $id = $_POST['id'];
    header("Location: estadisticas_empleado.php?id=$id&tecnico=$tecnico");
}
?>

<body>
    <!-- NAVEGACION -->
    <div class="countainer">
        <ul class="menu navbar-collapse">
            <li><a href="inicio.php">Inicio</a></li>
            <li><a href="crud.php">Gestionar</a></li>
            <?php
            if ($_SESSION['user'] == 'admin') {
                echo '<li><a href="panel_usuario.php">Panel de usuarios</a></li>';
            }
            ?>
            <li><a href="#!">Acerca de</a></li>
            <li><a onclick=closeSesion() style="cursor: pointer;">Salir</a></li>
        </ul>
        <div class="sesion">
            <p>Hora de conexión: <?php echo $conexion ?></p>
        </div>
        <div class="sesion">
            <p>Bienvenindo: <?php echo $_SESSION['user'] ?></p>
        </div>
        <!-- LOGO -->
        <div class="container-logo">
            <div class="box">
                <div class="title">
                    <span class="block"></span>
                    <h1 style="cursor: pointer;">Reparación de Móviles<span></span></h1>
                </div>

                <div class="role">
                    <div class="block"></div>
                    <p>Tienda Virtual</p>
                </div>
            </div>
        </div>
    </div>
    </nav>

    <!-- CONTENIDO -->
    <div class="tabla" style='width: 55%;'>
        <div class="container">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-6">
                            <h2>Datos de trabajadores</h2>
                        </div>
                        <table>
                            <tr>
                                <td style="padding-right: 10px;">
                                    <span>
                                        <i class="material-icons">
                                            <a href="#insertar" class="btn btn-success" data-toggle="modal">&#xE147;CREAR USUARIO</a>
                                        </i>
                                    </span>
                                </td>
                                <td style="padding-right: 10px;">
                                    <span>
                                        <i class="material-icons">
                                            <a href="./phpspreadsheet/datos_completos_excel.php" class="btn btn-success" data-toggle="modal">&#xE147;DESCARGAR EXCEL</a>
                                        </i>
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <?php

                    $csv = array_map('str_getcsv', file($file_datos_usuario));
                    if (num_users() > 1) {
                        echo "<table class='table table-striped table-hover' style='width: 78%;'>";
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th>ID de usuario</th>";
                        echo "<th>Nombre del trabajador</th>";
                        echo "<th>Numero de horas trabajadas</th>";
                        echo "<th>Numero de telefonos arreglados</th>";
                        echo "<th>Porcentaje de horas trabajadas</th>";
                        echo "<th>Porcentaje de moviles trabajados</th>";
                        echo "<th>Descargar estadistica</th>";
                        echo "<th>Ver tabla</th>";
                        echo "<th>Modificar usuario</th>";
                        echo "<th>Borrar usuario</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        foreach ($csv as $row) {
                            $id = $row[0];
                            $nombre = $row[1];
                            $horas_trabajadas = $row['2'];
                            $telefono_arreglados = $row['3'];
                            $porcentaje_horas =  porcentaje_horas($id, $file_datos_usuario);
                            $porcentaje_telefonos = porcentaje_moviles($id, $file_datos_usuario);
                            echo "<tr>";
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
                            echo "<input type='hidden' name='tecnico' value='$nombre'>";
                            echo "<td>";
                            echo "<i class='material-icons'>";
                            if ($id != 1) {
                                echo "<button type='submit' name='estadistica'>&#xE2C4;</button>";
                            } else {
                                echo "<button style='cursor: not-allowed' type='submit' name='estadistica' disabled>&#xE2C4;</button>";
                            }

                            echo "</i>";
                            echo "</td>";
                            echo "<td>";
                            echo "<i class='material-icons'>";
                            if ($id != 1) {
                                echo "<button type='submit' name='ver'>&#xE8EF;</button>";
                            } else {
                                echo "<button style='cursor: not-allowed' type='submit' name='ver' disabled>&#xE8EF;</button>";
                            }
                            echo "</i>";
                            echo "</td>";
                            echo "<td>";
                            if ($id != 1) {
                                echo "<button type='button' name='modificar' data-toggle='modal' data-id='$id' data-nombre='$nombre' data-password='' data-target='#modificar'>";
                                echo "<i class='material-icons'>&#xE254;</i>";
                                echo "</button>";
                                echo "</td>";
                            }
                            else{
                                echo "<button style='cursor: not-allowed' type='button' name='modificar' disabled>";
                                echo "<i class='material-icons'>&#xE254;</i>";
                                echo "</button>";
                                echo "</td>";
                            }
                            if ($id != 1) {
                    ?>
                            <td>
                                <i class='material-icons'>
                                    <button type='submit' name='borrar' onclick='return confirm("Estas seguro que quieres borrar el usuario?");'>&#xE92B;</button>
                                </i>
                            </td>
                            <?php
                            } else {
                                echo "<td>";
                                echo "<i class='material-icons'>";
                                echo "<button style='cursor: not-allowed' type='submit' name='borrar' disabled>&#xE92B;</button>";
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
        </div>
    </div>

    <!-- FORMULARIO INSERTAR -->
    <div id="insertar" class="modal fade">
        <div class="modal-dialog">
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
                            <label>Contraseña</label>
                            <input type="password" id="password_user" name="password_user" class="form-control">
                        </div>
                        <div class="modal-footer">
                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                            <input type="submit" class="btn btn-info" value="Guardar" onclick="new_user()">
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
                            <input type="password" id="password_trabajador" name="password_trabajador" class="form-control" value="">
                        </div>
                        <div class="modal-footer">
                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                            <input type="submit" class="btn btn-info" value="Modificar" onclick="modify_user()">
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
                    <a href="inicio.php">
                        <img src="assets/img/logo.png" alt="Logo Tienda reparación de Móviles">
                    </a>
                </figure>
            </div>
            <div class="box">
                <h2>SOBRE NOSOTROS</h2>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio, ipsa?</p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio, ipsa?</p>
            </div>
            <div class="box">
                <h2>SIGUENOS</h2>
                <div class="red-social">
                    <a href="#">link 1</a>
                    <a href="#">link 2</a>
                    <a href="#">link 3</a>
                </div>
            </div>
        </div>
        <div class="grupo-2">
            &copy; 2022 <b>Reparación de Móviles</b> - Tienda Virtual
        </div>
    </footer>
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
    <script src="./assets/js/login.js"></script>
    <script src="./assets/js/bootstrap.min.js"></script>
    <script src="assets/js/sweetalert2.all.min.js"></script>
</body>

</html>