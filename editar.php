<?php
spl_autoload_register(function($clase) {
    require_once "$clase.php";
});

$miConexion = new BD("172.17.0.2");
$producto = [];

if(isset($_POST['submit'])){
    $nomProducto=$_POST['nomProducto'];
    $consulta = "select * from producto where nombre_corto = '$nomProducto'";
    $producto = $miConexion->select($consulta);
    var_dump($producto);
}

$miConexion->cerrar();
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Formulario de edición</title>
    </head>
    <body>
        <h1>Edición de un producto</h1>
        <h2>Producto:</h2>
        <form>
            <label>Nombre corto:</label>
            <input type="text" name="nomCorto" value="<?php echo $nomProducto;?>">
            <label>Nombre:</label>
            <input type="textarea" name="nom" value="<?php echo $producto[1];?>">
            <label>Descripción:</label>
            <input type="textarea" name="desc" value="<?php echo $producto[3];?>">
            <label>PVP:</label>
            <input type="text" name="pvp" value="<?php echo $producto[4];?>">
        </form>
    </body>
</html>
