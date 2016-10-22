<?php
$datos['$carpeta'] = $carpeta = "../Public/productos/imagenes/";
$datos['$imagen'] = $imagen = $_FILES['imagen']['name'];
$datos['$imagen_temporal'] = $imagen_temporal = $_FILES['imagen']['tmp_name'];
$datos['$url'] = $url = $carpeta . $imagen;
$datos['$url_mostrar'] = $url_mostrar = "Public/productos/imagenes/" . $imagen;

$infoImagenesSubidas = array();
$datos['$mover'] = $mover = move_uploaded_file($imagen_temporal, $url);

$infoImagenesSubidas[0] = array("caption" => "$imagen", "height" => "120px", "url" => "System/borrar.php", "key" => $imagen);
$ImagenesSubidas[0] = "<img  height='120px' src='$url_mostrar' class='file-preview-image'>";

$arr = array("file_id" => 0, "overwriteInitial" => true, "initialPreviewConfig" => $infoImagenesSubidas, "initialPreview" => $ImagenesSubidas);

echo json_encode($arr);
?>

