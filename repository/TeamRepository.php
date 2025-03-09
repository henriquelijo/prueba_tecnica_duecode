<?php
require_once '../repository/connect_bbdd/connect_db.php';
require_once '../models/Team.php';
require_once '../logs/errors_log.php';

class TeamRepository
{
    private $db;

    public static function save(Team $team)
    {
        try {
            $connect = ConnectDb::connect();
    
            $query = "INSERT INTO teams (
                id, 
                name, 
                city, 
                sport, 
                description, 
                date_fundation, 
                date_created, 
                date_updated
            ) VALUES (
                ?, ?, ?, ?, ?, ?, ?, ?
            )";
    
            $statement = $connect->prepare($query);
            
            $statement->execute([
                $team->getId(),
                $team->getName(),
                $team->getCity(),
                $team->getSport(),
                $team->getDescription(),
                $team->getDateFundation(),
                $team->getDateCreated(),
                $team->getDateUpdated()
            ]);
            return true;
            
        } catch(PDOException $e) {
            $error = "Error al insertar equipo: " . $e->getMessage();
            log_helper::writeError($error);
            echo $error;
            return false;
        }
    }

    public static function getById($teamId)
    {
        try {
            $connect = ConnectDb::connect();
            
            $sql = "SELECT * FROM teams WHERE id = :id";
            $stmt = $connect->prepare($sql);
            $stmt->bindParam(':id', $teamId, PDO::PARAM_STR);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$result) {
                return null;
            }

            return new Team(
                $result['id'],
                $result['name'],
                $result['city'],
                $result['sport'],
                $result['description'],
                $result['date_fundation'],
                $result['date_created'],
                $result['date_updated']
            );

        } catch(PDOException $e) {
            $error = "Error al obtener equipo: " . $e->getMessage();
            log_helper::writeError($error);
            echo $error;
            return null;
        }
    }

    public static function update(Team $team)
    {
        try {
            $connect = ConnectDb::connect();
            
            $query = "UPDATE teams SET
                name = ?,
                city = ?,
                sport = ?,
                description = ?,
                date_fundation = ?,
                date_updated = ?
            WHERE id = ?";
            
            $statement = $connect->prepare($query);
            
            $statement->execute([
                $team->getName(),
                $team->getCity(),
                $team->getSport(),
                $team->getDescription(),
                $team->getDateFundation(),
                $team->getDateUpdated(),
                $team->getId()
            ]);
            
            return true;
            
        } catch(PDOException $e) {
            $error = "Error al actualizar equipo: " . $e->getMessage();
            log_helper::writeError($error);
            echo $error;
            return false;
        }
    }

    public static function delete($teamId)
    {
        try {
            $connect = ConnectDb::connect();
            
            $sql = "DELETE FROM teams WHERE id = :id";
            $stmt = $connect->prepare($sql);
            $stmt->bindParam(':id', $teamId, PDO::PARAM_STR);
            
            return $stmt->execute();
            
        } catch(PDOException $e) {
            $error = "Error al eliminar equipo: " . $e->getMessage();
            log_helper::writeError($error);
            echo $error;
            return false;
        }
    }

    // Método adicional útil para búsquedas
    public static function getBySport($sport)
    {
        try {
            $connect = ConnectDb::connect();
            
            $sql = "SELECT * FROM teams WHERE sport = :sport";
            $stmt = $connect->prepare($sql);
            $stmt->bindParam(':sport', $sport, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch(PDOException $e) {
            $error = "Error en consulta por deporte: " . $e->getMessage();
            log_helper::writeError($error);
            echo $error;
            return [];
        }
    }

    public static function getAllTeams()
    {
        try {
            $connect = ConnectDb::connect();
            
            $sql = "SELECT * FROM teams AS t ORDER BY t.id DESC";
            $stmt = $connect->prepare($sql);
            
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch(PDOException $e) {
            $error = "Error en consulta por deporte: " . $e->getMessage();
            log_helper::writeError($error);
            echo $error;
            return [];
        }
    }
}

?>