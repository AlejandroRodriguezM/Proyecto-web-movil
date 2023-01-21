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

if(isset($_POST['estadistica'])){
    $id = $_POST['id'];
    header("Location: phpspreadsheet/datos_excel.php?id=$id");
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
                    </div>
                </div>
                <?php
                $file_datos_usuario = "./csv/datos_usuarios.csv";
                $csv = array_map('str_getcsv', file('csv/datos_usuarios.csv'));

                echo "<table class='table table-striped table-hover' style='width: 78%;'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>ID de usuario</th>";
                echo "<th>Nombre del trabajador</th>";
                echo "<th>Numero de horas trabajadas</th>";
                echo "<th>Numero de telefonos arreglados</th>";
                echo "<th>Porcentaje de horas trabajadas</th>";
                echo "<th>Porcentaje de moviles trabajados</th>";
                echo "<th>Acción</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                foreach ($csv as $row) {
                    $id = $row[0];
                    $nombre = $row[1];
                    $horas_trabajadas = $row['2'];
                    $telefono_arreglados = $row['3'];
                    $porcentaje_horas =  porcentaje_horas($id,$file_datos_usuario);
                    $porcentaje_telefonos = porcentaje_moviles($id,$file_datos_usuario);
                    echo "<tr>";
                    echo "<td>$id</td>";
                    echo "<td>$nombre</td>";
                    echo "<td>" . $horas_trabajadas . "</td>";
                    echo "<td>" . $telefono_arreglados . "</td>";
                    echo "<td>" . $porcentaje_horas . "%</td>";
                    echo "<td>" . $porcentaje_telefonos . "%</td>";
                    echo "<form action='panel_usuario.php' method='post'>";
                    echo "<input type='hidden' name='id' value='$id'>";
                    echo "<td><input type='submit' name='estadistica' value='Descargar estadistica'></td>";

                    echo "</form>";
                }
                echo "</tr>";

                echo "</tbody>";
                ?>
                </table>
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
    <script src="./assets/js/login.js"></script>
    <script src="./assets/js/bootstrap.min.js"></script>
    <script src="assets/js/sweetalert2.all.min.js"></script>
</body>

</html>