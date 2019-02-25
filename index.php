<?php
spl_autoload_register(function($clase) {
    require_once "$clase.php";
});

$miConexion = new BD("172.17.0.2");
$familia = null;
$productos = [];
$filas = $miConexion->select("select * from familia");
$tabla= "";

if (isset($_POST['submit'])) { 
    $familia = $_POST['familia'];
    $consulta = "select * from producto where familia ='$familia'";
    $productos = $miConexion->select($consulta);
    $tabla = tabla($miConexion, $productos);
}

function tabla($miConexion,$productos){
    $campos = $miConexion->nomCol("producto");
    $tabla = "<table><tr><th>$campos[1]</th><th>$campos[2]</th><th>$campos[3]</th><th>$campos[4]</th></tr>";
                foreach ($productos as $datos) {
                    $tabla .= "<form method='POST' action='editar.php'> "
                                . "<input type='hidden' name='nomProducto' value='$datos[2]'/>"
                                . "<tr>"
                                    . "<td>$datos[1]</td>"
                                    . "<td>$datos[2]</td>"
                                    . "<td>$datos[3]</td>"
                                    . "<td>$datos[4]</td>"
                                    . "<td><input type='submit' value='Editar' name='submit'<td>"
                                . "</tr>"
                            . "</form>";
                }
    $tabla .= "</table>";
    return $tabla;
}

$miConexion->cerrar();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>Ejercicio productos</title>
        <style>
            table, tr, th, td{
                border: 1px solid black;
                border-collapse: collapse; 
                padding: 10px;
            }
            th{
                background-color: gainsboro;
            }

        </style>
    </head>
    <body>
        <h2>Selecciona una familia de productos</h2>
        <form action ="index.php" method="POST">
            <select name="familia">    
                <?php
                foreach ($filas as $fila) {
                    $check = ($familia == $fila[0]) ? "selected" : null;
                    echo "<option $check value=$fila[0]> $fila[1] </option>";
                }
                ?>
            </select>
            <input type="submit" value="Enviar" name="submit"/><br/><br/>
        </form>
            <?php
                echo $tabla;
            ?>
    </body>
</html>
