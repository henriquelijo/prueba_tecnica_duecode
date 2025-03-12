<?php

require_once '../models/Player.php';
require_once '../repository/PlayerRepository.php';
require_once '../middlewares/SessionMiddleware.php';

session_start();

class PlayerController
{

    public function create($data)
    {
        SessionMiddleware::handle(); 
        
        if (!isset($data['name']) || empty($data['name'])) {
            return ['success' => false, 'message' => 'El nombre es requerido.'];
        }
        if (strlen($data['name']) > 23) {
            return ['success' => false, 'message' => 'El nombre no puede tener más de 23 caracteres.'];
        }
        if (!isset($data['team_id']) || !is_numeric($data['team_id']) || $data['team_id'] <= 0) {
            return ['success' => false, 'message' => 'El ID del equipo es inválido.'];
        }
        if (!isset($data['number']) || empty($data['number'])) {
            return ['success' => false, 'message' => 'El número es requerido.'];
        }

        $captain = 0;
        if(isset($data['captain']) && $data['captain'] = '1'){
            $captain = 1;
        }

        $player = new Player(
            null, 
            $data['name'],
            $data['team_id'],
            $data['number'],
            $data['description'],
            date('Y-m-d H:i:s'), 
            date('Y-m-d H:i:s'),
            $captain
        );
        
        if (PlayerRepository::save($player)) {

            return header("Location: ../html/views/home/home.php");
        } 

        echo 'Error al guardar el jugador';
    }

    public function getPlayer($id)
    {
        SessionMiddleware::handle();
        return PlayerRepository::findById($id);
    }

    public function update($data)
    {
        SessionMiddleware::handle();
        $player = PlayerRepository::findById($data['id']);
        
        if ($player) {
            $player->setName($data['name']);
            $player->setTeamId($data['team_id']);
            $player->setNumber($data['number']);
            $player->setDescription($data['description']);
            $player->setDateUpdated(date('Y-m-d H:i:s'));
            $player->setCaptain(($data['captain'] == 0)? 0 : 1);
            
            if (PlayerRepository::update($player)) {

                $players = PlayerRepository::findByTeam($player->getTeamId());
                $_SESSION['players'] = $players;

                return true;
            }
        }
        return false;
    }

    public function edit($data)
    {
        SessionMiddleware::handle();
        
        $id = $data['id'];
        $player = PlayerRepository::findById($id);

        if($player){
            $_SESSION['player'] = $player;
        }else{
            $_SESSION['player'] = [];
        }

        header("Location: ../html/views/player/player_edit_form.php?id=$id");
        exit;
    }

    public function delete($id)
    {
        SessionMiddleware::handle();
        PlayerRepository::delete($id['id']);
        
        unset($_SESSION['players'][$id['position']]);

        return true;
    }

    public function getAllPlayers()
    {
        SessionMiddleware::handle();
        return PlayerRepository::findAll();
    }


    public function getAPlayersByTeam($team_id)
    {
        SessionMiddleware::handle();
        return PlayerRepository::findByTeam($team_id);
    }
}

$player_controller = new PlayerController();
switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $player_controller->create($_POST);
        break;

    case 'GET':
        $player_controller->edit($_GET);
        break;

    case 'PUT':
        $put_data = file_get_contents('php://input');
        $put_data = json_decode($put_data, true); 
        $player_controller->update($put_data); 
        break;
    case 'DELETE':
        $player_controller->delete($_GET);
        break;
    default:
        # code...
        break;
}
?>