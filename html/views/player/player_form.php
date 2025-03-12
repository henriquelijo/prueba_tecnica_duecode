<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Jugador</title>
    <style>
        .error {
            color: red;
            font-size: 0.8em;
        }
    </style>
    <link rel="stylesheet" href="./player_form.css">
</head>
<body>
    <h1>Agregar Jugador</h1>
    <form id="playerForm" action="http://localhost:8080/controllers/PlayerController.php" method="POST" novalidate>
        <label for="name">Nombre:</label><br>
        <input type="text" id="name" name="name"><br>
        <span id="nameError" class="error"></span><br>

        <label for="number">Número:</label><br>
        <input type="text" id="number" name="number"><br>
        <span id="numberError" class="error"></span><br>

        <label for="captain">Es capitán?</label><br>
        <input type="checkbox" id="captain" name="captain" value="1"><br>
        <span id="numberError" class="error"></span><br>

        <label for="description">Descripción:</label><br>
        <textarea id="description" name="description"></textarea><br>

        <input id="team_id" type="text" name="team_id" hidden>

        <button type="button" onclick="validateForm()">Agregar Jugador</button>
    </form>

    <script>
        function validateForm() {
            let name = document.getElementById("name").value.trim();
            let number = document.getElementById("number").value.trim();
            let nameError = document.getElementById("nameError");
            let numberError = document.getElementById("numberError");
            let isValid = true;

            if (name === "") {
                nameError.textContent = "El nombre es requerido.";
                isValid = false;
            } else if (name.length > 23) {
                nameError.textContent = "El nombre no puede tener más de 23 caracteres.";
                isValid = false;
            } else {
                nameError.textContent = "";
            }

            if (number === "") {
                numberError.textContent = "El número es requerido.";
                isValid = false;
            } else {
                numberError.textContent = "";
            }

            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            const id = urlParams.get('team_id');
            console.log('ID_TEAM '+id);

            const input = document.getElementById('team_id');
            input.value = id;

            if (isValid) {
                document.getElementById("playerForm").submit();
            }

        }
    </script>
</body>
</html>