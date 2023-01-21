<?php
session_start();
include_once 'php/funciones/funciones.php';
include_once 'php/funciones/funciones_csv.php';
checkCookiesUser();
$conexion = $_SESSION['conexion'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Tienda Virtual de Reparación de Móviles - Reparacion</title>
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="assets/style/font-awesome.min.css">
	<link rel="stylesheet" href="assets/style/bootstrap3.min.css">
	<link rel="stylesheet" href="assets/style/styleCrud.css">
	<link rel="stylesheet" href="assets/style/style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
</head>

<body onload="comprobarLogin()">
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
	<!-- center the nav  -->
	<nav class="center">
		<div class="countainer">
			<ul class="menu">
				<li><a href="CRUD.php">Todos</a></li>
				<li><a href="averiados.php">Averiados</a></li>
				<li><a href="reparados.php">Arreglados</a></li>
			</ul>
	</nav>
	<div class="tabla">
		<div class="container">
			<div class="table-wrapper">
				<div class="table-title">
					<div class="row">
						<div class="col-sm-6">
							<h2>Telefonos reparados</h2>
						</div>
					</div>
				</div>
				<table class="table table-striped table-hover" style="width: 78%;">
					<?php
					$file = './csv/moviles.csv';
					//mostrar todo apartir del 1º row
					if (!file_exists($file)) {
						echo "<h2>No hay datos</h2>";
					} else {
						$csv = array_map('str_getcsv', file('csv/moviles.csv'));
						if (countRowsCSVResueltos($file) >= 1) {
					?>
							<thead>
								<tr>
									<th>ID</th>
									<th>Nombre</th>
									<th>Email</th>
									<th>Problema del móvil</th>
									<th>Fecha</th>
									<th>Resuelto</th>
								</tr>
							</thead>
							<tbody>
						<?php
							foreach ($csv as $row) {
								$id = $row[0];
								$nombre = $row[1];
								$email = $row[2];
								$problema = $row[3];
								$fecha_entrega = $row[4];
								$fecha_terminado = $row[5];
								$horas_estimadas = $row[6];
								$horas_reales = $row[7];
								$resuelto = $row[8];
								$tecnico = $row[9];
								if ($resuelto == 'Si') {
									echo "<tr>";
									echo "<td>$id</td>";
									echo "<td>$nombre</td>";
									echo "<td>$email</td>";
									echo "<td>$problema</td>";
									echo "<td>$fecha_entrega</td>";
									echo "<td>$resuelto</td>";
									echo "<td>";
									if ($resuelto == 'Si') {
										$numFactara = $row[10];
										echo "<a class='edit' style='cursor: not-allowed'><i class='material-icons' data-toggle='tooltip' title='Editar'>&#xE254;</i></a>";
										if ($_SESSION['user'] == 'admin') {
											echo "<a href='#deleteEmployeeModal' data-id_delete='$id' class='delete' data-toggle='modal' ><i class='material-icons' data-toggle='tooltip' title='Eliminar'>&#xE872;</i></a>";
										}
										//make input submit
										echo "<form method='post' action='php/funciones/factura.php'>";
										echo "<input type='hidden' name='nombre_cliente_test' id='nombre_cliente_test' value='$nombre'>";
										echo "<input type='hidden' name='email_cliente_test' id='email_cliente_test' value='$email'>";
										echo "<input type='hidden' name='problema_cliente_test' id='problema_cliente_test' value='$problema'>";
										echo "<input type='hidden' name='fecha_cliente_test' id='fecha_cliente_test' value='$fecha_entrega'>";
										echo "<input type='hidden' name='fecha_terminado_test' id='fecha_terminado_test' value='$fecha_terminado'>";
										echo "<input type='hidden' name='horas_reales_test' id='horas_reales_test' value='$horas_reales'>";
										echo "<input type='hidden' name='tecnico_test' id='tecnico_test' value='$tecnico'>";
										echo "<input type='hidden' name='numFactura_test' id='numFactura_test' value='$numFactara'>";
										echo "<td><button type='submit' class='edit' name='submit' value='submit'>Generar PDF</button></td>";
										echo "</form>";
									} else {
										echo "<a href='#editEmployeeModal' class='edit' data-toggle='modal' data-id='$id' data-nombre='$nombre' data-email='$email' data-problema='$problema' data-fecha='$fecha_entrega' data-fecha_terminado='$fecha_terminado' data-horas_estimadas='$horas_estimadas' data-resuelto='$resuelto'><i class='material-icons' data-toggle='tooltip' title='Editar'>&#xE254;</i></a>";
									}

									echo "</td>";
									echo "</tr>";
								}
							}
							echo "</tbody>";
						} else {
							echo "<h2>No hay moviles reparados</h2>";
						}
					}
						?>
				</table>
			</div>
		</div>
	</div>

	<div id="deleteEmployeeModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form method="post" onsubmit="return false;">
					<div class="modal-header">
						<h4 class="modal-title">Eliminar</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<p>¿Estás seguro/a que quieres eliminarlo?</p>
						<p class="text-warning"><small>Esta acción no se puede deshacer</small></p>
					</div>
					<div class="modal-footer">
						<input type="hidden" class="form-control" name="id_eliminar" id="id_eliminar" value="">
						<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
						<input type="submit" class="btn btn-danger" value="Eliminar" onclick=delete_slice_CSV()>
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

	<!-- SCRIPTS -->
	<script>
		$('#deleteEmployeeModal').on('show.bs.modal', function(event) {
			var button = $(event.relatedTarget); // Button that triggered the modal
			var id = button.data('id_delete');
			deleteModalForm(id);
		});

		function deleteModalForm(id) {
			$('#deleteEmployeeModal input[name="id_eliminar"]').val(id);
		}
	</script>
	<script src="./assets/js/login.js"></script>
	<script src="./assets/js/bootstrap.min.js"></script>
	<script src="assets/js/sweetalert2.all.min.js"></script>
</body>

</html>