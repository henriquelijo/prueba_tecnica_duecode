<?php
require_once '../middlewares/SessionMiddleware.php';
require_once '../models/Team.php';
require_once '../repository/TeamRepository.php';
require_once '../errors/errors_helper.php';

session_start();

class TeamsController
{
    public $errors = [];

    public function getTeam($id)
    {
        SessionMiddleware::handle();

        $team = TeamRepository::getById($id);
       
        if ($team) {
            include '../html/views/team/team_view.php';
            exit;
        } else {
            echo "Equipo no encontrado.";
        }
        
    }

    public function formController()
    {
        if(SessionMiddleware::handle()){
            if (!isset($_SESSION['csrf_token'])) {
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Generar un token seguro
            }
            return header("Location: ../html/views/team/team_form.php");
        };

    }

    public function getTeams()
    {
        SessionMiddleware::handle();
        
        echo json_encode(TeamRepository::getAllTeams());
    }

    public function addTeam($data)
    {
        SessionMiddleware::handle();
        
        if (empty(trim($data['name'] ?? ''))) {
            $this->errors['name'] = 'El nombre del equipo es requerido';
        } elseif (strlen(trim($data['name'])) > 255) {
            $this->errors['name'] = 'El nombre no puede exceder los 255 caracteres';
        }
    
        // Validar deporte (requerido, entre opciones permitidas)
        $deportesPermitidos = ['Fútbol', 'Béisbol', 'Baloncesto', 'Voleibol', 'Otro'];
        if (empty($data['sport'] ?? '')) {
            $this->errors['sport'] = 'Debes seleccionar un deporte';
        } elseif (!in_array($data['sport'], $deportesPermitidos)) {
            $this->errors['sport'] = 'Selección de deporte inválida';
        }
    
        // Validar descripción (requerido)
        if (empty(trim($data['description'] ?? ''))) {
            $this->errors['description'] = 'La descripción es requerida';
        }
    
        // Validar ciudad (opcional, máximo 255 caracteres)
        if (!empty($data['city']) && strlen(trim($data['city'])) > 255) {
            $this->errors['city'] = 'La ciudad no puede exceder los 255 caracteres';
        }
    
        // Validar fecha de fundación (formato YYYY-MM-DD)
        if (!empty($data['date_fundation'] ?? '')) {
            $fecha = DateTime::createFromFormat('Y-m-d', $data['date_fundation']);
            if (!$fecha || $fecha->format('Y-m-d') !== $data['date_fundation']) {
                $this->errors['date_fundation'] = 'Formato de fecha inválido (YYYY-MM-DD)';
            }
        }
        
        if (!isset($data['csrf_token']) || $data['csrf_token'] !== $_SESSION['csrf_token']) {
            $this->errors['general'] = 'Error de seguridad. Intente nuevamente.';
        }

        if(count($this->errors) > 0){

            errors_helper::writeError($this->errors);
            foreach($this->errors as $error){

                echo "$error";
            }
            exit;
        }

        $team = new Team(
            null,
            $data['name'],
            $data['city'],
            $data['sport'],
            $data['description'],
            $data['date_fundation'],
            date("Y-m-d H:i:s"),
            date("Y-m-d H:i:s"),
        );
        
        TeamRepository::save($team);

        return header("Location: ../html/views/home/home.php");
    }

    public function updateTeam($data)
    {
        SessionMiddleware::handle();
    }

    public function deleteTeam($id)
    {
        SessionMiddleware::handle();
    }
}

$team_controller = new TeamsController();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $team_controller->addTeam($_POST);
        break;
    case 'PUT':
        $team_controller->updateTeam($_POST);
        break;
    case 'DELETE':
        $team_controller->deleteTeam($_POST);
        break;
    case 'GET':
        if(isset($_GET['all'])){
            $team_controller->getTeams();
        }else if(isset($_GET['id'])){
            $team_controller->getTeam($_GET['id']);
        }else{
            $team_controller->formController();
        }
    default:
        
        break;
}

?>