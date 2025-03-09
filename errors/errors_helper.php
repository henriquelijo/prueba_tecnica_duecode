<?php

class errors_helper
{
    public static function writeError(array $errors)
    {
        $logFile ='./team_errors.log';

        foreach($errors as $error)
        {
            $fecha = date('Y-m-d H:i:s');
            $logMessage = "[$fecha] ERROR: $error\n";
            error_log($logMessage, 3, $logFile);
        }
    }
}

?>