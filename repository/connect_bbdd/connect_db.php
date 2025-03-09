<?php

include_once 'configuration.php';
//require_once '../../logs/errors_log.php';

class ConnectDb
{
    public static function connect(){
        
        try {
            // Crear una nueva conexión PDO
            $dsn = "mysql:host=" . host . ";port=" . port . ";dbname=" . dbname;
            $pdo = new PDO($dsn, username, password);
            
            // Configurar el modo de error de PDO para lanzar excepciones
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Establecer el juego de caracteres a UTF-8
            $pdo->exec("set names utf8");

            return $pdo;
        } catch (PDOException $e) {
            $error = "Error al insertar equipo: " . $e->getMessage();
            log_helper::writeError($error);
            echo "Error de conexión: " . $e->getMessage();
            return null;
        }
    }
}
?>
