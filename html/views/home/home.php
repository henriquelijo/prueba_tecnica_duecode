<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Equipos</title>
    <link rel="stylesheet" href="home.styles.css">
</head>
<body>
    <header>
        <h1>Panel de Equipos</h1>
    </header>
    <main class="main-content">
        <section class="teams-section">
            <h2>Listado de equipos</h2>
            <div id="container_teams" class="teams-grid"></div>
        </section>
        <aside class="admin-panel">
            <div class="container">
                <h4>Administrar Equipos</h4>
                <ul class="admin-links">
                    <li><a href="../../../controllers/TeamsController.php">Añadir Equipo</a></li>
                </ul>
            </div>
        </aside>
    </main>
    <script>
        
        function findTeam(id) {
            fetch('../../../controllers/TeamsController.php?action=getTeam&id=' + id)
                .then(response => {
                    if (response.redirected) {
                        window.location.href = response.url; 
                    } else {
                        return response.text().then(text => {
                            console.error("Error del servidor:", text);
                            throw new Error("Error del servidor");
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function loadTeams() {
            fetch('../../../controllers/TeamsController.php?all=getTeams')
                .then(response => response.json())
                .then(data => {
                    let html = '';
                    console.log(data);
                    data.forEach(team => {
                        html += `<div class="team-card" id="${team.id}" onclick="findTeam(this.id)">
                                    <h3>${team.name}</h3>
                                    <p id="city">Ciudad: ${team.city}</p>
                                    <p id="sport">Deporte: ${team.sport}</p>
                                </div>`;
                    });
                    document.getElementById('container_teams').innerHTML = html;
                })
                .catch(error => {
                    console.error('Error al cargar equipos:', error);
                    document.getElementById('container_teams').innerHTML = '<p>Error al cargar los equipos.</p>';
                });
        }
        window.onload = loadTeams;
    </script>
</body>
</html>