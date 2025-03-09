<?php

require_once '../models/User.php';
require_once '../repository/UserRepository.php';

class RegisterController
{
    public $errors = [];

    private function saveUser($data)
    {
        $date = date('Y-m-d H:i:s');

        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

        $user = new User(
            null,
            $data['nombre'],
            $data['apellido'],
            $data['email'],
            $hashedPassword,
            $date,
            null
        );
       
        $save_user = new UserRepository();
        $success = $save_user->save($user);
        
        if($success){
            header("Location: ../html/views/login/login.html");
            //header("Location: ../html/views/login/login.html?success=success");
            exit;
        }else{
            $error = 'error al guardar';
            echo $error;
            // error_log($error, 3, '/var/www/html/errors/error.log');
        }
    }

    public function processData($data)
    {
        $fields = [
            "nombre",
            "apellido",
            "email",
            "password",
            "confirm_password"
        ];

        foreach($fields as $field)
        {
            if(!isset($data[$field])){
                array_push($this->errors, 'Incorrects fields');
            }
        }

        if (isset($data['nombre']) && strlen($data['nombre']) < 3) {
            $this->errors['nombre'] = "Name invalid";
        }
    
        // Validar la contraseña
        if (isset($data['password']) && strlen($data['password']) < 6) {
            $this->errors['password'] = "Password invalid";
        }
    
        // Validar si las contraseñas coinciden
        if (isset($data['password']) && isset($data['confirm_password']) && $data['password'] !== $data['confirm_password']) {
            $this->errors['confirm_password'] = "Confirm password invalid";
        }
    
        // Validar el formato del correo electrónico
        if (isset($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = "Email invalid";
        }

        if(count($this->errors) == 0){
            $this->saveUser($data);
        }else{
            error_log(json_encode($this->errors), 3, '../logs/errors.log');
        }
    }

}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $class = new RegisterController;
    
    $validation = $class->processData($_POST);

}else{
    echo '<h3>Error al enviar formulario</h3>';
}


?>