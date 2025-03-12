<?php
session_start();
require_once '../../../models/Player.php';

if (isset($_SESSION['player'])) {
    $player = $_SESSION['player'];
    $deserializedPlayers[] = unserialize(serialize($player)); 
    $player = $deserializedPlayers;
} else {
    echo "Datos del equipo no disponibles.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Jugador</title>
    <link rel="stylesheet" href="./player_edit_form.css">
</head>
<body>
    <h1>Editar Jugador</h1>
    
    <form id="editPlayerForm" action="/controllers/PlayerController.php" method="PUT">
        <input type="hidden" name="id" id="id" value="<?php echo $player[0]->getId(); ?>">
        <input type="hidden" name="team_id" id="team_id" value="<?php echo $player[0]->getTeamId(); ?>">

        <label for="name">Nombre:</label>
        <input type="text" id="name" name="name" value="<?php echo $player[0]->getName(); ?>" readonly>
        <span id="nameError" class="error"></span>

        <label for="number">Número:</label>
        <input type="number" id="number" name="number" value="<?php echo $player[0]->getNumber(); ?>" readonly>
        <span id="numberError" class="error"></span>

        <label for="captain">Es capitán?</label><br>
        <input type="checkbox" id="captain" name="captain" <?php echo ($player[0]->getCaptain() == 1) ? 'checked' : ''; ?> disabled><br>

        <label for="description">Descripción:</label>
        <textarea id="description" name="description" readonly><?php echo $player[0]->getDescription(); ?></textarea>
        <span id="descriptionError" class="error"></span>

        <button type="button" id="editButton">Editar</button>
        <button type="button" id="saveButton" style="display: none;">Guardar Cambios</button>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editButton = document.getElementById('editButton');
            const saveButton = document.getElementById('saveButton');
            const nameInput = document.getElementById('name');
            const numberInput = document.getElementById('number');
            const captainCheckbox = document.getElementById('captain');
            const descriptionTextarea = document.getElementById('description');

            editButton.addEventListener('click', function() {
                nameInput.removeAttribute('readonly');
                numberInput.removeAttribute('readonly');
                captainCheckbox.removeAttribute('disabled');
                descriptionTextarea.removeAttribute('readonly');

                editButton.style.display = 'none';
                saveButton.style.display = 'inline-block';
            });

            saveButton.addEventListener('click', validateForm);

            function validateForm() {
                let name = nameInput.value.trim();
                let number = numberInput.value.trim();
                let description = descriptionTextarea.value.trim();
                
                let nameError = document.getElementById('nameError');
                let numberError = document.getElementById('numberError');
                let descriptionError = document.getElementById('descriptionError');

                if (!nameError || !numberError || !descriptionError) {
                    console.error("Error: No se encontraron los elementos de error en el DOM.");
                    return;
                }

                let isValid = true;

                if (name === '') {
                    nameError.textContent = 'El nombre es obligatorio.';
                    isValid = false;
                } else if (name.length > 23) {
                    nameError.textContent = 'El nombre no puede tener más de 23 caracteres.';
                    isValid = false;
                } else {
                    nameError.textContent = '';
                }

                if (number === '') {
                    numberError.textContent = 'El número es obligatorio.';
                    isValid = false;
                } else if (isNaN(number)) {
                    numberError.textContent = 'El número debe ser un valor numérico.';
                    isValid = false;
                } else {
                    numberError.textContent = '';
                }

                if (description.length > 255) {
                    descriptionError.textContent = 'La descripción no puede tener más de 255 caracteres.';
                    isValid = false;
                } else {
                    descriptionError.textContent = '';
                }

                if (isValid) {
                    send();
                }
            }

            function send(){
                
                const team_id = document.getElementById('team_id').value;
                fetch('/controllers/PlayerController.php', {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        id: document.getElementById('id').value,
                        name: nameInput.value,
                        number: numberInput.value,
                        captain: captainCheckbox.checked ? 1 : 0, 
                        description: descriptionTextarea.value,
                        team_id: team_id
                    })
                })
                .then(response => {
                    if (response.ok) {
                       
                        var url = 'http://localhost:8080/html/views/team/team_view.php?id=' + team_id;
                        window.location.href = url;
                    } else {
                        console.error('Error al actualizar el jugador');
                    }
                })
                .catch(error => {
                    console.error('Error de red:', error);
                });
            }
        });
    </script>
</body>
</html>