<?php 
require_once '../repository/connect_bbdd/connect_db.php';
require_once '../models/User.php';

class UserRepository
{

    public function save(User $user)
    {

        try{

            $connect = ConnectDb::connect();
    
            $query = "INSERT INTO users (id, firstName, lastName, email, password, date_created, date_updated) 
                      VALUES (?, ?, ?, ?, ?, ?, ?)";
    
            $statement = $connect->prepare($query);
            
            // Ejecutar la consulta SQL con los valores del objeto User
            $statement->execute([
                $user->getId(),
                $user->getFirstName(),
                $user->getLastName(),
                $user->getEmail(),
                $user->getPassword(),
                $user->getDateCreated(),
                $user->getDateUpdated()
            ]);
            return true;
        }catch(PDOException $e){
            $error = "Error al insertar usuario en la base de datos: " . $e->getMessage();
            echo $error;
            //error_log($error, 3, '/var/www/html/errors/error.log');
        }
    }

    public function getById($userId)
    {
        try{
            $connect = ConnectDb::connect();
            
            $sql = "SELECT * FROM users WHERE id = :id";

            $stmt = $connect->prepare($sql);
            $stmt->bindParam(':id', $userId, PDO::PARAM_STR);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $user = new User(
                $result['id'],
                $result['firstName'],
                $result['lastName'],
                $result['email'],
                $result['password'],
                $result['date_created'],
                $result['date_updated']
            );
            
            return $user;

        }catch(PDOException $e){
            $error = "Error al insertar usuario en la base de datos: " . $e->getMessage();
            echo $error;
        }
    }

    public function update(User $user)
    {
        
    }

    public function delete($userId)
    {
        
    }

    public function getByEmail($email)
    {
        try{
            $connect = ConnectDb::connect();
            
            $sql = "SELECT password, id FROM users WHERE email = :email";

            $stmt = $connect->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result;

        }catch(PDOException $e){
            $error = "Error en base de datos: " . $e->getMessage();
            echo $error;
        }
    }
}


?>