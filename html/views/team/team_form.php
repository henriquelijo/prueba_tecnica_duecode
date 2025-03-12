<?php

session_start();
$_SESSION['csrf_token'] = '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Equipo</title>
    <link rel="stylesheet" href="team_form.css">
</head>
<body>
    <div class="container">
        <h2>Registrar Nuevo Equipo</h2>
        
        <form id="teamForm" action="../../../controllers/TeamsController.php" method="POST" novalidate>
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            
            <div class="form-group">
                <label for="name" class="required-label">Nombre del Equipo</label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       required
                       maxlength="255"
                       placeholder="Ej: Deportivo FC">
                <div class="error-message" id="nameError"></div>
            </div>

            <div class="form-group">
                <label for="city">Ciudad</label>
                <input type="text" 
                       id="city" 
                       name="city" 
                       maxlength="255"
                       placeholder="Ej: A Coruña">
            </div>

            <div class="form-group">
                <label for="sport" class="required-label">Deporte</label>
                <select id="sport" name="sport" required>
                    <option value="">Selecciona un deporte</option>
                    <option value="Fútbol">Fútbol</option>
                    <option value="Béisbol">Béisbol</option>
                    <option value="Baloncesto">Baloncesto</option>
                    <option value="Voleibol">Voleibol</option>
                    <option value="Otro">Otro</option>
                </select>
                <div class="error-message" id="sportError"></div>
            </div>

            <div class="form-group">
                <label for="description" class="required-label">Descripción</label>
                <textarea id="description" 
                          name="description" 
                          rows="3" 
                          required
                          placeholder="Breve descripción del equipo"></textarea>
                <div class="error-message" id="descriptionError"></div>
            </div>

            <div class="form-group">
                <label for="date_fundation">Fecha de Fundación</label>
                <input type="date" 
                       id="date_fundation" 
                       name="date_fundation"
                       pattern="\d{4}-\d{2}-\d{2}"
                       placeholder="YYYY-MM-DD">
                <div class="error-message" id="dateError"></div>
            </div>

            <button type="submit">Registrar Equipo</button>
        </form>
    </div>

    <script>
        document.getElementById('teamForm').addEventListener('submit', function(e) {
            let isValid = true;
            
            const name = document.getElementById('name');
            if (name.value.trim() === '') {
                document.getElementById('nameError').textContent = 'El nombre del equipo es requerido';
                isValid = false;
            } else {
                document.getElementById('nameError').textContent = '';
            }

            const sport = document.getElementById('sport');
            if (sport.value === '') {
                document.getElementById('sportError').textContent = 'Debes seleccionar un deporte';
                isValid = false;
            } else {
                document.getElementById('sportError').textContent = '';
            }

            const description = document.getElementById('description');
            if (description.value.trim() === '') {
                document.getElementById('descriptionError').textContent = 'La descripción es requerida';
                isValid = false;
            } else {
                document.getElementById('descriptionError').textContent = '';
            }

            const dateInput = document.getElementById('date_fundation');
            if (dateInput.value && !/^\d{4}-\d{2}-\d{2}$/.test(dateInput.value)) {
                document.getElementById('dateError').textContent = 'Formato de fecha inválido (YYYY-MM-DD)';
                isValid = false;
            } else {
                document.getElementById('dateError').textContent = '';
            }

            if (!isValid) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>