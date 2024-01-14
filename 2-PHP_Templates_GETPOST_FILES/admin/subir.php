<?php
    // $_FILE['nombreInput']['atributo']
    $nombre = $_FILES['fichero']['name'];
    // Ver toda la info
    echo "<pre>";
    echo var_dump($_FILES['fichero']);
    echo "</pre>";

    // Limitar el tipo de archivo
    if(mime_content_type($_FILES['fichero']['tmp_name']) !="image/jpeg" &&
    mime_content_type($_FILES['fichero']['tmp_name']) !="image/png") {
        echo "Tipo de fichero no admitido";
        exit;
    }

    // Limitar el tamano (/1024 para saber los Kb -- Kb)
    if(($_FILES['fichero']['size']/1024) > 3072) {
        echo "Archivo muy pesado";
    }

    // Comprobar si el directorio existe
    if(!file_exists("../archivos")) {
        // Crear el directorio si no existe - permisos de escritura y lectura
        if(!mkdir("../archivos", 0777)){
            echo "Error al crear el directorio";
            exit;
        }
    } 

    // Dar permisos lectura y escritura
    chmod("../archivos", 0777);
    
    // Guardar el archivo en el servidor
        // move_uploaded_file(archivoTemporal, carpetaDestino)
    if(move_uploaded_file($_FILES['fichero']['tmp_name'], 
    "../archivos/".$_FILES['fichero']['name'])) {
        echo "Guardado correctamente";
    } else {
        echo "Error al subir el archivo";
    }