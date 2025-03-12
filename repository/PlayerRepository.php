<?php
require_once '../repository/connect_bbdd/connect_db.php';
require_once '../models/Player.php';
require_once '../logs/errors_log.php';

class PlayerRepository
{

    public static function save(Player $player)
    {
        try {
            $connect = ConnectDb::connect();

            $query = "INSERT INTO players (
                id,
                name,
                team_id,
                number,
                description,
                date_created,
                date_updated,
                captain
            ) VALUES (
                ?, ?, ?, ?, ?, ?, ?, ?
            )";

            $statement = $connect->prepare($query);

            $statement->execute([
                $player->getId(),
                $player->getName(),
                $player->getTeamId(),
                $player->getNumber(),
                $player->getDescription(),
                $player->getDateCreated(),
                $player->getDateUpdated(),
                $player->getCaptain()
            ]);
            return true;

        } catch (PDOException $e) {
            $error = "Error al insertar jugador: " . $e->getMessage();
            log_helper::writeError($error);
            echo $error;
            return false;
        }
    }

    public static function findByTeam($id)
    {
        try {
            $connect = ConnectDb::connect();

            $query = "SELECT * FROM players WHERE team_id = ?";
            $statement = $connect->prepare($query);
            $statement->execute([$id]);
            $playerData = $statement->fetchAll(PDO::FETCH_ASSOC);

            if ($playerData) {
                $array_players = [];

                foreach($playerData as $player){

                    $player = new Player(
                        $player['id'],
                        $player['name'],
                        $player['team_id'],
                        $player['number'],
                        $player['description'],
                        $player['date_created'],
                        $player['date_updated'],
                        $player['captain']
                    );
                    array_push($array_players, $player);
                }
                return $array_players;
            }
            return null;

        } catch (PDOException $e) {
            $error = "Error al buscar jugador por ID: " . $e->getMessage();
            log_helper::writeError($error);
            echo $error;
            return null;
        }
    }


    public static function findById($id)
    {
        try {
            $connect = ConnectDb::connect();

            $query = "SELECT * FROM players WHERE id = ?";
            $statement = $connect->prepare($query);
            $statement->execute([$id]);
            $playerData = $statement->fetch(PDO::FETCH_ASSOC);

            if ($playerData) {
                return new Player(
                    $playerData['id'],
                    $playerData['name'],
                    $playerData['team_id'],
                    $playerData['number'],
                    $playerData['description'],
                    $playerData['date_created'],
                    $playerData['date_updated'],
                    $playerData['captain']
                );
            }
            return null;

        } catch (PDOException $e) {
            $error = "Error al buscar jugador por ID: " . $e->getMessage();
            log_helper::writeError($error);
            echo $error;
            return null;
        }
    }

    public static function update(Player $player)
    {
        try {
            $connect = ConnectDb::connect();

            $query = "UPDATE players SET
                name = ?,
                team_id = ?,
                number = ?,
                description = ?,
                date_updated = ?,
                captain = ?
            WHERE id = ?";

            $statement = $connect->prepare($query);

            $statement->execute([
                $player->getName(),
                $player->getTeamId(),
                $player->getNumber(),
                $player->getDescription(),
                $player->getDateUpdated(),
                $player->getCaptain(),
                $player->getId()
            ]);
            return true;

        } catch (PDOException $e) {
            $error = "Error al actualizar jugador: " . $e->getMessage();
            log_helper::writeError($error);
            echo $error;
            return false;
        }
    }

    public static function delete($id)
    {
        try {
            $connect = ConnectDb::connect();

            $query = "DELETE FROM players WHERE id = ?";
            $statement = $connect->prepare($query);
            $statement->execute([$id]);
            return true;

        } catch (PDOException $e) {
            $error = "Error al eliminar jugador: " . $e->getMessage();
            log_helper::writeError($error);
            echo $error;
            return false;
        }
    }

    public static function findAll()
    {
        try {
            $connect = ConnectDb::connect();

            $query = "SELECT * FROM players";
            $statement = $connect->prepare($query);
            $statement->execute();
            $playersData = $statement->fetchAll(PDO::FETCH_ASSOC);

            $players = [];
            foreach ($playersData as $playerData) {
                $players[] = new Player(
                    $playerData['id'],
                    $playerData['name'],
                    $playerData['team_id'],
                    $playerData['number'],
                    $playerData['description'],
                    $playerData['date_created'],
                    $playerData['date_updated'],
                    $playerData['captain']
                );
            }
            return $players;

        } catch (PDOException $e) {
            $error = "Error al obtener todos los jugadores: " . $e->getMessage();
            log_helper::writeError($error);
            echo $error;
            return [];
        }
    }
}
?>