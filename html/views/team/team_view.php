<?php
session_start();

require_once '../../../models/Team.php';
require_once '../../../models/Player.php';

if (isset($_SESSION['team'])) {

    $team = $_SESSION['team'];
    $players = $_SESSION['players'];

    $team = unserialize(serialize($team));
    
    if ($players) {
        $deserializedPlayers = [];
        foreach ($players as $player) {
             
            $deserializedPlayers[] = unserialize(serialize($player)); 
        }
        $players = $deserializedPlayers;
        //unset($_SESSION['players']); // Limpiar la sesión de players
    }
    $session_data = json_encode($_SESSION);
    //
} else {
    echo "Datos del equipo no disponibles.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Equipo</title>
    <link rel="stylesheet" href="./team_view.css">
</head>
<body>
    <div class="container_details_title">
        <h1>Detalles del Equipo</h1>
    </div>
    <main class="main-content">
        <section class="team-details">
            <?php if ($team instanceof Team): ?>
                <h2><?php echo $team->getName(); ?></h2>
                <p><strong>Ciudad:</strong> <?php echo $team->getCity(); ?></p>
                <p><strong>Deporte:</strong> <?php echo $team->getSport(); ?></p>
                <p><strong>Descripción:</strong> <?php echo $team->getDescription(); ?></p>
                <p><strong>Fecha de Fundación:</strong> <?php echo $team->getDateFundation(); ?></p>
                <p><strong>Fecha de Creación:</strong> <?php echo $team->getDateCreated(); ?></p>
                <p><strong>Fecha de Actualización:</strong> <?php echo $team->getDateUpdated(); ?></p>
            <?php else: ?>
                <p>Error: Datos del equipo no válidos.</p>
            <?php endif; ?>
        </section>

        <section class="player-list">
            <h2>Jugadores</h2>
            <button id="addPlayerButton">Agregar Jugador</button>
            <ul id="playerList">
                <?php
                if ($players) {
                    foreach ($players as $position => $player): ?>
                    <div id="<?php echo $player->getId(); ?>">
                        <li><?php echo $player->getName(); ?></li>
                        <li><?php echo $player->getDescription(); ?></li>
                        <li><?php echo ($player->getCaptain() == 1) ? 'Capitán': '';?></li>
                        <div class="buttonContainer">
                            <button class="editPlayerButton" data-player-id="<?php echo $player->getId(); ?>">Detalle Jugador</button>
                            <button class="deletePlayerButton" data-player-id="<?php echo $player->getId(); ?>"data-player-position="<?php echo $position; ?>">Eliminar</button>
                        </div>

                    </div>
                    <?php endforeach;
                } else {
                    ?><h4>El equipo no tiene aún jugadores</h4><?php
                }
                ?>
            </ul>
        </section>
    </main>
    <script>
        function clean(){

            const playerList = document.getElementById('playerList');
            console.log(playerList);
            playerList.innerHTML = ''; 
        }
            
        document.getElementById("addPlayerButton").addEventListener("click", function() {
            const id = <?php echo ($team instanceof Team) ? $team->getId() : 'null'; ?>;
            if(id !== 'null'){
                var url = 'http://localhost:8080/html/views/player/player_form.php?team_id=' + id;
                window.location.href = url;
            } else{
                console.error("El team id no es valido");
            }
        });

        document.querySelectorAll('.editPlayerButton').forEach(button => {
            button.addEventListener('click', function() {
                const playerId = this.getAttribute('data-player-id');
                editPlayer(playerId);
            });
        });

        document.querySelectorAll('.deletePlayerButton').forEach(button => {
            button.addEventListener('click', function() {
                const playerPosition = this.getAttribute('data-player-position');
                const playerId = this.getAttribute('data-player-id');
                deletePlayer(playerId, playerPosition);
            });
        });

        function editPlayer(playerId) {
            fetch(`/controllers/PlayerController.php?id=${playerId}`)
                .then(response => {
                    if (response.ok) {
                        
                        window.location.href = `/html/views/player/player_edit_form.php?id=${playerId}`;
                    } else {
                        console.error('Error al editar el jugador');
                        
                    }
                })
                .catch(error => {
                    console.error('Error de red:', error);
                  
                });

        }
        
        function deletePlayer(playerId, playerPosition) {
            fetch(`/controllers/PlayerController.php?id=${playerId}&position=${playerPosition}`, {
                method: 'DELETE'
            })
            .then(response => {
                if (response.ok) {
                    console.log('Jugador eliminado correctamente');
                    
                    const playerElement = document.getElementById(playerId);
                    if (playerElement) {
                        playerElement.remove();
                    }
                    
                } else {
                    console.error('Error al eliminar el jugador');
                }
            })
            .catch(error => {
                console.error('Error de red:', error);

            });
        }
        
    </script>
</body>
</html>

