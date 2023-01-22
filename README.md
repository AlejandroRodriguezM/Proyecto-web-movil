# Proyecto-web-Moviles
Proyecto WEB para php y JavaScript para clase como proyecto de reparacion de telefono.
--> 28/12/22
Subida del diseño y estilo del index.
Javascript para la verificación del formulario de login

--> 02/01/23 Antonia Log 1
Se subió el CRUD
Se renombró el inicio y login

-->02/01/2023 Alejandro Log 1
Crear cockies
Validacion de datos mediante JS front-end
Validacion de datos PHP backEnd
Creacion de sessiones en JS y php
Modificacion del HTML.
Creadas 2 nuevos ficheros php de funciones de csv y de validacion de datos y creacion de coockies
Crear ficheroi CSV para prueba de acceso
creado php logOut.php para eliminar cockies y sesions

--> 06/01/2023 Inma Log 2
Dar estilo, creación del menú, footer y logo
Renombrar CRUD por crud.php y eliminación de algún archivo css que no estaba en uso
Renombrar archivos de estilo para que quede más claro:
- style.css es el estilo general para el menú de navegación, logo, footer, que se repite en las páginas inicio y crud
- el styleCrud y styleInicio, los estilos individuales de cada una de las pags

--> 06/01/2023 Alejandro Log 1
Cambios en ficheros PHP en las variables $session.
Ahora el nombre de usuario se muestra usando JavaScript
Se ha solucionado el bug visual de inicio de sesion(icono de success)

--> 07/01/2023 Alejandro Log 1
Arreglado bug a la hora de acceder al login
Funcionalidad de insertar peticion de movil creada.

--> 07/01/2023 Alejandro Log 2
Se ha añadido un ID a la hora de crear peticion de telefono.
Se ha agregado la funcionalidad de gestion de telefonos.
Queda por arreglar a la hora de modificar que no solamente tenga en cuenta el ultimo row del bucle

--> 08/01/2023 Alejandro Log 1
Se puede ver los datos del fichero csv
A la hora de editar, se puede ver en el model los datos del row especifico
Queda por arreglar la edicion, para que modifique un row especifico en vez de añadir nuevos datos como row independiente

--> 08/01/2023 Alejandro Log 2
Se ha eliminado la linea de descripcion en el CSV
Se ha corregido la modificacion de datos del csv, ahora puede editar solamente la linea deseada de forma correcta(faltara debugear)
Arreglado unn bug donde nunca se modificaba el row y solamente se creaba uno nuevo

--> 08/01/2023 Alejandro Log 3
Arreglado bug que no actualizaba correctamente los slce del csv cuando se modificaba uno que no fuese el primero
Arreglado bug qaue hacia que todos los ID fuesen 1

--> 08/01/2023 Alejandro Log 4
Añadidos 2 paginas mas, que son crud pero que muestran solamente los telefonos arreglados o averiados.
Se ha arreglado varias funciones de creacion de csv.

--> 08/01/2023 Alejandro Log 5
Modificado el valor de id para el form de eliminacion, la funcion async referente a la eliminacion de un slice funciona y capta correctamente los datos.
Elimina un slice concreto de forma correcta
Actualizado el resto de ficheros con crud

--> 09/01/2023 Alejandro Log 1
Arreglado bug visual de las tablas

--> 09/01/2023 Alejandro Log 2
Modificadas las funciones de edicion y borrado y añadir datos de moviles.
Eliminado bug que no permitia el uso correcto del fichero csv moviles.csv

--> 13/01/2023 Alejandro Log 1
Se ha añadido un nunevo campo a la hora de dar por resuleto un telefono, ahora se puede de añadir coste de reparacion

--> 17/01/2023 Alejandro Log 1
Cambio en funciones para añadir tiempo estimado de reparacion y tiempo total real de reparacion, aun no funciona correctamente

--> 17/01/2023 Alejandro Log 2
Ya se guarda correctamente el total de precio/hora trabajado y estimado.

--> 18/01/2023 Alejandro Log 1
Aun no funciona, crear pdf de la factura especifica

--> 18/01/2023 Alejandro Log 2
Ya se pueden descargar facturas de telefonos ya solucionados

--> 20/01/2023 Alejandro Log 1
Cambios importantes, mas detalles mas adelante(no funciona bien descargar estadisticas)

--> 21/01/2023 Alejandro Log 1
El csv de usuarios ahora tiene ID
Ahora hay un nuevo user que es un administrador
Hay panel de control de usuarios, para ver de los trabajadores en la ficha, cuántos móviles han arreglado y cuántas horas han trabajado
Se puede descargar Excel sobre cada trabajador y sus logros de trabajo
Hay un nuevo csv donde se guarda dicha info para verla en la tabla, se actualiza cada vez que se edite un teléfono como terminado
Instalada la libreria phpspreadsheet con composer para la descarga de ficheros excel
Nuevas funciones para calcular el porcentaje correspondiente a cada campo

--> 21/01/2023 Alejandro Log 2
Se pueden crear usuarios
Se pueden borrar usuarios

--> 21/01/2023 Alejandro Log 3
Se pueden descargar un excel completo de todos los trabajadores
Se pueden modificar datos de los trabajadores, como el nombre y password
Solamente el administrador puede modificar los datos de un movil ya reparado
Solamente el administrador puede borrar moviles

--> 22/01/2023 Alejandro Log 1
Mejorado el nav-bar-menu de la pagina, queda mejorar las animaciones






