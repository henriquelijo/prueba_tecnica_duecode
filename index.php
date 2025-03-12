<?php
spl_autoload_register(function ($class) {
    $file = __DIR__ . "/controllers/{$class}.php"; 

    if (!file_exists($file)) {
        $file = __DIR__ . "/models/{$class}.php"; 
    }

    if (!file_exists($file)) {
        $file = __DIR__ . "/repository/{$class}.php"; 
    }

    if (!file_exists($file)) {
        $file = __DIR__ . "/middlewares/{$class}.php"; 
    }

    if (file_exists($file)) {
        require_once $file;
    } else {
        die("Error: No se pudo cargar la clase {$class} (Archivo no encontrado: {$file})");
    }
});
?>
