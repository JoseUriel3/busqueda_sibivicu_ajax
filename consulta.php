<?php
/////// CONEXIÓN A LA BASE DE DATOS /////////
$host = 'localhost';
$basededatos = 'sibivicu';
$usuario = 'root';
$contraseña = '';

$conexion = new mysqli($host,$usuario,$contraseña, $basededatos);
$conexion->query("SET NAMES 'utf8'");
if ($conexion -> connect_errno)
{
	die("Fallo la conexion:(".$conexion -> mysqli_connect_errno().")".$conexion-> mysqli_connect_error());
}

//////////////// VALORES INICIALES ///////////////////////

$tabla="";
$query="SELECT * FROM usuario ORDER BY NOMBRE";

///////// LO QUE OCURRE AL TECLEAR SOBRE EL INPUT DE BUSQUEDA ////////////
if(isset($_POST['alumnos']))
{
	$q=$conexion->real_escape_string($_POST['alumnos']);
	$query="SELECT * FROM usuario WHERE 
		ID_USUARIO LIKE '%".$q."%' OR
		NOMBRE LIKE '%".$q."%' OR
		AP_PAT LIKE '%".$q."%' OR
		AP_MAT LIKE '%".$q."%' OR
		GRADO LIKE '%".$q."%'";
}

$buscarAlumnos=$conexion->query($query);
if ($buscarAlumnos->num_rows > 0)
{
	$tabla.= 
	'<table class="table">
		<tr class="bg-primary">
			<td>ID ALUMNO</td>
			<td>NOMBRE</td>
			<td>AP_PAT</td>
			<td>AP_MAT</td>
			<td>GRADO</td>
		</tr>';

	while($filaAlumnos= $buscarAlumnos->fetch_assoc())
	{
		$tabla.=
		'<tr>
			<td>'.$filaAlumnos['ID_USUARIO'].'</td>
			<td>'.$filaAlumnos['NOMBRE'].'</td>
			<td>'.$filaAlumnos['AP_PAT'].'</td>
			<td>'.$filaAlumnos['AP_MAT'].'</td>
			<td>'.$filaAlumnos['GRADO'].'</td>
		 </tr>
		';
	}

	$tabla.='</table>';
} else
	{
		$tabla="No se encontraron coincidencias con sus criterios de búsqueda.";
	}


echo $tabla;
?>
