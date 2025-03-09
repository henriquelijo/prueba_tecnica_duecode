<?php

require_once '../repository/UserRepository.php';
require_once './HomeController.php';
require_once '../middlewares/SessionMiddleware.php';

class LoginController
{
    public $errors = [];

    public function loginValidation($data)
    {
        if (isset($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return "Email invalid";
        }
        
        $user_validated = new UserRepository();
        $pass = $user_validated->getByEmail($data['email']);
        
        if (password_verify($data['password'], $pass['password'])){
            
            session_start();
            
            $_SESSION['id'] = $pass['id'];
            $_SESSION['password'] = $pass['password'];
            
            $home = new HomeController();
            return $home->home();
        }else{
            SessionMiddleware::invalid();
        };
        
    }
    
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $class = new LoginController;
    
    $validation = $class->loginValidation($_POST);

}else{
    echo '<h3>Error al enviar formulario</h3>';
}

?>