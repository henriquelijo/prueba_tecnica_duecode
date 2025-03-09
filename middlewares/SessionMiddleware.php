<?php

require_once '../repository/UserRepository.php';

class SessionMiddleware {

    public static function invalid()
    {   
        header("Location: ../html/views/login/login.html");
        exit;
    }

    public static function handle() {
        if (!isset($_SESSION) || !session_status() == PHP_SESSION_ACTIVE) {
            self::invalid();
        }

        if (!isset($_SESSION['id']) || !isset($_SESSION['password'])) {
            self::invalid();
        }
        
        $user = new UserRepository;
        $valid = $user->getById($_SESSION['id']);
        
        if(!is_object($valid)){
            self::invalid();
        };
        
        if($valid->getPassword() != $_SESSION['password']){
            self::invalid();
        }
        
        return true;
    }
}
