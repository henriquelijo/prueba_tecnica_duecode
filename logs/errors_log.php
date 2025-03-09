<?php
class log_helper
{
    public static function writeError(string $errors)
    {
        $logFile = './errors.log';

        $fecha = date('Y-m-d H:i:s');
        $logMessage = "[$fecha] ERROR: $errors\n";
        error_log($logMessage, 3, $logFile);
        
    }
}
?>
